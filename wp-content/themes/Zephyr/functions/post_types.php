<?php
add_action( 'init', 'create_post_types' );

if ( ! function_exists('create_post_types')) {
	function create_post_types() {
		global $smof_data;
		// Portfolio post type
		register_post_type( 'us_portfolio',
			array(
				'labels' => array(
					'name' => 'Portfolio Items',
					'singular_name' => 'Portfolio Item',
					'add_new' => 'Add Portfolio Item',
				),
				'public' => true,
//                'has_archive' => true,
				'rewrite' => array('slug' => empty($smof_data['portfolio_slug'])?'us_portfolio':$smof_data['portfolio_slug']),
				'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments'),
				'can_export' => true,
			)
		);

		// Clients post type
		register_post_type( 'us_client',
			array(
				'labels' => array(
					'name' => 'Clients Logos',
					'singular_name' => 'Client Logo',
					'add_new' => 'Add Client Logo',
				),
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => false,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'has_archive' => false,
				'query_var' => false,
				'supports' => array('title', 'thumbnail'),
				'can_export' => true,
			)
		);

	}

	// Portfolio categories
	register_taxonomy('us_portfolio_category', array('us_portfolio'), array('hierarchical' => true, 'label' => 'Portfolio Categories','singular_label' => 'Portfolio Category', 'rewrite' => true));

}

add_filter( 'the_password_form', 'custom_password_form' );
function custom_password_form() {
	global $post;
	$output = '<form class="w-form protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
				<div class="w-form-row">
					<div class="w-form-label">
						<label>' . 'This post is password protected. To view it please enter your password below:' . '</label>
					</div>
					<div class="w-form-field for_input">
						<input type="password" value="" name="post_password"/><i class="mdfi_action_lock"></i><span class="w-form-field-bar"></span>
					</div>
					<div class="w-form-field for_submit">
						<input class="g-btn type_raised" type="submit" value="'.'Submit' .'" />
					</div>
				</div>
			</form>';
	return $output;
}

add_action( 'admin_head', 'us_portfolio_icons' );

function us_portfolio_icons() {
	?>
	<style type="text/css" media="screen">
		#adminmenu #menu-posts-us_portfolio .menu-icon-post div.wp-menu-image:before {
			content: "\f232";
			}
		#adminmenu #menu-posts-us_client .menu-icon-post div.wp-menu-image:before {
			content: "\f313";
			}
	</style>
<?php }
