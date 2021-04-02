<?php

/**
 * 自定义搜索框
 *
 * 方便添加动态效果等功能
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
$unique_id		=	esc_attr(uniqid('search-form-'));
$placeholder	=	esc_attr__('搜索 &hellip;', 'text-alfie');
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label><i class="fa fa-search" aria-hidden="true"></i></label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" name="s" value="<?php the_search_query(); ?>" placeholder="<?php echo $placeholder; ?>" />
</form>