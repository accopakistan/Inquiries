/*
 * Inquiry lookup for the quotation builders (house, commercial plaza, hospital design).
 *
 * Fetches an inquiry by its number from /quotation/inquiry/{id} — client, location, description and the
 * details read from the description (hints: plot, floors, beds, scope, city, society, hospital type) —
 * and hands it to the page. A page opened as ?inquiry=1235 (the Prepare Quotation button) looks it up straight away.
 *
 *   var inq = InquiryLookup.attach({url, input, button, status, source, onFound: function(inquiry){
 *     ...fill the form...
 *     return {applied: ["client name", "plot 10 Marla"], notes: ["set the covered area"]};
 *   }});
 *   inq.number()   // the entered inquiry number, or null
 *
 * `source` is an element that then lists what was filled in (to check) and shows the inquiry description.
 */
(function(){
  "use strict";

  var UNIT = {marla:"Marla", kanal:"Kanal", acre:"Acre", sqyd:"sq yd", sft:"SFT"};

  function num(n){ return (Math.round(n * 100) / 100).toLocaleString("en-US"); }
  function esc(s){
    return String(s == null ? "" : s).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;"}[c]; });
  }
  // "10 Marla", "1 Kanal", "5,000 sq yd", "40' × 70'"
  function plotText(p){ return p.w ? num(p.w) + "' × " + num(p.d) + "'" : num(p.value) + " " + UNIT[p.unit]; }

  function showSource(el, d, res){
    var applied = (res && res.applied) || [], notes = (res && res.notes) || [];
    el.innerHTML =
      '<div style="border-left:4px solid #C9A227;background:#FFFBEA;padding:11px 15px;font-size:13px;color:#5A4A00;line-height:1.5;margin:0 0 18px">' +
        '<b>Filled in from inquiry #' + esc(d.id) + ' — please check:</b> ' + esc(applied.join(" · ") || "nothing") +
        (notes.length ? '<br><b>Still to do:</b> ' + esc(notes.join(" · ")) : '') +
        (d.description ? '<details open style="margin-top:8px"><summary style="cursor:pointer;font-weight:600">Inquiry description' +
          (d.project_type ? ' — ' + esc(d.project_type) : '') + '</summary>' +
          '<div style="white-space:pre-wrap;margin-top:6px;color:#3B4A5E">' + esc(d.description) + '</div></details>' : '') +
      '</div>';
  }

  function attach(o){
    var input = document.getElementById(o.input), button = document.getElementById(o.button), stat = document.getElementById(o.status);
    var source = o.source ? document.getElementById(o.source) : null;

    function number(){ var n = parseInt(input.value, 10); return n > 0 ? n : null; }
    function say(cls, txt){ stat.className = "lookstat" + (cls ? " " + cls : ""); stat.textContent = txt; }

    function lookup(){
      var id = number();
      if(!id){ say("err", "Enter the inquiry number from the inquiries page."); return; }
      say("", "Looking up inquiry #" + id + "…");
      fetch(o.url + "/" + id, {headers:{"Accept":"application/json","X-Requested-With":"XMLHttpRequest"}, credentials:"same-origin"})
        .then(function(r){ if(!r.ok) throw r.status; return r.json(); })
        .then(function(d){
          d.hints = d.hints || {};
          var res = o.onFound(d);
          say("ok", "Inquiry #" + d.id + " — " + d.name + (d.location ? " · " + d.location : "") + (d.project_type ? " · " + d.project_type : "") + ". Check and edit below.");
          if(source) showSource(source, d, res);
        })
        .catch(function(code){
          if(source) source.innerHTML = "";
          say("err", code === 404 ? "No inquiry #" + id + " found. Enter the client details by hand."
            : "Could not reach the inquiries list. Enter the client details by hand.");
        });
    }

    button.addEventListener("click", lookup);
    input.addEventListener("keydown", function(e){ if(e.key === "Enter"){ e.preventDefault(); lookup(); } });

    var start = parseInt(new URLSearchParams(window.location.search).get("inquiry"), 10);
    if(start > 0){ input.value = start; lookup(); }

    return {number:number, lookup:lookup};
  }

  // set a form control and fire the event the page listens for
  function set(id, value, evt){
    var el = document.getElementById(id);
    if(!el) return false;
    el.value = value;
    el.dispatchEvent(new Event(evt || "input", {bubbles:true}));
    return true;
  }

  window.InquiryLookup = {attach:attach, plotText:plotText, set:set};
})();
