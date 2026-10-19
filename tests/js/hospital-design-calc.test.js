// Calculation tests for the hospital design quotation engine (public/js/hospital-design-calc.js).
// Run: npm run test:js   (Node's built-in test runner — no dependencies)
//
// Expected values are worked out by hand from the formula: fee = total covered SFT × rate.

const test = require("node:test");
const assert = require("node:assert/strict");
const C = require("../../public/js/hospital-design-calc.js");

// 2 Kanal plot (9,000 SFT), 60% coverage, ground only, Rs 25 / SFT
function cfg(over){
  return Object.assign({plot:2, unit:"kanal", cov:60, b:0, u:0, other:0, rate:25, over:{}}, over);
}

test("plot size converts from every unit to SFT", () => {
  assert.equal(C.plotSft(1, "kanal"), 4500);
  assert.equal(C.plotSft(10, "marla"), 2250);
  assert.equal(C.plotSft(1, "acre"), 43560);
  assert.equal(C.plotSft(100, "sqyd"), 900);
  assert.equal(C.plotSft(5000, "sft"), 5000);
  assert.equal(C.plotSft(0, "kanal"), 0);
});

test("ground floor only: plot × coverage × rate", () => {
  const e = C.estimate(cfg());
  // 9,000 × 60% = 5,400 SFT; × 25 = 135,000
  assert.equal(e.total, 5400);
  assert.equal(e.fee, 135000);
  assert.equal(e.floors, 1);
  assert.equal(e.desc, "Ground floor");
});

test("the AJK 500 bed quotation: 50,000 SFT on each of 5 floors at Rs 25", () => {
  // 2 basements + ground + 2 upper floors = 5 floors, each typed as 50,000 SFT
  const over = {b2:50000, b1:50000, g:50000, f1:50000, f2:50000};
  const e = C.estimate(cfg({b:2, u:2, over}));
  assert.equal(e.floors, 5);
  assert.equal(e.total, 250000);
  assert.equal(e.uniform, 50000);
  assert.equal(e.fee, 6250000);
  assert.equal(C.inWords(e.fee), "Rupees Sixty Two Lakh Fifty Thousand Only");
});

test("floor description and configuration", () => {
  assert.equal(C.floorsDesc(2, 3), "2 Basements & Ground to 3rd floor");
  assert.equal(C.floorsDesc(1, 1), "Basement & Ground to 1st floor");
  assert.equal(C.floorsDesc(0, 0), "Ground floor");
  assert.equal(C.configStr(2, 3), "2B+G+3");
  assert.equal(C.configStr(0, 4), "G+4");
});

test("rows run from the lowest basement up to the top floor", () => {
  const labels = C.estimate(cfg({b:2, u:2})).rows.map(r => r.label);
  assert.deepEqual(labels, ["Basement 2", "Basement 1", "Ground floor", "1st floor", "2nd floor"]);
});

test("a typed area changes only its own floor and breaks the uniform flag", () => {
  const e = C.estimate(cfg({u:2, over:{f2:3000}}));
  // 5,400 + 5,400 + 3,000
  assert.equal(e.total, 13800);
  assert.equal(e.uniform, null);
  assert.equal(e.rows.find(r => r.k === "f1").area, 5400);
});

test("other covered area is added to the total but not to the floor count", () => {
  const e = C.estimate(cfg({other:600}));
  assert.equal(e.total, 6000);
  assert.equal(e.floors, 1);
  assert.equal(e.uniform, 5400);
});

test("custom rate", () => {
  assert.equal(C.estimate(cfg({rate:40})).fee, 216000);
});

test("invalid values never reach the total", () => {
  const e = C.estimate(cfg({plot:NaN, rate:-5, b:9, u:2.6, cov:150}));
  assert.equal(e.total, 0);
  assert.equal(e.fee, 0);
  assert.equal(e.cfg.b, 5);
  assert.equal(e.cfg.u, 3);
  assert.equal(e.cfg.cov, 100);
  assert.ok(e.warnings.length >= 3);
});

test("standard package has the six drawings from the current quotation format", () => {
  const std = C.DRAWINGS.filter(d => d.on).map(d => d.label);
  assert.deepEqual(std, ["3D Elevation Views", "Furniture Layout Plans", "Architectural Drawings",
    "Structural Drawings with Stability Certificate", "Public Health Drawings", "Electrical Drawings"]);
});
