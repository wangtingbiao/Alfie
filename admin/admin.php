<?php

/**
 * 主题后台页面
 *
 * 关于主题的介绍与作者链接等
 *
 * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
function admin_theme_setup_page()
{
	add_submenu_page(
		'themes.php',
		esc_html__('主题设置', 'text-alfie'),
		esc_html__('主题设置', 'text-alfie'),
		'manage_options',
		'theme-setup',
		'admin_theme_setup',
	);
}
add_action('admin_menu', 'admin_theme_setup_page');

// 展示内容
function admin_theme_setup()
{
	$hello          =   esc_html__('你好，有缘人！此主题是开源免费的', 'text-alfie');
	$desc           =   __('我是王村长，一个喜欢代码的爱好者，主题使用我所学有限的知识制作。<br /><br />其实可以说是东拼西凑，一边学一边做，有幸制作出自己想要的主题。<br /><br />可能会有些许BUG，望请多多包涵。<br /><br />本主题适用于个人发布文章，资讯，教程，共享资源。<br />', 'text-alfie');

	$author_url     =   'https://www.wangtingbiao.com';
	$custom         =   esc_html__('自定义设置');
	$demand         =   esc_html__('提交需求');
	$bug            =   esc_html__('BUG反馈');

	$url            =   get_stylesheet_directory_uri() . '/admin/';
	$good           =   __('当然，如果您觉得还可以，能赏一杯香飘飘也是好的。<br />(๑•̀ㅂ•́)و✧！', 'text-alfie');
?>
	<div class="wrap">
		<h1><?php echo $hello; ?></h1>
		<p><?php echo $desc; ?></p>
		<ul class="enty-box">
			<li class="custom">
				<a href="<?php echo admin_url('customize.php'); ?>"><?php echo $custom; ?></a>
			</li>
			<li class="demand">
				<a href="<?php printf('%s/demand',  $author_url); ?>" target="_blank"><?php echo $demand; ?></a>
			</li>
			<li class="bug">
				<a href="<?php printf('%s/bug', $author_url); ?>" target="_blank"><?php echo $bug; ?></a>
			</li>
		</ul>

		<p><?php echo $good; ?></p>

		<ul class="enty-box">
			<li>
				<img src="<?php echo $url . 'Donate-alipay.jpg'; ?>" alt="">
			</li>
			<li>
				<img src="<?php echo $url . 'Donate-wechat.jpg'; ?>" alt="">
			</li>
		</ul>
		<style>
			.wrap {
				max-width: 640px;
				padding: 60px 40px;
				text-align: center;
				background-color: #fff;
			}

			.wrap .enty-box {
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-orient: vertical;
				-webkit-box-direction: normal;
				-ms-flex-flow: column wrap;
				flex-flow: column wrap;
				-webkit-box-pack: center;
				-ms-flex-pack: center;
				justify-content: center;
				width: 100%;
				margin-top: 40px;
			}

			.wrap .enty-box li {
				-webkit-box-flex: 1;
				-ms-flex: 1;
				flex: 1;
				overflow: hidden;
				margin-bottom: 20px;
				border-radius: 4px;
			}

			.wrap .enty-box li a {
				display: block;
				padding: 14px 30px;
				font-size: 17px;
				color: #fff;
				line-height: 1.3;
				white-space: nowrap;
				background-color: transparent;
				cursor: pointer;
				text-decoration: none;
			}

			.wrap .enty-box .custom {
				background-image: -webkit-gradient(linear, left top, right bottom, from(#3999ec), to(#0078f2));
				background-image: linear-gradient(to bottom right, #3999ec, #0078f2);
			}

			.wrap .enty-box .demand {
				background-image: -webkit-gradient(linear, left top, right bottom, from(#a4d007), to(#799a04));
				background-image: linear-gradient(to bottom right, #a4d007, #799a04);
			}

			.wrap .enty-box .bug {
				background-image: -webkit-gradient(linear, left top, right bottom, from(#f20031), to(#b80025));
				background-image: linear-gradient(to bottom right, #f20031, #b80025);
			}

			.wrap .enty-box img {
				max-width: 200px;
			}

			@media only screen and (min-width: 640px) {
				.wrap .enty-box {
					-webkit-box-orient: horizontal;
					-webkit-box-direction: normal;
					-ms-flex-flow: row wrap;
					flex-flow: row wrap;
				}

				.wrap .enty-box li {
					margin-right: 20px;
				}

				.wrap .enty-box li:last-child {
					margin-right: 0;
				}
			}
		</style>
	</div>
<?php
}
