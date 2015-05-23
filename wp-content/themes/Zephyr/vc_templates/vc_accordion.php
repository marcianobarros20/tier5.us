<?php
$attributes = shortcode_atts(
	array(
		'toggle' => '',
		'title_center' => '',
	), $atts);

global $first_tab, $first_tab_title, $auto_open;


$toggle_class = '';
if ($attributes['toggle'] == 'yes' OR $attributes['toggle'] == 1) {
	$toggle_class = ' type_toggle';
} else {
	$auto_open = TRUE;
	$first_tab_title = TRUE;
	$first_tab = TRUE;
}

$title_center_class = ($attributes['title_center'] == 'yes' OR $attributes['title_center'] == 1)?' title_center':'';

$output = '<div class="w-tabs layout_accordion'.$toggle_class.$title_center_class.'">'.do_shortcode($content).'</div>';
$auto_open = FALSE;
$first_tab_title = FALSE;
$first_tab = FALSE;

echo $output;