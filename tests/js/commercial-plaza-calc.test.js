// Calculation tests for the commercial plaza estimator engine (public/js/commercial-plaza-calc.js).
// Run: npm run test:js   (Node's built-in test runner — no dependencies)
//
// Every expected value below is worked out by hand from the documented formula in the comment next
// to it, not copied from the application's output.

const test = require("node:test");
const assert = require("node:assert/strict");
const C = require("../../public/js/commercial-plaza-calc.js");

const LHR = C.byId(C.CITIES, "lhr");
const DHA = C.byId(C.AUTHS, "dha");
const DHA_COV = {bmt:100, g:100, u:100, mz:75, ver:8};
const PLAIN_COV = {bmt:100, g:100, u:100, mz:75, ver:0};

// 8 Marla (30' × 60' = 1,800 SFT) DHA plaza, B+G+M+4F, Lahore, turnkey standard, design included
function cfg(over){
  return Object.assign({
    w:30, d:60, label:"8 Marla", cov:{...DHA_COV}, mumty:275, lmr:true,
    b:1, m:true, u:4, clear:0, setback:0, over:{},
    bmtUse:"shop", scope:"turnkey", level:"std", rates:{...C.STD},
    design:true, dr:{...C.DESIGN}, ads:{}, auth:DHA, city:LHR
  }, over);
}
// bare ground floor on 1,800 SFT: no basement, mezzanine, upper floors, mumty or lift room
const bare = (over) => cfg(Object.assign({b:0, m:false, u:0, lmr:false, mumty:0, cov:{...PLAIN_COV}}, over));
const rowArea = (e, k) => e.rows.find(r => r.k === k).area;
const sumAmt = (list) => list.reduce((t, l) => t + l.amt, 0);

// ── 1. ground floor only ──────────────────────────────────────────────
test("1. simple ground-floor project", () => {
  const e = C.estimate(bare({scope:"gray"}));
  assert.deepEqual(e.rows.map(r => r.k), ["g"]);
  assert.equal(e.a.total, 1800);
  assert.equal(e.gray, 6660000);                 // 1,800 × 3,700
  const t = C.estimate(bare());
  assert.equal(t.fin, 5400000);                  // 1,800 × 3,000
  assert.equal(t.build, 12060000);
  assert.equal(t.fee.fee, 1500000);              // 1,800 × 220 = 396,000 < minimum
  assert.equal(t.total, 13560000);
});

// ── 2. G+4 ────────────────────────────────────────────────────────────
test("2. ground plus four floors", () => {
  const e = C.estimate(cfg({b:0, m:false, cov:{...PLAIN_COV}}));
  assert.equal(e.a.up, 9000);                    // 5 × 1,800
  assert.equal(e.a.roof, 350);                   // mumty 275 + lift room 75
  assert.equal(e.gray, 34770000);                // 9,000 × 3,700 + 350 × 4,200
  assert.equal(e.fin, 27665000);                 // 9,000 × 3,000 + 350 × 1,900
  assert.equal(e.fee.fee, 2057000);              // 9,350 × 220
  assert.equal(e.total, 64492000);
});

// ── 3. one basement ───────────────────────────────────────────────────
test("3. one basement uses basement rates, never above-ground rates", () => {
  const e = C.estimate(bare({b:1}));
  const bg = e.lines.find(l => l.label.startsWith("Basement — gray"));
  assert.equal(bg.rate, 6500);
  assert.equal(bg.amt, 11700000);                // 1,800 × 6,500
  assert.equal(e.gray, 18360000);                // + ground 1,800 × 3,700
  assert.equal(e.fin, 10800000);                 // shops: (1,800 + 1,800) × 3,000
  const park = C.estimate(bare({b:1, bmtUse:"park"}));
  assert.equal(park.fin, 7740000);               // 1,800 × 1,300 + 1,800 × 3,000
});

// ── 4. mezzanine ──────────────────────────────────────────────────────
test("4. mezzanine follows the verandah rule", () => {
  assert.equal(rowArea(C.estimate(cfg()), "m"), 1170);                       // 75% × (1,800 − 8 × 30)
  assert.equal(rowArea(C.estimate(cfg({cov:{...PLAIN_COV}})), "m"), 1350);   // 75% × 1,800, no verandah
  assert.equal(C.estimate(cfg({m:false})).rows.some(r => r.k === "m"), false);
});

// ── 5. mumty and lift machine room ────────────────────────────────────
test("5. mumty and LMR are separate rows with their own rates", () => {
  const e = C.estimate(bare({mumty:275, lmr:true, level:"prem"}));
  assert.equal(rowArea(e, "mt"), 275);
  assert.equal(rowArea(e, "lmr"), 75);
  const roofGray = e.lines.find(l => l.label.startsWith("Stair mumty"));
  const roofFin = e.lines.find(l => l.label.startsWith("Mumty and machine room finishing"));
  assert.equal(roofGray.amt, 1470000);           // 350 × 4,200
  assert.equal(roofFin.amt, 665000);             // 350 × 1,900 — shell & core rate even for premium
});

