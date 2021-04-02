<?php

/**
 * 自定义函数与钩子
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
/*========================================================================================================
 标签类
 ========================================================================================================*/
// 自定义徽标（logo）
function alfie_get_app_title()
{
	$alfie_site_id					=	get_theme_mod('custom_logo', true);
	$alfie_site_img					=	wp_get_attachment_image_src($alfie_site_id, 'full');
	$alfie_header_title_switch		=	get_theme_mod('alfie_header_title_switch', true);

	echo '<h1 class="__app-title foo-title"><a rel="home" class="custom-logo-text" href="' . esc_url(home_url('/')) . '">';
	if (has_custom_logo()) {
		echo '<img src="' . esc_url($alfie_site_img[0]) . '" alt="' . get_bloginfo('name') . '">';
	}
	if ($alfie_header_title_switch) {
		bloginfo('name');
	}
	echo '</a></h1>';
}

// 头部的登录与注册
function alfie_get_register_login()
{
	$alfie_register_login_switch = get_theme_mod('alfie_register_login_switch', '');

	if ($alfie_register_login_switch) {
		if (!is_user_logged_in()) {
			echo '<a class="__reglog-btn" href="' . wp_login_url()  . '"><i class="fa fa-user-circle" aria-hidden="true"></i>' . esc_html__('登录', 'text-alfie') . '</a>';
		} else {
			if (!current_user_can('manage_options')) {
				echo '<a class="__reglog-btn"  href="' . home_url('account') . '"><i class="fa fa-user" aria-hidden="true"></i>' . esc_html__('个人中心', 'text-alfie') . '</a>';
			} else {
				echo '<a class="__reglog-btn"  href="' . admin_url() . '"><i class="fa fa-user" aria-hidden="true"></i>' . esc_html__('个人中心', 'text-alfie') . '</a>';
			}
		}
	}
}

// 顶部二维码
function alfie_get_qrcode()
{
	$alfie_qrcode_switch	=	get_theme_mod('alfie_qrcode_switch', '');
	$alfie_qrcode_title		=	get_theme_mod('alfie_qrcode_title', esc_html__('关注我', 'text-alfie'));

	if ($alfie_qrcode_switch) {
		echo '<a id="__qrcode-btn" class="__qrcode-btn"><i class="fa fa-qrcode" aria-hidden="true"></i><span>' . $alfie_qrcode_title . '</span>';
		echo '<p id="qrcode" class="qrcode">';
		$img_values = Walker_Qrcode_List::alfie_qrcodes();
		foreach ($img_values as $img_key => $img_value) {
			echo $img_value;
		}
		echo '</p></a>';
	}
}

// 全局横向栏目
function alfie_get_breadcrumbs()
{
	echo '<div class="__breadcrumbs main-list"><h2 class="enty-title" itemprop="breadcrumb">';
	if (is_home()) {
		echo esc_html__('首页', 'text-alfie');
	} elseif (is_search()) {
		echo sprintf(__('<span>" %1$s "</span>相关文章如下：', 'text-alfie'), get_search_query());
	} elseif (is_single()) {
		echo '<small><a href="' . get_bloginfo('url') . '">' . esc_html__('首页', 'text-alfie') . '</a> &raquo; ';
		$categorys = get_the_category();
		$category = $categorys[0];
		echo (get_category_parents($category->term_id, true, ' &raquo; ')) . esc_html__('正文', 'text-alfie') . '</small>';
	} elseif (is_tag()) {
		single_tag_title();
		echo '<p class="enty-desc">' . esc_html__('此标签相关文章。', 'text-alfie') . '</p>';
	} else {
		single_cat_title();
		echo '<p class="enty-desc">' . category_description() . '</p>';
	}
	echo '</h2><div id="__search" class="__search">';
	get_search_form();
	echo '</div></div>';
}

// 大尺寸图，例如海报和文章内页顶部图
function alfie_get_large_thumbnail_img()
{
	if (has_post_thumbnail()) { // 有特色图像
		if (is_mobile_device()) {
			the_post_thumbnail('alfie-medium');
		} elseif (is_tablet()) {
			the_post_thumbnail('alfie-large');
		} else {
			the_post_thumbnail('full');
		}
	}
}

// 中尺寸图，仅文章列表或者其他
function alfie_get_medium_thumbnail()
{
	if (has_post_thumbnail()) { // 有特色图像
		if (is_mobile_device()) {
			the_post_thumbnail('alfie-small');
		} else {
			the_post_thumbnail('alfie-medium');
		}
	}
}

// 中尺寸图链接，仅文章列表或者其他
function alfie_get_medium_thumbnail_url()
{
	if (has_post_thumbnail()) { // 有特色图像
		if (is_mobile_device()) {
			the_post_thumbnail_url('alfie-small');
		} else {
			the_post_thumbnail_url('alfie-medium');
		}
	}
}

