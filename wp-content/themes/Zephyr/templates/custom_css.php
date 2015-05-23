<?php
global $smof_data, $output_styles_to_file;

// Compatibility with the previous version
if ( ! isset($smof_data['heading_font_family']) AND isset($smof_data['heading_font'])){
	$smof_data['heading_font_family'] = $smof_data['heading_font'];
}
if ( ! isset($smof_data['body_font_family']) AND isset($smof_data['body_text_font'])){
	$smof_data['body_font_family'] = $smof_data['body_text_font'];
}
if ( ! isset($smof_data['nav_font_family']) AND isset($smof_data['navigation_font'])){
	$smof_data['nav_font_family'] = $smof_data['navigation_font'];
}

$font_weights = array('200', '300', '400', '600', '700');
$prefixes = array('heading', 'body', 'nav');
foreach ( $prefixes as $prefix ){
	// Default font-family
	if ( ! isset($smof_data[$prefix.'_font_family']) OR $smof_data[$prefix.'_font_family'] == '') {
		$smof_data[$prefix.'_font_family'] = 'none';
	}
	// Add quotes for custom font namings
	elseif(strpos($smof_data[$prefix.'_font_family'], ',') === FALSE){
		$smof_data[$prefix.'_font_family'] = "'".$smof_data[$prefix.'_font_family']."'";
	}
	// Default font-weight
	$smof_data[$prefix.'_font_weight'] = '400';
	foreach ( $font_weights as $font_weight ) {
		if (isset($smof_data[$prefix.'_font_weight_'.$font_weight]) AND $smof_data[$prefix.'_font_weight_'.$font_weight] == 1) {
			$smof_data[$prefix.'_font_weight'] = $font_weight;
			break;
		}
	}
}

