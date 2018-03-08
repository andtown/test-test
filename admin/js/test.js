
jQuery( function ( $ ) {
    'use strict';

    $(document).ready(function() {
    	if ( $('.test-admin-page_page_test-admin-page-test-admin-sub-page1 .form-table .input .input-tags').length ) {
	        $('.test-admin-page_page_test-admin-page-test-admin-sub-page1 .form-table .input .input-tags').tagsInput({
	        	width:'auto',
	        	defaultText:''
	        });    		
    	}

    });

});

(function($) {
	var $document = $( document );

	resultsItems = {

		init : function() {

			$(document.body).bind('click.widgets-toggle', function(e) {
				var target = $(e.target),
					css = { 'z-index': 100 },
					widget, inside, toggleBtn = target.closest( '.widget' ).find( '.widget-top button.widget-action' );

				if ( target.parents('.widget-top').length && ! target.parents('#available-widgets').length ) {
					widget = target.closest('div.widget');
					inside = widget.children('.widget-inside');

					if ( inside.is(':hidden') ) {
						toggleBtn.attr( 'aria-expanded', 'true' );
						inside.slideDown( 'fast', function() {
							widget.addClass( 'open' );
						});
					} else {
						toggleBtn.attr( 'aria-expanded', 'false' );
						inside.slideUp( 'fast', function() {
							widget.attr( 'style', '' );
							widget.removeClass( 'open' );
						});
					}
					e.preventDefault();
				}
			});

			$('#widget-list').children('.widget').draggable();

			$('div.widgets-sortables').droppable( {
				tolerance: 'intersect'
			} );

			$('div.widgets-sortables').sortable({
			    receive: function(event, ui) {
			        // alert("dropped on = "+this.id); // Where the item is dropped
			        //   alert("sender = "+ui.sender[0].id); // Where it came from
			        //   alert("item = "+ui.item[0].innerHTML); //Which item (or ui.item[0].id)
			    }
			}
			).sortable( 'option', 'connectWith', 'div.widgets-sortables' );

		}

	};

	$document.ready( function(){ 
		if ($('body.test-admin-page_page_test-admin-page-test-admin-sub-page3, body.test-admin-page_page_test-admin-page-test-admin-sub-page4').length) resultsItems.init(); 
	});

})(jQuery);