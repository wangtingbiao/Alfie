<?php

/**
 * Alfie功能和定义
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */

/**
 * 首先，让我们根据主题的设计和样式表设置最大内容宽度
 * 这将限制所有上载图像和嵌入的宽度
 */
if (!isset($content_width)) {
	$content_width = 1600;
}

/**
 * 设置主题默认值，并注册对各种WordPress功能的支持
 *
 * 请注意，此函数已挂接到after_setup_theme挂钩中，该挂钩在init挂钩之前运行
 * 对于某些功能（例如表示支持帖子缩略图），init挂钩为时已晚
 */
function alfie_setup_theme()
{
	/*
	 * 使主题可用于翻译
	 * 可以将翻译文件存储在/ languages /目录中
	 * 如果要基于Alfie创建主题，请使用查找和替换
	 * 将“text-alfie”更改为所有模板文件中主题的名称
	 */
	load_theme_textdomain('text-alfie', get_template_directory() . '/languages');

	/*
	 * 启用对帖子和页面上的帖子缩略图的支持
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	add_image_size('alfie-large', 1024, 480, true);
	add_image_size('alfie-medium', 768, 360, true);
	add_image_size('alfie-small', 320, 150, true);

	// 设置帖子缩略图的大小
	set_post_thumbnail_size(1024, 9999);

	/*
	 * 让WordPress管理文档标题
	 * 通过添加主题支持，我们声明此主题在文档头中不使用硬编码的<title>标签，
	 * 并希望WordPress为我们提供它
	 */
	add_theme_support('title-tag');

	// 将默认的帖子和评论RSS feed链接添加到头部
	add_theme_support('automatic-feed-links');

	// 自定义徽标
	add_theme_support('custom-logo');

	// 注册导航菜单在三个位置使用wp_nav_menu
	$locations				=	[
		'main-menu'			=>	esc_html__('主菜单', 'text-alfie'),
		'sidebar-menu'		=>	esc_html__('页面菜单', 'text-alfie'),
		'footer-menu'		=>	esc_html__('底部菜单', 'text-alfie'),
	];
	register_nav_menus($locations);

	/*
	 * 切换搜索表单，注释表单和注释的默认核心标记，
	 * 以输出有效的HTML5
	 */
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		]
	);

	/*
	 * 此功能启用对主题的“张贴格式”支持
	 * aside, gallery, link, image, quote, status, video, audio, chat
	 */
	add_theme_support(
		'post-formats',
		[
			'chat',
			'video',
			'image',
			'audio',
		]
	);

	// 添加主题支持，以选择性地刷新小部件
	add_theme_support('customize-selective-refresh-widgets');

	// 添加对全宽和宽对齐图像的支持
	add_theme_support('align-wide');

	// 添加对响应式嵌入的支持
	add_theme_support('responsive-embeds');

	// 块编辑器样式
	add_theme_support('editor-styles');
	add_editor_style('/editor-style.css');

	// 自定义背景色
	//add_theme_support('custom-background');

	// 自定义头部
	//add_theme_support( 'custom-header' );

}
add_action('after_setup_theme', 'alfie_setup_theme');