// Fault tolerance for missing options
$default_options = array(
	'nav_fontsize' => 16,
	'subnav_fontsize' => 15,
	'nav_fontsize_mobile' => 16,
	'subnav_fontsize_mobile' => 15,
	'regular_fontsize' => 14,
	'regular_lineheight' => 24,
	'regular_fontsize_mobile' => 13,
	'regular_lineheight_mobile' => 23,
	'h1_fontsize' => 40,
	'h2_fontsize' => 34,
	'h3_fontsize' => 28,
	'h4_fontsize' => 24,
	'h5_fontsize' => 20,
	'h6_fontsize' => 18,
	'h1_fontsize_mobile' => 30,
	'h2_fontsize_mobile' => 26,
	'h3_fontsize_mobile' => 22,
	'h4_fontsize_mobile' => 20,
	'h5_fontsize_mobile' => 18,
	'h6_fontsize_mobile' => 16,
);
foreach ( $default_options as $option_key => $option_value ) {
	if (empty($smof_data[$option_key])) {
		$smof_data[$option_key] = $option_value;
	}
}
?>
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
<style id="us_fonts_inline">
<?php endif; ?>
body {
	<?php if ($smof_data['body_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['body_font_family']; ?>;
	<?php endif; ?>
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight']; ?>px;
	font-weight: <?php echo $smof_data['body_font_weight']; ?>;
	}
.page-template-page-blank-php .l-main {
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	}

.l-header .w-nav-item {
	<?php if ($smof_data['nav_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['nav_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['nav_font_weight']; ?>;
	}
.l-header .touch_disabled .w-nav-anchor.level_1,
.touch_disabled [class*="columns"] .has_sublevel .w-nav-anchor.level_2 {
	font-size: <?php echo $smof_data['nav_fontsize']; ?>px;
	}
.l-header .touch_disabled .w-nav-anchor.level_2,
.l-header .touch_disabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize']; ?>px;
	}
.l-header .touch_enabled .w-nav-anchor.level_1 {
	font-size: <?php echo $smof_data['nav_fontsize_mobile']; ?>px;
	}
.l-header .touch_enabled .w-nav-anchor.level_2,
.l-header .touch_enabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize_mobile']; ?>px;
	}

h1, h2, h3, h4, h5, h6,
.w-counter-number,
.w-logo-title,
.w-pricing-item-title,
.w-pricing-item-price {
	<?php if ($smof_data['heading_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['heading_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['heading_font_weight']; ?>;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize']; ?>px;
	}
h4, .widgettitle, .comment-reply-title {
	font-size: <?php echo $smof_data['h4_fontsize']; ?>px;
	}
h5, .w-portfolio-item-title {
	font-size: <?php echo $smof_data['h5_fontsize']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize']; ?>px;
	}
@media only screen and (max-width: 767px) {
body {
	font-size: <?php echo $smof_data['regular_fontsize_mobile']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight_mobile']; ?>px;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize_mobile']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize_mobile']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize_mobile']; ?>px;
	}
h4, .widgettitle, .comment-reply-title {
	font-size: <?php echo $smof_data['h4_fontsize_mobile']; ?>px;
	}
h5, .w-portfolio-item-title {
	font-size: <?php echo $smof_data['h5_fontsize_mobile']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize_mobile']; ?>px;
	}
}
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
</style>
<style id="us_colors_inline">
<?php endif; ?>
/*************************** BODY ***************************/

/* Body Background Color */
.l-body {
	background-color: <?php echo ($smof_data['body_bg'] != '')?$smof_data['body_bg']:'#e0e0e0'; ?>;
	}

/*************************** HEADER ***************************/

/* Header Background Color */
.l-subheader.at_middle,
.l-subheader.at_middle .w-lang-list,
.l-subheader.at_middle .touch_enabled .w-nav-list.level_1 {
	background-color: <?php echo ($smof_data['header_bg'] != '')?$smof_data['header_bg']:'#7049ba'; ?>;
	}
	
/* Header Text Color */
.l-subheader.at_middle,
.transparent .l-subheader.at_middle .touch_enabled .w-nav-list.level_1 {
	color: <?php echo ($smof_data['header_text'] != '')?$smof_data['header_text']:'#fff'; ?>;
	}
.l-subheader.at_middle .w-nav-anchor.level_1 .ripple {
	background-color: <?php echo ($smof_data['header_text'] != '')?$smof_data['header_text']:'#fff'; ?>;
	}

/* Header Text Hover Color */
.no-touch .w-logo-link:hover,
.no-touch .l-subheader.at_middle .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_middle .w-lang-item:hover,
.no-touch .l-subheader.at_middle .w-socials-item-link:hover,
.no-touch .l-subheader.at_middle .w-search-show:hover,
.no-touch .l-subheader.at_middle .w-cart-link:hover {
	color: <?php echo ($smof_data['header_text_hover'] != '')?$smof_data['header_text_hover']:'#fff'; ?>;
	}

/* Extended Header Background Color */
.l-subheader.at_top,
.l-subheader.at_top .w-lang-list,
.l-subheader.at_bottom,
.l-subheader.at_bottom .touch_enabled .w-nav-list.level_1 {
	background-color: <?php echo ($smof_data['header_ext_bg'] != '')?$smof_data['header_ext_bg']:'#6039a8'; ?>;
	}

/* Extended Header Text Color */
.l-subheader.at_top,
.l-subheader.at_bottom,
.transparent .l-subheader.at_bottom .touch_enabled .w-nav-list.level_1,
.w-lang.active .w-lang-item {
	color: <?php echo ($smof_data['header_ext_text'] != '')?$smof_data['header_ext_text']:'#c8b8e5'; ?>;
	}
.l-subheader.at_bottom .w-nav-anchor.level_1 .ripple {
	background-color: <?php echo ($smof_data['header_ext_text'] != '')?$smof_data['header_ext_text']:'#c8b8e5'; ?>;
	}

/* Extended Header Text Hover Color */
.no-touch .l-subheader.at_top .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_top .w-lang-item:hover,
.no-touch .l-subheader.at_top .w-socials-item-link:hover,
.no-touch .l-subheader.at_bottom .w-search-show:hover,
.no-touch .l-subheader.at_bottom .w-cart-link:hover {
	color: <?php echo ($smof_data['header_ext_text_hover'] != '')?$smof_data['header_ext_text_hover']:'#fff'; ?>;
	}
	
/* Search Screen Background Color */
.w-search-form-overlay {
	background-color: <?php echo ($smof_data['search_bg'] != '')?$smof_data['search_bg']:'#7049ba'; ?>;
	}

/* Search Screen Text Color */
.l-subheader .w-search-form {
	color: <?php echo ($smof_data['search_text'] != '')?$smof_data['search_text']:'#fff'; ?>;
	}
.l-subheader .w-search-input:after,
.l-subheader input:focus ~ .w-search-input-bar:before,
.l-subheader input:focus ~ .w-search-input-bar:after {
	background-color: <?php echo ($smof_data['search_text'] != '')?$smof_data['search_text']:'#fff'; ?>;
	}
	
/*************************** MAIN MENU ***************************/

/* Menu Hover Background Color */
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	background-color: <?php echo ($smof_data['menu_hover_bg'] != '')?$smof_data['menu_hover_bg']:'#6039a8'; ?>;
	}

/* Menu Hover Text Color */
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_hover_text'] != '')?$smof_data['menu_hover_text']:'#fff'; ?>;
	}

