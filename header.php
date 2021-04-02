<?php

/**
 * 主题全局页头
 *
 * 这是显示所有<head>部分以及所有内容的模板，直到<div id="content"> *
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<?php wp_body_open(); ?>
	<header class="__app-header" role="banner">
		<?php
		// 站点标题
		alfie_get_app_title();

		// 主导航
		if (has_nav_menu('main-menu')) {
			$menus						=	[
				'theme_location'		=>	'main-menu',
				'container'				=>	'nav',
				'container_id'			=>	'__app-nav',
				'container_class'		=>	'__app-nav',
				'items_wrap'			=>	'<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'			=>	false,
				'depth'					=>	2,
			];
			wp_nav_menu($menus);
		}

		?>
		<div class="__sea-nav __btns">
			<?php
			// 页面不显示分享
			if (!is_page()) {
				echo '<a id="__sea-btn" class="__sea-btn"><i class="fa fa-search" aria-hidden="true"></i></a>';
			}
			// 导航移动按钮
			echo '<a id="__nav-btn" class="__nav-btn"><span></span></a>';
			?>
		</div>
		<div class="__reg-qrcode __btns">
			<?php
			// 注册登录
			alfie_get_register_login();

			// 二维码
			alfie_get_qrcode();
			?>
		</div>
	</header>
	<main id="content" class="__app-main">