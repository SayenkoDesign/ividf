<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'om_charts' );

if($el_class)
	$el_class=' '.$el_class;
	
if(!in_array($type, array('Line','Bar','Radar','PolarArea','Pie','Doughnut'))) 
	return false;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-chart wpb_content_element' . $el_class, $this->settings['base'], $atts ));

$id='chart'.rand();

$ratio=explode(':',$ratio);
if(count($ratio) == 2 && $ratio[0] && $ratio[1]) {
	$width=$ratio[0]*100;
	$height=$ratio[1]*100;
} else {
	$width=400;
	$height=200;
}

$labels=explode(',',$labels);
for($i=0;$i<count($labels);$i++) {
	$labels[$i]='"'.esc_js($labels[$i]).'"';
}

$data=explode("\n",$data);
$data_=array();
foreach($data as $set) {
	$set=explode('|',$set);
	if(count($set) < 2)
	 continue;
	
	$values=explode(',',$set[1]);
	for($i=0;$i<count($values);$i++) {
		$values[$i]=intval($values[$i]);
	}
	
	if(isset($set[2]))
		$color=om_parse2rgba($set[2]);
	else
		$color=om_parse2rgba(get_option(OM_THEME_PREFIX . 'hightlight_color'));
	if(!$color)
		$color=array(155,155,155);
	
	$color_a=$color;
	
	if(in_array($type, array('Line','Bar','Radar'))) {
		$color_a[3]=0.2;
		$data_[]='{
			label: "'.esc_js($set[0]).'",
			fillColor: "'.om_rgba2string($color_a).'",
	    strokeColor: "'.om_rgba2string($color).'",
	    pointColor: "'.om_rgba2string($color).'",
	    pointStrokeColor: "#fff",
	    pointHighlightFill: "#fff",
	    pointHighlightStroke: "rgba(220,220,220,1)",
	    data: ['.implode(',',$values).']
		}';
	} else {
		$color_a[3]=0.8;
		$data_[]='{
			label: "'.esc_js($set[0]).'",
			color: "'.om_rgba2string($color).'",
	    highlight: "'.om_rgba2string($color_a).'",
	    value: '.$values[0].'
		}';
	}
}

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').'>';
echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'vc_om-chart_heading' ) );
echo '<canvas id="'.$id.'" width="'.$width.'" height="'.$height.'"></canvas>';
echo '<script>';

$side_color=( $labels_color ? $labels_color : get_option(OM_THEME_PREFIX . 'side_text_color') );
$lines_color=om_parse2rgba($side_color);
$grid_color=$lines_color;
$backdrop_color=$lines_color;

$lines_color[3]=0.25;
$lines_color=om_rgba2string($lines_color);

$grid_color[3]=0.12;
$grid_color=om_rgba2string($grid_color);

$backdrop_color=om_rgb2hsl($backdrop_color);
if($backdrop_color[2] <= 0.7)
	$backdrop_color[2] += 0.5;
else
	$backdrop_color[2] -= 0.5;
if($backdrop_color[2] > 1)
	$backdrop_color[2]=1;
$backdrop_color=om_hsl2rgb($backdrop_color);
$backdrop_color[3]=0.75;
$backdrop_color=om_rgba2string($backdrop_color);
?>
jQuery(function($){
	<?php if(in_array($type, array('Line','Bar','Radar'))) { ?>
	var data = {
	    labels: [<?php echo implode(',',$labels) ?>],
	    datasets: [<?php echo implode(',',$data_) ?>]
	};
	<?php } else { ?>
	var data = [<?php echo implode(',',$data_) ?>];
	<?php } ?>
	var ctx = document.getElementById("<?php echo esc_js($id) ?>").getContext("2d");
	var options = {
		responsive: true,
		animationSteps: 100,
		scaleFontColor: "<?php echo esc_js($side_color) ?>",
		scaleLineColor: "<?php echo esc_js($lines_color) ?>",
		scaleGridLineColor : "<?php echo esc_js($grid_color) ?>",
		angleLineColor : "<?php echo esc_js($lines_color) ?>",
		pointLabelFontColor : "<?php echo esc_js($side_color) ?>",
		scaleBackdropColor : "<?php echo esc_js($backdrop_color) ?>",
		<?php echo ($segmentstroke_color ? 'segmentStrokeColor : "'.esc_js($segmentstroke_color).'",' : '' ) ?>
		datasetFill: <?php echo ($fill == 'yes' ? 'true':'false' ) ?>
	};
	var obj=new Chart(ctx).<?php echo esc_js($type) ?>(data,options);
	if($.waypoints) {
		$('#<?php echo esc_js($id) ?>').waypoint(function(){
			obj.render();
		},{
			offset: '100%',
			triggerOnce: true
		});
	}
	<?php if($legend == 'yes') { ?>$('#<?php echo esc_js($id) ?>').after('<div class="vc-om_chart-legend clearfix"<?php echo ( $labels_color ? ' style="color:'.$labels_color.'"' : '' ) ?>>'+obj.generateLegend()+'</div>'); <?php } ?>
});
<?php
echo '</script>';
echo '</div>';

