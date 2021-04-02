<?php

/**
 * 允许子主题覆盖父主题的文件路径。
 */
$path					=	get_theme_file_path();
$alfie_rlra_switch		=	get_theme_mod('alfie_rlra_switch', '');

/**
 * 必填文件
 * 包括必需的文件。
 */
// 功能和定义
require $path . '/includes/setup.php';

// 安全类
require $path . '/includes/safety.php';

// 引入JS和CSS
require $path . '/includes/enqueue.php';

// 标签/钩子函数
require $path . '/includes/tags-hooks.php';

// 自定义评论
require $path . '/includes/comment.php';

// 底部社会化
require $path . '/includes/social.php';

// 顶部二维码
require $path . '/includes/qrcode.php';

// 前台功能设置
if ($alfie_rlra_switch) {
	$query = new WP_Query('pagename=login');
	if ($query->have_posts()) {
		require $path . '/includes/user.php';
	}
}

// 自动添加页面
function user_open()
{
	global $pagenow;
	if ('themes.php' == $pagenow && isset($_GET['activated'])) {

		$page_definitions		=	[

			'login'				=>	[
				'title'			=>	esc_html__('登录', 'text-alfie'),
				'content'		=>	'[login-form]',
			],

			'register'			=>	[
				'title'			=>	esc_html__('注册', 'text-alfie'),
				'content'		=>	'[register-form]',
			],

			'account'			=>	[
				'title'			=>	esc_html__('个人中心', 'text-alfie'),
				'content'		=>	'[account-info]',
			],

			'password-lost'		=>	[
				'title'			=>	esc_html__('忘记密码', 'text-alfie'),
				'content'		=>	'[password-lost-form]',
			],

			'password-reset'	=>	[
				'title'			=>	esc_html__('重置密码', 'text-alfie'),
				'content'		=>	'[password-reset-form]',
			],

		];

		foreach ($page_definitions as $slug => $page) {
			// 检查页面是否存在
			$query = new WP_Query('pagename=' . $slug);
			if (!$query->have_posts()) {
				// 使用上面数组中的数据添加页面
				$pagess					=	[
					'post_content'		=>	$page['content'],
					'post_name'			=>	$slug,
					'post_title'		=>	$page['title'],
					'post_status'		=>	'publish',
					'post_type'			=>	'page',
					'ping_status'		=>	'closed',
					'comment_status'	=>	'closed',
				];
				wp_insert_post($pagess);
			}
		}

		wp_redirect(admin_url('themes.php?page=theme-setup'));
		exit;
	}
}
add_action('load-themes.php', 'user_open');

// 小工具
require $path . '/includes/widgets.php';
require $path . '/includes/widgets/recommend.php';
require $path . '/includes/widgets/breadcrumbs.php';
require $path . '/includes/widgets/swiper.php';
require $path . '/includes/widgets/videos.php';
require $path . '/includes/widgets/images.php';
require $path . '/includes/widgets/adhome.php';

// 主题设置
require $path . '/includes/customizer.php';
require $path . '/includes/customizer/header.php';
require $path . '/includes/customizer/home.php';
require $path . '/includes/customizer/post.php';
require $path . '/includes/customizer/social.php';
require $path . '/includes/customizer/footer.php';
require $path . '/includes/customizer/other.php';
require $path . '/includes/customizer/smtp.php';


// 让分类支持选择模板
require $path . '/plugin/category-template.php';

// 让分类支持缩略图
require $path . '/plugin/category-thumbnail.php';

// 文章列表添加媒体功能
require $path . '/plugin/easy-thumbnail.php';

// 数据库清理
require $path . '/plugin/wp-clean-up/wp-clean-up.php';

// 主题面板
require $path . '/admin/admin.php';


/**
 * 为wp_body_open填充，
 * 以确保与5.2之前的WordPress版本向后兼容。
 */
if (!function_exists('wp_body_open')) {
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}

// 低于IE11浏览器
function custom_body_open()
{
	$browser	=	wp_kses_post(__('<strong>浏览器版本可能过低！</strong> 该网站将在此浏览器中提供有限的显示效果与功能，建议升级为Chrome，Firefox，Safari，Edge等<a href="https://browsehappy.com/" target="_blank">浏览器最新版本</a>以获取更好的体验！', 'text-alfie'));
	if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT'])) {
		echo '<div class="__browser">' . $browser . '</div>';
	}
}
add_action('wp_body_open', 'custom_body_open');
