/**
 * File collapse.js.
 *
 * Handler that uses various data-* attributes to trigger
 * specific actions, mimicking bootstraps attributes or collapse function
 * Basic Vanilla JS script adapted from here:
 * https://medium.com/dailyjs/mimicking-bootstraps-collapse-with-vanilla-javascript-b3bb389040e7
 *
 */

"use strict";

/* Polyfill for use of Array.from below.
 * Production steps of ECMA-262, Edition 6, 22.1.2.1
 */  
if (!Array.from) {
  Array.from = (function () {
      var symbolIterator;
      try {
          symbolIterator = Symbol.iterator
              ? Symbol.iterator
              : 'Symbol(Symbol.iterator)';
      } catch (e) {
          symbolIterator = 'Symbol(Symbol.iterator)';
      }

      var toStr = Object.prototype.toString;
      var isCallable = function (fn) {
          return (
              typeof fn === 'function' ||
              toStr.call(fn) === '[object Function]'
          );
      };
      var toInteger = function (value) {
          var number = Number(value);
          if (isNaN(number)) return 0;
          if (number === 0 || !isFinite(number)) return number;
          return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
      };
      var maxSafeInteger = Math.pow(2, 53) - 1;
      var toLength = function (value) {
          var len = toInteger(value);
          return Math.min(Math.max(len, 0), maxSafeInteger);
      };

      var setGetItemHandler = function setGetItemHandler(isIterator, items) {
          var iterator = isIterator && items[symbolIterator]();
          return function getItem(k) {
              return isIterator ? iterator.next() : items[k];
          };
      };

      var getArray = function getArray(
          T,
          A,
          len,
          getItem,
          isIterator,
          mapFn
      ) {
          // 16. Let k be 0.
          var k = 0;

          // 17. Repeat, while k < len… or while iterator is done (also steps a - h)
          while (k < len || isIterator) {
              var item = getItem(k);
              var kValue = isIterator ? item.value : item;

              if (isIterator && item.done) {
                  return A;
              } else {
                  if (mapFn) {
                      A[k] =
                          typeof T === 'undefined'
                              ? mapFn(kValue, k)
                              : mapFn.call(T, kValue, k);
                  } else {
                      A[k] = kValue;
                  }
              }
              k += 1;
          }

          if (isIterator) {
              throw new TypeError(
                  'Array.from: provided arrayLike or iterator has length more then 2 ** 52 - 1'
              );
          } else {
              A.length = len;
          }

          return A;
      };

      // The length property of the from method is 1.
      return function from(arrayLikeOrIterator /*, mapFn, thisArg */) {
          // 1. Let C be the this value.
          var C = this;

          // 2. Let items be ToObject(arrayLikeOrIterator).
          var items = Object(arrayLikeOrIterator);
          var isIterator = isCallable(items[symbolIterator]);

          // 3. ReturnIfAbrupt(items).
          if (arrayLikeOrIterator == null && !isIterator) {
              throw new TypeError(
                  'Array.from requires an array-like object or iterator - not null or undefined'
              );
          }

          // 4. If mapfn is undefined, then let mapping be false.
          var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
          var T;
          if (typeof mapFn !== 'undefined') {
              // 5. else
              // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
              if (!isCallable(mapFn)) {
                  throw new TypeError(
                      'Array.from: when provided, the second argument must be a function'
                  );
              }

              // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
              if (arguments.length > 2) {
                  T = arguments[2];
              }
          }

          // 10. Let lenValue be Get(items, "length").
          // 11. Let len be ToLength(lenValue).
          var len = toLength(items.length);

          // 13. If IsConstructor(C) is true, then
          // 13. a. Let A be the result of calling the [[Construct]] internal method
          // of C with an argument list containing the single item len.
          // 14. a. Else, Let A be ArrayCreate(len).
          var A = isCallable(C) ? Object(new C(len)) : new Array(len);

          return getArray(
              T,
              A,
              len,
              setGetItemHandler(isIterator, items),
              isIterator,
              mapFn
          );
      };
  })();
}

/* Main code for managing collapse functionality. */  
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
      if ( collapseAllItems.indexOf( elm ) !== -1 ) {
        ev.preventDefault();
        var selector = elm.getAttribute("data-target");
        collapseAllItems.forEach( function ( collapsibleItem ) {
          var collapsibleItemSelector = collapsibleItem.getAttribute(
            "data-target"
          );
          if ( selector == collapsibleItemSelector ) {
            collapse( selector, "toggle" );
          } else {
            collapse( collapsibleItemSelector, "hide" );
          }
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
  targets.forEach(function (target) {
    target.classList[fnmap[cmd]]("show");
    document.querySelector('[data-target="#' + target.getAttribute("id") + '"]').setAttribute("aria-expanded", attmap[cmd]);
  });
};
