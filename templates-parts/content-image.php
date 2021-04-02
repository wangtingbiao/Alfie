<article id="post-<?php the_ID(); ?>" <?php post_class('enty-list'); ?>>
	<figure class="enty-pic">
		<a href="<?php the_permalink(); ?>">
			<?php
			alfie_get_post_format();
			alfie_get_medium_thumbnail();
			?>
		</a>
	</figure>
	<?php
	/* 标题 */
	the_title('<h3 class="enty-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h3>');
	?>
</article>