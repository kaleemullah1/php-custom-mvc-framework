(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$(document).on('click','#sidebarCollapse', function () {
		console.log('here');
      $('#sidebar').toggleClass('active');
  });

})(jQuery);
