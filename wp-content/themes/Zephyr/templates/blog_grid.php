<?php
// We'll need the isotope script for this, but only once
if ( ! wp_script_is('us-isotope', 'enqueued')){
	wp_enqueue_script('us-isotope');
}
// We need fotorama script for this, but only once per page
if ( ! wp_script_is('us-fotorama', 'enqueued')){
	wp_enqueue_script('us-fotorama');
}
global $smof_data, $us_thumbnail_size;
?><div class="w-blog type_masonry imgpos_attop">
	<div class="w-blog-list">

		<?php
		$temp = $wp_query; $wp_query= null;
		$wp_query = new WP_Query(); $wp_query->query('paged='.$paged.'&post_type=post');
		$max_num_pages = $wp_query->max_num_pages;
		while ($wp_query->have_posts())
		{
			$wp_query->the_post();
			$us_thumbnail_size = 'blog-grid';
			get_template_part('templates/blog_single_post');
		}
		?>

	</div>
</div>
<?php
if ($max_num_pages > 1) {
?>
<script type="text/javascript">
var page = 1,
	max_page = <?php echo esc_js($max_num_pages) ?>;
jQuery(document).ready(function(){
	jQuery("#grid_load_more").click(function(){
		jQuery(".w-loadmore").addClass("loading");
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: {
				action: 'gridPagination',
				page: page+1
			},
			success: function(data, textStatus, XMLHttpRequest){
				page++;

				var newItems = jQuery('<div>', {html:data}),
					blogList = jQuery('.w-blog-list');

				newItems.imagesLoaded(function() {
					newItems.children().each(function(childIndex,child){
						blogList.append(jQuery(child)).isotope('appended', jQuery(child));
						blogList.find(".fotorama").fotorama().on("fotorama:ready", function (e, fotorama) { blogList.isotope("layout"); });
					});
				});

				jQuery(".w-loadmore").removeClass("loading");
				if (max_page <= page) {
					jQuery(".w-loadmore").addClass("done");
				}

			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				jQuery(".w-loadmore").removeClass("loading");
			}
		});
	});
});
</script>
<div class="w-loadmore">
	<a href="javascript:void(0);" id="grid_load_more" class="g-btn color_contrast hover_light outlined"><span><?php echo __('Load More Posts', 'us') ?></span></a>
	<i class="fa fa-refresh fa-spin"></i>
</div>
<?php
}
wp_reset_postdata();
$wp_query= $temp;
