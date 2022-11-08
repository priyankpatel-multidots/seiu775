import '../library/instafeed';
// require('../library/instafeed');

document.addEventListener('DOMContentLoaded', () => {
	const wrapper = document.querySelector('#instafeed');
	const data = wrapper.dataset;

	const feed = new Instafeed({
	  accessToken: data.instagramToken,
	  debug: true,
	  template: '<a href="{{link}}"><img title="{{caption}}" src="{{image}}" /></a>',
	  limit: data.limit
	});

	feed.run();
});