// ── 6. optional structures disabled ───────────────────────────────────
test("6. disabled options contribute nothing", () => {
  const e = C.estimate(bare({scope:"turnkey"}));
  assert.equal(e.a.bmt, 0);
  assert.equal(e.a.roof, 0);
  assert.equal(e.lines.length, 2);               // ground gray + ground finishing only — no Rs 0 lines
  assert.equal(e.addT, 0);
});

// ── 7. design only ────────────────────────────────────────────────────
test("7. design-only quotation: fee only, add-ons ignored, no construction schedule", () => {
  const e = C.estimate(cfg({scope:"none", ads:{lift:{on:true, opt:"8"}}}));
  assert.equal(e.build, 0);
  assert.equal(e.ads.length, 0);
  assert.equal(e.contract, 0);
  assert.equal(e.fee.fee, 2710400);              // 12,320 × 220
  assert.equal(e.total, 2710400);
  assert.deepEqual(e.stages, []);
  // design stages 20/15/15/20/20/10
  assert.deepEqual(e.dAmts, [542080, 406560, 406560, 542080, 542080, 271040]);
});

// ── 8–11. construction scopes on the full DHA 8 Marla Phase V envelope ─
// areas: basement 1,800 · above ground 1,800 + 1,170 + 4 × 1,800 = 10,170 · roof 350 · total 12,320
test("8. gray structure", () => {
  const e = C.estimate(cfg({scope:"gray"}));
  assert.equal(e.a.total, 12320);
  assert.equal(e.gray, 50799000);                // 1,800×6,500 + 10,170×3,700 + 350×4,200
  assert.equal(e.fin, 0);
});
test("9. shell and core", () => {
  const e = C.estimate(cfg({scope:"shell"}));
  assert.equal(e.fin, 23408000);                 // (10,170 + 1,800 + 350) × 1,900
  assert.equal(e.build, 74207000);
});
test("10. turnkey, standard finishing", () => {
  const e = C.estimate(cfg());
  assert.equal(e.fin, 36575000);                 // 10,170×3,000 + 1,800×3,000 + 350×1,900
  assert.equal(e.build, 87374000);
});
test("11. turnkey, premium finishing", () => {
  const e = C.estimate(cfg({level:"prem"}));
  assert.equal(e.fin, 66500000);                 // 10,170×5,500 + 1,800×5,500 + 350×1,900
  assert.equal(e.build, 117299000);
});

// ── 12. custom rates ──────────────────────────────────────────────────
test("12. custom rates replace every standard rate", () => {
  const rates = {g:4000, bg:7000, mg:4500, sc:2000, fs:3200, fp:6000, bp:1500};
  const e = C.estimate(cfg({rates, bmtUse:"park"}));
  assert.equal(e.gray, 54855000);                // 1,800×7,000 + 10,170×4,000 + 350×4,500
  assert.equal(e.fin, 35944000);                 // 10,170×3,200 + 1,800×1,500 + 350×2,000
});

// ── 13–15. design fee ─────────────────────────────────────────────────
test("13. per-SFT design fee", () => {
  const f = C.estimate(cfg()).fee;
  assert.deepEqual(f, {fee:2710400, raw:2710400, atMin:false});
});
test("14. percentage design fee is not offered (ACCO charges per SFT only)", () => {
  assert.equal(C.DESIGN.pct, undefined);
  assert.deepEqual(Object.keys(C.DESIGN).sort(), ["min", "sft"]);
  // the fee does not move with construction cost — only with area
  assert.equal(C.estimate(cfg({level:"prem"})).fee.fee, C.estimate(cfg({scope:"gray"})).fee.fee);
});
test("15. design fee below the minimum, and exactly at it", () => {
  assert.deepEqual(C.designFeeOf(5000, {sft:220, min:1500000}), {fee:1500000, raw:1100000, atMin:true});
  assert.deepEqual(C.designFeeOf(5000, {sft:300, min:1500000}), {fee:1500000, raw:1500000, atMin:false});
  assert.equal(C.estimate(cfg({design:false})).fee, null);
  assert.equal(C.estimate(cfg({design:false})).total, 87374000);
});

