
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
        const elm = ev.target;
        if ( triggers.includes( elm ) ) {
          ev.preventDefault();
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
    var id       = '#' + target.getAttribute('id');
    var button   = document.querySelector('[data-target="' + id + '"]');
    var desc     = document.querySelector( id + ' .panel_description');
    console.log(desc);
    var expanded =  null;
    if ( button ) {
      expanded = button.getAttribute('aria-expanded');
      if ( expanded === "false" ) {
        button.setAttribute("aria-expanded", true );
        if ( desc ) {
          desc.setAttribute("tabindex", 0);
        }
      } 
      else {
        button.setAttribute("aria-expanded", false );
        if ( desc  ) {
          desc.removeAttribute("tabindex");
        }
      }
    } 
  });
}