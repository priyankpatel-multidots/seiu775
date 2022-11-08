var Flickity = require('flickity-imagesloaded');

const selectors = {
  slider: '[data-member-testimonials-slider]',
};

const sliderOptions = {
  autoPlay: false,
  cellAlign: 'left',
  pageDots: false,
  wrapAround: true,
};

document.addEventListener('DOMContentLoaded', () => {
  if ($(selectors.slider).length > 0) {
    window.testimonialsSlider = new Flickity(selectors.slider, sliderOptions);
    $(window).on('load', () => { window.testimonialsSlider.resize(); });
  }
});
