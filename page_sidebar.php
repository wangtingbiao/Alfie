<?php

/**
 * Template Name: Page sidebar template
 *
 * 独立页面模板文件
 *
 * 带有侧边导航的页面模板
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
					// 内容
					the_content();

					// 内容内部分页
					$link_pages	=	[
						'before'	=>	'<p class="prevnext">',
						'after'		=>	'</p>',
					];
					wp_link_pages($link_pages);
					?>
				</div>
			</article>
			<?php
			// 评论表单
			if (comments_open() || get_comments_number()) {
			?>
				<div class="layout-full enty-comment">
					<div class="enty-box">
						<?php comments_template(); ?>
					</div>
				</div>
			<?php } ?>
		<?php endwhile; ?>
		<?php
		// 侧面导航
		if (has_nav_menu('sidebar-menu')) { ?>
			<aside class="layout-right enty-aside">
				<div class="enty-box">
					<?php
					$foo_menus				=	[
						'theme_location'	=>	'sidebar-menu',
						'container'			=>	'nav',
						'container_class'	=>	'enty-nav',
						'items_wrap'		=>	'<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'				=>	1,
					];
					wp_nav_menu($foo_menus);
					?>
				</div>
			</aside>
		<?php } ?>
	</div>
</div>
<?php get_footer(); ?>