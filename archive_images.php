<?php

/**
 * Template Name: Images template
 *
 * 自定义图片列表模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w" itemprop="ImageGallery">
	<?php
	// 当前分类子分类
	get_template_part('templates/template', 'recommend');

	// 当前分类标题信息与搜索
	alfie_get_breadcrumbs();

	// 循环文章
	if (have_posts()) {
		echo '<div class="__images">';
		while (have_posts()) : the_post();
			get_template_part('templates-parts/content', 'image');
		endwhile;
		echo '</div>';
		get_template_part('templates-parts/content', 'next');
	} else {
		get_template_part('templates-parts/content', 'none');
	}
	?>
</div>
<?php get_footer(); ?>