jQuery(document).ready(function($){
  $(window).load(function(){
    'use strict';
		var search_widget = $('.widget_tz_search');
		search_widget.each(function() {
			var search_icon_wrapper = $(this).find('.tz-search-icon-wrapper');
			var search_form = $(this).find('.tz-searchform-wrapper');
			/* Get header demensions */
			if ( $(this).parent().hasClass('hgroup-sidebar') ) {
				var search_form_w = search_form.innerWidth();
				search_form.css({
					'margin-left': '-'+(search_form_w/2)+'px'
				});
			}
			/* Add classes on click */
			search_icon_wrapper.on('click', function(e) {
				if ( $(this).hasClass('opened') ) {
					$(this).removeClass('opened')
								 .find('.tz-search-icon')
								 .removeClass('jshop-icon-close')
								 .addClass('jshop-icon-magnifier');
 					search_form.removeClass('opened').delay(300).queue(function() {
	  				$(this).css('visibility', 'hidden').dequeue();
	  			});
				} else {
					$(this).addClass('opened')
								 .find('.tz-search-icon')
								 .removeClass('jshop-icon-magnifier')
								 .addClass('jshop-icon-close');
					search_form.css('visibility','visible').addClass('opened');
				}
			});
		});
	});
})