/* Menu Active Text Color */
.l-header .w-nav-item.level_1.active .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_active_text'] != '')?$smof_data['menu_active_text']:'#ffc670'; ?>;
	}

/* Dropdown Background Color */
.l-header .w-nav-list.level_2,
.l-header .w-nav-list.level_3 {
	background-color: <?php echo ($smof_data['drop_bg'] != '')?$smof_data['drop_bg']:'#fff'; ?>;
	}
	
/* Dropdown Text Color */
.l-header .w-nav-anchor.level_2,
.l-header .w-nav-anchor.level_3,
.touch_disabled [class*="columns"] .w-nav-item.has_sublevel.active .w-nav-anchor.level_2,
.touch_disabled [class*="columns"] .w-nav-item.has_sublevel.current-menu-item .w-nav-anchor.level_2,
.touch_disabled [class*="columns"] .w-nav-item.has_sublevel.current-menu-ancestor .w-nav-anchor.level_2,
.no-touch .touch_disabled [class*="columns"] .w-nav-item.has_sublevel:hover .w-nav-anchor.level_2 {
	color: <?php echo ($smof_data['drop_text'] != '')?$smof_data['drop_text']:'#212121'; ?>;
	}
.l-header .w-nav-anchor.level_2 .ripple,
.l-header .w-nav-anchor.level_3 .ripple {
	background-color: <?php echo ($smof_data['drop_text'] != '')?$smof_data['drop_text']:'#212121'; ?>;
	}
	
/* Dropdown Hover Background Color */
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3 {
	background-color: <?php echo ($smof_data['drop_hover_bg'] != '')?$smof_data['drop_hover_bg']:'#eee'; ?>;
	}
	
/* Dropdown Hover Text Color */
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3 {
	color: <?php echo ($smof_data['drop_hover_text'] != '')?$smof_data['drop_hover_text']:'#212121'; ?>;
	}
	
/* Dropdown Active Background Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3 {
	background-color: <?php echo ($smof_data['drop_active_bg'] != '')?$smof_data['drop_active_bg']:'#f7f7f7'; ?>;
	}
	
/* Dropdown Active Text Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3 {
	color: <?php echo ($smof_data['drop_active_text'] != '')?$smof_data['drop_active_text']:'#7049ba'; ?>;
	}
	
/* Menu Button Background Color */
.btn.w-nav-item .w-nav-anchor.level_1,
.home .headerpos_fixed .transparent.state_initial .btn.w-nav-item .w-nav-anchor.level_1 {
	background-color: <?php echo ($smof_data['menu_button_bg'] != '')?$smof_data['menu_button_bg']:'#fff'; ?> !important;
	}
	
/* Menu Button Text Color */
.btn.w-nav-item .w-nav-anchor.level_1 {
	color: <?php echo ($smof_data['menu_button_text'] != '')?$smof_data['menu_button_text']:'#7049ba'; ?> !important;
	}

