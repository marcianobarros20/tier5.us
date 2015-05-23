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

global $first_tab, $auto_open, $is_timeline;
if ($auto_open) {
//	$active_class = ($first_tab)?' active':'';
	$first_tab = FALSE;
}

$active_class = ($attributes['active'] == 1 OR $attributes['active'] == 'yes')?' active':'';

if ($is_timeline) {

	$output = 	'<div class="w-timeline-section'.$active_class.'">
					<div class="w-timeline-section-title">
						<span class="w-timeline-section-title-text">'.$attributes['title'].'</span>
					</div>
					<div class="w-timeline-section-content">
						'.do_shortcode($content).'
					</div>
				</div>';
} else {

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
	$title_part = ($attributes['title'] != '')?'<h5 class="w-tabs-section-title">'.$attributes['title'].'</h5>':'';

	$output = 	'<div class="w-tabs-section'.$active_class.$item_icon_class.$no_indents_class.'">'.
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
}

echo $output;
