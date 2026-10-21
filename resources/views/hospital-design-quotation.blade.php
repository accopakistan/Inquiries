<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hospital Design Quotation | Ahmed Construction Company (ACCO)</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#08182F;
  --navy:#003478;
  --blue:#1A6FC4;
  --blue-bright:#0057B8;
  --paper:#FFFFFF;
  --mist:#F2F5FA;
  --line:#D6E0EE;
  --line-strong:#B4C6DE;
  --text:#222222;
  --muted:#5A6B82;
  --maxw:1140px;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}*{animation:none!important;transition:none!important}}
body{
  margin:0;background:var(--paper);color:var(--text);
  font-family:"IBM Plex Sans",system-ui,-apple-system,sans-serif;
  font-size:16px;line-height:1.65;-webkit-font-smoothing:antialiased;
}
h1,h2,h3,h4{font-family:"Archivo",system-ui,sans-serif;margin:0;line-height:1.12;letter-spacing:-0.02em;color:var(--ink)}
p{margin:0 0 1em}
a{color:var(--blue-bright)}
.wrap{max-width:var(--maxw);margin:0 auto;padding:0 24px}
.mono{font-family:"IBM Plex Mono",ui-monospace,monospace;font-variant-numeric:tabular-nums}

/* ── eyebrow ──────────────────────────────────────────── */
.eyebrow{
  font-family:"IBM Plex Mono",monospace;font-size:11.5px;letter-spacing:.18em;
  text-transform:uppercase;color:var(--blue);margin:0 0 14px;display:flex;align-items:center;gap:10px;
}
.eyebrow::after{content:"";flex:1;height:1px;background:var(--line);max-width:120px}
.dark .eyebrow{color:#7FB2E8}
.dark .eyebrow::after{background:rgba(255,255,255,.18)}

/* ── header ───────────────────────────────────────────── */
header.bar{
  position:sticky;top:0;z-index:50;background:rgba(8,24,47,.94);
  backdrop-filter:blur(10px);border-bottom:1px solid rgba(255,255,255,.1);
}
.bar .wrap{display:flex;align-items:center;gap:24px;height:62px}
.logo{display:flex;align-items:baseline;gap:9px;color:#fff;text-decoration:none;font-family:"Archivo";font-weight:800;font-size:19px;letter-spacing:-.01em}
.logo span{font-family:"IBM Plex Mono";font-weight:400;font-size:10.5px;letter-spacing:.16em;color:#8FB8E4;text-transform:uppercase}
nav.links{margin-left:auto;display:flex;gap:22px}
nav.links a{color:#C9DAF0;text-decoration:none;font-size:13.5px;font-weight:500}
nav.links a:hover{color:#fff}
.btn{
  display:inline-block;background:var(--blue-bright);color:#fff;text-decoration:none;
  font-weight:600;font-size:14px;padding:11px 20px;border-radius:2px;border:1px solid var(--blue-bright);
  transition:background .18s ease;cursor:pointer;font-family:inherit;
}
.btn:hover{background:#0068D8;border-color:#0068D8}
.btn.ghost{background:transparent;color:#fff;border-color:rgba(255,255,255,.4)}
.btn.ghost:hover{background:rgba(255,255,255,.1)}
@media(max-width:900px){nav.links{display:none}}

/* ── hero ─────────────────────────────────────────────── */
.hero{background:var(--ink);color:#EAF1FA;padding:76px 0 0;position:relative;overflow:hidden}
.hero::before{
  content:"";position:absolute;inset:0;opacity:.5;pointer-events:none;
  background-image:linear-gradient(rgba(122,166,220,.09) 1px,transparent 1px),linear-gradient(90deg,rgba(122,166,220,.09) 1px,transparent 1px);
  background-size:44px 44px;
  mask-image:radial-gradient(ellipse 90% 70% at 70% 20%,#000,transparent 75%);
  -webkit-mask-image:radial-gradient(ellipse 90% 70% at 70% 20%,#000,transparent 75%);
}
.hero .wrap{position:relative}
.hero h1{color:#fff;font-size:clamp(38px,6.2vw,68px);font-weight:800;max-width:16ch;margin:0 0 20px}
.hero h1 em{font-style:normal;color:#5FA3E8}
.hero .lede{font-size:clamp(16px,2vw,19px);color:#B7CBE2;max-width:62ch;margin-bottom:34px}
.year-tag{
  display:inline-block;font-family:"IBM Plex Mono";font-size:12px;letter-spacing:.2em;
  border:1px solid rgba(127,178,232,.45);color:#9FC6EC;padding:6px 12px;margin-bottom:26px;
}
.rates{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1px;background:rgba(255,255,255,.14);margin-top:8px;border:1px solid rgba(255,255,255,.14)}
.rate{background:var(--ink);padding:26px 24px}
.rate .lbl{font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#8FB8E4;margin-bottom:10px}
.rate .val{font-family:"Archivo";font-weight:800;font-size:clamp(30px,4.6vw,44px);color:#fff;line-height:1;letter-spacing:-.03em}
.rate .val small{font-family:"IBM Plex Mono";font-weight:400;font-size:13px;color:#9FC6EC;letter-spacing:0;margin-left:6px}
.rate .sub{font-size:13.5px;color:#A9C2DC;margin-top:8px}
@media(max-width:820px){.rates{grid-template-columns:1fr}}
.citystrip{
  margin-top:56px;border-top:1px solid rgba(255,255,255,.13);padding:16px 0 20px;
  display:flex;flex-wrap:wrap;gap:8px 20px;align-items:center;
}
.citystrip b{font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#7FB2E8;font-weight:500}
.citystrip span{font-size:13.5px;color:#AFC7E0}

/* ── sections ─────────────────────────────────────────── */
section{padding:78px 0;border-top:1px solid var(--line)}
section.tint{background:var(--mist)}
section.dark{background:var(--ink);color:#DCE7F4;border-top:none}
section.dark h2,section.dark h3{color:#fff}
h2{font-size:clamp(27px,3.7vw,40px);font-weight:700;margin-bottom:16px}
h3{font-size:19px;font-weight:700;margin-bottom:10px}
.section-lede{font-size:17px;color:var(--muted);max-width:66ch}
.dark .section-lede{color:#A9C2DC}

/* ── estimator ────────────────────────────────────────── */
.est{display:grid;grid-template-columns:1.05fr 1fr;gap:0;border:1px solid var(--line-strong);background:#fff;margin-top:34px}
.est-controls{padding:30px;border-right:1px solid var(--line)}
.est-out{padding:30px;background:var(--ink);color:#fff;position:sticky;top:76px;align-self:start}
@media(max-width:880px){.est{grid-template-columns:1fr}.est-controls{border-right:none;border-bottom:1px solid var(--line)}.est-out{position:static}}
.ctrl-label{font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin:0 0 10px;display:block}
.mini{display:block;font-family:"IBM Plex Mono";font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:6px}
.field{margin-bottom:24px}
.field input[type=number]{
  width:100%;font-family:"IBM Plex Mono";font-size:17px;padding:11px 13px;
  border:1px solid var(--line-strong);border-radius:2px;color:var(--ink);background:#fff;
}
.field .hint{font-size:12.5px;color:var(--muted);margin-top:7px}
.txt,.sel{width:100%;font-family:"IBM Plex Sans";font-size:15px;padding:11px 13px;border:1px solid var(--line-strong);border-radius:2px;background:#fff;color:var(--ink)}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px 12px}
.grid2 .full{grid-column:1 / -1}
@media(max-width:520px){.grid2{grid-template-columns:1fr}}
.lookup{display:flex;gap:8px}
.lookup input{flex:1}
.lookup .btn{padding:10px 16px;white-space:nowrap}
.lookstat{font-size:12.5px;margin-top:7px;color:var(--muted);min-height:1em}
.lookstat.ok{color:#1E7B3A}
.lookstat.err{color:#B3261E}
.chip:focus-visible,.seg button:focus-visible,input:focus-visible,select:focus-visible,a:focus-visible,button:focus-visible{outline:2px solid var(--blue);outline-offset:2px}
.seg{display:flex;border:1px solid var(--line-strong);border-radius:2px;overflow:hidden}
.seg button{
  flex:1;padding:11px 8px;background:#fff;border:0;border-right:1px solid var(--line);
  font-family:"IBM Plex Sans";font-size:13.5px;font-weight:500;color:var(--navy);cursor:pointer;
}
.seg button:last-child{border-right:0}
.seg button[aria-pressed="true"]{background:var(--blue-bright);color:#fff}
.plotin{display:grid;grid-template-columns:1fr 130px;gap:8px}
.plotarea{font-family:"IBM Plex Mono";font-size:12.5px;color:var(--navy);margin-top:8px}
.counts{display:flex;flex-wrap:wrap;gap:14px 22px;align-items:flex-end}
.stepper{display:flex;align-items:center;border:1px solid var(--line-strong);border-radius:2px;background:#fff;width:max-content}
.stepper button{width:38px;height:40px;border:0;background:#fff;color:var(--navy);font-size:19px;cursor:pointer;line-height:1}
.stepper button:hover{background:var(--mist)}
.stepper button:disabled{color:#B8C3D3;cursor:not-allowed;background:#fff}
.field .stepper input[type=number]{width:58px;height:40px;padding:0;border:0;border-left:1px solid var(--line);border-right:1px solid var(--line);border-radius:0;text-align:center;font-size:16px;-moz-appearance:textfield;appearance:textfield}
.stepper input::-webkit-outer-spin-button,.stepper input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
.counts .covbox{width:120px}
.floortbl{border:1px solid var(--line-strong);background:#fff}
.floortbl table{width:100%;border-collapse:collapse}
.floortbl th,.floortbl td{padding:7px 10px;font-size:13.5px;vertical-align:middle;text-align:left;border-bottom:1px solid var(--line)}
.floortbl thead th{background:var(--navy);color:#fff;font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.13em;text-transform:uppercase;font-weight:500}
.floortbl .num{text-align:right}
.floortbl td.name{font-weight:600;color:var(--navy)}
.field .floortbl input[type=number]{width:120px;font-size:14px;padding:6px 8px;text-align:right}
.floortbl tr.edited input{border-color:var(--blue-bright);background:#EEF5FF}
.floortbl tfoot td{background:var(--mist);font-family:"IBM Plex Mono";font-size:13px;font-weight:600;color:var(--navy);border-bottom:0}
.linkbtn{background:none;border:0;padding:6px 0;color:var(--blue-bright);font-size:13px;cursor:pointer;text-decoration:underline;text-underline-offset:3px;margin-right:14px}
.drw{display:flex;gap:11px;align-items:flex-start;padding:10px 0;border-top:1px solid var(--line);cursor:pointer}
.drw:last-child{border-bottom:1px solid var(--line)}
.drw input{width:18px;height:18px;margin:2px 0 0;accent-color:var(--blue-bright);flex:none}
.drw b{display:block;font-weight:600;color:var(--navy);font-size:14.5px}
.drw span{display:block;font-size:12.5px;color:var(--muted);line-height:1.45}
.drw .std{font-family:"IBM Plex Mono";font-size:9.5px;letter-spacing:.1em;color:var(--blue);border:1px solid var(--line-strong);padding:1px 5px;border-radius:2px;margin-left:6px;vertical-align:2px;display:inline}
.chkline{display:flex;align-items:center;gap:9px;font-size:14px;color:var(--navy);cursor:pointer}
.chkline input{width:17px;height:17px;accent-color:var(--blue-bright);margin:0}

.out-row{display:flex;justify-content:space-between;align-items:baseline;padding:13px 0;border-bottom:1px solid rgba(255,255,255,.13);gap:12px}
.out-row .k{font-size:14px;color:#A9C2DC}
.out-row .k em{font-style:normal;display:block;font-family:"IBM Plex Mono";font-size:11px;color:#7FA0C4;letter-spacing:.05em}
.out-row .v{font-family:"IBM Plex Mono";font-size:17px;color:#fff;white-space:nowrap}
.out-list{margin:14px 0 0;padding:0;list-style:none;font-size:13px;color:#C9DAF0}
.out-list li{padding:3px 0 3px 20px;position:relative}
.out-list li::before{content:"✓";position:absolute;left:0;color:#5FA3E8;font-weight:700}
.total{margin-top:22px;padding-top:20px;border-top:2px solid var(--blue)}
.total .k{font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#8FB8E4;margin-bottom:8px}
.total .big{font-family:"Archivo";font-weight:800;font-size:clamp(30px,4.4vw,42px);letter-spacing:-.03em;line-height:1.05;color:#fff}
.total .alt{font-family:"IBM Plex Mono";font-size:14px;color:#7FB2E8;margin-top:8px}
.note-box{border-left:4px solid #C9A227;background:#FFFBEA;padding:11px 15px;font-size:13px;color:#5A4A00;margin-top:12px;line-height:1.5}
.note-box:empty{display:none}
.disclaim{font-size:12px;color:#7FA0C4;margin-top:22px;line-height:1.55}

/* ── content blocks ───────────────────────────────────── */
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--line);border:1px solid var(--line);margin-top:32px}
.grid3 .cell{background:#fff;padding:22px 20px}
.grid3 .cell .n{font-family:"IBM Plex Mono";font-size:11px;color:var(--blue);letter-spacing:.12em;margin-bottom:9px}
.grid3 .cell h4{font-size:15.5px;font-weight:700;margin-bottom:6px}
.grid3 .cell p{font-size:13.5px;color:var(--muted);margin:0;line-height:1.5}
@media(max-width:900px){.grid3{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.grid3{grid-template-columns:1fr}}
.caps{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.14);margin-top:34px}
.cap{background:var(--ink);padding:24px 22px}
.cap .n{font-family:"IBM Plex Mono";font-size:11px;color:#5FA3E8;letter-spacing:.14em;margin-bottom:10px}
.cap h4{font-size:16px;color:#fff;margin-bottom:6px}
.cap p{font-size:13.5px;color:#A9C2DC;margin:0;line-height:1.55}
.cap ul{margin:8px 0 0;padding-left:18px;font-size:13px;color:#A9C2DC;line-height:1.55}
@media(max-width:880px){.caps{grid-template-columns:repeat(2,1fr)}}
@media(max-width:520px){.caps{grid-template-columns:1fr}}
footer{background:var(--ink);color:#7FA0C4;padding:34px 0;font-size:13px;border-top:1px solid rgba(255,255,255,.1)}
footer .wrap{display:flex;flex-wrap:wrap;gap:14px;justify-content:space-between;align-items:center}
footer b{color:#C9DAF0;font-weight:600}

/* ══ QUOTATION DOCUMENT ══════════════════════════════════ */
.quote-toolbar{position:sticky;top:0;z-index:80;background:var(--ink);color:#fff;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.15)}
.quote-toolbar .wrap{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.quote-toolbar .ttl{font-family:"IBM Plex Mono";font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#8FB8E4;margin-right:auto}
.quote-stage{background:#E8EDF3;padding:26px 16px 60px}
.quote-doc{
  width:210mm;max-width:100%;margin:0 auto;background:#fff;color:#1A1A1A;min-height:297mm;
  padding:16mm 15mm;box-shadow:0 2px 24px rgba(0,40,90,.16);font-size:11.2px;line-height:1.5;
}
.quote-doc *{box-sizing:border-box}
.lh{display:flex;align-items:flex-start;gap:20px;padding-bottom:12px;border-bottom:3px solid var(--navy)}
.lh img{width:118px;height:auto;flex:none}
.lh .co{margin-left:auto;text-align:right;font-size:10.4px;color:#333;line-height:1.62}
.lh .co b{display:block;font-family:"Archivo";font-weight:800;font-size:14px;color:var(--navy);letter-spacing:-.01em;margin-bottom:2px}
.lh .co span{display:block;color:#5A6B82;margin-bottom:2px}
.lh .co .qfor{display:block;margin-top:6px;padding-top:6px;border-top:1px solid #D6E0EE;font-weight:700;color:var(--navy);font-size:11px}
.lh-rule{height:3px;background:var(--blue);width:96px;margin-top:-3px}
.qtitle{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin:18px 0 14px}
.qtitle h1{font-family:"Archivo";font-weight:800;font-size:21px;color:var(--navy);letter-spacing:-.02em;margin:0}
.qtitle .sub{font-family:"IBM Plex Sans";font-weight:600;font-size:9.6px;letter-spacing:.11em;text-transform:uppercase;color:var(--blue);margin-top:4px}
.qmeta{font-family:"IBM Plex Sans";font-variant-numeric:tabular-nums;font-size:10.6px;text-align:right;color:#444;line-height:1.8;white-space:nowrap}
.qmeta b{color:var(--navy)}
.qto{display:grid;grid-template-columns:1fr 1fr;gap:0;border:1px solid #C9D6E6;margin-bottom:12px}
.qto > div{padding:10px 13px}
.qto > div:first-child{border-right:1px solid #C9D6E6}
.qto .lbl{font-family:"IBM Plex Sans";font-weight:600;font-size:9px;letter-spacing:.09em;text-transform:uppercase;color:#5A6B82;margin-bottom:4px}
.qto .val{font-weight:600;color:var(--navy);font-size:12px}
.qto .val small{display:block;font-weight:500;color:#333;font-size:11px}
.qsubj{border:1px solid #C9D6E6;border-left:4px solid var(--navy);background:#F4F8FC;padding:9px 13px;margin-bottom:12px;font-weight:700;color:var(--navy);font-size:11.2px;letter-spacing:.02em}
.qsubj b{font-family:"IBM Plex Sans";font-weight:600;font-size:9px;letter-spacing:.09em;color:#5A6B82;margin-right:8px}
.qletter{font-size:11px;margin:0 0 14px}
.qletter p{margin:0 0 4px}
.qsection{margin:0 0 16px;page-break-inside:avoid}
.qsection > h2{
  font-family:"Archivo";font-weight:700;font-size:12.4px;color:#fff;background:var(--navy);
  padding:6px 12px;margin:0 0 9px;letter-spacing:.02em;display:flex;align-items:baseline;gap:9px;
}
.qsection > h2 i{font-family:"IBM Plex Sans";font-style:normal;font-weight:600;font-size:9.8px;color:#8FB8E4;letter-spacing:.05em}
table.qt{width:100%;border-collapse:collapse;min-width:0}
table.qt th,table.qt td{border:1px solid #C9D6E6;padding:6px 9px;font-size:10.6px;text-align:left;vertical-align:top}
table.qt thead th{background:#EAF1FA;color:var(--navy);font-family:"IBM Plex Sans";font-size:9.2px;letter-spacing:.07em;text-transform:uppercase;font-weight:700}
table.qt td.n,table.qt th.n{text-align:right;font-family:"IBM Plex Sans";font-variant-numeric:tabular-nums;white-space:nowrap}
table.qt td.c,table.qt th.c{text-align:center;width:34px;font-family:"IBM Plex Sans";font-variant-numeric:tabular-nums}
table.qt td.k{background:#F4F8FC;font-weight:600;color:var(--navy);width:24%}
table.qt td.tick{text-align:center;width:34px;color:var(--blue-bright);font-weight:700;font-size:13px}
table.qt tr.grand td{background:var(--navy);color:#fff;font-weight:700;font-size:12px;border-color:var(--navy)}
table.qt tr.sub td{background:#F4F8FC;font-weight:600;color:var(--navy)}
.qd{color:#5A6B82;font-size:9.6px}
.inwords{border:1px solid #C9D6E6;border-top:0;padding:8px 12px;background:#FAFCFE;font-size:10.6px}
.inwords b{font-family:"IBM Plex Sans";font-weight:600;font-size:9px;letter-spacing:.09em;text-transform:uppercase;color:#5A6B82;margin-right:8px}
.qcols{display:grid;grid-template-columns:1fr 1fr;gap:0;border:1px solid #C9D6E6}
.qcols > div{padding:10px 13px}
.qcols > div:first-child{border-right:1px solid #C9D6E6}
.qcols h4{font-family:"Archivo";font-weight:700;font-size:11.4px;color:var(--navy);margin:0 0 7px}
.qcols p{font-size:10.2px;color:#333;margin:0 0 6px}
.qlist{list-style:none;margin:0 0 8px;padding:0}
.qlist li{font-size:10.2px;padding:1.5px 0 1.5px 11px;position:relative;break-inside:avoid;color:#333}
.qlist li::before{content:"";position:absolute;left:0;top:8px;width:6px;height:1.5px;background:var(--blue)}
.terms{margin:0;padding-left:17px;font-size:10.3px;color:#333}
.terms li{padding:2.5px 0}
.qclose{margin-top:18px;font-size:11px;page-break-inside:avoid}
.qclose p{margin:0 0 3px}
.qclose .nm{font-family:"Archivo";font-weight:700;color:var(--navy);font-size:12px;margin-top:10px}
.sign{display:grid;grid-template-columns:1fr 1fr;gap:34px;margin-top:22px;page-break-inside:avoid}
.sign > div{padding-top:40px;border-top:1px solid #333}
.sign .r{font-family:"Archivo";font-weight:700;font-size:11.4px;color:var(--navy)}
.sign .s{font-size:9.6px;color:#5A6B82;margin-top:2px}
.qfoot{margin-top:22px;padding-top:9px;border-top:1px solid #C9D6E6;font-size:9.2px;color:#5A6B82;display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap}
@media screen and (max-width:760px){
  .quote-doc{width:100%;padding:18px 14px;font-size:11.6px}
  .qto,.qcols{grid-template-columns:1fr}
  .qto > div:first-child,.qcols > div:first-child{border-right:0;border-bottom:1px solid #C9D6E6}
  .qtitle{flex-direction:column;align-items:flex-start}
  .qmeta{text-align:left}
  .sign{grid-template-columns:1fr;gap:16px}
}
@media print{
  @page{size:210mm 297mm portrait;margin:14mm 12mm 14mm 12mm}
  html,body{background:#fff!important;width:auto!important}
  body.quote-mode .qhead{background:#fff;-webkit-print-color-adjust:exact;print-color-adjust:exact}
  body.quote-mode #site{display:none!important}
  body.quote-mode header.bar,body.quote-mode .quote-toolbar{display:none!important}
  body.quote-mode .quote-stage{background:#fff;padding:0;margin:0!important;border:0!important}
  body.quote-mode .quote-doc{
    width:auto!important;max-width:none!important;min-width:0!important;min-height:0!important;
    padding:0!important;box-shadow:none!important;margin:0!important;font-size:10.2px;transform:none!important;
  }
  body.quote-mode table.qt{table-layout:fixed;width:100%!important}
  body.quote-mode table.qt td{word-wrap:break-word;overflow-wrap:anywhere}
  .qsection,.sign,.qto,.qclose{page-break-inside:avoid}
  .lh,.qsubj,table.qt thead th,table.qt tr.grand td,.qsection > h2{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  header.bar,.printhide{display:none!important}
  .est-out{position:static}
}
</style>
</head>
<body>

<div id="site">

<header class="bar">
  <div class="wrap">
    <a class="logo" href="#top">ACCO <span>Ahmed Construction Co.</span></a>
    <nav class="links">
      <a href="#estimator">Quotation</a>
      <a href="#drawings">Drawings</a>
      <a href="#why">Why ACCO</a>
      <a href="#terms">Terms</a>
    </nav>
    <a class="btn printhide" href="#estimator">Prepare quotation</a>
  </div>
</header>

<!-- ═══ HERO ═══ -->
<div class="hero" id="top">
  <div class="wrap">
    <div class="year-tag">HOSPITAL DESIGN · PAKISTAN</div>
    <h1>Hospital design services, <em>priced per square foot.</em></h1>
    <p class="lede">PHC-compliant architecture and construction design for hospitals and medical centres. Enter the plot, the floors and the drawings to be provided — the covered area, design fee and client quotation follow.</p>

    <div class="rates">
      <div class="rate">
        <div class="lbl">Design fee</div>
        <div class="val">Rs 25<small>/ SFT</small></div>
        <div class="sub">Architecture and construction design, charged on the total covered area of every floor.</div>
      </div>
      <div class="rate">
        <div class="lbl">Standard package</div>
        <div class="val">6<small>DRAWING SETS</small></div>
        <div class="sub">3D elevations, furniture layouts, architectural, structural with stability certificate, public health and electrical.</div>
      </div>
      <div class="rate">
        <div class="lbl">Deliverables</div>
        <div class="val">A3<small>+ CAD FILES</small></div>
        <div class="sub">Drawings for approval and construction, with AutoCAD soft copies.</div>
      </div>
    </div>

    <div class="citystrip">
      <b>Compliance</b>
      <span>Building Code of Pakistan — seismic &amp; fire safety · PEC guidelines · Provincial Healthcare Commissions</span>
    </div>
  </div>
</div>

<!-- ═══ ESTIMATOR ═══ -->
<section class="tint" id="estimator">
  <div class="wrap">
    <p class="eyebrow">Quotation builder</p>
    <h2>Prepare a hospital design quotation</h2>
    <p class="section-lede">Enter the inquiry number to pull the client from the inquiries list, then the plot, floors and drawings. The fee updates as you go; create the PDF when it is ready.</p>

    <div class="est">
      <div class="est-controls">
        <div class="field">
          <span class="ctrl-label">Client</span>
          <label class="mini" for="qInq">Client ID — inquiry number</label>
          <div class="lookup">
            <input type="number" id="qInq" class="txt" min="1" step="1" inputmode="numeric" placeholder="e.g. 1235">
            <button type="button" class="btn" id="qInqGo">Fetch client</button>
          </div>
          <div class="lookstat" id="qInqStat" role="status"></div>
          <div id="qInqSource"></div>
          <div class="grid2" style="margin-top:10px">
            <div><label class="mini" for="qClient">Client name</label><input type="text" id="qClient" class="txt" placeholder="e.g. Dr Bilal Alvi"></div>
            <div><label class="mini" for="qSal">Salutation</label>
              <select id="qSal" class="sel"><option value="Sir">Dear Sir</option><option value="Madam">Dear Madam</option><option value="Sir / Madam">Dear Sir / Madam</option></select></div>
            <div class="full"><label class="mini" for="qOrg">Organisation / hospital name</label><input type="text" id="qOrg" class="txt" placeholder="e.g. Rahim-u-din Naeem Foundation Hospital"></div>
            <div class="full"><label class="mini" for="qLoc">Location of project</label><input type="text" id="qLoc" class="txt" placeholder="e.g. Azad Jammu and Kashmir"></div>
          </div>
        </div>

        <div class="field">
          <span class="ctrl-label">Hospital</span>
          <div class="grid2">
            <div><label class="mini" for="qBeds">Number of beds (optional)</label><input type="number" id="qBeds" class="txt" min="0" step="1" inputmode="numeric" placeholder="e.g. 500"></div>
            <div><label class="mini" for="qType">Hospital type</label><select id="qType" class="sel"></select></div>
          </div>
        </div>

        <div class="field">
          <span class="ctrl-label">Plot size</span>
          <div class="plotin">
            <input type="number" id="pVal" min="0" step="any" value="10" inputmode="decimal" aria-label="Plot size">
            <select id="pUnit" class="sel" aria-label="Plot size unit"></select>
          </div>
          <div class="plotarea" id="plotArea">—</div>
        </div>

        <div class="field">
          <span class="ctrl-label">Floors</span>
          <div class="counts">
            <div><span class="mini">Basements</span>
              <div class="stepper" data-k="b"><button type="button" data-d="-1" aria-label="Fewer basements">−</button><input type="number" id="vB" min="0" max="5" step="1" inputmode="numeric" aria-label="Number of basements"><button type="button" data-d="1" aria-label="More basements">+</button></div>
            </div>
            <div><span class="mini">Floors above ground</span>
              <div class="stepper" data-k="u"><button type="button" data-d="-1" aria-label="Fewer upper floors">−</button><input type="number" id="vU" min="0" max="30" step="1" inputmode="numeric" aria-label="Number of floors above ground"><button type="button" data-d="1" aria-label="More upper floors">+</button></div>
            </div>
            <div class="covbox"><label class="mini" for="cov">Coverage %</label><input type="number" id="cov" min="0" max="100" step="any" inputmode="decimal"></div>
          </div>
          <div class="hint" id="cfgHint"></div>
        </div>

        <div class="field">
          <span class="ctrl-label">Covered area by floor (SFT)</span>
          <div class="floortbl">
            <table>
              <thead><tr><th>Floor</th><th class="num">Area (SFT)</th></tr></thead>
              <tbody id="floorBody"></tbody>
              <tfoot><tr><td>Total covered area</td><td class="num" id="floorTotal">—</td></tr></tfoot>
            </table>
          </div>
          <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:10px">
            <label class="mini" for="allArea" style="margin:0">Same area on every floor</label>
            <input type="number" id="allArea" min="0" step="any" inputmode="decimal" placeholder="SFT" style="width:140px;font-size:14px;padding:7px 9px">
            <button type="button" class="linkbtn" id="applyAll">Apply</button>
            <button type="button" class="linkbtn" id="resetAreas">Reset to coverage</button>
          </div>
          <div style="margin-top:12px"><label class="mini" for="other">Mumty, machine rooms and service areas (SFT)</label>
            <input type="number" id="other" min="0" step="any" value="0" inputmode="decimal"></div>
          <div class="hint">Each floor defaults to plot area × coverage. Type over any floor to match the client's brief.</div>
        </div>

        <div class="field" id="drawings">
          <span class="ctrl-label">Drawings and design work to be provided</span>
          <div id="drwList"></div>
          <button type="button" class="linkbtn" id="drwStd">Standard package</button>
          <button type="button" class="linkbtn" id="drwAll">Select all</button>
          <button type="button" class="linkbtn" id="drwNone">Clear</button>
        </div>

        <div class="field">
          <span class="ctrl-label">Design rate</span>
          <label class="mini" for="rate">Rs per SFT of covered area</label>
          <input type="number" id="rate" min="0" step="any" inputmode="decimal">
          <div class="hint">One rate covers every drawing selected above. Raise it when adding HVAC, medical gas or other specialist sets.</div>
        </div>

        <div class="field">
          <span class="ctrl-label">Quotation options</span>
          <label class="chkline"><input type="checkbox" id="optProfile" checked> Include "Why ACCO" — PHC-compliant hospital design profile</label>
        </div>
      </div>

      <div class="est-out" id="estOut">
        <div class="out-row"><div class="k">Plot<em id="oPlotBreak">—</em></div><div class="v" id="oPlot">—</div></div>
        <div class="out-row"><div class="k">Building<em id="oCfgBreak">—</em></div><div class="v" id="oCfg">—</div></div>
        <div class="out-row"><div class="k">Covered area<em id="oAreaBreak">—</em></div><div class="v" id="oArea">—</div></div>
        <div class="out-row"><div class="k">Design rate<em>PER SFT OF COVERED AREA</em></div><div class="v" id="oRate">—</div></div>
        <div class="out-row"><div class="k">Drawings<em id="oDrwBreak">—</em></div><div class="v" id="oDrw">—</div></div>
        <ul class="out-list" id="oDrwList"></ul>

        <div class="note-box" id="calcWarn" role="status"></div>
        <div class="total">
          <div class="k">Total design fee</div>
          <div class="big" id="oTotal">—</div>
          <div class="alt" id="oAlt">—</div>
        </div>

        <button class="btn" type="button" id="qGen" style="width:100%;margin-top:20px;padding:14px;font-size:15px">Create PDF quotation</button>
        <p class="disclaim">Design services only — construction, authority fees, soil investigation and site supervision are not included. If the covered area increases at the design stage, the fee increases at the same rate.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══ WHY ACCO ═══ -->
<section class="dark" id="why">
  <div class="wrap">
    <p class="eyebrow">Why ACCO</p>
    <h2>PHC-compliant hospital design experts</h2>
    <p class="section-lede">ACCO Architects designs hospitals that comply with Healthcare Commission guidelines, for doctors, healthcare groups, universities, government health departments and donor-funded projects across Pakistan.</p>
    <div class="caps" id="whyCaps"></div>
  </div>
</section>

<!-- ═══ TERMS ═══ -->
<section id="terms">
  <div class="wrap">
    <p class="eyebrow">Terms</p>
    <h2>Terms and conditions in the quotation</h2>
    <div class="grid3" id="termCells"></div>
  </div>
</section>

<footer>
  <div class="wrap">
    <div><b>Ahmed Construction Company (ACCO)</b> — Architecture · Engineering · Construction · 25+ years</div>
    <div>Hospital design quotation builder. Rates are indicative, not a contractual offer.</div>
  </div>
</footer>

</div><!-- /#site -->

<div id="quoteWrap" hidden>
  <div class="quote-toolbar">
    <div class="wrap">
      <span class="ttl">Quotation preview<br><span style="letter-spacing:0;text-transform:none;font-family:'IBM Plex Sans';font-size:11.5px;color:#7FA0C4">In the print dialog choose <b style="color:#B7CBE2">A4</b> paper and enable <b style="color:#B7CBE2">Background graphics</b></span></span>
      <button class="btn ghost" type="button" id="qBack">Back to builder</button>
      <button class="btn ghost" type="button" id="qSaveCopy">Save copy</button>
      <button class="btn" type="button" id="qPrint">Save as PDF</button>
    </div>
  </div>
  <div class="quote-stage"><div class="quote-doc" id="quoteDoc"></div></div>
</div>

<script src="@modernAsset('js/inquiry-lookup.js')?v={{ filemtime(public_path('js/inquiry-lookup.js')) }}"></script>
<script src="@modernAsset('js/hospital-design-calc.js')?v={{ filemtime(public_path('js/hospital-design-calc.js')) }}"></script>
<script>

(function(){
  "use strict";

  // calculation engine — public/js/hospital-design-calc.js; every figure comes from C.estimate()
  var C = window.HospitalCalc;
  if(!C){
    document.getElementById("calcWarn").textContent = "The calculation script (public/js/hospital-design-calc.js) did not load, so the quotation cannot be prepared. Check that the file is uploaded to the server.";
    return;
  }
  var fmt = C.fmt, ordinal = C.ordinal, estimate = C.estimate, inWords = C.inWords;
  var LOOKUP_URL = "{{ url('/quotation/inquiry') }}";

  var TYPES = ["General hospital","Teaching hospital","Multi-specialty hospital","Gynaecology & paediatric hospital",
    "Oncology & radiology centre","Cardiac & dialysis unit","Emergency & trauma centre","Maternity & neonatal care unit",
    "Diagnostic lab & imaging centre","Clinic / medical centre"];

  var WHY = [
    {t:"PHC standard-compliant design", d:"Designed to Healthcare Commission guidelines for healthcare facilities.",
      l:["Patient safety and hygiene protocols","Infection control zoning","Ventilation, isolation and sanitation areas","Emergency department planning","Medical waste management areas"]},
    {t:"Trusted by healthcare leaders", d:"Consultants and surgeons, hospital CEOs and healthcare groups, medical universities, government health departments, NGOs and donor-funded projects.",
      l:["Clinical accuracy for ICUs, OTs, radiology suites and diagnostic labs"]},
    {t:"Complete design-build services", d:"Concept to completion under one roof.",
      l:["Feasibility and site selection","Hospital master planning","MEP and HVAC for healthcare standards","Medical gas and specialised systems","Structural engineering","Fire protection and safety compliance","Construction supervision and quality control"]},
    {t:"PHC-aligned infrastructure", d:"Ready for routine operations and for trauma care, epidemics and disaster readiness.",
      l:["Infection prevention and control (IPC)","Emergency preparedness planning","Patient and caregiver safety","Staff workflow efficiency","Sustainable, climate-responsive concepts"]},
    {t:"Hospital designs for all scales", d:"From small clinics to 500-bed multi-specialty hospitals.",
      l:["General and teaching hospitals","Gynaecology and paediatric hospitals","Oncology and radiology centres","Cardiac and dialysis units","Emergency and trauma centres","Maternity and neonatal care units"]},
    {t:"National and international codes", d:"Headquartered in Lahore, serving Pakistan, the Middle East and South Asia.",
      l:["Building Code of Pakistan — seismic and fire safety","Pakistan Engineering Council (PEC) guidelines","Provincial Healthcare Commissions of Pakistan"]}
  ];

  function terms(){
    return [
      "This quotation excludes any tax.",
      "Work will start after advance payment.",
      "We will be providing A3 size drawings for approval and construction, along with CAD files.",
      "If the area of the design increases, the charge will also increase accordingly at the same rate per SFT.",
      "Drawings and services not listed in this quotation are not included and will be quoted separately if required.",
      "Authority scrutiny fees, NOCs, soil investigation and site supervision are not part of this quotation.",
      "This quotation is valid for 30 days from the above-mentioned date."
    ];
  }

  // ── formatting ────────────────────────────────
  function rs(n){ return "Rs " + fmt(n); }
  function qty(n){ return (Math.round(n*100)/100).toLocaleString("en-US", {maximumFractionDigits:2}); }
  function sft(n){ return qty(n) + " SFT"; }
  function words(n){
    if(n >= 10000000) return "≈ Rs " + (n/10000000).toFixed(2) + " Crore";
    if(n >= 100000)   return "≈ Rs " + (n/100000).toFixed(2) + " Lakh";
    return "";
  }
  function esc(s){
    return String(s == null ? "" : s).replace(/[&<>"]/g, function(c){
      return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;"}[c];
    });
  }
  function val(id){ return document.getElementById(id).value.trim(); }

  // ── state ─────────────────────────────────────
  var state = {plot:10, unit:"kanal", cov:C.COVERAGE, b:1, u:3, other:0, rate:C.RATE, over:{}, drw:{}};
  C.DRAWINGS.forEach(function(d){ state.drw[d.id] = d.on; });

  function cfgNow(){
    return {plot:state.plot, unit:state.unit, cov:state.cov, b:state.b, u:state.u, other:state.other, rate:state.rate, over:state.over};
  }
  function chosen(){ return C.DRAWINGS.filter(function(d){ return state.drw[d.id]; }); }

  // ── controls ──────────────────────────────────
  document.getElementById("qType").innerHTML = TYPES.map(function(t){ return '<option>' + esc(t) + '</option>'; }).join("");
  var pUnit = document.getElementById("pUnit");
  pUnit.innerHTML = C.UNITS.map(function(u){ return '<option value="' + u.id + '">' + esc(u.label) + '</option>'; }).join("");
  pUnit.value = state.unit;

  function numInput(id, fn){
    var el = document.getElementById(id);
    el.addEventListener("input", function(){
      var v = parseFloat(el.value), ok = el.value !== "" && isFinite(v) && v >= 0;
      el.style.borderColor = ok ? "" : "#B3261E";
      if(ok) fn(v);
    });
  }
  numInput("pVal", function(v){ state.plot = v; state.over = {}; renderAll(); });
  pUnit.addEventListener("change", function(){ state.unit = pUnit.value; state.over = {}; renderAll(); });
  numInput("cov", function(v){ state.cov = Math.min(100, v); state.over = {}; renderAll(); });
  numInput("other", function(v){ state.other = v; render(); });
  numInput("rate", function(v){ state.rate = v; render(); });

  function setCount(k, v){
    state[k] = Math.max(0, Math.min(C.MAX[k], Math.round(v)));
    var keys = C.rowsOf(C.sanitize(cfgNow())).map(function(r){ return r.k; });
    Object.keys(state.over).forEach(function(key){ if(keys.indexOf(key) === -1) delete state.over[key]; });
  }
  Array.prototype.forEach.call(document.querySelectorAll(".stepper"), function(st){
    var k = st.getAttribute("data-k");
    st.addEventListener("click", function(e){
      var b = e.target.closest("button");
      if(!b || b.disabled) return;
      setCount(k, state[k] + parseInt(b.getAttribute("data-d"), 10));
      renderAll();
    });
    st.querySelector("input").addEventListener("input", function(e){
      var v = parseFloat(e.target.value);
      if(!isFinite(v)) return;
      setCount(k, v);
      renderAll();
    });
  });

  document.getElementById("applyAll").addEventListener("click", function(){
    var v = parseFloat(document.getElementById("allArea").value);
    if(!isFinite(v) || v < 0) return;
    C.rowsOf(C.sanitize(cfgNow())).forEach(function(r){ if(r.k !== "other") state.over[r.k] = v; });
    renderAll();
  });
  document.getElementById("resetAreas").addEventListener("click", function(){ state.over = {}; renderAll(); });

  // drawings checklist
  var drwList = document.getElementById("drwList");
  drwList.innerHTML = C.DRAWINGS.map(function(d){
    return '<label class="drw"><input type="checkbox" data-id="' + d.id + '">' +
      '<div><b>' + esc(d.label) + (d.on ? '<span class="std">STANDARD</span>' : '') + '</b><span>' + esc(d.desc) + '</span></div></label>';
  }).join("");
  drwList.addEventListener("change", function(e){
    var id = e.target.getAttribute("data-id");
    if(!id) return;
    state.drw[id] = e.target.checked;
    render();
  });
  function setDrawings(fn){ C.DRAWINGS.forEach(function(d){ state.drw[d.id] = fn(d); }); renderDrawings(); render(); }
  document.getElementById("drwStd").addEventListener("click", function(){ setDrawings(function(d){ return d.on; }); });
  document.getElementById("drwAll").addEventListener("click", function(){ setDrawings(function(){ return true; }); });
  document.getElementById("drwNone").addEventListener("click", function(){ setDrawings(function(){ return false; }); });
  function renderDrawings(){
    Array.prototype.forEach.call(drwList.querySelectorAll("input"), function(i){ i.checked = !!state.drw[i.getAttribute("data-id")]; });
  }

  // ── inquiry lookup — public/js/inquiry-lookup.js ──
  function attachLookup(){
    return InquiryLookup.attach({url:LOOKUP_URL, input:"qInq", button:"qInqGo", status:"qInqStat", source:"qInqSource", onFound:function(d){
      var h = d.hints, set = InquiryLookup.set, got = ["client name"], todo = [];
      document.getElementById("qClient").value = d.name || "";
      if(d.location){ document.getElementById("qLoc").value = d.location; got.push("location"); }
      if(h.hospital_type && set("qType", h.hospital_type, "change")) got.push(h.hospital_type.toLowerCase());
      if(h.beds){ set("qBeds", h.beds); got.push(h.beds + " beds"); }
      if(h.plot){
        // frontage × depth goes in as SFT; the other units exist on the page as they are
        set("pUnit", h.plot.w ? "sft" : h.plot.unit, "change");
        set("pVal", h.plot.w ? h.plot.sft : h.plot.value);
        got.push("plot " + InquiryLookup.plotText(h.plot));
      } else todo.push("plot size");
      if(h.floors){
        if(h.floors.b != null) set("vB", h.floors.b);
        if(h.floors.u != null) set("vU", h.floors.u);
        got.push("floors (" + h.floors.text + ")");
      } else todo.push("basements and floors");
      todo.push("covered area of each floor", "drawings");
      return {applied:got, notes:todo};
    }});
  }

  // ── rendering ─────────────────────────────────
  function setVal(id, v){ var el = document.getElementById(id); if(document.activeElement !== el) el.value = v; }

  function renderControls(){
    setVal("pVal", state.plot); setVal("cov", state.cov); setVal("other", state.other); setVal("rate", state.rate);
    setVal("vB", state.b); setVal("vU", state.u);
    pUnit.value = state.unit;
    Array.prototype.forEach.call(document.querySelectorAll(".stepper"), function(st){
      var k = st.getAttribute("data-k"), btns = st.querySelectorAll("button");
      btns[0].disabled = state[k] <= 0;
      btns[1].disabled = state[k] >= C.MAX[k];
    });
  }

  function renderFloors(){
    var rows = C.rowsOf(C.sanitize(cfgNow())).filter(function(r){ return r.k !== "other"; });
    var tb = document.getElementById("floorBody");
    tb.innerHTML = "";
    rows.forEach(function(r){
      var tr = document.createElement("tr");
      if(state.over[r.k] != null && state.over[r.k] !== r.def) tr.className = "edited";
      tr.innerHTML = '<td class="name">' + esc(r.label) + '</td>' +
        '<td class="num"><input type="number" min="0" step="any" inputmode="decimal" aria-label="' + esc(r.label) + ' area" value="' + (Math.round(r.area * 100) / 100) + '"></td>';
      tr.querySelector("input").addEventListener("input", function(e){
        var v = parseFloat(e.target.value);
        if(e.target.value === "") delete state.over[r.k];
        else state.over[r.k] = (isFinite(v) && v >= 0) ? v : 0;
        tr.className = (state.over[r.k] != null && state.over[r.k] !== r.def) ? "edited" : "";
        render();
      });
      tb.appendChild(tr);
    });
  }

  function render(){
    var e = estimate(cfgNow()), cfg = e.cfg, d = chosen();
    document.getElementById("calcWarn").textContent = e.warnings.length ? "Check inputs: " + e.warnings.join(" · ") + "." : "";
    var unit = C.byId(C.UNITS, cfg.unit);

    document.getElementById("plotArea").textContent = fmt(e.plotSft) + " SFT · " + fmt(e.plotSft / 9) + " sq yd · " + (Math.round(e.plotSft / 43560 * 100) / 100) + " acre";
    document.getElementById("cfgHint").textContent = e.desc + " — " + e.floors + (e.floors > 1 ? " floors" : " floor") + ".";
    document.getElementById("floorTotal").textContent = sft(e.total);

    document.getElementById("oPlot").textContent = qty(cfg.plot) + " " + unit.label;
    document.getElementById("oPlotBreak").textContent = fmt(e.plotSft) + " SFT · " + qty(cfg.cov) + "% COVERAGE";
    document.getElementById("oCfg").textContent = e.floors + (e.floors > 1 ? " floors" : " floor");
    document.getElementById("oCfgBreak").textContent = e.desc.toUpperCase();
    document.getElementById("oArea").textContent = sft(e.total);
    document.getElementById("oAreaBreak").textContent = e.uniform != null ? fmt(e.uniform) + " SFT EACH FLOOR" + (cfg.other ? " + " + fmt(cfg.other) + " OTHER" : "") : "AS PER FLOOR SCHEDULE";
    document.getElementById("oRate").textContent = "Rs " + qty(cfg.rate);
    document.getElementById("oDrw").textContent = d.length + " of " + C.DRAWINGS.length;
    document.getElementById("oDrwBreak").textContent = d.length ? "TICKED BELOW" : "NONE SELECTED";
    document.getElementById("oDrwList").innerHTML = d.map(function(x){ return "<li>" + esc(x.label) + "</li>"; }).join("");
    document.getElementById("oTotal").textContent = rs(e.fee);
    document.getElementById("oAlt").textContent = e.fee ? words(e.fee) + "   ·   " + sft(e.total) + " × Rs " + qty(cfg.rate) : "";
  }

  function renderAll(){ renderControls(); renderFloors(); render(); }

  document.getElementById("whyCaps").innerHTML = WHY.map(function(w, i){
    return '<div class="cap"><div class="n">0' + (i + 1) + '</div><h4>' + esc(w.t) + '</h4><p>' + esc(w.d) + '</p>' +
      '<ul>' + w.l.map(function(x){ return '<li>' + esc(x) + '</li>'; }).join("") + '</ul></div>';
  }).join("");
  document.getElementById("termCells").innerHTML = terms().map(function(t, i){
    return '<div class="cell"><div class="n">TERM ' + (i < 9 ? "0" : "") + (i + 1) + '</div><p style="color:#3B4A5E">' + esc(t) + '</p></div>';
  }).join("");

  // ══ QUOTATION GENERATOR ═══════════════════════════════
  var LOGO = "data:image/png;base64,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";

  var MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  function dateTxt(d){ return MONTHS[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear(); }
  function today(){ return dateTxt(new Date()); }
  function validTill(){ var d = new Date(); d.setDate(d.getDate() + 30); return dateTxt(d); }
  function inqNo(){ var n = parseInt(val("qInq"), 10); return n > 0 ? n : null; }
  var QREF = "";
  function refNo(){
    var n = inqNo();
    if(n) return "ACCO/QTN/HOS" + n;
    var d = new Date(), p = function(x){ return (x<10?"0":"") + x; };
    return "ACCO/QTN/HOS-" + d.getFullYear() + p(d.getMonth()+1) + p(d.getDate()) + "-" + String(Math.floor(Math.random()*900)+100);
  }

  function buildQuote(){
    QREF = refNo();
    var e = estimate(cfgNow()), cfg = e.cfg, d = chosen(), unit = C.byId(C.UNITS, cfg.unit);
    var client = val("qClient") || "—", org = val("qOrg"), loc = val("qLoc");
    var beds = parseInt(val("qBeds"), 10), type = document.getElementById("qType").value, inq = inqNo();
    var bldg = (beds > 0 ? beds + " Bed " : "") + "Hospital Building";
    var subject = "Quotation for design of " + bldg + (loc ? " at " + loc : "");
    var sec = 0;
    var head = function(t){ sec++; return '<div class="qsection"><h2><i>' + (sec < 10 ? "0" : "") + sec + '</i> ' + t + '</h2>'; };

    var html1 = head("Project particulars") + '<table class="qt"><tbody>' +
      '<tr><td class="k">Project</td><td colspan="3"><b>' + esc(bldg) + '</b> &nbsp;<span class="qd">' + esc(type) + '</span></td></tr>' +
      '<tr><td class="k">Location</td><td>' + esc(loc || "—") + '</td><td class="k">Client ID</td><td>' + (inq ? "#" + inq : "—") + '</td></tr>' +
      '<tr><td class="k">Plot size</td><td>' + qty(cfg.plot) + ' ' + esc(unit.label) + ' &nbsp;(' + fmt(e.plotSft) + ' SFT)</td>' +
          '<td class="k">Floors</td><td><b>' + e.floors + '</b> &mdash; ' + esc(e.desc) + '</td></tr>' +
      '<tr><td class="k">Total covered area</td><td><b>' + sft(e.total) + '</b></td><td class="k">Design rate</td><td>Rs ' + qty(cfg.rate) + ' / SFT</td></tr>' +
      '</tbody></table></div>';

    var html2 = head("Covered area schedule") + '<table class="qt"><thead><tr><th>Floor</th><th class="n">Covered area (SFT)</th></tr></thead><tbody>' +
      e.rows.map(function(r){ return '<tr><td>' + esc(r.label) + '</td><td class="n">' + qty(r.area) + '</td></tr>'; }).join("") +
      '<tr class="sub"><td>TOTAL COVERED AREA</td><td class="n">' + qty(e.total) + '</td></tr></tbody></table></div>';

    var areaNote = e.uniform != null ? "Covered area of each floor (" + fmt(e.uniform) + " SFT)" + (cfg.other ? ", plus " + fmt(cfg.other) + " SFT mumty, machine rooms and service areas" : "")
      : "Covered area as per the floor schedule above";
    var html3 = head("Cost summary") + '<table class="qt"><thead><tr><th class="c">Sr.#</th><th>Description</th><th class="n">Covered area</th><th class="n">Rate (Rs.)</th><th class="n">Amount (Rs.)</th></tr></thead><tbody>' +
      '<tr><td class="c">1</td><td><b>Architecture and Construction Design of ' + e.floors + ' Floor Hospital Building (' + esc(e.desc) + ')</b><br><span class="qd">' + esc(areaNote) + '</span></td>' +
        '<td class="n">' + qty(e.total) + ' SFT</td><td class="n">' + qty(cfg.rate) + '/-</td><td class="n">' + fmt(e.fee) + '/-</td></tr>' +
      '<tr class="grand"><td colspan="4">TOTAL COST</td><td class="n">' + rs(e.fee) + '/-</td></tr></tbody></table>' +
      '<div class="inwords"><b>In words</b>' + inWords(e.fee) + '</div></div>';

    var html4 = head("List of architectural design work") + (d.length
      ? '<table class="qt"><tbody>' + d.map(function(x){
          return '<tr><td class="tick">&#10003;</td><td><b>' + esc(x.label) + '</b><br><span class="qd">' + esc(x.desc) + '</span></td></tr>';
        }).join("") + '</tbody></table>'
      : '<div class="inwords" style="border-top:1px solid #C9D6E6">No drawings selected.</div>') + '</div>';

    var html5 = document.getElementById("optProfile").checked ? head("ACCO Architects — PHC-compliant hospital design experts") +
      '<div class="qcols">' +
        [WHY.slice(0, 3), WHY.slice(3)].map(function(col){
          return '<div>' + col.map(function(w){
            return '<h4>' + esc(w.t) + '</h4><p>' + esc(w.d) + '</p><ul class="qlist">' + w.l.map(function(x){ return '<li>' + esc(x) + '</li>'; }).join("") + '</ul>';
          }).join("") + '</div>';
        }).join("") +
      '</div></div>' : '';

    var html6 = head("Terms &amp; conditions") + '<ol class="terms">' + terms().map(function(x){ return '<li>' + esc(x) + '</li>'; }).join("") + '</ol></div>';

    var html =
    '<div class="qhead">' +
      '<div class="lh">' +
        '<img src="' + LOGO + '" alt="Ahmed Construction Company">' +
        '<div class="co"><b>AHMED CONSTRUCTION COMPANY</b>' +
          '<span>Architecture &middot; Engineering &middot; Construction</span>' +
          'Office 2, 3rd Floor, Bigcity Plaza, Gulberg-III, Lahore<br>' +
          '0322-8000190 &nbsp;|&nbsp; info@acco.com.pk &nbsp;|&nbsp; acco.com.pk' +
          '<span class="qfor">Prepared for: ' + esc(client) + '</span></div>' +
      '</div><div class="lh-rule"></div>' +
    '</div>' +
    '<div class="qtitle"><div><h1>Quotation — Hospital Design</h1>' +
      '<div class="sub">Architecture &amp; Construction Design Services</div></div>' +
      '<div class="qmeta"><b>Ref No</b> ' + esc(QREF) + '<br><b>Date</b> ' + today() + '<br><b>Valid till</b> ' + validTill() +
        (inq ? '<br><b>Client ID</b> #' + inq : '') + '</div></div>' +
    '<div class="qto">' +
      '<div><div class="lbl">To</div><div class="val">' + esc(client) + (org ? '<small>' + esc(org) + '</small>' : '') + '</div></div>' +
      '<div><div class="lbl">Project site</div><div class="val">' + esc(loc || "—") + '</div></div>' +
    '</div>' +
    '<div class="qsubj"><b>SUBJECT</b>' + esc(subject.toUpperCase()) + '</div>' +
    '<div class="qletter"><p>Dear ' + esc(document.getElementById("qSal").value) + ',</p><p>ACCO is pleased to submit our best quote for the subject work as follows:</p></div>' +
    html1 + html2 + html3 + html4 + html5 + html6 +
    '<div class="qclose"><p>We will be obliged for your cooperation in this regard.</p><p>Thanks &amp; Regards,</p>' +
      '<div class="nm">Tanveer Ahmed</div><p>Director, Ahmed Construction Company</p></div>' +
    '<div class="sign">' +
      '<div><div class="r">For Ahmed Construction Company</div><div class="s">Authorised signatory &nbsp;|&nbsp; Date</div></div>' +
      '<div><div class="r">Accepted by client</div><div class="s">Name, signature &amp; CNIC &nbsp;|&nbsp; Date</div></div>' +
    '</div>' +
    '<div class="qfoot"><span>Ahmed Construction Company (ACCO) &middot; Architecture, Engineering &amp; Construction &middot; 25+ years</span>' +
      '<span>This quotation supersedes all previous verbal or written estimates for this project.</span></div>';

    document.getElementById("quoteDoc").innerHTML = html;
  }

  function showQuote(show){
    document.body.classList.toggle("quote-mode", show);
    document.getElementById("site").hidden = show;
    document.getElementById("quoteWrap").hidden = !show;
    window.scrollTo(0,0);
  }

  document.getElementById("qGen").addEventListener("click", function(){ buildQuote(); showQuote(true); });
  document.getElementById("qBack").addEventListener("click", function(){ showQuote(false); });

  // filename used for both save actions — inquiry number first, then client name
  function quoteFileName(){
    var c = val("qClient").replace(/[^A-Za-z0-9 ]/g,"").replace(/\s+/g,"-");
    var n = inqNo();
    return [n ? "HOS" + n : "", c].filter(Boolean).join("-") || QREF.replace(/[^A-Za-z0-9]/g,"-");
  }

  function needClient(){
    if(val("qClient")) return false;
    showQuote(false);
    var el = document.getElementById("qClient");
    el.focus();
    el.style.borderColor = "#0057B8";
    el.placeholder = "Enter client name — used for the file name";
    return true;
  }

  // Save as PDF — names the file via document.title, then opens the print dialog
  document.getElementById("qPrint").addEventListener("click", function(){
    if(needClient()) return;
    var t = document.title;
    document.title = quoteFileName();
    window.print();
    setTimeout(function(){ document.title = t; }, 1200);
  });

  // Save copy — downloads the quotation as a standalone HTML file
  document.getElementById("qSaveCopy").addEventListener("click", function(){
    if(needClient()) return;
    var css = "";
    Array.prototype.forEach.call(document.querySelectorAll("style"), function(s){ css += s.textContent + "\n"; });
    var doc = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">' +
      '<meta name="viewport" content="width=device-width, initial-scale=1">' +
      '<title>' + esc(quoteFileName()) + '</title>' +
      '<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">' +
      '<style>' + css + 'body{margin:0;background:#E8EDF3}</style></head>' +
      '<body class="quote-mode"><div class="quote-stage"><div class="quote-doc">' +
      document.getElementById("quoteDoc").innerHTML +
      '</div></div></body></html>';
    var blob = new Blob([doc], {type:"text/html;charset=utf-8"});
    var url = URL.createObjectURL(blob);
    var link = document.createElement("a");
    link.href = url; link.download = quoteFileName() + ".html";
    document.body.appendChild(link); link.click(); document.body.removeChild(link);
    setTimeout(function(){ URL.revokeObjectURL(url); }, 4000);
  });

  renderDrawings();
  renderAll();
  attachLookup();   // also fetches ?inquiry=1235 straight away
})();

</script>
</body>
</html>
