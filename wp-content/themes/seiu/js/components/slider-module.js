import $ from 'jquery';
var Flickity = require('flickity-imagesloaded');

const selectors = {
  slider: '[data-slider-module-carousel]',
};

const sliderOptions = {
  autoPlay: 4500,
  cellAlign: 'left',
  pageDots: false,
  wrapAround: false,
};

document.addEventListener('DOMContentLoaded', () => {
  if ($(selectors.slider).length > 0) {
    window.testimonialsSlider = new Flickity(selectors.slider, sliderOptions);
    $(window).on('load', () => { window.testimonialsSlider.resize(); });
  }
});
