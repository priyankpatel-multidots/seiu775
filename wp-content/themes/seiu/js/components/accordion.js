import $ from 'jquery';

const selectors = {
  accordion: '[data-accordion-selector]',
};

document.addEventListener('DOMContentLoaded', () => {



	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	function getUrlParam(parameter, defaultvalue){
		var urlparameter = defaultvalue;
		if(window.location.href.indexOf(parameter) > -1){
			urlparameter = getUrlVars()[parameter];
		}
		return urlparameter;
	}

  if ($(selectors.accordion).length > 0) {
  	$(selectors.accordion).on('click', '[data-accordion-heading]', function(e){
  		e.preventDefault();
  		e.stopPropagation();
  		var $item = $(this).closest('[data-accordion-item]');
  		var $content = $item.find('[data-accordion-content]');

  		$item.toggleClass('active');

  		if ($item.hasClass('active')) {
  			$content.slideDown();
  		} else {
  			$content.slideUp();
  		}
  	});

  	$(selectors.accordion).on('change', '[data-accordion-category]', function(e){
  		e.preventDefault();
  		e.stopPropagation();
  		var category = $(this).val();
  		if (category === "all") {
				var $target = $(".member-offerings");
				var $content = $("[data-accordion-content]");

				$target.addClass('active');
				$content.slideDown();
			} else {
				var $target = $(`.member-offerings[data-category-slug="${category}"]`);
				if ($target.length <= 0) return;

				var $content = $target.find('[data-accordion-content]');

				$target.toggleClass('active');

				if ($target.hasClass('active')) {
					$content.slideDown();
				} else {
					$content.slideUp();
				}
			}

  	});
  }

  var urlParam = getUrlParam("category", "");

  if (urlParam !== "") {
  	//console.log(urlParam);
		var $paramTarget = $(`.member-offerings[data-category-slug="${urlParam}"]`);
		var targetOffset = $paramTarget.offset().top - 230;
		//console.log(targetOffset);
		$(window).scrollTop(targetOffset);
		if ($paramTarget.length <= 0) return;

		var $paramContent = $paramTarget.find('[data-accordion-content]');

		$paramTarget.toggleClass('active');

		if ($paramTarget.hasClass('active')) {
			$paramContent.slideDown();
		} else {
			$paramContent.slideUp();
		}
	} else {
  	//console.log("No param");
	}
});
