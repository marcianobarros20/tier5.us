<?php

if ( ! function_exists('gridAjaxPagination'))
{
	function gridAjaxPagination(){

		global $smof_data, $us_thumbnail_size;

		$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
		if ($page < 1){
			$page = 1;
		}

		$wp_query = new WP_Query();

		$lang_param = '';

		if (defined('ICL_LANGUAGE_CODE')){
			$lang_param = '&lang='.ICL_LANGUAGE_CODE;
		}

		$wp_query->query('paged='.$page.'&post_type=post&post_status=publish'.$lang_param);

		while ($wp_query->have_posts()){
			$wp_query->the_post();
			$us_thumbnail_size = 'blog-big';
			get_template_part('templates/blog_single_post');
		}

		die();

	}

	add_action( 'wp_ajax_nopriv_gridPagination', 'gridAjaxPagination' );
	add_action( 'wp_ajax_gridPagination', 'gridAjaxPagination' );
}
