import $ from 'jquery';

// Open offcanvas panel
$('[data-toggle="openPanel"]').on('click', function(event) {
  event.preventDefault();
  $('body').removeClass((index, className) => {
    return (className.match(/(^|\s)panel-open--\S+/g) || []).join(' ');
  });
  $('body').addClass(this.dataset.openClassname);
});

// Close offcanvas panel
$('[data-toggle="closePanel"]').on('click', (event) => {
  event.preventDefault();
  $('body').removeClass((index, className) => {
    return (className.match(/(^|\s)panel-open--\S+/g) || []).join(' ');
  });
});


// Mobile Search Toggle
$('[data-mobile-search-toggle]').on('click', (event) => {
  event.preventDefault();
  $('.bc-sf-search-suggestion-mobile-top-panel').show();
});
$('.bc-sf-search-btn-close-suggestion').on('click', (event) => {
  event.preventDefault();
  $('.bc-sf-search-suggestion-wrapper').hide();
});

$('.panel-mobile-menu__items').on('click', '.menu-item a span.menu-toggle', function(e) {
  var $menu_item = $(this).closest('.menu-item');
  if ($menu_item.hasClass('menu-item-has-children')) {
    e.preventDefault();
    e.stopPropagation();
    $menu_item.find(' > .sub-menu').slideToggle();
    $menu_item.toggleClass('active');
    // console.log(e.target, e.currentTarget);
  } else {

  }
  
})