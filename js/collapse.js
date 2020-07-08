
/**
 * File collapse.js.
 *
 * Handler that uses various data-* attributes to trigger
 * specific actions, mimicking bootstraps attributes or collapse function
 * Basic Vanilla JS script adapted from here: 
 * https://medium.com/dailyjs/mimicking-bootstraps-collapse-with-vanilla-javascript-b3bb389040e7
 *
 */

const triggers = Array.from( document.querySelectorAll('[data-toggle="collapse"]') );
window.addEventListener( 'click', ( ev ) => {
    if ( triggers && triggers.length > 0 ) {
        ev.preventDefault();
        const elm = ev.target;
        if ( triggers.includes( elm ) ) {
            const selector = elm.getAttribute('data-target');
            collapse( selector, 'toggle' );
        }
    }
}, false );

const fnmap = {
  'toggle': 'toggle',
  'show': 'add',
  'hide': 'remove'
};
const collapse = ( selector, cmd ) => {
  const targets = Array.from( document.querySelectorAll( selector ) );
  targets.forEach( target => {
    target.classList[fnmap[cmd]]('show');
  });
}