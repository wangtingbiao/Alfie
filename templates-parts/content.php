<?php

$enty_link	=	esc_html__('查看详情', 'text-alfie');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('enty-list'); ?>>
	<?php if (has_post_thumbnail()) : ?>
		<figure class="enty-pic">
			<a href="<?php the_permalink(); ?>" style="background-image: url(<?php alfie_get_medium_thumbnail_url(); ?>);"></a>
		</figure>
	<?php endif; ?>
	<div class="enty-box">
		<div class="enty-cat">
			<?php the_category(' ', ''); ?>
		</div>
		<?php
		/* 标题 */
		the_title('<h3 class="enty-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h3>');

		/* 元数据 */
		alfie_get_post_meta();

		/* 摘要 */
		the_excerpt();
		?>
		<div class="enty-link"><a href="<?php the_permalink(); ?>"><?php echo $enty_link; ?></a></div>
	</div>
</article>