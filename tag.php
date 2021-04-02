<?php

/**
 * 帖子标签页模板文件
 *
 * 这是WordPress主题中最通用的模板文件，一般作为默认标签模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();

$tags	=	esc_html__('热门标签', 'text-alfie');
?>
<div class="max-w-2">
	<?php
	/* 分类和搜索 */
	alfie_get_breadcrumbs();

	/* 标签循环 */
	if (have_posts()) {
		echo '<div class="__posts">';
		while (have_posts()) : the_post();
			get_template_part('templates-parts/content');
		endwhile;
		echo '</div>';
		get_template_part('templates-parts/content', 'next');
	} else {
		get_template_part('templates-parts/content', 'none');
	}

	/* 热门标签 */
	echo '<div class="__breadcrumbs main-list-2">
			<h2 class="enty-title" itemprop="breadcrumb">' . $tags . '</h2>
			<div class="enty-desc">';
				$tag_cloud		=	[
					'unit'		=>	'px',
					'smallest'	=>	'15',
					'largest'	=>	'15',
					'number'	=>	'16',
					'order'		=>	'rand',
				];
				wp_tag_cloud($tag_cloud);
	echo '</div>
		</div>';
	?>
</div>
<?php get_footer(); ?>