// 当前文章的格式，视频、音乐、图片、等等
function alfie_get_post_format()
{
	if (has_post_format('video')) {
		echo '<i class="fa fa-video-camera" aria-hidden="true"></i>';
	} elseif (has_post_format('audio')) {
		echo '<i class="fa fa-headphones" aria-hidden="true"></i>';
	} elseif (has_post_format('image')) {
		echo '<i class="fa fa-picture-o" aria-hidden="true"></i>';
	} elseif (has_post_format('chat')) {
		echo '<i class="fa fa-comments-o" aria-hidden="true"></i>';
	}
}

// 帖子元数据
function alfie_get_post_meta()
{
	echo '<div class="enty-meta">';
	echo '<time datetime="' . get_the_time('Y-m-d A G:i:s') . '"><i class="fa fa-clock-o" aria-hidden="true"></i>' . get_the_time('Fj,Y') . '</time>';
	echo '<span><i class="fa fa-eye" aria-hidden="true"></i>';
	alfie_get_post_view();
	echo ' 浏览</span>';
	echo '<span><i class="fa fa-commenting-o" aria-hidden="true"></i>' . get_comments_number() . ' 评论</span>';
	if (get_post_meta(get_the_ID(), 'baidu_submit', true) == 'OK') {
		echo '<span><i class="fa fa-check-circle"></i></span>';
	}
	echo '</div>';
}

// 文章页相关文章
function alfie_get_related_articles()
{
	$alfie_related_post_switch		=	get_theme_mod('alfie_related_post_switch', '');
	$alfie_related_post				=	absint(get_theme_mod('alfie_related_post', '3'));

	if ($alfie_related_post_switch) {
		global $post;
		$categories = get_the_category($post->ID);
		$related_query				=   new WP_Query([
			'posts_per_page'		=>  $alfie_related_post,
			'post__not_in'			=>  [$post->ID],
			'category__in'			=>  !empty($categories) ?  $categories[0]->term_id : null
		]);
		if ($related_query->have_posts()) {

			echo '<div class="__posts main-list-2">';
			while ($related_query->have_posts()) : $related_query->the_post();
				get_template_part('templates-parts/content');
			endwhile;
			echo '</div>';
		}
		wp_reset_postdata();
	}
}

// 底部站点介绍，带logo
function alfie_get_foo_top()
{
	$alfie_social_switch			=	get_theme_mod('alfie_social_switch', '');
	$alfie_footer_desc				=	wp_kses_post(get_theme_mod('alfie_footer_desc', __('欢迎您访问我的小栈！您可以看到我转发的一些教程、资源、工具、站点等推荐无需付费、帐户注册或邮箱订阅，如果您有收获也想保持这个网站正常运行，请考虑支持我！', 'text-alfie')));
	$alfie_footer_title_switch		=	get_theme_mod('alfie_footer_title_switch', '');
	if ($alfie_social_switch || $alfie_footer_desc || $alfie_footer_title_switch) {
		echo '<div class="foo-top">';

		if ($alfie_social_switch) {
			$link_values = Walker_Social_List::alfie_socials();
			echo '<div class="socials">';
			foreach ($link_values as $link_key => $link_value) {
				echo $link_value;
			}
			echo '</div>';
		}

		if ($alfie_footer_desc) {
			echo '<div class="foo-desc">' . $alfie_footer_desc . '</div>';
		}

		if ($alfie_footer_title_switch) {
			alfie_get_app_title();
		}

		echo '</div>';
	}
}

// 导航，自动更新当前版权年份，版权自动链接到官方查询站点
function alfie_get_foo_bot()
{
	$alfie_record			=	esc_html(get_theme_mod('alfie_record', ''));
	$alfie_statistics		=	base64_decode(get_theme_mod('alfie_statistics', ''));

	echo '<div class="foo-bot">';
	if (has_nav_menu('footer-menu')) {
		echo '<p class="foo-nav">' . strip_tags(wp_nav_menu(['theme_location' => 'footer-menu', 'items_wrap' => '%3$s', 'echo' => false, 'depth' => 1,]), '<a>') . '</p>';
	}
	echo '<p class="copyright">';
	echo '&copy; ' . date_i18n('Y') . ' ' . get_bloginfo('name');
	if ($alfie_record) {
		echo ' | <a class="record" href="https://beian.miit.gov.cn" target="_blank">' . $alfie_record . '</a>';
	}
	echo '<span class="statistics">' . $alfie_statistics . '</span>';
	echo '</p></div>';
}

