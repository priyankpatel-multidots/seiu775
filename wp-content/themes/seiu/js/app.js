import $ from 'jquery';
import AOS from 'aos';

// Expose jQuery to third party plugins
window.jQuery = $;
window.$ = $;


import './components/header';
import './components/offcanvas-panel';
import './components/accordion';

import './components/hero';
import './components/slider-module';
import './components/membership-module';
// import './components/instagram';

import './components/member-testimonials';

// ..
AOS.init();

// Generate the SVG Sprites
const files = require.context(
  '!svg-sprite-loader!../images/svg/',
  false,
  /.*\.svg$/
);
files.keys().forEach(files);


// Lazysizes breakpoints
window.lazySizesConfig = window.lazySizesConfig || {};
window.lazySizesConfig.customMedia = {
  '--sm': '(min-width: 568px)',
  '--md': '(min-width: 768px)',
  '--lg': '(min-width: 1024px)',
  '--xl': '(min-width: 1280px)',
};


document.addEventListener('aos:in', ({ detail }) => {
	detail.classList.add('aos-animate-out');
});

document.addEventListener('aos:out', ({ detail }) => {
  // detail.classList.add('aos-animate-out');
});