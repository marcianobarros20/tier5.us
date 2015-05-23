<?php
define('IS_FULLWIDTH', TRUE);
get_header(); ?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">

				<div class="page-404">
					<i class="mdfi_action_explore"></i>
					<h1><?php esc_html_e('Error 404 - page not found', 'us') ?></h1>
					<p><?php esc_html_e('Ohh... You have requested the page that is no longer there', 'us') ?>.<p>
				</div>

			</div>
		</div>
	</div>
<?php get_footer(); ?>
