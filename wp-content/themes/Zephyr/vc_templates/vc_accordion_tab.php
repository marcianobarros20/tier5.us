<?php
$attributes = shortcode_atts(
	array(
		'title' => '',
		'active' => false,
		'icon' => '',
		'no_indents' => '',
		'bg_color' => '',
		'text_color' => '',
	), $atts);

$attributes['icon'] = trim($attributes['icon']);

global $first_tab, $auto_open;
if ($auto_open) {
//	$active_class = ($first_tab)?' active':'';
	$first_tab = FALSE;
} else {
	$active_class = ($attributes['active'])?' active':'';
}

$active_class = ($attributes['active'] == 1 OR $attributes['active'] == 'yes')?' active':'';

$icon_class = '';
if ($attributes['icon'] != '') {
	if (substr($attributes['icon'], 0, 4) == 'mdfi') {
		$icon_class = ''.str_replace('-', '_', $attributes['icon']);
	} else {
		if (substr($attributes['icon'], 0, 3) == 'fa-') {
			$icon_class = 'fa '.$attributes['icon'];
		} else {
			$icon_class = 'fa fa-'.$attributes['icon'];
		}

	}
}
$item_icon_class = ($attributes['icon'] != '')?' with_icon':'';
$no_indents_class = ($attributes['no_indents'] == 'yes' OR $attributes['no_indents'] == 1)?' no_indents':'';

$item_style = $item_custom_class = '';

if ($attributes['bg_color'] != '') {
	$item_style .= 'background-color: '.$attributes['bg_color'].';';
}
if ($attributes['text_color'] != '') {
	$item_style .= ' color: '.$attributes['text_color'].';';
}
if ($item_style != '') {
	$item_style = ' style="'.$item_style.'"';
	$item_custom_class = ' color_custom';
}
$title_part = ($attributes['title'] != '')?'<h5 class="w-tabs-section-title">'.$attributes['title'].'</h5>':'';

$output = 	'<div class="w-tabs-section'.$active_class.$item_icon_class.$item_custom_class.$no_indents_class.'"'.$item_style.'>'.
				'<div class="w-tabs-section-header">'.
					'<div class="w-tabs-section-icon"><i class="'.$icon_class.'"></i></div>'.
					$title_part.
					'<div class="w-tabs-section-control"><i class="mdfi_hardware_keyboard_arrow_down"></i></div>'.
				'</div>'.
				'<div class="w-tabs-section-content">'.
					'<div class="w-tabs-section-content-h i-cf">'.
						do_shortcode($content).
					'</div>'.
				'</div>'.
			'</div>';

echo $output;
