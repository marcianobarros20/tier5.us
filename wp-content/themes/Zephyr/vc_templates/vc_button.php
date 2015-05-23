<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
$attributes = shortcode_atts(array(
	'text' => '',
	'url' => '',
	'external' => false,
	'color' => 'primary',
	'type' => 'raised',
	'icon' => '',
	'iconpos' => false,
	'size' => '',
	'align' => 'left',
), $atts);

$attributes['icon'] = trim($attributes['icon']);

$icon_part = '';
if ($attributes['icon'] != '') {
	if (substr($attributes['icon'], 0, 4) == 'mdfi') {
		$icon_part = '<i class="'.str_replace('-', '_', $attributes['icon']).'"></i>';
	} else {
		if (substr($attributes['icon'], 0, 3) == 'fa-') {
			$icon_part = '<i class="fa '.$attributes['icon'].'"></i>';
		} else {
			$icon_part = '<i class="fa fa-'.$attributes['icon'].'"></i>';
		}

	}
}

$output = '<span class="wpb_button align_'.$attributes['align'].'"><a href="'.esc_url($attributes['url']).'"';
$output .= ($attributes['external'] == 1)?' target="_blank"':'';
$output .= ' class="g-btn';
$output .= ($attributes['color'] != '')?' color_'.$attributes['color']:'';
$output .= ($attributes['type'] != '')?' type_'.$attributes['type']:'';
$output .= ($attributes['size'] != '')?' size_'.$attributes['size']:'';
$output .= ($attributes['iconpos'] == 'right')?' iconpos_right':'';
$output .= ($el_class != '')?' '.$el_class:'';
$output .= '">'.$icon_part.'<span>'.$attributes['text'].'</span></a></span>';

echo $output . "\n";
