<?php
$attributes = shortcode_atts(
	array(
		'type' => null,
		'color' => null,
		'bg_color' => FALSE,
		'text_color' => FALSE,
		'icon' => FALSE,
		'closing' => FALSE,
	), $atts);

$attributes['icon'] = trim($attributes['icon']);

if (empty($attributes['color']) AND ( ! empty($attributes['type']))) {
	$attributes['color'] = $attributes['type'];
}

$icon_part = $icon_class = '';
if ($attributes['icon'] != '') {
	if (substr($attributes['icon'], 0, 4) == 'mdfi') {
		$icon_part = '<div class="g-alert-icon"><i class="'.str_replace('-', '_', $attributes['icon']).'"></i></div>';
	} else {
		if (substr($attributes['icon'], 0, 3) == 'fa-') {
			$icon_part = '<div class="g-alert-icon"><i class="fa '.$attributes['icon'].'"></i></div>';
		} else {
			$icon_part = '<div class="g-alert-icon"><i class="fa fa-'.$attributes['icon'].'"></i></div>';
		}

	}
//	$icon_part = '<div class="g-alert-icon"><i class="fa fa-'.$attributes['icon'].'"></i></div>';
	$icon_class = ' with_icon';
}

$closing_class = ($attributes['closing'] == 1 OR $attributes['closing'] == 'yes')?' with_close':'';

$item_style = '';
if ($attributes['color'] == 'custom') {
	if ($attributes['bg_color'] != '') {
		$item_style .= 'background-color: '.$attributes['bg_color'].';';
	}
	if ($attributes['text_color'] != '') {
		$item_style .= ' color: '.$attributes['text_color'].';';
	}
}

if ($item_style != '') {
	$item_style = ' style="'.$item_style.'"';
}

if ( ! in_array($attributes['color'], array('info', 'attention', 'success', 'error', 'custom', ))) {
	$attributes['color'] = 'info';
}

$output = '<div class="g-alert type_'.$attributes['color'].$icon_class.$closing_class.'"'.$item_style.'><div class="g-alert-close"> &#10005; </div>'.$icon_part.'<div class="g-alert-body"><p>'.do_shortcode($content).'</p></div></div>';

echo $output;
