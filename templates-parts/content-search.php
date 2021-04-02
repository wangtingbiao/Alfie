<article id="post-<?php the_ID(); ?>" <?php post_class('enty-list'); ?>>
	<div class="enty-box">
		<?php
		/* 标题 */
		the_title('<h3 class="enty-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h3>');

		/* 元数据 */
		alfie_get_post_meta();
		?>
		<div class="enty-cat">
			<?php the_category(' ', ''); ?>
		</div>
	</div>
</article>