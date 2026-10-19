/*
 * Hospital design quotation — calculation engine.
 *
 * Every figure on the hospital design page and in its quotation comes from estimate() in this file.
 * No DOM access here. Loaded by resources/views/hospital-design-quotation.blade.php;
 * tested by tests/js/hospital-design-calc.test.js.
 *
 * Fee = total covered area (all floors + other roof / service areas) × design rate, in whole rupees.
 */
(function(root, factory){
  if(typeof module === "object" && module.exports) module.exports = factory();
  else root.HospitalCalc = factory();
})(typeof self !== "undefined" ? self : this, function(){
  "use strict";

  var RATE = 25;            // Rs per SFT of covered area — architecture and construction design
  var COVERAGE = 60;        // default % of plot built on each floor
  var MAX = {b:5, u:30};

  // plot size units, in SFT (Marla at 225 SFT, as in the plaza estimator)
  var UNITS = [
    {id:"kanal", label:"Kanal",  sft:4500},
    {id:"marla", label:"Marla",  sft:225},
    {id:"acre",  label:"Acre",   sft:43560},
    {id:"sqyd",  label:"Sq yd",  sft:9},
    {id:"sft",   label:"SFT",    sft:1}
  ];

  // drawings and design work — the first six are the standard hospital design package
  var DRAWINGS = [
    {id:"3d",    on:true,  label:"3D Elevation Views", desc:"Realistic 3D renderings showcasing the external look and aesthetic of the building."},
    {id:"furn",  on:true,  label:"Furniture Layout Plans", desc:"Detailed layout plans indicating furniture and medical equipment placement for optimal space utilisation."},
    {id:"arch",  on:true,  label:"Architectural Drawings", desc:"Complete set of architectural plans including floor plans, sections and elevations."},
    {id:"str",   on:true,  label:"Structural Drawings with Stability Certificate", desc:"Detailed structural layout along with a certified structural stability document."},
    {id:"ph",    on:true,  label:"Public Health Drawings", desc:"Plumbing and sanitary layout including water supply and drainage systems."},
    {id:"elec",  on:true,  label:"Electrical Drawings", desc:"Power layout, lighting design and circuit distribution plans."},
    {id:"hvac",  on:false, label:"HVAC Drawings", desc:"Air conditioning, ventilation and pressure-zoning layouts for OTs, ICUs and isolation rooms."},
    {id:"gas",   on:false, label:"Medical Gas Drawings", desc:"Oxygen, vacuum and medical air pipeline layouts with outlet schedules."},
    {id:"fire",  on:false, label:"Fire Fighting and Fire Alarm Drawings", desc:"Fire alarm, hose reel, sprinkler and emergency exit layouts as per Building Code of Pakistan."},
    {id:"site",  on:false, label:"Site Master Plan and Landscape", desc:"Site zoning, access, parking, ambulance route and landscape layout."},
    {id:"int",   on:false, label:"Interior Design Drawings", desc:"Interior finishes, ceiling, flooring and joinery details for patient and public areas."},
    {id:"sub",   on:false, label:"Submission Drawings for Approval", desc:"Drawings prepared to the approving authority's format, with follow-up of observations."}
  ];

  function fmt(n){ return Math.round(n).toLocaleString("en-US"); }
  function ordinal(n){ var s=["th","st","nd","rd"], v=n%100; return n + (s[(v-20)%10] || s[v] || s[0]); }
  function isNum(v){ return typeof v === "number" && isFinite(v); }
  function byId(list, id){ for(var i=0;i<list.length;i++) if(list[i].id === id) return list[i]; return list[0]; }

  function plotSft(value, unit){
    return isNum(value) && value > 0 ? value * byId(UNITS, unit).sft : 0;
  }

  // "2 Basements & Ground to 3rd floor", "Ground floor", "Basement & Ground to 1st floor"
  function floorsDesc(b, u){
    var g = u ? "Ground to " + ordinal(u) + " floor" : "Ground floor";
    return b ? (b > 1 ? b + " Basements" : "Basement") + " & " + g : g;
  }
  function configStr(b, u){ return (b ? (b > 1 ? b + "B+" : "B+") : "") + "G" + (u ? "+" + u : ""); }

  // returns a copy of cfg with numeric inputs forced into range, plus what was corrected
  function sanitize(cfg){
    var w = [], c = {};
    function nonneg(v, name){ if(isNum(v) && v >= 0) return v; w.push(name + " is not a valid number — treated as 0"); return 0; }
    function count(v, max, name){
      if(!isNum(v)){ w.push(name + " is not a valid number — treated as 0"); return 0; }
      var r = Math.max(0, Math.min(max, Math.round(v)));
      if(r !== v) w.push(name + " adjusted to " + r);
      return r;
    }
    c.plot  = nonneg(cfg.plot, "Plot size");
    c.unit  = cfg.unit || "kanal";
    c.cov   = Math.min(100, nonneg(cfg.cov, "Coverage"));
    c.b     = count(cfg.b, MAX.b, "Basements");
    c.u     = count(cfg.u, MAX.u, "Upper floors");
    c.other = nonneg(cfg.other || 0, "Other covered area");
    c.rate  = nonneg(cfg.rate, "Design rate");
    var over = {};
    if(cfg.over) Object.keys(cfg.over).forEach(function(k){
      if(cfg.over[k] == null) return;
      over[k] = nonneg(cfg.over[k], "Area of " + k);
    });
    c.over = over;
    c.warnings = w;
    return c;
  }

  //   each floor = plot SFT × coverage %, rounded to whole SFT, unless typed over
  function rowsOf(cfg){
    var A = plotSft(cfg.plot, cfg.unit), def = Math.round(A * cfg.cov / 100), rows = [], i;
    for(i = cfg.b; i >= 1; i--) rows.push({k:"b"+i, label: cfg.b > 1 ? "Basement " + i : "Basement", def:def});
    rows.push({k:"g", label:"Ground floor", def:def});
    for(i = 1; i <= cfg.u; i++) rows.push({k:"f"+i, label:ordinal(i) + " floor", def:def});
    rows.forEach(function(r){
      var o = cfg.over ? cfg.over[r.k] : null;
      r.area = (o != null) ? o : r.def;
    });
    if(cfg.other > 0) rows.push({k:"other", label:"Mumty, machine rooms and service areas", def:cfg.other, area:cfg.other});
    return rows;
  }

  function estimate(input){
    var cfg = sanitize(input), rows = rowsOf(cfg);
    var floorRows = rows.filter(function(r){ return r.k !== "other"; });
    var total = rows.reduce(function(t, r){ return t + r.area; }, 0);
    var first = floorRows.length ? floorRows[0].area : 0;
    var uniform = floorRows.every(function(r){ return r.area === first; }) ? first : null;
    return {
      cfg:cfg, warnings:cfg.warnings, rows:rows,
      plotSft: plotSft(cfg.plot, cfg.unit),
      floors: cfg.b + 1 + cfg.u,
      desc: floorsDesc(cfg.b, cfg.u), config: configStr(cfg.b, cfg.u),
      uniform: uniform, total: total,
      fee: Math.round(total * cfg.rate)
    };
  }

  // Pakistani numbering: crore / lakh / thousand / hundred
  var ONES = ["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven","Twelve",
    "Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"];
  var TENS = ["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];
  function twoDigit(n){ return n < 20 ? ONES[n] : TENS[Math.floor(n/10)] + (n%10 ? " " + ONES[n%10] : ""); }
  function threeDigit(n){
    var out = "";
    if(n > 99){ out += ONES[Math.floor(n/100)] + " Hundred"; n %= 100; if(n) out += " "; }
    if(n) out += twoDigit(n);
    return out;
  }
  function inWords(num){
    num = Math.round(num);
    if(num === 0) return "Rupees Zero Only";
    var parts = [];
    var crore = Math.floor(num/10000000); num %= 10000000;
    var lakh  = Math.floor(num/100000);   num %= 100000;
    var thou  = Math.floor(num/1000);     num %= 1000;
    if(crore) parts.push(threeDigit(crore) + " Crore");
    if(lakh)  parts.push(twoDigit(lakh) + " Lakh");
    if(thou)  parts.push(twoDigit(thou) + " Thousand");
    if(num)   parts.push(threeDigit(num));
    return "Rupees " + parts.join(" ") + " Only";
  }

  return {
    RATE:RATE, COVERAGE:COVERAGE, MAX:MAX, UNITS:UNITS, DRAWINGS:DRAWINGS,
    fmt:fmt, ordinal:ordinal, byId:byId, plotSft:plotSft, floorsDesc:floorsDesc, configStr:configStr,
    sanitize:sanitize, rowsOf:rowsOf, estimate:estimate, inWords:inWords
  };
});
