<?php

/*************************************************************************************
 *	Add MetaBox to Post edit page
 *************************************************************************************/

$om_post_meta_box=array(

	'quote' => array (
		'id' => 'om-post-meta-box-quote',
		'name' => __('Quote Settings', 'om_theme'),
		'fields' => array (
			array (
				'name' => __('The Quote','om_theme'),
				'desc' => __('Write your quote in this field','om_theme'),
				'id' => OM_THEME_SHORT_PREFIX.'quote',
				'type' => 'textarea',
				'std' => ''
			),
			array (
				'name' => __('Quote author','om_theme'),
				'desc' => '',
				'id' => OM_THEME_SHORT_PREFIX.'quote_author',
				'type' => 'text',
				'std' => ''
			),
		),
	),
	
	'link' => array(
		'id' => 'om-post-meta-box-link',
		'name' => __('Link Settings', 'om_theme'),
		'fields' => array (
			array (
				'name' => __('The URL','om_theme'),
				'desc' => __('Insert the URL you wish to link to','om_theme'),
				'id' => OM_THEME_SHORT_PREFIX.'link_url',
				'type' => 'text',
				'std' => ''
			),
		),
	),
	
	'video' => array (
		'id' => 'om-post-meta-box-video',
		'name' =>  __('Video Settings', 'om_theme'),
		'fields' => array (
			array ( "name" => __('HTML Embed code or link to YouTube, Vimeo, etc.','om_theme'),
					"desc" => __('If your video is hosted by video service insert the link to the video or HTML embed code.<br/>If you want to insert video file from WordPress Media library, use the fields below','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."video_embed",
					"type" => "textarea",
					"rows" => 3,
					"std" => ''
			),
			array ( "name" => __('Video File URL','om_theme'),
					"desc" => __('The URL to the video file','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."video_src",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('Poster Image','om_theme'),
					"desc" => __('The preivew image, only for self hosted videos','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."video_poster",
					"type" => "text_browse",
					"std" => '',
					"library" => 'image',
			),
			array ( "name" => '',
					"desc" => __('Fields below are not necessary if the "Video File URL" is specified, but can be used as a fallback video sources if the browser does not support format of the video chosen above.','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."videoformat_info",
					"type" => "info",
			),
			array ( "name" => __('MP4 File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_mp4",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('M4V File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_m4v",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('WebM File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_webm",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('OGV File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_ogv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('WMV File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_wmv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			array ( "name" => __('FLV File URL','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."video_flv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
		),
	),
	
	'audio' => array (
		'id' => 'om-post-meta-box-audio',
		'name' =>  __('Audio Settings', 'om_theme'),
		'fields' => array (
			array ( "name" => __('HTML Embed code or link to SoundCloud, etc.','om_theme'),
					"desc" => __('If your audio is hosted by audio service insert the link to the audio or HTML embed code.<br/>If you want to insert audio file from WordPress Media library, use the fields below','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."audio_embed",
					"type" => "textarea",
					"rows" => 3,
					"std" => ''
			),
			array( "name" => __('Audio File URL','om_theme'),
				"desc" => __('The URL to the audio file','om_theme'),
				"id" => OM_THEME_SHORT_PREFIX."audio_src",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			array ( "name" => '',
					"desc" => __('Fields below are not necessary if the "Audio File URL" is specified, but can be used as a fallback audio sources if the browser does not support format of the audio chosen above.','om_theme'),
					"id" => OM_THEME_SHORT_PREFIX."audioformat_info",
					"type" => "info",
			),
			array( "name" => __('MP3 File URL','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."audio_mp3",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			array( "name" => __('M4A File URL','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."audio_m4a",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			array( "name" => __('OGG File URL','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."audio_ogg",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			array( "name" => __('WAV File URL','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."audio_wav",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			array( "name" => __('WMA File URL','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."audio_wma",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
		),
	),
	
	'gallery' => array (
		'id' => 'om-post-meta-box-gallery',
		'name' => __('Gallery Settings', 'om_theme'),
		'fields' => array (

			array ( "name" => __('Gallery mode on the single page','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."gallery_mode",
					"type" => "select",
					"std" => '',
					'options' => array(
						'' => __('Standard (slider)', 'om_theme'),
						'sliced' => __('Sliced', 'om_theme'),
						'masonry' => __('Masonry', 'om_theme'),
					)
			),
			
			array ( "name" => __('Captions','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."gallery_captions",
					"type" => "select",
					"std" => '',
					'options' => array(
						'' => __('Hide', 'om_theme'),
						'true' => __('Display image captions', 'om_theme'),
					)
			),

			array ( "name" => __('Gallery','om_theme'),
					"desc" => '',
					"id" => OM_THEME_SHORT_PREFIX."gallery",
					"type" => "gallery",
					"std" => '',
			),

		),
	),
);

om_add_common_meta_boxes($om_post_meta_box, array('pagetitle', 'slider', 'header', 'sidebar'), 'om-post-meta-box-');

function om_add_post_meta_box() {
	global $om_post_meta_box;
	
	ommb_add_meta_boxes($om_post_meta_box, 'post');
 
}
add_action('add_meta_boxes', 'om_add_post_meta_box');


/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function om_save_post_metabox($post_id) {
	global $om_post_meta_box;
 
	ommb_save_metabox($post_id, $om_post_meta_box);

}
add_action('save_post', 'om_save_post_metabox');


/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/

function om_post_meta_box_scripts($hook) {
	if( 'post.php' != $hook && 'post-new.php' != $hook )
		return;
		
	wp_enqueue_script('om-admin-post-meta', TEMPLATE_DIR_URI . '/admin/js/post-meta.js', array('jquery'));

}
add_action('admin_enqueue_scripts', 'om_post_meta_box_scripts');