/* Menu Button Hover Background Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:hover,
.no-touch .home .headerpos_fixed .transparent.state_initial .btn.w-nav-item .w-nav-anchor.level_1:hover {
	background-color: <?php echo ($smof_data['menu_button_hover_bg'] != '')?$smof_data['menu_button_hover_bg']:'#fff'; ?> !important;
	}
	
/* Menu Button Hover Text Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:hover {
	color: <?php echo ($smof_data['menu_button_hover_text'] != '')?$smof_data['menu_button_hover_text']:'#7049ba'; ?> !important;
	}

/*************************** MAIN CONTENT ***************************/

/* Background Color */
.l-canvas,
.w-blog.type_masonry .w-blog-entry-h,
.w-cart-dropdown,
.w-portfolio-item-anchor,
.w-pricing.type_1 .w-pricing-item-h,
.w-team.type_1,
.woocommerce .form-row .chosen-drop,
.woocommerce-ordering:after,
.woocommerce-type_2 .product-h,
.no-touch .woocommerce-type_2 .product-meta,
.woocommerce #payment .payment_box,
.widget_layered_nav ul li.chosen {
	background-color: <?php echo ($smof_data['main_bg'] != '')?$smof_data['main_bg']:'#fff'; ?>;
	}
button.g-btn.color_contrast.type_raised,
a.g-btn.color_contrast.type_raised,
.w-iconbox.type_circle.color_contrast .w-iconbox-icon,
.w-socials.inverted.desaturated .w-socials-item-link {
	color: <?php echo ($smof_data['main_bg'] != '')?$smof_data['main_bg']:'#fff'; ?>;
	}

/* Alternate Background Color */
.l-submain.color_alternate,
.no-touch .g-btn.type_flat:hover,
.no-touch .g-pagination-item:hover,
.w-actionbox.color_alternate,
.w-blog.imgpos_atleft .w-blog-entry-preview-icon,
.w-bloglist,
.protected-post-form,
.w-iconbox.type_circle.color_light .w-iconbox-icon,
.no-touch .w-pagehead-nav-item:hover,
.w-pricing.type_1 .w-pricing-item-header,
.w-pricing.type_2 .w-pricing-item-h,
.w-socials-item-link,
.w-tabs-item .ripple,
.w-testimonial.type_1,
.w-timeline-item,
.w-timeline-section-title-text,
.widget_calendar #calendar_wrap,
.no-touch .l-main .widget_nav_menu a:hover,
.no-touch .slick-prev:hover,
.no-touch .slick-next:hover,
#lang_sel a,
#lang_sel a:visited,
#lang_sel ul ul,
.woocommerce .login,
.woocommerce .checkout_coupon,
.woocommerce .register,
.no-touch .woocommerce-type_2 .product-h .button:hover,
.no-touch .woocommerce-pagination a:hover,
.woocommerce .variations_form,
.woocommerce .variations_form .variations td.value:after,
.woocommerce .comment-respond,
.woocommerce .stars span a:after,
.woocommerce .cart_totals,
.no-touch .woocommerce .product-remove a:hover,
.woocommerce .shipping_calculator,
.woocommerce .checkout #order_review,
.woocommerce ul.order_details,
.widget_shopping_cart,
.widget_layered_nav ul {
	background-color: <?php echo ($smof_data['main_bg_alt'] != '')?$smof_data['main_bg_alt']:'#f5f5f5'; ?>;
	}

/* Border Color */
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="tel"],
input[type="number"],
input[type="date"],
textarea,
select,
.w-form-field > input:focus,
.w-form-field > textarea:focus,
.w-search.submit_inside input[type="text"]:focus,
.w-comments,
.w-sharing.type_simple .w-sharing-item,
.w-tabs-list,
.w-tabs.layout_accordion .w-tabs-section,
.w-timeline-list:before,
.w-timeline.type_vertical .w-timeline-section-title:before,
.l-main .widget_nav_menu > div,
.l-main .widget_nav_menu .menu-item a,
.woocommerce table th,
.woocommerce table td,
.woocommerce .quantity .plus,
.woocommerce .quantity .minus,
.woocommerce .form-row .chosen-container-single .chosen-single,
.woocommerce-tabs .tabs,
.woocommerce .related,
.woocommerce .upsells,
.woocommerce .cross-sells,
.woocommerce ul.order_details li,
.woocommerce .shop_table.my_account_orders {
	border-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e0e0e0'; ?>;
	}
