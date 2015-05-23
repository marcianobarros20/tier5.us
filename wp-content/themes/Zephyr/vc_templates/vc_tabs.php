<?php
$attributes = shortcode_atts(
	array(
		'timeline' => '',
		'type' => '',
	), $atts);

global $first_tab, $first_tab_title, $auto_open, $is_timeline;
$auto_open = TRUE;
$first_tab_title = TRUE;
$first_tab = TRUE;

//$type_class = ($attributes['type'] != '')?' type_'.$attributes['type']:' type_1';

if ($attributes['timeline'] == 'yes') {
	$is_timeline = TRUE;

	$content_titles = str_replace('[vc_tab', '[timepoint_title', $content);
	$content_titles = str_replace('[/vc_tab', '[/timepoint_title', $content_titles);

	$output = '<div class="w-timeline"><div class="w-timeline-list">'.do_shortcode($content_titles).'</div><div class="w-timeline-sections">'.do_shortcode($content).'</div></div>';
} else {
	$is_timeline = FALSE;

	$tabs_id = 'tabs_'.rand(99999, 999999);
	$tabs_id_string = ' id="'.$tabs_id.'"';

	$content_titles = str_replace('[vc_tab', '[item_title', $content);
	$content_titles = str_replace('[/vc_tab', '[/item_title', $content_titles);

	$output = '<div class="w-tabs"'.$tabs_id_string.'><div class="w-tabs-list">'.do_shortcode($content_titles).'</div>'.do_shortcode($content).'</div>';
}

$is_timeline = FALSE;
$auto_open = FALSE;
$first_tab_title = FALSE;
$first_tab = FALSE;

echo $output;