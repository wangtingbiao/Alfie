<?php

/**
 * 主页面模板
 *
 * 这是WordPress主题中最通用的模板文件，一般作为默认首页模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();
?>
<div class="max-w">
	<?php
	if (is_active_sidebar('home-sidebar')) {
		dynamic_sidebar('home-sidebar');
	}
	?>
</div>
<?php get_footer(); ?>