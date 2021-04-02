<?php

/**
 * 用于显示搜索结果页面的模板。
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w-2">
	<?php
	// 搜索结果提示和搜索框
	alfie_get_breadcrumbs();

	// 循环文章
	if (have_posts()) :
		echo '<div class="__posts" itemprop="SearchResultsPage">';
		while (have_posts()) : the_post();
			get_template_part('templates-parts/content', 'search');
		endwhile;
		echo '</div>';
		get_template_part('templates-parts/content', 'next');
	else :
		get_template_part('templates-parts/content', 'none');
	endif;
	?>
</div>
<?php get_footer(); ?>