// ── 16. add-ons ───────────────────────────────────────────────────────
test("16. add-ons are counted exactly once", () => {
  const ads = {lift:{on:true, opt:"8"}, falarm:{on:true}, facade:{on:true, opt:"glass"}, ramp:{on:true}};
  const e = C.estimate(cfg({ads}));
  // lift 3,600,000 · fire alarm 12,320 × 60 = 739,200
  // facade 30 ft × (17 + 11 × 4 + 3 = 64 ft) = 1,920 SFT × 3,500 = 6,720,000 · ramp unavailable on 1,800 SFT
  assert.deepEqual(e.ads.map(l => [l.id, l.amt]), [["lift", 3600000], ["falarm", 739200], ["facade", 6720000]]);
  assert.equal(e.addT, 11059200);
  assert.equal(e.contract, 98433200);            // 87,374,000 + 11,059,200
  assert.equal(e.total, 101143600);              // + design 2,710,400
  assert.equal(e.total - e.feeT - e.build, e.addT);
  const typed = C.estimate(cfg({ads:{falarm:{on:true, qty:10000, rate:75}}}));
  assert.equal(typed.addT, 750000);              // typed quantity and rate win
});

// ── 17. city settings ─────────────────────────────────────────────────
test("17. city factors, rounded half-up to Rs 10", () => {
  assert.deepEqual(C.cityRates(LHR), C.STD);
  // Islamabad: g 3,700×1.075 = 3,977.5 → 3,980 · bg 6,500×1.15 = 7,475 → 7,480 · mg 4,515 → 4,520
  //            sc 1,995 → 2,000 · fs 3,150 · fp 5,775 → 5,780 · bp 1,365 → 1,370
  assert.deepEqual(C.cityRates(C.byId(C.CITIES, "isb")), {g:3980, bg:7480, mg:4520, sc:2000, fs:3150, fp:5780, bp:1370});
  // Karachi: g 3,422.5 → 3,420 · bg 7,637.5 → 7,640 · mg 3,885 → 3,890 · sc 1,947.5 → 1,950
  //          fs 3,075 → 3,080 · fp 5,637.5 → 5,640 · bp 1,332.5 → 1,330
  assert.deepEqual(C.cityRates(C.byId(C.CITIES, "khi")), {g:3420, bg:7640, mg:3890, sc:1950, fs:3080, fp:5640, bp:1330});
  const isb = C.estimate(cfg({scope:"gray", rates:C.cityRates(C.byId(C.CITIES, "isb"))}));
  assert.equal(isb.gray, 1800*7480 + 10170*3980 + 350*4520);
});
test("17b. authority presets change coverage", () => {
  const lda = C.estimate(cfg({cov:{...C.byId(C.AUTHS, "lda").cov}, u:5}));
  assert.equal(rowArea(lda, "g"), 1575);         // 87.5% × 1,800
  assert.equal(rowArea(lda, "m"), 524);          // 33.3% × 1,575 = 524.475
  assert.equal(rowArea(lda, "f1"), 1350);        // 75% × 1,800
});

// ── 18. manual overrides ──────────────────────────────────────────────
test("18. a manual area changes only its own floor", () => {
  const base = C.estimate(cfg());
  const e = C.estimate(cfg({over:{f2:1500}}));
  assert.equal(rowArea(e, "f2"), 1500);
  e.rows.filter(r => r.k !== "f2").forEach(r => assert.equal(r.area, rowArea(base, r.k)));
  assert.equal(e.a.total, 12020);                // 12,320 − 300
  assert.equal(C.estimate(cfg({over:{f2:0}})).a.total, 10520);
});

// ── 19. decimals and rounding ─────────────────────────────────────────
test("19. decimal dimensions and whole-rupee lines that reconcile", () => {
  const e = C.estimate(cfg({w:30.5, d:60.25, scope:"gray"}));
  // plot 1,837.625 → bylaw floors 1,838 · verandah 8 × 30.5 = 244 · mezzanine round(0.75 × 1,594) = 1,196
  assert.equal(e.a.total, 1838 + 1838 + 1196 + 4*1838 + 350);
  assert.equal(e.gray, 1838*6500 + (1838 + 1196 + 4*1838)*3700 + 350*4200);

  const r = C.estimate(bare({scope:"gray", over:{g:1000.333}, rates:{...C.STD, g:3701.5}}));
  assert.equal(r.lines[0].amt, 3702733);         // 1,000.333 × 3,701.5 = 3,702,732.5995
  assert.equal(r.total, r.lines[0].amt + r.fee.fee);
  [e, r, C.estimate(cfg({ads:{facade:{on:true, qty:333.33, rate:949.99}}}))].forEach(x => {
    assert.equal(x.build, sumAmt(x.lines));
    assert.equal(x.addT, sumAmt(x.ads));
    assert.ok(Number.isInteger(x.total));
  });
});

