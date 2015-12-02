<?php

/************************************************************************************
 *	Add MetaBox to Portfolio edit page
 ************************************************************************************/

$ompf_portfolio_meta_box=array (
	'type' => array (
		'id' => 'ompf-portfolio-meta-box-type',
		'name' =>  __('Portfolio Details', 'om_portfolio'),
		'fields' => array (
			'ompf_portfolio_type' => array ( "name" => __('Portfolio format','om_portfolio'),
					"desc" => __('Choose the type of portfolio you wish to display.<br/>Don\'t forget to set a featured image that will be displayed on the main portfolio page.','om_portfolio'),
					"id" => "ompf_portfolio_type",
					"type" => "select",
					"std" => 'image',
					'options' => array(
						'image' => __('Single Image / Images List', 'om_portfolio'),
						'gallery' => __('Gallery', 'om_portfolio'),
						'video' => __('Video', 'om_portfolio'),
						'audio' => __('Audio', 'om_portfolio'),
						'custom' => __('No Media block, Full Width custom page', 'om_portfolio')
					)
			),
			'ompf_portfolio_gallery_columns' => array ( "name" => __('Number of columns for Gallery format','om_portfolio'),
					"desc" => '',
					"id" => "ompf_portfolio_gallery_columns",
					"type" => "select",
					"std" => '3',
					'code' => '
						<script>
							jQuery(function($){
								$("#ompf_portfolio_type").change(function(){
									if($(this).val() == "gallery") {
										$("#ompf_portfolio_gallery_columns").parents("tr").show();
									} else {
										$("#ompf_portfolio_gallery_columns").parents("tr").hide();
									}
								}).change();
							});
						</script>
					',
					'options' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						'9' => 9,
					)
			),
			'ompf_portfolio_column_ratio' => array ( "name" => __('Description/Media ratio','om_portfolio'),
					"desc" => __('Choose the size of columns for media(images/audio/video) and description','om_portfolio'),
					"id" => "ompf_portfolio_column_ratio",
					"type" => "select",
					"std" => '2v1',
					'options' => array(
						'2v1' => __('2/3 Media, 1/3 Description', 'om_portfolio'),
						'1v1' => __('1/2 Media, 1/2 Description', 'om_portfolio'),
						'1v2' => __('1/3 Media, 2/3 Description', 'om_portfolio'),
						'full' => __('Full Width Media and Description below', 'om_portfolio'),
					),
			),
			'ompf_portfolio_column_ratio_width100' => array ( "name" => __('Expand Media to 100% Width','om_portfolio'),
					"desc" => '',
					"id" => "ompf_portfolio_column_ratio_width100",
					"type" => "select",
					"std" => '',
					'options' => array(
						'' => __('No', 'om_portfolio'),
						'1' => __('Yes', 'om_portfolio'),
					),
					'code' => '
						<script>
							jQuery(function($){
								$("#ompf_portfolio_column_ratio").change(function(){
									if($(this).val() == "full") {
										$("#ompf_portfolio_column_ratio_width100").parents("tr").show();
									} else {
										$("#ompf_portfolio_column_ratio_width100").parents("tr").hide();
									}
								}).change();
							});
						</script>
					',
			),
			'ompf_portfolio_media_position' => array ( "name" => __('Description/Media position','om_portfolio'),
					"desc" => '',
					"id" => "ompf_portfolio_media_position",
					"type" => "select",
					"std" => 'left',
					'options' => array(
						'left' => __('Media on the left side, Description on the right', 'om_portfolio'),
						'right' => __('Media on the right side, Description on the left', 'om_portfolio'),
					),
			),

		),
	),
	
	'imageblock' => array (
		'id' => 'ompf-portfolio-meta-box-images',
		'name' =>  __('Portfolio Images', 'om_portfolio'),
		'fields' => array (
			'ompf_gallery' => array ( "name" => __('Gallery','om_portfolio'),
					"desc" => '',
					"id" => "ompf_gallery",
					"type" => "gallery",
					"std" => '',
			),
		),
	),
	
	'video' => array (
		'id' => 'ompf-portfolio-meta-box-video',
		'name' =>  __('Video Settings', 'om_portfolio'),
		'fields' => array (
			'ompf_video_embed' => array ( "name" => __('HTML Embed code or link to YouTube, Vimeo, etc.','om_portfolio'),
					"desc" => __('If your video is hosted by video service insert the link to the video or HTML embed code.<br/>If you want to insert video file from WordPress Media library, use the fields below','om_portfolio'),
					"id" => "ompf_video_embed",
					"type" => "textarea",
					"rows" => 3,
					"std" => ''
			),
			'ompf_video_src' => array ( "name" => __('Video File URL','om_portfolio'),
					"desc" => __('The URL to the video file','om_portfolio'),
					"id" => "ompf_video_src",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_poster' => array ( "name" => __('Poster Image','om_portfolio'),
					"desc" => __('The preivew image, only for self hosted videos','om_portfolio'),
					"id" => "ompf_video_poster",
					"type" => "text_browse",
					"std" => '',
					"library" => 'image',
			),
			'ompf_videoformat_info' => array ( "name" => '',
					"desc" => __('Fields below are not necessary if the "Video File URL" is specified, but can be used as a fallback video sources if the browser does not support format of the video chosen above.','om_portfolio'),
					"id" => "ompf_videoformat_info",
					"type" => "info",
			),
			'ompf_video_mp4' => array ( "name" => __('MP4 File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_mp4",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_m4v' => array ( "name" => __('M4V File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_m4v",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_webm' => array ( "name" => __('WebM File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_webm",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_ogv' => array ( "name" => __('OGV File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_ogv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_wmv' => array ( "name" => __('WMV File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_wmv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
			'ompf_video_flv' => array ( "name" => __('FLV File URL','om_portfolio'),
					"desc" => '',
					"id" => "ompf_video_flv",
					"type" => "text_browse",
					"std" => '',
					"library" => 'video',
			),
		),
	),
	
	'audio' => array (
		'id' => 'ompf-portfolio-meta-box-audio',
		'name' =>  __('Audio Settings', 'om_portfolio'),
		'fields' => array (
			'ompf_audio_embed' => array ( "name" => __('HTML Embed code or link to SoundCloud, etc.','om_portfolio'),
					"desc" => __('If your audio is hosted by audio service insert the link to the audio or HTML embed code.<br/>If you want to insert audio file from WordPress Media library, use the fields below','om_portfolio'),
					"id" => "ompf_audio_embed",
					"type" => "textarea",
					"rows" => 3,
					"std" => ''
			),
			'ompf_audio_src' => array( "name" => __('Audio File URL','om_portfolio'),
				"desc" => __('The URL to the audio file','om_portfolio'),
				"id" => "ompf_audio_src",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			'ompf_audioformat_info' => array ( "name" => '',
					"desc" => __('Fields below are not necessary if the "Audio File URL" is specified, but can be used as a fallback audio sources if the browser does not support format of the audio chosen above.','om_portfolio'),
					"id" => "ompf_audioformat_info",
					"type" => "info",
			),
			'ompf_audio_mp3' => array( "name" => __('MP3 File URL','om_portfolio'),
				"desc" => '',
				"id" => "ompf_audio_mp3",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			'ompf_audio_m4a' => array( "name" => __('M4A File URL','om_portfolio'),
				"desc" => '',
				"id" => "ompf_audio_m4a",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			'ompf_audio_ogg' => array( "name" => __('OGG File URL','om_portfolio'),
				"desc" => '',
				"id" => "ompf_audio_ogg",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			'ompf_audio_wav' => array( "name" => __('WAV File URL','om_portfolio'),
				"desc" => '',
				"id" => "ompf_audio_wav",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
			'ompf_audio_wma' => array( "name" => __('WMA File URL','om_portfolio'),
				"desc" => '',
				"id" => "ompf_audio_wma",
				"type" => "text_browse",
				"std" => '',
				"library" => 'audio',
			),
		),
	),
	
	'preview' => array (
		'id' => 'ompf-portfolio-meta-box-preview',
		'name' =>  __('Preview Options', 'om_portfolio'),
		'fields' => array (
			'ompf_portfolio_short_desc' => array ( "name" => __('Portfolio short description','om_portfolio'),
					"desc" => __('Short description which will be shown on preview page','om_portfolio'),
					"id" => "ompf_portfolio_short_desc",
					"type" => "textarea",
					"std" => '',
					'rows' => 3,
			),
			'ompf_portfolio_company' => array ( "name" => __('Portfolio Company Type','om_portfolio'),

					"desc" => __('Company Name which will be shown on preview page','om_portfolio'),

					"id" => "ompf_portfolio_company",

					"type" => "text",

					"std" => '',

			),
			/*
			'ompf_portfolio_preview_layout' => array ( "name" => __('Preview layout','om_portfolio'),
					"desc" => '',
					"id" => "ompf_portfolio_preview_layout",
					'type' => 'select',
					'std' => 'inherit',
					'options' => array(
						'inherit' => __('Inherit option from Portfolio page settings','om_portfolio'),
						'full' => __('Show thumbnail/ title/ description','om_portfolio'),
						'thumbnail' => __('Show only thumbnail','om_portfolio'),
					)
			),
			*/
			'ompf_portfolio_custom_link' => array ( "name" => __('Custom link from preview','om_portfolio'),
					"desc" => __('Specify custom link from item preview if you don\'t want the link to the portfolio item page. Also you can enter "none" to disable linking at all','om_portfolio'),
					"id" => "ompf_portfolio_custom_link",
					"type" => "text",
					"std" => '',
			),
		),
	),
	
);
 
function ompf_add_portfolio_meta_box() {
	global $ompf_portfolio_meta_box;
	
	if(!$GLOBALS['omPortfolioPlugin']['config']['theme_support_width100'])
		unset($ompf_portfolio_meta_box['type']['fields']['ompf_portfolio_column_ratio_width100']);
	$ompf_portfolio_meta_box=apply_filters('ompf_portfolio_meta_box', $ompf_portfolio_meta_box);
	
	ompfmb_add_meta_boxes($ompf_portfolio_meta_box, 'portfolio');
	
}
add_action('add_meta_boxes', 'ompf_add_portfolio_meta_box');

/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function ompf_save_portfolio_metabox($post_id) {
	global $ompf_portfolio_meta_box;
 
	$ompf_portfolio_meta_box=apply_filters('ompf_portfolio_meta_box', $ompf_portfolio_meta_box);
 
	ompfmb_save_metabox($post_id, $ompf_portfolio_meta_box);

}
add_action('save_post', 'ompf_save_portfolio_metabox');


/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/


function ompf_portfolio_meta_box_scripts($hook) {
	if( 'post.php' != $hook && 'post-new.php' != $hook )
		return;
	
	if( $GLOBALS['omPortfolioPlugin']['config']['include_custom_post_meta_js'] )
		wp_enqueue_script('ompf-admin-portfolio-meta', $GLOBALS['omPortfolioPlugin']['path_url'] . 'assets/js/custom-post-meta.js', array('jquery'));
	
}
add_action('admin_enqueue_scripts', 'ompf_portfolio_meta_box_scripts');