.g-hr-h i,
.w-iconbox.type_default.color_light .w-iconbox-icon,
.w-testimonial.type_2:before,
.woocommerce .star-rating:before {
	color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e0e0e0'; ?>;
	}
.g-hr-h:before,
.g-hr-h:after,
button.g-btn.color_light.type_raised,
a.g-btn.color_light.type_raised,
.no-touch .color_alternate .g-btn.type_flat:hover,
.no-touch .color_alternate .g-pagination-item:hover,
.no-touch .color_alternate .w-pagehead-nav-item:hover,
.no-touch .color_alternate .slick-prev:hover,
.no-touch .color_alternate .slick-next:hover,
.no-touch .color_alternate .woocommerce-pagination a:hover,
.widget_price_filter .ui-slider:before {
	background-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e0e0e0'; ?>;
	}

/* Heading Color */
h1, h2, h3, h4, h5, h6,
.w-counter-number,
.w-portfolio-item-anchor,
.no-touch .w-portfolio-item-anchor:hover,
.l-submain.color_primary a.w-portfolio-item-anchor,
.l-submain.color_secondary a.w-portfolio-item-anchor {
	color: <?php echo ($smof_data['main_heading'] != '')?$smof_data['main_heading']:'#212121'; ?>;
	}

/* Text Color */
.l-canvas,
button.g-btn.color_light.type_raised,
a.g-btn.color_light.type_raised,
.w-blog.type_masonry .w-blog-entry-h,
.w-cart-dropdown,
.w-iconbox.type_circle.color_light .w-iconbox-icon,
.w-pricing-item-h,
.w-team.type_1,
.w-testimonial.type_1,
.w-timeline-item,
.w-timeline-section-title-text,
.woocommerce .form-row .chosen-drop,
.woocommerce-type_2 .product-h {
	color: <?php echo ($smof_data['main_text'] != '')?$smof_data['main_text']:'#424242'; ?>;
	}
button.g-btn.color_contrast.type_raised,
a.g-btn.color_contrast.type_raised,
.w-iconbox.type_circle.color_contrast .w-iconbox-icon {
	background-color: <?php echo ($smof_data['main_text'] != '')?$smof_data['main_text']:'#424242'; ?>;
	}
	
/* Primary Color */
a,
.highlight_primary,
button.g-btn.color_primary.type_flat,
a.g-btn.color_primary.type_flat,
.w-counter.color_primary .w-counter-number,
.w-iconbox.type_default.color_primary .w-iconbox-icon,
.w-filters-item.active,
.w-form-field > input:focus + i,
.w-form-field > textarea:focus + i,
.w-search-input > input:focus + i,
.w-tabs-item.active,
.w-tabs-section.active .w-tabs-section-header,
.w-team-link .w-team-name,
.l-main .widget_nav_menu .menu-item.current-menu-item > a,
.no-touch .woocommerce-type_2 .product-h a.button,
.woocommerce-tabs .tabs li.active,
.woocommerce .cart_totals .order-total,
.woocommerce .checkout .shop_table .order-total {
	color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#7049ba'; ?>;
	}
.l-submain.color_primary,
.highlight_primary_bg,
button,
input[type="submit"],
button.g-btn.color_primary.type_raised,
a.g-btn.color_primary.type_raised,
.g-pagination-item.active,
.no-touch .g-pagination-item.active:hover,
.w-actionbox.color_primary,
input:focus ~ .w-form-field-bar:before,
input:focus ~ .w-form-field-bar:after,
textarea:focus ~ .w-form-field-bar:before,
textarea:focus ~ .w-form-field-bar:after,
input:focus ~ .w-search-input-bar:before,
input:focus ~ .w-search-input-bar:after,
.w-iconbox.type_circle.color_primary .w-iconbox-icon,
.w-pricing.type_1 .type_featured .w-pricing-item-header,
.w-pricing.type_2 .type_featured .w-pricing-item-h,
.w-tabs-item:last-child:before,
.no-touch .w-timeline-item:hover,
.w-timeline-item.active,
.w-timeline-section.active .w-timeline-section-title-text,
.tp-bullets.custom .bullet.selected,
.no-touch .tp-bullets.custom .bullet.selected:hover,
.woocommerce .button.alt,
.woocommerce .button.checkout,
.woocommerce-pagination span.current,
.widget_price_filter .ui-slider-range,
.widget_price_filter .ui-slider-handle {
	background-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#7049ba'; ?>;
	}
