jQuery(function($){
	"use strict";
	
	// Overall Functionality
	jQuery('.group').hide();
	
	if(window.location.hash) {
		var $current=jQuery(window.location.hash+'.group');
		if($current.length) {
			jQuery('#om-options-sections li a[href='+window.location.hash+']').parent().addClass('current');
			$current.show();
		} else {
			jQuery('.group:first').show();
			jQuery('#om-options-sections li:first').addClass('current');
		}
	}
	else {
		jQuery('.group:first').show();
		jQuery('#om-options-sections li:first').addClass('current');
	}
	
	jQuery('#om-options-sections li a').click(function(evt){
	
		jQuery('#om-options-sections li').removeClass('current');
		jQuery(this).parent().addClass('current');
		
		var clicked_group = jQuery(this).attr('href');

		jQuery('.group').hide();
		
		jQuery(clicked_group).fadeIn();

		evt.preventDefault();
	});
	
	// Image Radio
	jQuery('.om-radio-img-img').click(function(){
		jQuery(this).parent().parent().find('.om-radio-img-img').removeClass('om-radio-img-selected');
		jQuery(this).addClass('om-radio-img-selected');
	});
	
	jQuery('.om-radio-img-label').hide();
	jQuery('.om-radio-img-img').show();
	jQuery('.om-radio-img-radio').hide();


	//Color Picker

	jQuery('.wp-color-picker-field').wpColorPicker({
		clear: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').addClass('wp-picked-cleared');
		},
		change: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').removeClass('wp-picked-cleared');
		}
	});

	//Save Options
	jQuery('#om-options-form').submit(function(){
	
		jQuery('.ajax-loading-img').fadeIn();
		var serializedReturn = jQuery("#om-options-form").serialize();
		 
		var args = {
			type: 'options',
			action: 'om_theme_options_ajax',
			data: serializedReturn
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
			   success.fadeOut(); 
			}, 2000);
		});
		
		return false; 
		
	});
	
	// styling presets save
	jQuery('#om-styling-button-save').click(function(){
		
		jQuery(this).unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		var serializedReturn = jQuery("#om-options-form").serialize();
		 
		var args = {
			type: 'options',
			action: 'om_theme_options_ajax',
			data: serializedReturn
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
			   window.location.hash='#om-option-section-styling';
				 window.location.reload();
			}, 1000);
		});
		
		return false; 
		
	});
	
	// styling presets remove
	jQuery('.om-style-remove-button').click(function(){
		
		if(!confirm('Remove this style preset?'))
			return;
		
		var $this=jQuery(this);
		$this.unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		 
		var data = {
			id: jQuery(this).data('optionid'),
			name: jQuery(this).data('optionname')
		}
	
		var args = {
			type: 'style_preset_remove',
			action: 'om_theme_options_ajax',
			data: data
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			$this.parents('tr').remove();
		});
		
		return false; 
		
	});
	
	// styling presets apply
	jQuery('.om-style-apply-button').click(function(){
		
		var $this=jQuery(this);
		$this.unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		 
		var data = {
			id: jQuery(this).data('optionid'),
			name: jQuery(this).data('optionname')
		}
	
		var args = {
			type: 'style_preset_apply',
			action: 'om_theme_options_ajax',
			data: data
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
			   window.location='?page=om_options&rnd='+Math.random()+'#om-option-section-styling';
			}, 1000);
		});
		
		return false; 
		
	});
	
});