/*========================================================================================================
 钩子类
 ========================================================================================================*/
// 站点关键词
function alfie_get_header()
{
	$alfie_keyword			=	esc_html(get_theme_mod('alfie_keywords', ''));
	$alfie_description		=	esc_html(get_bloginfo('description'));
	$alfie_html_verify		=	base64_decode(get_theme_mod('alfie_html_verify', ''));

	echo '<meta name="keywords" content="';
	if (is_home() || is_front_page()) {
		echo $alfie_keyword;
	} elseif (is_category()) {
		single_cat_title();
	} elseif (is_singular()) {
		echo trim(wp_title('', false)) . ',';
		if (has_tag()) {
			foreach (get_the_tags() as $tag) {
				echo $tag->name . ',';
			}
		}
		foreach (get_the_category() as $category) {
			echo $category->cat_name . ',';
		}
	} elseif (is_search()) {
		the_search_query();
	} else {
		echo trim(wp_title('', false));
	}
	echo '">';
	echo '<meta name="description" content="' . $alfie_description . '">';
	echo $alfie_html_verify;
}
add_action('wp_head', 'alfie_get_header');

// 文章浏览量（刷新+1）
function alfie_get_post_view($before = '', $after = '', $echo = 1)
{
	global $post;
	$post_ID	=	$post->ID;
	$views		=	(int)get_post_meta($post_ID, 'views', true);

	if ($echo) echo $before, number_format($views), $after;
	else return $views;
}

function alfie_post_record_visitors()
{
	if (is_singular('post')) {
		global $post;
		$post_ID = $post->ID;
		if ($post_ID) {
			$alfie_get_post_view = (int)get_post_meta($post_ID, 'views', true);
			if (!update_post_meta($post_ID, 'views', ($alfie_get_post_view + 1))) {
				add_post_meta($post_ID, 'views', 1, true);
			}
		}
	}
}
add_action('wp_head', 'alfie_post_record_visitors');

// 自定义摘要输出
function alfie_get_post_excerpt($excerpt)
{
	$excerpt = '<div class="enty-desc">' . get_the_excerpt() . '</div>';
	return $excerpt;
}
add_filter('the_excerpt', 'alfie_get_post_excerpt', 10, true);