.g-html blockquote,
.w-filters-item.active,
.fotorama__thumb-border,
input:focus,
textarea:focus,
select:focus,
.validate-required.woocommerce-validated input:focus,
.validate-required.woocommerce-invalid input:focus,
.woocommerce .form-row .chosen-search input[type="text"]:focus,
.woocommerce-tabs .tabs li.active {
	border-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#7049ba'; ?>;
	}
input:focus,
textarea:focus {
	box-shadow: 0 -1px 0 0 <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#7049ba'; ?> inset;
	}

/* Secondary Color */
.no-touch a:hover,
.highlight_secondary,
button.g-btn.color_secondary.type_flat,
a.g-btn.color_secondary.type_flat,
.no-touch .w-blog-entry-link:hover .w-blog-entry-title-h,
.no-touch .w-blog-meta a:hover,
.w-counter.color_secondary .w-counter-number,
.w-iconbox.type_default.color_secondary .w-iconbox-icon,
.w-iconbox.type_default .w-iconbox-link:active .w-iconbox-icon,
.no-touch .w-iconbox.type_default .w-iconbox-link:hover .w-iconbox-icon,
.w-iconbox-link:active .w-iconbox-title,
.no-touch .w-iconbox-link:hover .w-iconbox-title,
.no-touch .w-team-link:hover .w-team-name,
.no-touch .l-main .widget_tag_cloud a:hover,
.no-touch .l-main .widget_product_tag_cloud .tagcloud a:hover,
.woocommerce .star-rating span:before,
.woocommerce .stars span a:after {
	color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#ffb03a'; ?>;
	}
.l-submain.color_secondary,
.highlight_secondary_bg,
button.g-btn.color_secondary.type_raised,
a.g-btn.color_secondary.type_raised,
.w-actionbox.color_secondary,
.w-iconbox.type_circle.color_secondary .w-iconbox-icon,
.no-touch .w-toplink.active:hover,
.no-touch .tp-leftarrow.custom:hover,
.no-touch .tp-rightarrow.custom:hover,
p.demo_store,
.woocommerce .onsale,
.woocommerce .form-row .chosen-results li.highlighted {
	background-color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#ffb03a'; ?>;
	}

/* Fade Elements Color */
.highlight_faded,
button.g-btn.color_light.type_flat,
a.g-btn.color_light.type_flat,
.w-blog-meta,
.w-comments-item-date,
.w-comments-item-answer a,
.w-socials.desaturated .w-socials-item-link,
.w-tags,
.l-main .widget_tag_cloud a,
.l-main .widget_product_tag_cloud .tagcloud a,
.woocommerce .stars span:after {
	color: <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#9e9e9e'; ?>;
	}
.g-btn.type_flat .ripple,
.g-btn.color_light.type_raised .ripple,
.w-socials.inverted.desaturated .w-socials-item-link {
	background-color: <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#9e9e9e'; ?>;
	}

/*************************** SUBFOOTER ***************************/

/* Background Color */
.l-subfooter.at_top,
.l-subfooter.at_top #lang_sel ul ul {
	background-color: <?php echo ($smof_data['subfooter_bg'] != '')?$smof_data['subfooter_bg']:'#212121'; ?>;
	}
	
/* Alternate Background Color */
.l-subfooter.at_top .w-socials-item-link,
.l-subfooter.at_top .widget_calendar #calendar_wrap,
.l-subfooter.at_top .widget_shopping_cart {
	background-color: <?php echo ($smof_data['subfooter_bg_alt'] != '')?$smof_data['subfooter_bg_alt']:'#292929'; ?>;
	}

