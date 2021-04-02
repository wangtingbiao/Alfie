<?php

/**
 * 主模板文件
 *
 * 这是WordPress主题中最通用的模板文件，一般作为默认归档模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w-2">
	<?php
	// 当前分类子分类
	get_template_part('templates/template', 'recommend');

	// 当前分类标题信息与搜索
	alfie_get_breadcrumbs();

	// 循环文章
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
	?>
</div>
<?php get_footer(); ?>