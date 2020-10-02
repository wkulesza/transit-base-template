# Transit Base Template

This template is intended as a starting point for developing a GTFS-optimized Wordpress site, specifically for public transit agencies. It works in tandem with the [Transit Custom Posts](https://github.com/trilliumtransit/transit-custom-posts) plugin in order to display automatically generated routes and timetables. You'll also need a publically exported GTFS feed if you want to use its best features. 

While this template can function as a stand-alone theme, it's not quite ready to be used that way. Some front-end development experience is necessary to get the most out of it; consider this template a huge head start on developing an accessible, easy-to-maintain transit theme.

## Installation

* [Download ZIP](https://github.com/trilliumtransit/transit-base-template/archive/master.zip)
* Install from the WP Admin area in Appearance > Themes > Add new > Upload Theme
* Once you have activated the theme, it will prompt you to install the Transit Custom Posts plugin

## Theme Features

### Transit Custom Posts compatibility

Many of the Transit Custom Posts API functions show up in this theme. Have an idea for something bigger, better? Feel free to use this theme as a working example for how to use the plugin API and put your GTFS data to work. There's a template for route pages and a board meetings page, two menus, two (optional) sidebars, homepage widgets, and other helpers. The static front-page template is already set up to display recent news and active alerts, and featured images are enabled throughout.

### Trip Planner (Google Maps)

A trip planner form is already packaged and included on the front page, with just enough JavaScript to make it responsive and easy-to-use. It redirects to the Google transit directions service (although can be tailored with some familiarity with the Google Maps API to provide directions on your site). If you have a Google Places API key, you can also enable autocomplete on the form fields and center results around your agency location. 

You can set the Google API Key for the Trip Planner by going to Appearance > Customize > Transit Base Theme options within the Wordpress Dashboard.

### Interactive Map 

The interactive map page template has been added that includes an iframe to a separately generated interactive map. If you have a map key, then you can add or update it by going to Appearance > Customize > Transit Base Theme options within the Wordpress Dashboard. The template will display nothing if a key has not been added or is not working.


### Best Practices

Because it's based on _s, Automattic's starter theme, this theme benefits from over 1000 hours of development and refinement baked in from the very start. The Transit Base Template continues in that vein, using development best practices whenever possible. We strive to keep it:

* Accessible

	Public transit websites are required to be WCAG 2.0 compliant. We incorporate accessibility into the base code including ARIA markup, semantic HTML, screen-reader-text, and keyboard controls. 
* Translatable
	
	Uses Wordpress' built-in translation functions so the theme can easily be extended into other languages.
* Lightweight
	
	No jQuery. No Bootstrap. Just lean, thoughtful HTML and ultra-fast, vanilla JavaScript. One tiny JS library is used for the planner date and time pickers, but that's it.
* Mobile-first

	There's just enough CSS to put a wrapper on the site, but what's there is always mobile-first. 

### Transit Icon Pack

Thirty (mostly transit-related) SVG icons from the Noun Project are included just in case you need to sprinkle a little flavor on the site. They'll only load if you include them in the theme, so don't worry about them if you don't need them. If you do, though, there's a nice convenience function for including and styling the icons within the theme. 

```php
get_svg_icon('light-rail', 'small');
```

## Development Guidelines

Use this theme however you like! It's GPLv2 and yours to hack and modify as you please. We don't currently recommend using it as a parent theme, however, since development is still in flux. Stay tuned for stable release 1.0.0 if you're looking for a stand-alone or parent theme!

A couple of simple functions have been built into the theme for making CSS changes and can be run via NPM. Commands include: 
- npm run watch - Will transpile CASS and watch for changes
- npm run build - Will transpile CSS
- npm test - Tests that sass node module is installed and working 

A collapse function that follows the syntax for Bootstrap's collapse has also been built in for creating easy accordions and hide/show panels. See Bootstrap documentation for how to implement. (https://getbootstrap.com/docs/4.3/components/collapse/)

Basic example of the collapse functionality on a menu structure: 
```
<ul id="primary-menu" class="collapse-all">
<li class="menu-item">
	<a href="#" role="button" data-toggle="collapse" data-target="#aMenuItemDropdown" aria-expanded="false" aria-controls="aMenuItemDropdown"> A Menu Item</a>
	<ul id="aMenuItemDropdown" class="sub-menu collapse">
		<li>Submenu Item</li>
	</ul>		
</li>	
```
The .collapse-all added to the collapse container element will collapse any open items when a new item is selected. If it is not added, then items will be left open until they are double clicked.
									
## How to Contribute

We welcome contributions in the form of pull-requests, documentation, and bug submission. Feedback and feature enhancement requests are appreciated as well; we're trying to build a theme that will actually get used, and it's our user ideas that matter most! 

If you're interested in submitting code, please read through the current issue log or send a message. 

## Credits

Theme created by Trillium Solutions, Inc for the Northwest Oregon Transit Alliance 

Based on _s by Automattic

Icons from The Noun Project


