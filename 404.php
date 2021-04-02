<?php

/**
 * 用于显示404页的模板（未找到）
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();

$no_title	=	esc_html__('4 0 4', 'text-alfie');
$no_desc	=	esc_html__('没有任何信息，请您重新来过！', 'text-alfie');

?>
<div class="max-w-2">
	<div class="__404">
		<h2 class="enty-title"><?php echo $no_title; ?></h2>
		<p class="enty-desc"><?php echo $no_desc; ?></p>
		<?php get_search_form(); ?>
	</div>
</div>
<?php get_footer(); ?>