/**
 * File collapse.js.
 *
 * Handler that uses various data-* attributes to trigger
 * specific actions, mimicking bootstraps attributes or collapse function
 * Basic Vanilla JS script adapted from here:
 * https://medium.com/dailyjs/mimicking-bootstraps-collapse-with-vanilla-javascript-b3bb389040e7
 *
 */

var triggers = Array.from(
  document.querySelectorAll('[data-toggle="collapse"]')
);
var collapseAllItems = Array.from(
  document.querySelectorAll('.collapse-all > div > [data-toggle="collapse"]')
);
window.addEventListener(
  "click",
  function (ev) {
    if ( triggers && triggers.length > 0 ) {
      var elm = ev.target;
      var elmParent = ev.target.parentNode.parentNode;
      if ( collapseAllItems.indexOf( elm ) !== -1 ) {
        ev.preventDefault();
        var selector = elm.getAttribute("data-target");
        collapseAllItems.forEach( function ( collapsibleItem ) {
          var collapsibleItemParent   = collapsibleItem.parentNode.parentNode;
          var collapsibleItemSelector = collapsibleItem.getAttribute("data-target");
          if ( collapsibleItemParent == elmParent ) {
            if ( selector == collapsibleItemSelector  ) {
            collapse( selector, "toggle" );
          } else {
            collapse( collapsibleItemSelector, "hide" );
          } }
        });
      } else {
        if ( triggers.indexOf(elm) !== -1 ) {
          ev.preventDefault();
          var _selector = elm.getAttribute("data-target");
          collapse(_selector, "toggle");
        }
      }
    }
  },
  false
);

var fnmap = {
  toggle: "toggle",
  show: "add",
  hide: "remove"
};

var attmap = {
  toggle: true,
  show: true,
  hide: false
};

var collapse = function collapse(selector, cmd) {
  var targets = Array.from(document.querySelectorAll(selector));
  targets.forEach(function (target, index ) {  
    var element = target;
    if ( target && target.classList ) {
      target.classList[fnmap[cmd]]("show");
    }
    if ( document.querySelector('[data-target="#' + target.getAttribute("id") + '"]') ) {
      document.querySelector('[data-target="#' + target.getAttribute("id") + '"]').setAttribute("aria-expanded", attmap[cmd]); 
    } 
  });
};
