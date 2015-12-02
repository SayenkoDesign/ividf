"use strict";

if (typeof window['ompf_items_sort'] !== 'function') {
  window.ompf_items_sort = function(selector, action) {

		var portfolioItems = jQuery(selector);
		var updateAjax=false;
		
		portfolioItems.sortable({
			update: function(event, ui) {
				if(updateAjax) {
					updateAjax.abort();
					updateAjax=false;
				}
				updateAjax=jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					async: true,
					cache: false,
					dataType: 'json',
					data:{
					    action: action,
					    order: portfolioItems.sortable('toArray').toString() 
					},
					success: function(response) {
					    return;
					},
					error: function(xhr,textStatus,e) {
						if(textStatus != 'abort')
					  	alert('There was an error saving the update.');
					  return;
					}
				});
			}
		});
	}
}