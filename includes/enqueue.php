<?php

/**
 * 脚本和样式引入
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */

// 是否开发者模式
define('ALF_DEV_MOOE', true);

/**
 * 注册和排队样式
 */
function alfie_enqueue()
{
	$ver	= 	ALF_DEV_MOOE ? time() : false;
	$uri	=	get_theme_file_uri();

	if (!is_admin()) {
		// 主css
		wp_register_style('alfie-style', get_stylesheet_uri(), [], $ver);
		wp_enqueue_style('alfie-style');

		// 样式统一css
		wp_register_style('alfie-moralize', $uri . '/assets/css/normalize.min.css', [], $ver);
		wp_enqueue_style('alfie-moralize');

		// 文字图标css
		wp_register_style('alfie-font-awesome', $uri . '/assets/css/font-awesome.min.css', [], $ver);
		wp_enqueue_style('alfie-font-awesome');

		// JQ
		wp_register_script('alfie-jquery', $uri . '/assets/js/jquery.min.js', [], $ver, false);
		wp_enqueue_script('alfie-jquery');

		// 轮播框架
		if (!is_single() || !is_page() || !is_search()) {
			wp_register_style('alfie-swiper', $uri . '/assets/css/swiper.min.css', [], $ver);
			wp_enqueue_style('alfie-swiper');

			wp_register_script('alfie-swiper', $uri . '/assets/js/swiper.min.js', [], $ver, false);
			wp_enqueue_script('alfie-swiper');
		}

		// 分享
		if (is_single()) {
			wp_register_style('alfie-share', $uri . '/assets/css/share.min.css', [], $ver);
			wp_enqueue_style('alfie-share');

			wp_register_script('alfie-share', $uri . '/assets/js/share.min.js', [], $ver, true);
			wp_enqueue_script('alfie-share');
		}

		// 全局js
		wp_register_script('alfie-app', $uri . '/assets/js/app.js', [], $ver, true);
		wp_enqueue_script('alfie-app');

		// 内联CSS，针对主题设置
		/*
		$header_color = get_theme_mod('alfie_logo_color');
		wp_add_inline_style(
			'alfie_custom',
			'header{ color: ' . $header_color . '; border-color: ' . $header_color . '; }'
		) */
	}

	// 评论
	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'alfie_enqueue');

// 前端 wp_enqueue_scripts
// 后台 admin_enqueue_scripts
// 登录 login_enqueue_scripts

/**
 * 古腾堡块样式添加
 */
function blocks_add_styles()
{
	wp_enqueue_style('blocks-bsv-css', get_theme_file_uri() . '/blocks/blocks_bsv.css');
	wp_enqueue_style('blocks-bsv-css');
}
add_action('enqueue_block_assets', 'blocks_add_styles');

function blocks_add_scripts()
{
	wp_enqueue_script('blocks-bsv-js', get_theme_file_uri() . '/blocks/blocks_bsv.js');
	wp_enqueue_script('blocks-bsv-js');
}
add_action('enqueue_block_editor_assets', 'blocks_add_scripts');
