/*
 * Inquiry lookup for the quotation builders (house, commercial plaza, hospital design).
 *
 * Fetches the client of an inquiry by its number from /quotation/inquiry/{id} and hands it to the page.
 * A page opened as ?inquiry=1235 looks that inquiry up straight away.
 *
 *   var inq = InquiryLookup.attach({url, input, button, status, onFound: function(client){ ... }});
 *   inq.number()   // the entered inquiry number, or null
 */
(function(){
  "use strict";

  function attach(o){
    var input = document.getElementById(o.input), button = document.getElementById(o.button), stat = document.getElementById(o.status);

    function number(){ var n = parseInt(input.value, 10); return n > 0 ? n : null; }
    function say(cls, txt){ stat.className = "lookstat" + (cls ? " " + cls : ""); stat.textContent = txt; }

    function lookup(){
      var id = number();
      if(!id){ say("err", "Enter the inquiry number from the inquiries page."); return; }
      say("", "Looking up inquiry #" + id + "…");
      fetch(o.url + "/" + id, {headers:{"Accept":"application/json","X-Requested-With":"XMLHttpRequest"}, credentials:"same-origin"})
        .then(function(r){ if(!r.ok) throw r.status; return r.json(); })
        .then(function(d){
          o.onFound(d);
          say("ok", "Inquiry #" + d.id + " — " + d.name + (d.location ? " · " + d.location : "") + (d.project_type ? " · " + d.project_type : "") + ". Check and edit below.");
        })
        .catch(function(code){
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

  window.InquiryLookup = {attach:attach};
})();
