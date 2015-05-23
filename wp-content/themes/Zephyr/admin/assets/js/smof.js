/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance!
 */
jQuery(document).ready(function($){

	//(un)fold options in a checkbox-group
	jQuery('.fld').click(function() {
		var $fold='.f_'+this.id;
		$($fold).slideToggle('normal', "swing");
	});

	//delays until AjaxUpload is finished loading
	//fixes bug in Safari and Mac Chrome
	if (typeof AjaxUpload != 'function') {
		return ++counter < 6 && window.setTimeout(init, counter * 500);
	}

	//hides warning if js is enabled
	$('#js-warning').hide();

	//Tabify Options
	$('.group').hide();

	// Display last current tab
	if ($.cookie("of_current_opt") === null) {
		$('.group:first').fadeIn('fast');
		$('#of-nav li:first').addClass('current');
	} else {

		var hooks = $('#hooks').html();
		hooks = jQuery.parseJSON(hooks);

		$.each(hooks, function(key, value) {

			if ($.cookie("of_current_opt") == '#of-option-'+ value) {
				$('.group#of-option-' + value).fadeIn();
				$('#of-nav li.' + value).addClass('current');
			}

		});

	}

	//Current Menu Class
	$('#of-nav li a').click(function(evt){
	// event.preventDefault();

		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');

		var clicked_group = $(this).attr('href');

		$.cookie('of_current_opt', clicked_group, { expires: 7, path: '/' });

		$('.group').hide();

		$(clicked_group).fadeIn('fast');
		return false;

	});

	//Expand Options
	var flip = 0;

	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(760);
			$('#of_container .group').add('#of_container .group h2').show();

			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');

		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(600);
			$('#of_container .group').add('#of_container .group h2').hide();
			$('#of_container .group:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');

			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');

		}

	});

	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}


	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();

	$(window).scroll(function() {
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});


	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();

	//AJAX Upload
	function of_image_upload() {
	$('.image_upload_button').each(function(){

	var clickedObject = $(this);
	var clickedID = $(this).attr('id');

	var nonce = $('#security').val();

	new AjaxUpload(clickedID, {
		action: ajaxurl,
		name: clickedID, // File upload name
		data: { // Additional data to send
			action: 'of_ajax_post_action',
			type: 'upload',
			security: nonce,
			data: clickedID },
		autoSubmit: true, // Submit file after selection
		responseType: false,
		onChange: function(file, extension){},
		onSubmit: function(file, extension){
			clickedObject.text('Uploading'); // change button text, when user selects file
			this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
			interval = window.setInterval(function(){
				var text = clickedObject.text();
				if (text.length < 13){	clickedObject.text(text + '.'); }
				else { clickedObject.text('Uploading'); }
				}, 200);
		},
		onComplete: function(file, response) {
			window.clearInterval(interval);
			clickedObject.text('Upload Image');
			this.enable(); // enable upload button


			// If nonce fails
			if(response==-1){
				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
				fail_popup.fadeOut();
				}, 2000);
			}

			// If there was an error
			else if(response.search('Upload Error') > -1){
				var buildReturn = '<span class="upload-error">' + response + '</span>';
				$(".upload-error").remove();
				clickedObject.parent().after(buildReturn);

				}
			else{
				var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

				$(".upload-error").remove();
				$("#image_" + clickedID).remove();
				clickedObject.parent().after(buildReturn);
				$('img#image_'+clickedID).fadeIn();
				clickedObject.next('span').fadeIn();
				clickedObject.parent().prev('input').val(response);
			}
		}
	});

	});

	}

	of_image_upload();

	//AJAX Remove Image (clear option value)
	$('.image_reset_button').live('click', function(){

		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		var theID = $(this).attr('title');

		var nonce = $('#security').val();

		var data = {
			action: 'of_ajax_post_action',
			type: 'image_reset',
			security: nonce,
			data: theID
		};

		$.post(ajaxurl, data, function(response) {

			//check nonce
			if(response==-1){ //failed

				var fail_popup = $('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
					fail_popup.fadeOut();
				}, 2000);
			}

			else {

				var image_to_remove = $('#image_' + theID);
				var button_to_hide = $('#reset_' + theID);
				image_to_remove.fadeOut(500,function(){ $(this).remove(); });
				button_to_hide.fadeOut();
				clickedObject.parent().prev('input').val('');
			}


		});

	});

	// Style Select
	(function ($) {
	styleSelect = {
		init: function () {
		$('.select_wrapper').each(function () {
			$(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
		});
		$('.select').live('change', function () {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		});
		$('.select').bind($.browser.msie ? 'click' : 'change', function(event) {
			$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
		});
		}
	};
	$(document).ready(function () {
		styleSelect.init()
	})
	})(jQuery);


	/** Aquagraphite Slider MOD */

	//Hide (Collapse) the toggle containers on load
	$(".slide_body").hide();

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$(".slide_edit_button").live( 'click', function(){
		$(this).parent().toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});

	// Update slide title upon typing
	function update_slider_title(e) {
		var element = e;
		if ( this.timer ) {
			clearTimeout( element.timer );
		}
		this.timer = setTimeout( function() {
			$(element).parent().prev().find('strong').text( element.value );
		}, 100);
		return true;
	}

	$('.of-slider-title').live('keyup', function(){
		update_slider_title(this);
	});


	//Remove individual slide
	$('.slide_delete_button').live('click', function(){
	// event.preventDefault();
	var agree = confirm("Are you sure you wish to delete this slide?");
		if (agree) {
			var $trash = $(this).parents('li');
			//$trash.slideUp('slow', function(){ $trash.remove(); }); //chrome + confirm bug made slideUp not working...
			$trash.animate({
					opacity: 0.25,
					height: 0,
				}, 500, function() {
					$(this).remove();
			});
			return false; //Prevent the browser jump to the link anchor
		} else {
		return false;
		}
	});

	//Add new slide
	$(".slide_add_button").live('click', function(){
		var slidesContainer = $(this).prev();
		var sliderId = slidesContainer.attr('id');
		var sliderInt = $('#'+sliderId).attr('rel');

		var numArr = $('#'+sliderId +' li').find('.order').map(function() {
			var str = this.id;
			str = str.replace(/\D/g,'');
			str = parseFloat(str);
			return str;
		}).get();

		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;

		var newSlide = '<li class="temphide"><div class="slide_header"><strong>Slide ' + newNum + '</strong><input type="hidden" class="slide of-input order" name="' + sliderId + '[' + newNum + '][order]" id="' + sliderId + '_slide_order-' + newNum + '" value="' + newNum + '"><a class="slide_edit_button" href="#">Edit</a></div><div class="slide_body" style="display: none; "><label>Title</label><input class="slide of-input of-slider-title" name="' + sliderId + '[' + newNum + '][title]" id="' + sliderId + '_' + newNum + '_slide_title" value=""><label>Image URL</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][url]" id="' + sliderId + '_' + newNum + '_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="' + sliderId + '_' + newNum + '" rel="'+sliderInt+'">Upload</span><span class="button mlu_remove_button hide" id="reset_' + sliderId + '_' + newNum + '" title="' + sliderId + '_' + newNum + '">Remove</span></div><div class="screenshot"></div><label>Link URL (optional)</label><input class="slide of-input" name="' + sliderId + '[' + newNum + '][link]" id="' + sliderId + '_' + newNum + '_slide_link" value=""><label>Description (optional)</label><textarea class="slide of-input" name="' + sliderId + '[' + newNum + '][description]" id="' + sliderId + '_' + newNum + '_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#">Delete</a><div class="clear"></div></div></li>';

		slidesContainer.append(newSlide);
		$('.temphide').fadeIn('fast', function() {
			$(this).removeClass('temphide');
		});

		of_image_upload(); // re-initialise upload image..

		return false; //prevent jumps, as always..
	});

	//Sort slides
	jQuery('.slider').find('ul').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).sortable({
			placeholder: "placeholder",
			opacity: 0.6
		});
	});


	/**	Sorter (Layout Manager) */
	jQuery('.sorter').each( function() {
		var id = jQuery(this).attr('id');
		$('#'+ id).find('ul').sortable({
			items: 'li',
			placeholder: "placeholder",
			connectWith: '.sortlist_' + id,
			opacity: 0.6,
			update: function() {
				$(this).find('.position').each( function() {

					var listID = $(this).parent().attr('id');
					var parentID = $(this).parent().parent().attr('id');
					parentID = parentID.replace(id + '_', '')
					var optionID = $(this).parent().parent().parent().attr('id');
					$(this).prop("name", optionID + '[' + parentID + '][' + listID + ']');

				});
			}
		});
	});


	/**	Ajax Backup & Restore MOD */
	//backup button
	$('#of_backup_button').live('click', function(){

		var answer = confirm("Click OK to backup your current saved options.")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'backup_options',
				security: nonce
			};

			$.post(ajaxurl, data, function(response) {

				//check nonce
				if(response==-1){ //failed

					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}

				else {

					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

	return false;

	});

	//restore button
	$('#of_restore_button').live('click', function(){

		var answer = confirm("'Warning: All of your current options will be replaced with the data from your last backup! Proceed?")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'restore_options',
				security: nonce
			};

			$.post(ajaxurl, data, function(response) {

				//check nonce
				if(response==-1){ //failed

					var fail_popup = $('#of-popup-fail');
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}

				else {

					var success_popup = $('#of-popup-save');
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

	return false;

	});

	/**	Ajax Transfer (Import/Export) Option */
	$('#of_import_button').live('click', function(){

		var answer = confirm("Click OK to import options.")

		if (answer){

			var clickedObject = $(this);
			var clickedID = $(this).attr('id');

			var nonce = $('#security').val();

			var import_data = $('#export_data').val();

			var data = {
				action: 'of_ajax_post_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};

			$.post(ajaxurl, data, function(response) {
				var fail_popup = $('#of-popup-fail');
				var success_popup = $('#of-popup-save');

				//check nonce
				if(response==-1){ //failed
					fail_popup.fadeIn();
					window.setTimeout(function(){
						fail_popup.fadeOut();
					}, 2000);
				}
				else
				{
					success_popup.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}

			});

		}

	return false;

	});

	/** AJAX Save Options */
	$('#of_save').live('click',function() {

		var nonce = $('#security').val();

		$('.ajax-loading-img').fadeIn();

		//get serialized data from all our option fields
		var serializedReturn = $('#of_form :input[name][name!="security"][name!="of_reset"]').serialize();

		var data = {
			type: 'save',
			action: 'of_ajax_post_action',
			security: nonce,
			data: serializedReturn
		};

		$.post(ajaxurl, data, function(response) {
			var success = $('#of-popup-save');
			var fail = $('#of-popup-fail');
			var loading = $('.ajax-loading-img');
			loading.fadeOut();

			if (response==1) {
				success.fadeIn();
			} else {
				fail.fadeIn();
			}

			window.setTimeout(function(){
				success.fadeOut();
				fail.fadeOut();
			}, 2000);
		});

	return false;

	});


	/* AJAX Options Reset */
	$('#of_reset').click(function() {

		//confirm reset
		var answer = confirm("Click OK to reset. All settings will be lost and replaced with default settings!");

		//ajax reset
		if (answer){

			var nonce = $('#security').val();

			$('.ajax-reset-loading-img').fadeIn();

			var data = {

				type: 'reset',
				action: 'of_ajax_post_action',
				security: nonce,
			};

			$.post(ajaxurl, data, function(response) {
				var success = $('#of-popup-reset');
				var fail = $('#of-popup-fail');
				var loading = $('.ajax-reset-loading-img');
				loading.fadeOut();

				if (response==1)
				{
					success.fadeIn();
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
				else
				{
					fail.fadeIn();
					window.setTimeout(function(){
						fail.fadeOut();
					}, 2000);
				}


			});

		}

	return false;

	});


	/**	Tipsy @since v1.3 */
	if (jQuery().tipsy) {
		$('.typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}


	/**
	  * JQuery UI Slider function
	  * Dependencies 	 : jquery, jquery-ui-slider
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery('.smof_sliderui').each(function() {

		var obj   = jQuery(this);
		var sId   = "#" + obj.data('id');
		var val   = parseInt(obj.data('val'));
		var min   = parseInt(obj.data('min'));
		var max   = parseInt(obj.data('max'));
		var step  = parseInt(obj.data('step'));

		//slider init
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
			}
		});

	});


	/**
	  * Switch
	  * Dependencies 	 : jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery(".cb-enable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-disable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', true);

		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideDown('normal', "swing");
	});
	jQuery(".cb-disable").click(function(){
		var parent = $(this).parents('.switch-options');
		jQuery('.cb-enable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.main_checkbox',parent).attr('checked', false);

		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});
	//disable text select(for modern chrome, safari and firefox is done via CSS)
	if (($.browser.msie && $.browser.version < 10) || $.browser.opera) {
		$('.cb-enable span, .cb-disable span').find().attr('unselectable', 'on');
	}


	/**
	  * Google Fonts
	  * Dependencies 	 : google.com, jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	function GoogleFontSelect( slctr, mainID ){

		//get current value - selected and saved
		var _selected = $(slctr).val(),
			_linkclass = 'style_link_'+ mainID,
			_previewer = mainID +'_ggf_previewer',
			// Font-stylings that should be visible only at custom font
			_suboptions = mainID +'_suboptions';

		//remove other elements crested in <head>
		$( '.'+ _linkclass ).remove();

		if( _selected ){ //if var exists and isset

			//Check if selected is not equal with "Select a font" and execute the script.
			if ( _selected === 'none' || _selected === 'Font not specifined' ) {

				//if selected is not a font remove style "font-family" at preview box
				$('.'+ _previewer ).css('font-family', '' );

				$('.'+ _suboptions ).slideUp();

			}
			// Selected web safe font combination
			else if(_selected.indexOf(',') != -1){

				//show in the preview box the font
				$('.'+ _previewer ).css('font-family', _selected);

				$('.'+ _suboptions ).slideUp();
			}
			// Selected a custom (Google font)
			else{

				//replace spaces with "+" sign
				var the_font = _selected.replace(/\s+/g, '+');

				//add reference to google font family
				$('head').append('<link href="http://fonts.googleapis.com/css?family='+ the_font +'" rel="stylesheet" type="text/css" class="'+ _linkclass +'">');

				//show in the preview box the font
				$('.'+ _previewer ).css('font-family', _selected +', sans-serif' );

				$('.'+ _suboptions ).slideDown();

			}

		}

	}

	//init for each element
	jQuery( '.google_font_select' ).each(function(){
		var $this = jQuery(this),
			mainID = $this.attr('id'),
			value = $this.val();
		GoogleFontSelect( this, mainID );

		// Wrapping all the custom options inside the separate div
		var parentSection = $this.parents('.section'),
			subOptionsContainer = jQuery('<div class="suboptions-container '+mainID+'_suboptions"></div>').insertAfter(parentSection),
			subOptionsPattern = mainID.replace(/family$/, ''),
			curElement = subOptionsContainer.next();
		while (curElement.attr('id').indexOf(subOptionsPattern) != -1){
			curElement.appendTo(subOptionsContainer);
			curElement = subOptionsContainer.next();
		}
		subOptionsContainer[(value == 'none' || value == 'Font not specified' || value.indexOf(',') != -1)?'hide':'show']();
	});

	//init when value is changed
	jQuery( '.google_font_select' ).on('change keyup', function(){
		var mainID = jQuery(this).attr('id');
		GoogleFontSelect( this, mainID );
	});



}); //end doc ready

jQuery(document).ready(function($) {
	var colors = {
		color_0: {
			body_bg: '#e0e0e0',
			header_bg: '#7049ba',
			header_text: '#fff',
			header_text_hover: '#fff',
			header_ext_bg: '#6039a8',
			header_ext_text: '#c8b8e5',
			header_ext_text_hover: '#fff',
			search_bg: '#7049ba',
			search_text: '#fff',
			menu_hover_bg: '#6039a8',
			menu_hover_text: '#fff',
			menu_active_bg: '#7049ba',
			menu_active_text: '#ffc670',
			drop_bg: '#fff',
			drop_text: '#212121',
			drop_hover_bg: '#eee',
			drop_hover_text: '#212121',
			drop_active_bg: '#f7f7f7',
			drop_active_text: '#7049ba',
			menu_button_bg: '#fff',
			menu_button_text: '#7049ba',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#7049ba',
			main_bg: '#fff',
			main_bg_alt: '#f5f5f5',
			main_border: '#e0e0e0',
			main_heading: '#212121',
			main_text: '#424242',
			main_primary: '#7049ba',
			main_secondary: '#ffb03a',
			main_fade: '#9e9e9e',
			subfooter_bg: '#212121',
			subfooter_bg_alt: '#292929',
			subfooter_border: '#333',
			subfooter_text: '#757575',
			subfooter_heading: '#9e9e9e',
			subfooter_link: '#9e9e9e',
			subfooter_link_hover: '#ffb03a',
			footer_bg: '#111',
			footer_text: '#757575',
			footer_link: '#9e9e9e',
			footer_link_hover: '#ffb03a'
		},
		color_1: {
			body_bg: '#d7e0df',
			header_bg: '#009688',
			header_text: '#fff',
			header_text_hover: '#fff',
			header_ext_bg: '#00897b',
			header_ext_text: '#b2dfdb',
			header_ext_text_hover: '#fff',
			search_bg: '#fff',
			search_text: '#00897b',
			menu_hover_bg: '#009688',
			menu_hover_text: '#fff',
			menu_active_bg: '#009688',
			menu_active_text: '#7dfadb',
			drop_bg: '#00897b',
			drop_text: '#fff',
			drop_hover_bg: '#00796b',
			drop_hover_text: '#fff',
			drop_active_bg: '#00897b',
			drop_active_text: '#7dfadb',
			menu_button_bg: '#fff',
			menu_button_text: '#00897b',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#00897b',
			main_bg: '#fff',
			main_bg_alt: '#f2f7f7',
			main_border: '#d7e0df',
			main_heading: '#212121',
			main_text: '#3f4544',
			main_primary: '#00bfa5',
			main_secondary: '#2196f3',
			main_fade: '#9da6a5',
			subfooter_bg: '#1d2625',
			subfooter_bg_alt: '#26302f',
			subfooter_border: '#2d3837',
			subfooter_text: '#7f8a88',
			subfooter_heading: '#b2bfbe',
			subfooter_link: '#b2bfbe',
			subfooter_link_hover: '#2196f3',
			footer_bg: '#141a19',
			footer_text: '#7f8a88',
			footer_link: '#b2bfbe',
			footer_link_hover: '#2196f3'
		},
		color_2: {
			body_bg: '#e5e5e5',
			header_bg: '#ffb300',
			header_text: '#fff',
			header_text_hover: '#fff',
			header_ext_bg: '#ffa000',
			header_ext_text: '#ffecb3',
			header_ext_text_hover: '#fff',
			search_bg: '#ffb300',
			search_text: '#fff',
			menu_hover_bg: '#ffb300',
			menu_hover_text: '#fff',
			menu_active_bg: '#ffb300',
			menu_active_text: '#a939bd',
			drop_bg: '#fff',
			drop_text: '#212121',
			drop_hover_bg: '#f5f5f5',
			drop_hover_text: '#212121',
			drop_active_bg: '#fff',
			drop_active_text: '#a939bd',
			menu_button_bg: '#fff',
			menu_button_text: '#424242',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#424242',
			main_bg: '#fff',
			main_bg_alt: '#f6f6f6',
			main_border: '#e5e5e5',
			main_heading: '#222',
			main_text: '#444',
			main_primary: '#a939bd',
			main_secondary: '#ffb300',
			main_fade: '#999',
			subfooter_bg: '#212121',
			subfooter_bg_alt: '#292929',
			subfooter_border: '#333',
			subfooter_text: '#757575',
			subfooter_heading: '#9e9e9e',
			subfooter_link: '#9e9e9e',
			subfooter_link_hover: '#ffb300',
			footer_bg: '#111',
			footer_text: '#757575',
			footer_link: '#9e9e9e',
			footer_link_hover: '#ffb300'
		},
		color_3: {
			body_bg: '#e1e4e5',
			header_bg: '#fff',
			header_text: '#25282b',
			header_text_hover: '#ff5722',
			header_ext_bg: '#f2f4f5',
			header_ext_text: '#949799',
			header_ext_text_hover: '#ff5722',
			search_bg: '#00bcd4',
			search_text: '#fff',
			menu_hover_bg: '#fff',
			menu_hover_text: '#ff5722',
			menu_active_bg: '#fff',
			menu_active_text: '#ff5722',
			drop_bg: '#25282b',
			drop_text: '#c2c4c5',
			drop_hover_bg: '#ff5722',
			drop_hover_text: '#fff',
			drop_active_bg: '#25282b',
			drop_active_text: '#ff5722',
			menu_button_bg: '#ff5722',
			menu_button_text: '#fff',
			menu_button_hover_bg: '#00bcd4',
			menu_button_hover_text: '#fff',
			main_bg: '#fff',
			main_bg_alt: '#f2f4f5',
			main_border: '#e1e4e5',
			main_heading: '#25282b',
			main_text: '#4f5459',
			main_primary: '#ff5722',
			main_secondary: '#00bcd4',
			main_fade: '#949799',
			subfooter_bg: '#25282b',
			subfooter_bg_alt: '#1c1f21',
			subfooter_border: '#35383b',
			subfooter_text: '#8e9194',
			subfooter_heading: '#c2c4c5',
			subfooter_link: '#c2c4c5',
			subfooter_link_hover: '#fff',
			footer_bg: '#1c1f21',
			footer_text: '#8e9194',
			footer_link: '#8e9194',
			footer_link_hover: '#fff'
		},
		color_4: {
			body_bg: '#0f0f0f',
			header_bg: '#21b11e',
			header_text: '#fff',
			header_text_hover: '#fff',
			header_ext_bg: '#1b9d17',
			header_ext_text: '#c8e6c9',
			header_ext_text_hover: '#fff',
			search_bg: '#1d1d1d',
			search_text: '#1b9d17',
			menu_hover_bg: '#21b11e',
			menu_hover_text: '#fff',
			menu_active_bg: '#21b11e',
			menu_active_text: '#9bff99',
			drop_bg: '#1d1d1d',
			drop_text: '#aaa',
			drop_hover_bg: '#1d1d1d',
			drop_hover_text: '#fff',
			drop_active_bg: '#1d1d1d',
			drop_active_text: '#41c23e',
			menu_button_bg: '#fff',
			menu_button_text: '#1d1d1d',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#1d1d1d',
			main_bg: '#262626',
			main_bg_alt: '#1d1d1d',
			main_border: '#393939',
			main_heading: '#ddd',
			main_text: '#aaa',
			main_primary: '#21b11e',
			main_secondary: '#5676f1',
			main_fade: '#777',
			subfooter_bg: '#1d1d1d',
			subfooter_bg_alt: '#262626',
			subfooter_border: '#333',
			subfooter_text: '#777',
			subfooter_heading: '#aaa',
			subfooter_link: '#aaa',
			subfooter_link_hover: '#5676f1',
			footer_bg: '#0f0f0f',
			footer_text: '#666',
			footer_link: '#666',
			footer_link_hover: '#5676f1'
		},
		color_5: {
			body_bg: '#12171a',
			header_bg: '#263238',
			header_text: '#cfd8dc',
			header_text_hover: '#fff',
			header_ext_bg: '#1b2327',
			header_ext_text: '#b0bec5',
			header_ext_text_hover: '#fff',
			search_bg: '#80cbc4',
			search_text: '#fff',
			menu_hover_bg: '#263238',
			menu_hover_text: '#fff',
			menu_active_bg: '#263238',
			menu_active_text: '#80cbc4',
			drop_bg: '#1b2327',
			drop_text: '#b0bec5',
			drop_hover_bg: '#1b2327',
			drop_hover_text: '#fff',
			drop_active_bg: '#1b2327',
			drop_active_text: '#80cbc4',
			menu_button_bg: '#80cbc4',
			menu_button_text: '#1b2327',
			menu_button_hover_bg: '#fff',
			menu_button_hover_text: '#1b2327',
			main_bg: '#37474f',
			main_bg_alt: '#263238',
			main_border: '#4f5d64',
			main_heading: '#fff',
			main_text: '#cfd8dc',
			main_primary: '#80cbc4',
			main_secondary: '#96de72',
			main_fade: '#9ea8ad',
			subfooter_bg: '#1b2327',
			subfooter_bg_alt: '#263238',
			subfooter_border: '#263238',
			subfooter_text: '#82939c',
			subfooter_heading: '#b0bec5',
			subfooter_link: '#b0bec5',
			subfooter_link_hover: '#96de72',
			footer_bg: '#12171a',
			footer_text: '#82939c',
			footer_link: '#b0bec5',
			footer_link_hover: '#96de72'
		}
	}

	function update_custom_colors(color_scheme){
		for (var field_id in color_scheme) {
			var color_hex = color_scheme[field_id];
			jQuery('#section-' + field_id + ' .colorSelector').ColorPickerSetColor(color_hex);
			jQuery('#section-' + field_id + ' .colorSelector').children('div').css('backgroundColor', color_hex);
			jQuery('#section-' + field_id + ' .of-color').val(color_hex);
		}
	}

	jQuery('#color_scheme').change(function() {
		switch ($(this).val()){
			case 'Purple White': update_custom_colors(colors.color_0); break;
			case 'Teal Serenity': update_custom_colors(colors.color_1); break;
			case 'Sunny Cocktail': update_custom_colors(colors.color_2); break;
			case 'Light Tangerine': update_custom_colors(colors.color_3); break;
			case 'Green Darkness': update_custom_colors(colors.color_4); break;
			case 'Wet Stone': update_custom_colors(colors.color_5); break;
		}
	});

	jQuery('#section-header_is_sticky .controls .switch-options').click(function(){
		if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
			if (window.main_header_layout == 'standard' || window.main_header_layout == 'extended') {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			}
		} else {
			jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
		}
	});

	jQuery('#section-main_header_layout .of-radio-img-img').on('click', function(){

		var layout = 'standard';
		if (jQuery(this).siblings('#of-radio-img-main_header_layout2').length) {
			layout = 'extended';
		}
		if (jQuery(this).siblings('#of-radio-img-main_header_layout3').length) {
			layout = 'advanced';
		}
		if (jQuery(this).siblings('#of-radio-img-main_header_layout4').length) {
			layout = 'centered';
		}

		window.main_header_layout = layout;

		if (layout == 'centered') {
			jQuery('#section-header_invert_logo_pos').slideUp('normal', "swing");
		} else {
			jQuery('#section-header_invert_logo_pos').slideDown('normal', "swing");
		}

		if (layout == 'standard') {
			if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			}
			jQuery('#section-header_extra_height').slideUp('normal', "swing");

		} else if (layout == 'extended') {
			if (jQuery('#section-header_is_sticky .controls .cb-enable').hasClass('selected')) {
				jQuery('#section-header_main_shrinked_height').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			}
			jQuery('#section-header_extra_height').slideDown('normal', "swing");

		} else if (layout == 'advanced' || layout == 'centered') {
			jQuery('#section-header_main_shrinked_height').slideUp('normal', "swing");
			jQuery('#section-header_extra_height').slideDown('normal', "swing");

		}

		if (layout == 'standard' || layout == 'centered') {
			jQuery('#section-header_show_language').slideUp('normal', "swing");
			jQuery('#section-header_language_type').slideUp('normal', "swing");
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

			jQuery('#section-header_show_contacts').slideUp('normal', "swing");
			jQuery('#section-header_phone').slideUp('normal', "swing");
			jQuery('#section-header_email').slideUp('normal', "swing");

			jQuery('#section-header_show_socials').slideUp('normal', "swing");
			jQuery('#section-header_social_facebook').slideUp('normal', "swing");
			jQuery('#section-header_social_twitter').slideUp('normal', "swing");
			jQuery('#section-header_social_google').slideUp('normal', "swing");
			jQuery('#section-header_social_linkedin').slideUp('normal', "swing");
			jQuery('#section-header_social_youtube').slideUp('normal', "swing");
			jQuery('#section-header_social_vimeo').slideUp('normal', "swing");
			jQuery('#section-header_social_flickr').slideUp('normal', "swing");
			jQuery('#section-header_social_instagram').slideUp('normal', "swing");
			jQuery('#section-header_social_behance').slideUp('normal', "swing");
			jQuery('#section-header_social_xing').slideUp('normal', "swing");
			jQuery('#section-header_social_pinterest').slideUp('normal', "swing");
			jQuery('#section-header_social_skype').slideUp('normal', "swing");
			jQuery('#section-header_social_tumblr').slideUp('normal', "swing");
			jQuery('#section-header_social_dribbble').slideUp('normal', "swing");
			jQuery('#section-header_social_vk').slideUp('normal', "swing");
			jQuery('#section-header_social_soundcloud').slideUp('normal', "swing");
			jQuery('#section-header_social_yelp').slideUp('normal', "swing");
			jQuery('#section-header_social_twitch').slideUp('normal', "swing");
			jQuery('#section-header_social_rss').slideUp('normal', "swing");

			jQuery('#section-header_show_custom').slideUp('normal', "swing");
			jQuery('#section-header_custom_icon').slideUp('normal', "swing");
			jQuery('#section-header_custom_text').slideUp('normal', "swing");

		} else {
			jQuery('#section-header_show_contacts').slideDown('normal', "swing");
			jQuery('#section-header_show_contacts .controls .switch-options .selected').click();

			jQuery('#section-header_show_socials').slideDown('normal', "swing");
			jQuery('#section-header_show_socials .controls .switch-options .selected').click();

			jQuery('#section-header_show_custom').slideDown('normal', "swing");
			jQuery('#section-header_show_custom .controls .switch-options .selected').click();

			jQuery('#section-header_show_language').slideDown('normal', "swing");
			jQuery('#section-header_show_language .controls').click();
		}
	});

	jQuery('#section-header_show_language .controls').live('click', function() {

		if (jQuery('#section-header_show_language .controls .cb-enable').hasClass('selected')) {
			jQuery('#section-header_language_type').slideDown('normal', "swing");
			jQuery('#header_language_type').change();

		} else {
			jQuery('#section-header_language_type').slideUp('normal', "swing");
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

		}

	});


	jQuery('#header_language_type').live('change', function(){
		if (jQuery(this).val() == 'Your own links') {
			jQuery('#section-header_language_amount').slideDown('normal', "swing");
			jQuery('#section-header_language_1_name').slideDown('normal', "swing");
			jQuery('#header_language_amount').change();

		} else {
			jQuery('#section-header_language_amount').slideUp('normal', "swing");
			jQuery('#section-header_language_1_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_name').slideUp('normal', "swing");
			jQuery('#section-header_language_2_url').slideUp('normal', "swing");
			jQuery('#section-header_language_3_name').slideUp('normal', "swing");
			jQuery('#section-header_language_3_url').slideUp('normal', "swing");
			jQuery('#section-header_language_4_name').slideUp('normal', "swing");
			jQuery('#section-header_language_4_url').slideUp('normal', "swing");
			jQuery('#section-header_language_5_name').slideUp('normal', "swing");
			jQuery('#section-header_language_5_url').slideUp('normal', "swing");
			jQuery('#section-header_language_6_name').slideUp('normal', "swing");
			jQuery('#section-header_language_6_url').slideUp('normal', "swing");
			jQuery('#section-header_language_7_name').slideUp('normal', "swing");
			jQuery('#section-header_language_7_url').slideUp('normal', "swing");
			jQuery('#section-header_language_8_name').slideUp('normal', "swing");
			jQuery('#section-header_language_8_url').slideUp('normal', "swing");
			jQuery('#section-header_language_9_name').slideUp('normal', "swing");
			jQuery('#section-header_language_9_url').slideUp('normal', "swing");
			jQuery('#section-header_language_10_name').slideUp('normal', "swing");
			jQuery('#section-header_language_10_url').slideUp('normal', "swing");

		}
	});

	jQuery('#header_language_amount').live('change', function(){
		for(var i = 2; i <= 10; i++) {
			if (i <= jQuery(this).val()-0) {
				jQuery('#section-header_language_'+i+'_name').slideDown('normal', "swing");
				jQuery('#section-header_language_'+i+'_url').slideDown('normal', "swing");
			} else {
				jQuery('#section-header_language_'+i+'_name').slideUp('normal', "swing");
				jQuery('#section-header_language_'+i+'_url').slideUp('normal', "swing");
			}
		}
	});

	if (jQuery('#section-main_header_layout .of-radio-img-img.of-radio-img-selected').length) {
		jQuery('#section-main_header_layout .of-radio-img-img.of-radio-img-selected').click();
	} else {
		jQuery('#section-main_header_layout .of-radio-img-img')[0].click();
	}


	jQuery('.of-color').on('change', function(){
		jQuery(this).siblings('.colorSelector').ColorPickerSetColor(jQuery(this).val());
		jQuery(this).siblings('.colorSelector').children('div').css('backgroundColor', jQuery(this).val());
	})

});
