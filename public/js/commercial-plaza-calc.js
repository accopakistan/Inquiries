/*
 * Commercial plaza estimator — calculation engine.
 *
 * Every number on the plaza page and in its quotation comes from estimate() in this file,
 * so the estimator, payment tables and PDF cannot drift apart. No DOM access here.
 * Loaded by resources/views/commercial-plaza-cost.blade.php; tested by tests/js/commercial-plaza-calc.test.js.
 *
 * Rounding policy: areas stay unrounded (bylaw defaults are whole SFT); each money line is rounded
 * once to whole rupees, and every subtotal and total is the sum of those rounded lines.
 */
(function(root, factory){
  if(typeof module === "object" && module.exports) module.exports = factory();
  else root.PlazaCalc = factory();
})(typeof self !== "undefined" ? self : this, function(){
  "use strict";

  // ── 2026 commercial base rates, Lahore, Rs per SFT ──
  // g gray above ground · bg basement gray · mg mumty & lift machine room gray
  // sc shell & core finishing · fs standard finishing · fp premium finishing · bp basement parking finishing
  var STD    = {g:3700, bg:6500, mg:4200, sc:1900, fs:3000, fp:5500, bp:1300};
  var DESIGN = {sft:220, min:1500000};   // design fee per SFT of total covered area, with a minimum
  var LMR_AREA = 75;
  var MAX = {b:5, u:60};

  // city factors on gray (g), finishing (fin) and basement (b) — mid-points of published ranges
  var CITIES = [
    {id:"lhr", label:"Lahore", f:{g:1, fin:1, b:1}, why:"Base rates"},
    {id:"isb", label:"Islamabad", f:{g:1.075, fin:1.05, b:1.15}, why:"Boulder and rock strata raise excavation and foundation cost; freight on finishes"},
    {id:"rwp", label:"Rawalpindi", f:{g:1.075, fin:1.05, b:1.15}, why:"As Islamabad"},
    {id:"khi", label:"Karachi", f:{g:0.925, fin:1.025, b:1.175}, why:"Lower labour and aggregate cost; high water table and saline soil raise waterproofing and need sulphate-resistant cement"},
    {id:"fsd", label:"Faisalabad", f:{g:1, fin:1, b:1}, est:true},
    {id:"mul", label:"Multan", f:{g:1, fin:1, b:1}, est:true},
    {id:"grw", label:"Gujranwala", f:{g:1, fin:1, b:1}, est:true},
    {id:"skt", label:"Sialkot", f:{g:1, fin:1, b:1}, est:true},
    {id:"pew", label:"Peshawar", f:{g:1, fin:1, b:1}, est:true},
    {id:"oth", label:"Other city", f:{g:1, fin:1, b:1}, est:true}
  ];

  // coverage presets by society / authority — every value stays editable in the estimator
  var AUTHS = [
    {id:"dha", label:"DHA", cov:{bmt:100, g:100, u:100, mz:75, ver:8},
      note:"DHA commercial: basement and ground 100% of plot, mezzanine 75% of shop area excluding the 8 ft verandah, upper floors 100% (DHA Lahore regulations 2026). Floors and height depend on plot size and phase.",
      floors:"By plot and phase — B+G+M+2F (52 ft) to 2B+G+26F (350 ft); see the table below"},
    {id:"bahria", label:"Bahria Town", cov:{bmt:100, g:87.5, u:75, mz:75, ver:0}, assumed:true,
      note:"Bahria Town byelaws set 7/8 ground coverage and 3/4 on upper floors in civic and commercial centres, FAR 1:5. Floors and height are issued per plot by the Bahria Design Wing — the mezzanine rule is assumed.",
      floors:"Per plot from the Design Wing; one basement up to 1 Kanal, more above"},
    {id:"lda", label:"LDA — commercial centre", cov:{bmt:100, g:87.5, u:75, mz:33.3, ver:0},
      note:"LDA 2019 cl. 3.3.2: ground 7/8 including arcade, upper floors 3/4, shop gallery up to 1/3 of shop area. A full-plot basement needs RCC piling, otherwise 4 ft clear all round.",
      floors:"B+G+5 (72 ft) on 4–8 Marla · B+G+6 (90 ft) on 1 Kanal · G+9 (120 ft) on 2 Kanal · G+14 (200 ft) on 4 Kanal"},
    {id:"ldac", label:"LDA — converted / commercial road", cov:{bmt:100, g:65, u:65, mz:33.3, ver:0},
      note:"LDA 2019 cl. 3.1.1: 65% coverage on ground and upper floors, gallery up to 1/3 of shop area. Floors and height depend on plot size and road width. A commercialisation fee applies to converted plots.",
      floors:"G+3 (50 ft) under 1 Kanal · G+6 (90 ft) 1–2 Kanal · G+9 (120 ft) 2–4 Kanal · G+14 (200 ft) 4–6 Kanal"},
    {id:"cda", label:"CDA / ICT", cov:{bmt:100, g:100, u:100, mz:75, ver:0}, assumed:true,
      note:"CDA controls commercial plots by floor area ratio — Markaz 1:5 to 1:6, Blue Area 1:8 to 1:10 — not by floor count. Coverage comes from the plot's allotment terms; enter each floor from the approved plan.",
      floors:"By FAR; no height limit since 2025, extra storeys charged per SFT"},
    {id:"pvt", label:"Private society / other", cov:{bmt:100, g:100, u:100, mz:75, ver:0}, assumed:true,
      note:"Enter your society's coverage rules and the basements and floors on your approved plan.",
      floors:"Per the society's byelaws"}
  ];

  // ── DHA Lahore commercial allowances (Reg. 23e), used for the reference tables and the one-click DHA option ──
  var PH_SMALL = [
    {id:"a", label:"Phase I–IV",      b:1, m:true, u:2, h:"52 ft"},
    {id:"b", label:"Phase V onwards", b:1, m:true, u:4, h:"74 / 78 ft"}
  ];
  var PH_MID = PH_SMALL.concat([{id:"c", label:"Phase V — corner", b:1, m:true, u:6, h:"100 ft"}]);
  var PH_BIG = [
    {id:"a", label:"Phase I, II, IV", b:1, m:true,  u:4,  h:"74 / 78 ft"},
    {id:"b", label:"Phase V onwards", b:2, m:false, u:12, h:"150 ft"}
  ];
  var DHA_PLOTS = [
    {id:"4m",  label:"4 Marla",  w:30,  d:30,  phases:PH_SMALL},
    {id:"8m",  label:"8 Marla",  w:30,  d:60,  phases:PH_SMALL},
    {id:"16m", label:"16 Marla", w:60,  d:60,  phases:PH_MID, assumed:"16 Marla is two 8 Marla plots amalgamated; dimensions assumed."},
    {id:"1k",  label:"1 Kanal",  w:75,  d:60,  phases:PH_MID, assumed:"1 Kanal is not a standard DHA commercial size; the 16 Marla rules are applied."},
    {id:"32m", label:"32 Marla", w:60,  d:120, phases:PH_BIG, note:"Phase III (XX) is subject to CAA and parking approval."},
    {id:"2k",  label:"2 Kanal",  w:75,  d:120, phases:PH_BIG, assumed:"2 Kanal is an amalgamated site; the 32 Marla rules are applied."},
    {id:"4k",  label:"4 Kanal",  w:150, d:120, assumed:"Theoretical maximum; parking normally limits real projects well below this.",
      phases:[{id:"a", label:"All phases", b:2, m:false, u:26, h:"350 ft", clear:4, setback:20}]}
  ];

  // ── programme, calendar days (ACCO research, Section 6) ──
  var TL = {
    tiny:  {mob:15, bmt:45, g:21, m:15, u:21, roof:20, fb:100, fu:20},
    small: {mob:20, bmt:50, g:25, m:18, u:23, roof:25, fb:130, fu:20},
    large: {mob:35, bmt:70, g:30, m:25, u:27, roof:30, fb:130, fu:20},
    xl:    {mob:40, bmt:80, g:35, m:28, u:30, roof:35, fb:170, fu:25}
  };

  var DESIGN_STAGES = [
    ["Mobilisation — on signing", 20],
    ["Concept plans approved by client", 15],
    ["3D elevation approved", 15],
    ["Submission drawings delivered to the approving authority", 20],
    ["Structural, MEP and working drawings delivered", 20],
    ["Approval received — complete set handed over", 10]
  ];

  var ADDONS = [
    {id:"lift", label:"Passenger lift", unit:"lifts", short:"lift",
      opts:[{k:"6", label:"6 person (450 kg)", rate:3000000},{k:"8", label:"8 person (630 kg)", rate:3600000},
            {k:"10", label:"10 person (800 kg)", rate:4500000},{k:"13", label:"13 person (1,000 kg)", rate:5500000}],
      defOpt:"8", auto:function(x){ return x.a.total > 60000 ? Math.ceil(x.a.total/60000) : 1; },
      note:"Typical stops. Extra stops Rs 150,000–300,000 each."},
    {id:"falarm", label:"Fire alarm system", unit:"SFT", short:"SFT", rate:60,
      auto:function(x){ return x.a.total; }, note:"Conventional system; addressable runs higher."},
    {id:"fhose", label:"Hose reels and wet riser", unit:"SFT", short:"SFT", rate:200,
      auto:function(x){ return x.a.total; }},
    {id:"sprink", label:"Automatic sprinklers", unit:"SFT", short:"SFT", rate:160,
      auto:function(x){ return x.a.total; }, note:"Usual from 1 Kanal and on multi-level basements."},
    {id:"fpump", label:"Fire pump set — electric, diesel and jockey", unit:"sets", short:"set", rate:5000000,
      auto:function(){ return 1; }},
    {id:"facade", label:"Premium facade", unit:"SFT of facade", short:"SFT",
      opts:[{k:"glass", label:"Glass curtain wall", rate:3500},{k:"acp", label:"ACP cladding, FR core", rate:950},{k:"stone", label:"Stone / tile cladding", rate:1300}],
      defOpt:"glass", auto:function(x){ return facadeAuto(x); },
      note:"Front elevation only, from ground to parapet."},
    {id:"gen", label:"Diesel generator, soundproof canopy", unit:"kVA", short:"kVA", rate:35000,
      auto:function(x){ return Math.min(x.D.gen || 2000, Math.max(20, Math.ceil(x.a.total/60/10)*10)); },
      noteFn:function(x){ return x.D.gen ? "DHA rooftop limit for this plot: " + x.D.gen + " kVA." : "Sized at about 1 kVA per 60 SFT."; }},
    {id:"vrf", label:"Central HVAC / VRF", unit:"SFT conditioned", short:"SFT", rate:1150,
      auto:function(x){ return x.a.up; }, note:"Above-ground floors; about 350 SFT per ton."},
    {id:"trans", label:"Transformer, 200–630 kVA", unit:"nos", short:"no.", rate:5500000,
      auto:function(){ return 1; }, note:"Utility-approved make."},
    {id:"ramp", label:"Basement ramp", unit:"ramps", short:"ramp", rate:4000000,
      auto:function(){ return 1; }, avail:function(x){ return x.cfg.b > 0 && x.D.A >= 3600; },
      why:"Needs a basement on a plot of about 16 Marla (3,600 SFT) or more."},
    {id:"tanks", label:"Water tanks — underground and overhead, RCC", unit:"gallons", short:"gal", rate:120,
      auto:function(x){ return x.a.total < 10000 ? 6000 : 22500; }},
    {id:"solar", label:"Solar PV, on-grid", unit:"kW", short:"kW", rate:110000,
      auto:function(){ return 10; }},
    {id:"cctv", label:"CCTV and access control", unit:"SFT", short:"SFT", rate:50,
      auto:function(x){ return x.a.total; },
      noteFn:function(x){ return x.cfg.auth.id === "dha" ? "DHA requires at least 4 cameras and 10 days of storage." : ""; }}
  ];

  // ── small helpers ─────────────────────────────
  function fmt(n){ return Math.round(n).toLocaleString("en-US"); }
  function num(n){ return String(Math.round(n*10)/10); }
  function ordinal(n){ var s=["th","st","nd","rd"], v=n%100; return n + (s[(v-20)%10] || s[v] || s[0]); }
  function sum(list){ return list.reduce(function(t,x){ return t + x[1]; }, 0); }
  function sumAmt(list){ return list.reduce(function(t,x){ return t + x.amt; }, 0); }
  function extend(a, b){ var o={}, k; for(k in a) o[k]=a[k]; for(k in b) o[k]=b[k]; return o; }
  function byId(list, id){ for(var i=0;i<list.length;i++) if(list[i].id === id) return list[i]; return list[0]; }
  function money(n){ return Math.round(n); }          // whole rupees, applied once per line
  function configStr(b, m, u){
    return (b ? (b > 1 ? b + "B+" : "B+") : "") + "G" + (m ? "+M" : "") + (u ? "+" + u + "F" : "");
  }
  function defMumty(A){ return A <= 900 ? 150 : 275; }
  // plot size in local units — Marla / Kanal at 225 SFT per Marla
  function sizeName(A){
    var m = A / 225;
    if(m >= 20 && Math.abs(m/20 - Math.round(m/20)) < 0.001) return Math.round(m/20) + " Kanal";
    return (Math.abs(m - Math.round(m)) < 0.001 ? Math.round(m) : "≈ " + (Math.round(m*10)/10)) + " Marla";
  }
  function isNum(v){ return typeof v === "number" && isFinite(v); }

  // standard rates adjusted for the city, rounded half-up to the nearest Rs 10.
  // Factors are applied as whole per-mille numbers: 6500 × 1.15 in floating point is 7474.999…,
  // which would wrongly round down to 7470 instead of 7480.
  function cityRates(city){
    var f = city.f, r = function(v, k){ return Math.round(v * Math.round(k * 1000) / 10000) * 10; };
    return {g:r(STD.g, f.g), bg:r(STD.bg, f.b), mg:r(STD.mg, f.g), sc:r(STD.sc, f.fin), fs:r(STD.fs, f.fin), fp:r(STD.fp, f.fin), bp:r(STD.bp, f.fin)};
  }

  // ── input safety ──────────────────────────────
  // Returns a copy of cfg with every numeric input forced into a valid range, plus a list of
  // what was corrected. The UI already blocks most bad input; this is the last line of defence
  // so NaN, Infinity or negative values can never reach a total.
  function sanitize(cfg){
    var w = [], c = extend(cfg, {});
    function pos(v, name, fallback){ if(isNum(v) && v > 0) return v; w.push(name + " must be greater than 0"); return fallback; }
    function nonneg(v, name){ if(isNum(v) && v >= 0) return v; w.push(name + " is not a valid number — treated as 0"); return 0; }
    function count(v, max, name){
      if(!isNum(v)){ w.push(name + " is not a valid number — treated as 0"); return 0; }
      var r = Math.max(0, Math.min(max, Math.round(v)));
      if(r !== v) w.push(name + " adjusted to " + r);
      return r;
    }
    c.w = pos(cfg.w, "Frontage", 1);
    c.d = pos(cfg.d, "Depth", 1);
    c.b = count(cfg.b, MAX.b, "Basements");
    c.u = count(cfg.u, MAX.u, "Upper floors");
    c.m = !!cfg.m; c.lmr = !!cfg.lmr; c.design = !!cfg.design;
    c.mumty = nonneg(cfg.mumty, "Mumty area");
    c.clear = nonneg(cfg.clear || 0, "Basement clearance");
    c.setback = nonneg(cfg.setback || 0, "Ground set-back");
    var cov = {};
    ["bmt","g","u","mz"].forEach(function(k){ cov[k] = Math.min(100, nonneg(cfg.cov[k], "Coverage " + k)); });
    cov.ver = nonneg(cfg.cov.ver, "Verandah depth");
    c.cov = cov;
    var r = {};
    Object.keys(STD).forEach(function(k){ r[k] = nonneg(cfg.rates[k], "Rate " + k); });
    c.rates = r;
    c.dr = {sft:nonneg(cfg.dr.sft, "Design rate"), min:nonneg(cfg.dr.min, "Design minimum")};
    var over = {};
    if(cfg.over) Object.keys(cfg.over).forEach(function(k){
      if(cfg.over[k] == null) return;
      over[k] = nonneg(cfg.over[k], "Area of " + k);
    });
    c.over = over;
    c.warnings = w;
    return c;
  }

  // plot geometry and programme class
  function dims(cfg){
    var A = cfg.w * cfg.d;
    return {w:cfg.w, d:cfg.d, A:A,
            cls: A <= 1000 ? "tiny" : A <= 2000 ? "small" : A <= 5000 ? "large" : "xl",
            gen: cfg.auth && cfg.auth.id === "dha" ? (A <= 1350 ? 150 : A <= 1800 ? 200 : 400) : 0};
  }

  // ── covered area by floor ─────────────────────
  //   basement  = plot × basement %   (or (w − 2·clear)(d − 2·clear) for a piled basement)
  //   ground    = plot × ground %     (or plot − set-back × frontage)
  //   mezzanine = mezzanine % × (ground − verandah depth × frontage)
  //   each upper floor = plot × upper %
  //   mumty and lift machine room as entered (75 SFT)
  // Bylaw defaults are rounded to whole SFT; a manual override replaces only its own floor.
  function rowsOf(cfg){
    var A = cfg.w * cfg.d, cv = cfg.cov, rows = [], i;
    var bmtA = cfg.clear ? Math.max(0, (cfg.w - 2*cfg.clear) * (cfg.d - 2*cfg.clear)) : Math.round(A * cv.bmt / 100);
    var gA   = cfg.setback ? Math.max(0, A - cfg.setback * cfg.w) : Math.round(A * cv.g / 100);
    var ver  = cv.ver * cfg.w;
    var mA   = Math.max(0, Math.round(cv.mz / 100 * (gA - ver)));
    var uA   = Math.round(A * cv.u / 100);
    for(i = cfg.b; i >= 1; i--){
      rows.push({k:"b"+i, t:"bmt", label: cfg.b > 1 ? "Basement " + i : "Basement", def:bmtA,
                 rule: cfg.clear ? "Plot less " + cfg.clear + " ft clear all round, piled" : num(cv.bmt) + "% of plot"});
    }
    rows.push({k:"g", t:"up", label:"Ground floor", def:gA,
               rule: cfg.setback ? "Plot less " + cfg.setback + " ft road-side set-back" : num(cv.g) + "% of plot" + (cv.ver ? " incl. verandah" : "")});
    if(cfg.m) rows.push({k:"m", t:"up", label:"Mezzanine", def:mA,
               rule: num(cv.mz) + "% of " + (ver ? "shop area excl. " + fmt(ver) + " SFT verandah" : "ground floor")});
    for(i = 1; i <= cfg.u; i++) rows.push({k:"f"+i, t:"up", label:ordinal(i) + " floor", def:uA, rule:num(cv.u) + "% of plot"});
    if(cfg.mumty > 0) rows.push({k:"mt", t:"roof", label:"Stair mumty", def:cfg.mumty, rule:"Roof structure"});
    if(cfg.lmr) rows.push({k:"lmr", t:"roof", label:"Lift machine room", def:LMR_AREA, rule:"Roof structure"});
    rows.forEach(function(r){
      var o = cfg.over ? cfg.over[r.k] : null;
      r.area = (o != null) ? o : r.def;
    });
    return rows;
  }
  function sumAreas(rows){
    var a = {bmt:0, up:0, roof:0};
    rows.forEach(function(r){ a[r.t] += r.area; });
    a.total = a.bmt + a.up + a.roof;
    return a;
  }

  // ── construction cost ─────────────────────────
  function levelName(cfg){
    return cfg.scope === "shell" ? "Shell & core finishing" : (cfg.level === "prem" ? "Premium finishing" : "Standard finishing");
  }
  // finishing rates by floor group: above ground at the selected level; basement at the parking rate
  // or the same level; mumty and machine room always at the shell & core rate
  function finRates(cfg){
    var r = cfg.rates, up = cfg.scope === "shell" ? r.sc : (cfg.level === "prem" ? r.fp : r.fs);
    return {up:up, bmt: cfg.bmtUse === "park" ? r.bp : up, roof:r.sc};
  }
  //   gray      = basement SFT × bg + above-ground SFT × g + roof SFT × mg          (all construction scopes)
  //   finishing = above-ground SFT × level + basement SFT × basement finish + roof SFT × sc   (shell & turnkey)
  function costLines(cfg, a){
    var r = cfg.rates, L = [];
    var hasG = cfg.scope !== "none", hasF = (cfg.scope === "shell" || cfg.scope === "turnkey");
    if(hasG){
      if(a.bmt) L.push({g:"gray", label:"Basement — gray structure", qty:a.bmt, rate:r.bg,
        desc:"Excavation, shoring, raft, RCC retaining walls, waterproofing, dewatering and slab"});
      if(a.up) L.push({g:"gray", label:"Gray structure — ground, mezzanine and upper floors", qty:a.up, rate:r.g,
        desc:"RCC frame and slabs, stair and lift core, masonry, plaster, conduits, roof and parapet"});
      if(a.roof) L.push({g:"gray", label:"Stair mumty and lift machine room — gray", qty:a.roof, rate:r.mg,
        desc:"Roof structures, parapet, lift hook beam and machine base"});
    }
    if(hasF){
      var f = finRates(cfg), name = levelName(cfg);
      if(a.up) L.push({g:"fin", label:name + " — ground, mezzanine and upper floors", qty:a.up, rate:f.up,
        desc: cfg.scope === "shell" ? "Facade, lobby, stairs, corridors, common washrooms, risers; units left bare"
            : cfg.level === "prem" ? "Premium finishes to every unit and common area"
            : "Tiles, paint, ceilings, glazing, shopfronts, washrooms, electrical and plumbing to every unit"});
      if(a.bmt) L.push({g:"fin", label:"Basement finishing — " + (cfg.bmtUse === "park" ? "parking" : "shops / offices"),
        qty:a.bmt, rate:f.bmt,
        desc: cfg.bmtUse === "park" ? "Power-floated floor, line marking, ventilation, lighting, sump pumps"
            : "As the floors above, plus forced ventilation and extra waterproof detailing"});
      if(a.roof) L.push({g:"fin", label:"Mumty and machine room finishing", qty:a.roof, rate:f.roof,
        desc:"Finished at the shell & core rate"});
    }
    L.forEach(function(l){ l.amt = money(l.qty * l.rate); });
    return L;
  }
  function costOf(cfg){
    var rows = rowsOf(cfg), a = sumAreas(rows), L = costLines(cfg, a), gray = 0, fin = 0;
    L.forEach(function(l){ if(l.g === "gray") gray += l.amt; else fin += l.amt; });
    return {rows:rows, a:a, L:L, gray:gray, fin:fin, build:gray + fin};
  }

  // ── design fee ────────────────────────────────
  //   fee = max(total covered SFT × design rate, minimum), in whole rupees
  function designFeeOf(area, dr){
    var raw = money(area * dr.sft);
    return {fee:Math.max(raw, money(dr.min)), raw:raw, atMin: raw < dr.min};
  }
  function designFee(cfg, c){
    return cfg.design ? designFeeOf(c.a.total, cfg.dr) : null;
  }

  // ── add-ons ───────────────────────────────────
  function facadeAuto(x){
    var h = (x.cfg.m ? 17 : 12) + 11 * x.cfg.u + 3;   // ground (+ mezzanine), floors, parapet
    return Math.round(x.D.w * h / 10) * 10;
  }
  function optOf(ad, k){ for(var i=0;i<ad.opts.length;i++) if(ad.opts[i].k === k) return ad.opts[i]; return ad.opts[0]; }
  function addonCtx(cfg, c){ return {cfg:cfg, a:c.a, D:dims(cfg)}; }
  //   each selected add-on = quantity (automatic unless typed) × rate (default unless typed)
  function addonLines(cfg, c){
    var x = addonCtx(cfg, c), out = [];
    ADDONS.forEach(function(ad){
      var s = cfg.ads ? cfg.ads[ad.id] : null;
      if(!s || !s.on) return;
      if(ad.avail && !ad.avail(x)) return;
      var opt = ad.opts ? optOf(ad, s.opt) : null;
      var qty  = (isNum(s.qty) && s.qty >= 0) ? s.qty : ad.auto(x);
      var rate = (isNum(s.rate) && s.rate >= 0) ? s.rate : (opt ? opt.rate : ad.rate);
      out.push({id:ad.id, label:ad.label + (opt ? " — " + opt.label : ""), short:ad.short, qty:qty, rate:rate, amt:money(qty*rate)});
    });
    return out;
  }

  // ── programme ─────────────────────────────────
  function durOf(cfg){
    var t = TL[dims(cfg).cls], hasG = cfg.scope !== "none";
    var bmt  = hasG ? cfg.b * t.bmt : 0;
    var gray = hasG ? t.mob + bmt + t.g + (cfg.m ? t.m : 0) + cfg.u * t.u + t.roof : 0;
    var full = t.fb + t.fu * Math.min(cfg.u, 8);        // finishing crews run floors in parallel
    var fin  = cfg.scope === "turnkey" ? full : cfg.scope === "shell" ? Math.round(full * 0.6 / 5) * 5 : 0;
    return {gray:gray, bmt:bmt, fin:fin, total:gray + fin, pre: dims(cfg).cls === "xl" ? 135 : 105};
  }

  // ── payment schedule ──────────────────────────
  // head and tail stages are fixed; what is left is shared equally by the mezzanine and upper slabs
  function payStages(cfg){
    if(cfg.scope === "none") return [];
    var gray = cfg.scope === "gray", shell = cfg.scope === "shell", hasB = cfg.b > 0;
    var slabs = (cfg.m ? 1 : 0) + cfg.u, s = [], i;
    s.push(["Mobilisation advance — on signing, against bank guarantee or post-dated cheques", 10]);
    if(hasB){
      s.push(["Excavation, shoring and basement raft / foundation complete", cfg.b > 3 ? 6 : 8]);
      for(i = 1; i < cfg.b; i++) s.push(["Intermediate basement walls and slab cast" + (cfg.b > 2 ? " — level " + (cfg.b - i) : ""), cfg.b > 3 ? 5 : 8]);
      s.push(["Basement retaining walls and ground floor slab cast", 10]);
    } else {
      s.push(["Foundation, plinth and ground floor slab cast", 14]);
    }
    var tail = gray ? [
      ["Roof slab, mumty, machine room and parapet complete", 7],
      ["Masonry and plaster complete — all floors", hasB ? 15 : 19],
      ["Gray structure handed over — snag list cleared", 5],
      ["Retention — released after the defects liability period", 5]
    ] : [
      ["Roof slab, mumty, machine room and parapet complete", 5],
      ["Masonry and plaster complete — all floors", hasB ? 7 : 11],
      [shell ? "MEP risers, common services and facade frames installed" : "MEP rough-in and window / facade frames installed", 6],
      [shell ? "Lobby, stairs, corridors and common washrooms finished" : "Flooring and wall tiling complete", 6],
      [shell ? "Base facade, common lighting and fixtures complete" : "Paint, doors, sanitary and electrical fixtures complete", 5],
      ["Testing, commissioning, snagging and handover", 4],
      ["Retention — released after the 6–12 month defects liability period", 5]
    ];
    var pool = 100 - sum(s) - sum(tail);
    if(slabs > 0){
      // work in tenths of a percent so the slabs differ by at most 0.1% and still total the pool exactly
      var poolT = Math.round(pool * 10), baseT = Math.floor(poolT / slabs), rem = poolT - baseT * slabs;
      for(i = 0; i < slabs; i++){
        var lbl = (cfg.m && i === 0) ? "Mezzanine slab cast" : ordinal(cfg.m ? i : i + 1) + " floor slab cast";
        s.push([lbl, (baseT + (i < rem ? 1 : 0)) / 10]);
      }
    } else {
      s[s.length - 1][1] += pool;
    }
    return s.concat(tail);
  }
  // amounts per stage in whole rupees; the last stage absorbs rounding so the stages sum to the total
  function stageAmounts(total, stages){
    var running = 0, whole = money(total);
    return stages.map(function(st, i){
      var amt = (i === stages.length - 1) ? whole - running : money(total * st[1] / 100);
      running += amt;
      return amt;
    });
  }

  // ── the single source of every figure on the page and in the quotation ──
  //   construction contract = gray + finishing + add-ons        (0 for design only)
  //   design fee            = max(covered SFT × design rate, minimum)   (if design is included)
  //   preliminary total     = construction contract + design fee
  // Add-ons are construction items, so they are ignored when the scope is design only.
  function estimate(input){
    var cfg = sanitize(input);
    var c = costOf(cfg), hasG = cfg.scope !== "none";
    var ads = hasG ? addonLines(cfg, c) : [];
    var addT = sumAmt(ads);
    var contract = c.build + addT;
    var fee = designFee(cfg, c), feeT = fee ? fee.fee : 0;
    var stages = payStages(cfg);
    return {
      cfg:cfg, warnings:cfg.warnings,
      rows:c.rows, a:c.a, lines:c.L, gray:c.gray, fin:c.fin, build:c.build,
      ads:ads, addT:addT, contract:contract, fee:fee, feeT:feeT, total:contract + feeT,
      dur:durOf(cfg),
      stages:stages, payAmts:stageAmounts(contract, stages),
      dStages: fee ? DESIGN_STAGES : [], dAmts: fee ? stageAmounts(fee.fee, DESIGN_STAGES) : []
    };
  }

  return {
    STD:STD, DESIGN:DESIGN, LMR_AREA:LMR_AREA, MAX:MAX, CITIES:CITIES, AUTHS:AUTHS, DHA_PLOTS:DHA_PLOTS,
    TL:TL, DESIGN_STAGES:DESIGN_STAGES, ADDONS:ADDONS,
    fmt:fmt, num:num, ordinal:ordinal, extend:extend, byId:byId, configStr:configStr, defMumty:defMumty, sizeName:sizeName,
    cityRates:cityRates, sanitize:sanitize, dims:dims, rowsOf:rowsOf, sumAreas:sumAreas, levelName:levelName,
    finRates:finRates, costLines:costLines, costOf:costOf, designFeeOf:designFeeOf, designFee:designFee,
    facadeAuto:facadeAuto, optOf:optOf, addonCtx:addonCtx, addonLines:addonLines, durOf:durOf,
    payStages:payStages, stageAmounts:stageAmounts, estimate:estimate
  };
});