// 加一个点赞功能
function alfie_add_post_like()
{
	global $wpdb, $post;
	$id						=	$_POST["um_id"];
	$action					=	$_POST["um_action"];

	if ($action == 'ding') {
		$alfie_raters		=	get_post_meta($id, 'like_ding', true);
		$expire				=	time() + 99999999;
		$domain				=	($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('like_ding_' . $id, $id, $expire, '/', $domain, false);
		if (!$alfie_raters || !is_numeric($alfie_raters)) {
			update_post_meta($id, 'like_ding', 1);
		} else {
			update_post_meta($id, 'like_ding', ($alfie_raters + 1));
		}
		echo get_post_meta($id, 'like_ding', true);
	}
	die;
}
add_action('wp_ajax_nopriv_alfie_add_post_like', 'alfie_add_post_like');
add_action('wp_ajax_alfie_add_post_like', 'alfie_add_post_like');

// 点赞Js
function alfie_post_like_script()
{
	if (is_singular('post')) {
		echo '<script>
			jQuery(document).ready(function($) {
				function getPostLikeCookie(cookieName) {
					var cookieValue = "";
					if (document.cookie && document.cookie != "") {
						var cookies = document.cookie.split(";");
						for (var i = 0; i < cookies.length; i++) {
							var cookie = cookies[i];
							if (cookie.substring(0, cookieName.length + 2).trim() == cookieName.trim() + "=") {
								cookieValue = cookie.substring(cookieName.length + 2, cookie.length);
								break;
							}
						}
					}
					return cookieValue;
				}

				$.fn.postLike = function () {
					if ($(this).hasClass("done")) {
						return false;
					} else {
						$(this).addClass("done");
						$(this).children("i").removeClass("fa-heart-o").addClass("fa-heart");
						var id = $(this).data("id"),
							action = $(this).data("action"),
							rateHolder = $(this).children(".count");
						var ajax_data = {
							action: "alfie_add_post_like",
							um_id: id,
							um_action: action,
						};
						$.post("/wp-admin/admin-ajax.php", ajax_data,
							function (data) {
								$(rateHolder).html(data);
							});
						return false;
					}
				};

				$(document).on("click", "#enty-like", function (e) {
					var post_id = $("#enty-like").attr("data-id");
					if (getPostLikeCookie("like_ding_" + post_id) != "") {
						alert("' . esc_html__('您已经喜欢它了！', 'text-alfie') . '");
					} else {
						$(this).postLike();
					}
					e.stopPropagation();
				});
			});
		</script>';
	}
}
add_action('wp_footer', 'alfie_post_like_script', 11);

// 将alt和title属性添加到文章图片的img标签中
function alfie_post_img_add_gesalt($content)
{
	global $post;
	$pattern			=	"/<img(.*?)src=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement		=	'<img$1src=$2$3.$4$5 alt="' . $post->post_title . '" title="' . $post->post_title . '"$6>';
	$content			=	preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'alfie_post_img_add_gesalt');

// 返回顶部 + 在线客服
function alfie_fixed()
{
	echo '<div class="__app-fixed">';

	$alfie_totop_switch		=	get_theme_mod('alfie_totop_switch', '');
	$alfie_clerk_switch		=	get_theme_mod('alfie_clerk_switch', '');
	$alfie_clerk_setup		=	get_theme_mod('alfie_clerk_setup', '');
	$alfie_clerk_url		=	esc_url(get_theme_mod('alfie_clerk_url', ''));
	$alfie_clerk_js			=	base64_decode(get_theme_mod('alfie_clerk_js', ''));

	if ($alfie_totop_switch) {
		echo '<a id="totop" class="totop"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>';
	}

	if ($alfie_clerk_switch) {
		if ($alfie_clerk_setup == 'clerk_url') {
			echo '<a id="clerk" class="clerk" target="_blank" href="' . $alfie_clerk_url . '"><i class="fa fa-bell" aria-hidden="true"></i></a>';
		} elseif ($alfie_clerk_setup == 'clerk_js') {
			echo $alfie_clerk_js;
		}
	}

	echo '</div>';
}
add_action('wp_footer', 'alfie_fixed');

// 配置SMTP邮件
function mail_smtp($phpmailer)
{
	$phpmailer->FromName		=	esc_html(get_theme_mod('alfie_smtp_name', get_bloginfo('name'))); // 发件人
	$phpmailer->From			=	esc_html(get_theme_mod('alfie_smtp_email', '')); // 邮箱
	$phpmailer->Username		=	esc_html(get_theme_mod('alfie_smtp_email', '')); // 邮箱
	$phpmailer->Password		=	esc_html(get_theme_mod('alfie_smtp_pass', '')); // 密码
	$phpmailer->Host			=	esc_html(get_theme_mod('alfie_smtp_host', '')); // 服务器
	$phpmailer->Port			=	absint(get_theme_mod('alfie_smtp_port', '25')); // 端口
	$phpmailer->SMTPSecure		=	esc_html(get_theme_mod('alfie_smtp_ssl', 'tls')); //tls or ssl
	$phpmailer->SMTPAuth		=	true;
	$phpmailer->IsSMTP();
}
add_action('phpmailer_init', 'mail_smtp');

// 百度自动推送
function alfie_baidu_auto_js()
{
	$alfie_baidu_auto_js_switch		=	get_theme_mod('alfie_baidu_auto_js_switch', '');

	if ($alfie_baidu_auto_js_switch) {
		echo '<script>
			(function(){
				var bp = document.createElement("script");
				var curProtocol = window.location.protocol.split(":")[0];
				if (curProtocol === "https") {
					bp.src = "https://zz.bdstatic.com/linksubmit/push.js";
				}
				else {
					bp.src = "http://push.zhanzhang.baidu.com/push.js";
				}
				var s = document.getElementsByTagName("script")[0];
				s.parentNode.insertBefore(bp, s);
			})();
		</script>';
	}
}
add_action('wp_footer', 'alfie_baidu_auto_js', 12);

// 百度快速收录
function alfie_baidu_submit($post_id, $post, $update)
{
	$alfie_baidu_submit_switch		=	get_theme_mod('alfie_baidu_submit_switch', '');
	$alfie_baidu_token				=	esc_html(get_theme_mod('alfie_baidu_token', ''));

	if ($alfie_baidu_submit_switch) {
		if ($post->post_status != 'publish' || get_post_meta($post_id, 'baidu_submit', true) == 'OK') return;

		$api = 'http://data.zz.baidu.com/urls?site=' . get_option('home') . '&token=' . $alfie_baidu_token . '&type=daily'; //快速收录复制过来
		$response = wp_remote_post($api, array(
			'headers' => array('Accept-Encoding' => '', 'Content-Type' => 'text/plain'),
			'sslverify' => false,
			'blocking' => false,
			'body' => get_permalink($post_id)
		));
		if (!is_wp_error($response)) {
			$res = json_decode($response['body'], true);
			if ($res['success_daily'] == 1) update_post_meta($post_id, 'baidu_submit', 'OK'); // OK 避免重复提交
		}
	}
}
add_action('save_post', 'alfie_baidu_submit', 10, 3);
