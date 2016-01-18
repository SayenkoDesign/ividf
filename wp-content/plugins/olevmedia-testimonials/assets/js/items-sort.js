"use strict";

if (typeof window['omtm_items_sort'] !== 'function') {
  window.omtm_items_sort = function(selector, action) {

		var items = jQuery(selector);
		var updateAjax=false;
		
		items.sortable({
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
					    order: items.sortable('toArray').toString() 
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