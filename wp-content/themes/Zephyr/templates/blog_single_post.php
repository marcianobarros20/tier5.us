<?php

global $smof_data;

$post_format = get_post_format()?get_post_format():'standard';

global $us_thumbnail_size, $post;
if (empty($us_thumbnail_size))
{
	$us_thumbnail_size = 'blog-grid';
}


if ($post_format == 'image')
{
	$preview = us_post_format_image_preview($us_thumbnail_size);
}
elseif ($post_format == 'gallery')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '') {
		$preview = us_post_format_gallery_preview(true, $us_thumbnail_size);
		if ($us_thumbnail_size == 'blog-small') {
			$preview = '<span class="w-blog-entry-preview-icon">
							<i class="mdfi_image_collections"></i>
						</span>';
		}
	}
}
elseif ($post_format == 'video')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '') {
		if ($us_thumbnail_size == 'blog-small') {
			$preview = '<span class="w-blog-entry-preview-icon">
						<i class="mdfi_av_play_circle_fill"></i>
					</span>';
		} else {
			$preview = us_post_format_video_preview();
		}
	}

}
elseif ($post_format == 'quote')
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';

	if ($preview == '' AND $us_thumbnail_size == 'blog-small') {
		$preview = '<span class="w-blog-entry-preview-icon">
						<i class="mdfi_editor_format_quote"></i>
					</span>';
	}
}
else
{
	$preview = (has_post_thumbnail())?get_the_post_thumbnail(get_the_ID(), $us_thumbnail_size):'';
}

if (empty($preview) AND $us_thumbnail_size == 'blog-small')
{
	$preview = '<span class="w-blog-entry-preview-icon"><i class="fa fa-file-o"></i></span>';
}
?>
<div <?php post_class('w-blog-entry') ?>>
	<div class="w-blog-entry-h">
		<?php  if ($preview AND in_array($post_format, array('video', 'gallery'))) {
			echo '<span class="w-blog-entry-preview">'.$preview.'</span>';
		} ?>
		<a class="w-blog-entry-link" href="<?php the_permalink(); ?>">
			<?php  if ($preview AND ! in_array($post_format, array('video', 'gallery'))) {
				echo '<span class="w-blog-entry-preview">'.$preview.'</span>';
			} ?>
			<?php
			if ($post_format == 'quote')
			{
				?><div class="w-blog-entry-title">
					<blockquote class="w-blog-entry-title-h"><?php the_title(); ?></blockquote>
				</div><?php
			}
			else
			{
				?><h2 class="w-blog-entry-title">
					<span class="w-blog-entry-title-h"><?php the_title(); ?></span>
				</h2><?php
			}
			?>
		</a>
		<div class="w-blog-entry-body">
			<div class="w-blog-meta">
				<?php if ( ! isset($smof_data['post_meta_date']) OR $smof_data['post_meta_date'] == 1) { ?>
				<div class="w-blog-meta-date">
					<i class="mdfi_action_schedule"></i>
					<span><?php echo get_the_date() ?></span>
				</div>
				<?php } ?>
				<?php if ( ! isset($smof_data['post_meta_author']) OR $smof_data['post_meta_author'] == 1) { ?>
					<div class="w-blog-meta-author">
						<i class="mdfi_social_person"></i>
						<?php if (get_the_author_meta('url')) { ?>
							<a href="<?php echo esc_url( get_the_author_meta('url') ); ?>"><?php echo get_the_author() ?></a>
						<?php } else { ?>
							<span><?php echo get_the_author() ?></span>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if ( ! isset($smof_data['post_meta_categories']) OR $smof_data['post_meta_categories'] == 1) { ?>
					<div class="w-blog-meta-tags">
						<i class="mdfi_file_folder_open"></i>
						<?php the_category(', '); ?>
					</div>
				<?php } ?>
				<?php if ( ! isset($smof_data['post_meta_comments']) OR $smof_data['post_meta_comments'] == 1) { ?>
					<div class="w-blog-meta-comments">
						<?php if ( ! (get_comments_number() == 0 AND ! comments_open() AND ! pings_open())) { echo '<i class="mdfi_communication_comment"></i>'; }  ?>
						<?php comments_popup_link(__('No Comments', 'us'), __('1 Comment', 'us'), __('% Comments', 'us'), 'w-blog-meta-comments-h', ''); ?>
					</div>
				<?php } ?>
			</div>
			<?php if ($smof_data['use_excerpt'] != 'No Content') { ?>
			<div class="w-blog-entry-short">
				<?php
				if ($smof_data['use_excerpt'] == 'Full Content of Post' AND $us_thumbnail_size != 'blog-grid')
				{
					global $disable_section_shortcode;
					$original_section_shortcode_state = $disable_section_shortcode;
					$disable_section_shortcode = TRUE;

					$content = $post->post_content;

					$more_tag_found = 0;
					if ( preg_match( '/<!--nextpage(.*?)?-->/', $content, $matches ) ) {
						$content = explode( $matches[0], $content, 2 );
						$content = $content[0];
					}
					if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
						$more_tag_found = 1;
						$content = explode( $matches[0], $content, 2 );
						$content = $content[0];
					}

					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					echo $content;
					if ($more_tag_found) {
						echo ' <a href="'.get_the_permalink().'">'.__('Continue reading', 'us').'</a>';
					}

					$disable_section_shortcode = $original_section_shortcode_state;
				}
				else
				{
					$excerpt = $post->post_excerpt;
					if(!empty($excerpt))
					{
						the_excerpt();
					}
					else
					{
						$excerpt = $post->post_content;

						$more_tag_found = 0;
						if ( preg_match( '/<!--nextpage(.*?)?-->/', $excerpt, $matches ) ) {
							$excerpt = explode( $matches[0], $excerpt, 2 );
							$excerpt = $excerpt[0];
						}
						if ( preg_match( '/<!--more(.*?)?-->/', $excerpt, $matches ) ) {
							$more_tag_found = 1;
							$excerpt = explode( $matches[0], $excerpt, 2 );
							$excerpt = $excerpt[0];
						}

						$excerpt = apply_filters('the_content', $excerpt);
						$excerpt = apply_filters('the_excerpt', $excerpt);
						$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
						$excerpt_length = apply_filters('excerpt_length', 55);
						$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
						$excerpt = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
						echo $excerpt;
						if ($more_tag_found) {
							echo ' <a href="'.get_the_permalink().'">'.__('Continue reading', 'us').'</a>';
						}
					}

				}

				?>
			</div>
			<?php
				if ( ! isset($smof_data['post_read_more']) OR $smof_data['post_read_more'] == 1) { ?><a class="w-blog-entry-more g-btn color_light hover_secondary outlined" href="<?php the_permalink(); ?>"><span><?php echo __('Read More', 'us') ?></span></a><?php }
			} ?>
		</div>
	</div>
</div>
