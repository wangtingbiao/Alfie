<?php

/**
 * Template Name: Links template
 *
 * 自定义友情链接二级页面
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w-2">
	<div class="__post_page __page __layout">
		<?php while (have_posts()) : the_post(); ?>
			<article class="layout-full enty-conent">
				<?php
				// 主体内容
				the_content();

				/* 链接循环 */
				$args					=	[
					'show_description'	=>	true,
					'title_before'		=>	'<h2 class="enty-title">',
					'title_after'		=>	'</h2>',
					'category_before'	=>	'<div id="%id" class="widget_links">',
					'category_after'	=>	'</div>',
				];
				wp_list_bookmarks($args);

				?>
			</article>
			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="layout-full enty-comment">
					<div class="enty-box">
						<?php comments_template(); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>