// ── 20. invalid input ─────────────────────────────────────────────────
test("20. invalid, missing, zero and negative values never reach a total", () => {
  const e = C.estimate(cfg({w:0, d:NaN, b:-2, u:2.6, mumty:"abc", cov:{bmt:100, g:150, u:-5, mz:75, ver:8},
                            rates:{...C.STD, g:-5, fs:Infinity}, over:{f1:-10}}));
  assert.equal(e.cfg.w, 1);
  assert.equal(e.cfg.d, 1);
  assert.equal(e.cfg.b, 0);
  assert.equal(e.cfg.u, 3);
  assert.equal(e.cfg.mumty, 0);
  assert.equal(e.cfg.cov.g, 100);
  assert.equal(e.cfg.cov.u, 0);
  assert.equal(e.cfg.rates.g, 0);
  assert.equal(e.cfg.rates.fs, 0);
  assert.equal(rowArea(e, "f1"), 0);
  assert.ok(e.warnings.length >= 8, "every correction is reported");
  [e.a.total, e.gray, e.fin, e.total].concat(e.payAmts).forEach(v => assert.ok(Number.isFinite(v) && v >= 0));
  assert.equal(C.estimate(cfg({u:1000})).cfg.u, C.MAX.u);
});

// ── 21. changed settings ──────────────────────────────────────────────
test("21. estimates are pure — changing settings never leaks between calculations", () => {
  const input = cfg();
  const a1 = C.estimate(input), b = C.estimate(Object.assign({}, input, {scope:"gray", u:2})), a2 = C.estimate(input);
  assert.deepEqual(a2.total, a1.total);
  assert.notEqual(b.total, a1.total);
  assert.equal(input.u, 4);                      // input object untouched
});

// ── 22. quotation after a rate change ─────────────────────────────────
test("22. payment amounts follow the latest rates", () => {
  const before = C.estimate(cfg());
  const after = C.estimate(cfg({rates:{...C.STD, g:4000}}));
  assert.equal(after.contract - before.contract, 10170 * 300);   // above-ground area × Rs 300 increase
  assert.equal(after.payAmts.reduce((t, x) => t + x, 0), after.contract);
});

// ── 23. payment reconciliation ────────────────────────────────────────
test("23. every schedule totals 100% and its amounts total the contract", () => {
  let combos = 0;
  for(const scope of ["gray", "shell", "turnkey"]) for(let b = 0; b <= C.MAX.b; b++)
  for(const u of [0, 1, 2, 3, 4, 6, 12, 26, 40, 60]) for(const m of [true, false]){
    const st = C.payStages(cfg({scope, b, u, m}));
    const pct = Math.round(st.reduce((t, s) => t + s[1], 0) * 1000) / 1000;
    assert.equal(pct, 100, `${scope} ${b}B ${u}F mezz=${m}`);
    st.forEach(s => assert.ok(s[1] > 0, "no zero or negative stage"));
    combos++;
  }
  assert.equal(combos, 360);
  // odd totals: amounts sum to the rounded total and the last stage stays positive
  const stages = C.payStages(cfg());
  for(const total of [1, 99, 1234567.89, 87374000, 999999999.5]){
    const amts = C.stageAmounts(total, stages);
    assert.equal(amts.reduce((t, x) => t + x, 0), Math.round(total));
    assert.ok(amts[amts.length - 1] >= 0);
  }
});

// ── reference data: DHA bylaw envelopes match the research PDF ────────
test("DHA envelopes match the research figures", () => {
  const expected = {"4m":{a:4320, b:6120}, "8m":{a:8720, b:12320}, "16m":{a:17090, b:24290, c:31490},
                    "1k":{a:21275, b:30275, c:39275}, "32m":{a:48590, b:108350}, "2k":{a:60650, b:135350}, "4k":{a:515158}};
  for(const p of C.DHA_PLOTS) for(const ph of p.phases){
    const e = C.estimate(cfg({w:p.w, d:p.d, b:ph.b, m:ph.m, u:ph.u, clear:ph.clear || 0, setback:ph.setback || 0,
                              mumty:C.defMumty(p.w * p.d)}));
    assert.equal(e.a.total, expected[p.id][ph.id], `${p.label} ${ph.label}`);
  }
});

// ── programme ─────────────────────────────────────────────────────────
test("timeline responds to basements, floors and scope", () => {
  // 8 Marla (small): 20 + 50 + 25 + 18 + 4 × 23 + 25 = 230 gray; finishing 130 + 20 × 4 = 210
  assert.deepEqual(C.durOf(cfg()), {gray:230, bmt:50, fin:210, total:440, pre:105});
  assert.equal(C.durOf(cfg({b:0})).total, 390);
  assert.equal(C.durOf(cfg({scope:"shell"})).fin, 125);           // 210 × 0.6 = 126 → nearest 5
  assert.equal(C.durOf(cfg({scope:"none"})).total, 0);
});
