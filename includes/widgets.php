<?php

/**
 * 注册窗口小部件区域
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
function adds_widgets()
{
	$sidebar				=	[
		'name'				=>	esc_html__('自定义首页', 'text-alfie'),
		'id'				=>	'home-sidebar',
		'before_widget'		=>	'<div id="%1$s" class="widget %2$s">',
		'after_widget'		=>	'</div>',
		'before_title'		=>	'<h2 class="enty-title">',
		'after_title'		=>	'</h2>',
	];
	register_sidebar($sidebar);
}
add_action('widgets_init', 'adds_widgets');