/* Border Color */
.l-subfooter.at_top,
.l-subfooter.at_top input,
.l-subfooter.at_top textarea,
.l-subfooter.at_top select,
.l-subfooter.at_top .w-form-field > input:focus,
.l-subfooter.at_top .w-form-field > textarea:focus,
.l-subfooter.at_top .w-search.submit_inside input[type="text"]:focus {
	border-color: <?php echo ($smof_data['subfooter_border'] != '')?$smof_data['subfooter_border']:'#333'; ?>;
	}

/* Heading Color */
.l-subfooter.at_top h1,
.l-subfooter.at_top h2,
.l-subfooter.at_top h3,
.l-subfooter.at_top h4,
.l-subfooter.at_top h5,
.l-subfooter.at_top h6 {
	color: <?php echo ($smof_data['subfooter_heading'] != '')?$smof_data['subfooter_heading']:'#9e9e9e'; ?>;
	}
	
/* Text Color */
.l-subfooter.at_top {
	color: <?php echo ($smof_data['subfooter_text'] != '')?$smof_data['subfooter_text']:'#757575'; ?>;
	}
	
/* Link Color */
.l-subfooter.at_top a,
.l-subfooter.at_top .widget_tag_cloud .tagcloud a,
.l-subfooter.at_top .widget_product_tag_cloud .tagcloud a {
	color: <?php echo ($smof_data['subfooter_link'] != '')?$smof_data['subfooter_link']:'#9e9e9e'; ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_top a:hover,
.l-subfooter.at_top .w-form-field > input:focus + i,
.l-subfooter.at_top .w-form-field > textarea:focus + i,
.l-subfooter.at_top .w-search-input > input:focus + i,
.no-touch .l-subfooter.at_top .widget_tag_cloud .tagcloud a:hover,
.no-touch .l-subfooter.at_top .widget_product_tag_cloud .tagcloud a:hover {
	color: <?php echo ($smof_data['subfooter_link_hover'] != '')?$smof_data['subfooter_link_hover']:'#ffb03a'; ?>;
	}
.l-subfooter.at_top input:focus ~ .w-form-field-bar:before,
.l-subfooter.at_top input:focus ~ .w-form-field-bar:after,
.l-subfooter.at_top textarea:focus ~ .w-form-field-bar:before,
.l-subfooter.at_top textarea:focus ~ .w-form-field-bar:after,
.l-subfooter.at_top input:focus ~ .w-search-input-bar:before,
.l-subfooter.at_top input:focus ~ .w-search-input-bar:after {
	background-color: <?php echo ($smof_data['subfooter_link_hover'] != '')?$smof_data['subfooter_link_hover']:'#ffb03a'; ?>;
	}
.l-subfooter.at_top input:focus,
.l-subfooter.at_top textarea:focus,
.l-subfooter.at_top select:focus {
	border-color: <?php echo ($smof_data['subfooter_link_hover'] != '')?$smof_data['subfooter_link_hover']:'#ffb03a'; ?>;
	}
.l-subfooter.at_top input:focus,
.l-subfooter.at_top textarea:focus {
	box-shadow: 0 -1px 0 0 <?php echo ($smof_data['subfooter_link_hover'] != '')?$smof_data['subfooter_link_hover']:'#ffb03a'; ?> inset;
	}

/*************************** FOOTER ***************************/

/* Background Color */
.l-subfooter.at_bottom {
	background-color: <?php echo ($smof_data['footer_bg'] != '')?$smof_data['footer_bg']:'#111'; ?>;
	}

/* Text Color */
.l-subfooter.at_bottom {
	color: <?php echo ($smof_data['footer_text'] != '')?$smof_data['footer_text']:'#757575'; ?>;
	}

/* Link Color */
.l-subfooter.at_bottom a {
	color: <?php echo ($smof_data['footer_link'] != '')?$smof_data['footer_link']:'#9e9e9e'; ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_bottom a:hover {
	color: <?php echo ($smof_data['footer_link_hover'] != '')?$smof_data['footer_link_hover']:'#ffb03a'; ?>;
	}
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
</style>
<?php
}
?>
<?php if ($smof_data['custom_css'] != '') { ?>
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
<style>
<?php
}
?>
<?php echo $smof_data['custom_css'] ?>
<?php
if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE) {
?>
</style>
<?php
}
?>
<?php } ?>