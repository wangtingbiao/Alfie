<?php

/**
 * 独立页面模板文件
 *
 * 这是WordPress主题中最通用的模板文件，一般作为默认页面模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w-2">
	<div class="__post_page __page __layout">
		<?php while (have_posts()) : the_post(); ?>
			<article class="layout-left enty-conent">
				<div class="enty-box">
					<?php the_title('<h3 class="enty-title">', '</h3>'); ?>
					<div class="enty-meta"></div>
					<?php
					// 主体内容
					the_content();

					// 内容分页
					$link_pages		=	[
						'before'	=>	'<p class="prevnext">',
						'after'		=>	'</p>',
					];
					wp_link_pages($link_pages);
					?>
				</div>
			</article>
			<?php if (comments_open() || get_comments_number()) : ?>
				<!-- 评论表单 -->
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