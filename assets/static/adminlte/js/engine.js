var ENVIRONMENT = 'development';

function debug($data) {
	if ( 'development' === ENVIRONMENT) {
		console.log($data);
	}
}
// jQuery deps
(function ($, window, undefined) {
	// Document on load.
;
	$(function(){
		// bind go back button
		$('.btn-go-back').click(function() {
			window.history.back();
		});
		
		// bind yoxview elements
		if($.fn.yoxview) {
			$('.yoxview').yoxview();
		}
		
		// bind image preview
		$('a.img-preview').each(function() {
			$( this ).imgPreview({
				containerID: 'preview-container',
				imgCSS: {
					// Limit preview size:
					height: 200
				},
				// When container is shown:
				onShow: function(link){
					$('<span>' + $(link).text() + '</span>').appendTo(this);
				},
				// When container hides: 
				onHide: function(link){
					$('span', this).remove();
				}
			});
		});

		//iCheck for checkbox and radio inputs
		if($.fn.iCheck) {
			$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass: 'iradio_minimal-blue'
			});
		}
		
		//Initialize Select2 Elements
		if($.fn.select2)
			$(".select2").select2();
		
		//Initialize iconpicker elements
		if($.fn.iconpicker)
			$('.icp-auto').iconpicker();
		
		// AJAX handler
		$(document).ajaxStart(function() { Pace.restart(); });
		//ajax_bind();

	});

	// blinking effect
	;(function blink() { 
		$('.blink_me').fadeOut(500).fadeIn(500, blink); 
	})();
	

	if( $.isFunction( $.fn.sortable ) ) {
		//Make the dashboard widgets sortable Using jquery UI
		$(".connectedSortable").sortable({
			placeholder: "sort-highlight",
			connectWith: ".connectedSortable",
			handle: ".box-header, .nav-tabs",
			forcePlaceholderSize: true,
			zIndex: 999999
		});
		$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
		
		//jQuery UI sortable for the todo list
		$(".todo-list").sortable({
			placeholder: "sort-highlight",
			handle: ".handle",
			forcePlaceholderSize: true,
			zIndex: 999999
		});
	}
	
	if( $.isFunction( $.fn.datetimepicker ) ) {

		$( '.datetimepicker' ).datetimepicker({keepOpen: true, debug: true});
		
	}

})(jQuery, window);
