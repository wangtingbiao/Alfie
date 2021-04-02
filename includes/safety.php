<?php

/**
 * 优化和安全设置
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */

// 升级WP失败删除core_updater.lock文件
$alfie_delete_updater_switch	=	get_theme_mod('alfie_delete_updater_switch', '');
if ($alfie_delete_updater_switch) {
	global $wpdb;
	$wpdb->query("DELETE FROM wp_options WHERE option_name = 'core_updater.lock'");
}

// 设备判断函数
function is_ipad() // 只检测iPad
{
	$is_ipad = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
	if ($is_ipad)
		return true;
	else return false;
}
function is_iphone() // 只检测iPhone
{
	$cn_is_iphone = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
	if ($cn_is_iphone)
		return true;
	else return false;
}
function is_ios() // 检测所有iOS设备
{
	if (is_iphone() || is_ipad())
		return true;
	else return false;
}
function is_android() // 检测所有android设备
{
	$is_android = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
	if ($is_android)
		return true;
	else return false;
}
function is_android_mobile() // 只检测Android手机
{
	$is_android = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
	$is_android_m = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
	if ($is_android && $is_android_m)
		return true;
	else return false;
}
function is_android_tablet() // 只检测Android平板电脑
{
	if (is_android() && !is_android_mobile())
		return true;
	else return false;
}
function is_mobile_device() // 检测Android手机、iPhone
{
	if (is_android_mobile() || is_iphone())
		return true;
	else return false;
}
function is_tablet() // 检测Android平板电脑和iPad
{
	if ((is_android() && !is_android_mobile()) || is_ipad())
		return true;
	else return false;
}

// 移除菜单多余分类选择器
function css_attributes_filter($var)
{
	return is_array($var) ? array_intersect($var, array('current-menu-item', 'current-menu-ancestor', 'current-post-ancestor', 'menu-item-has-children')) : '';
}
add_filter('nav_menu_css_class', 'css_attributes_filter', 100, true);
add_filter('nav_menu_item_id', 'css_attributes_filter', 100, true);
add_filter('page_css_class', 'css_attributes_filter', 100, true);
add_action('template_redirect', 'one_post_result');

// 后台分类/文章列表显示ID
function csid_column($cols)
{
	$cols['ssid'] = 'ID';
	return $cols;
}
function csid_value($column_name, $id)
{
	if ($column_name == 'ssid')
		echo $id;
}
function csid_return_value($value, $column_name, $id)
{
	if ($column_name == 'ssid')
		$value = $id;
	return $value;
}
add_filter('manage_posts_columns', 'csid_column');
add_action('manage_posts_custom_column', 'csid_value', 10, 2);

add_filter('manage_pages_columns', 'csid_column');
add_action('manage_pages_custom_column', 'csid_value', 10, 2);

add_filter('manage_media_columns', 'csid_column');
add_action('manage_media_custom_column', 'csid_value', 10, 2);

add_filter('manage_link-manager_columns', 'csid_column');
add_action('manage_link_custom_column', 'csid_value', 10, 2);

add_action('manage_edit-link-categories_columns', 'csid_column');
add_filter('manage_link_categories_custom_column', 'csid_return_value', 10, 3);

foreach (get_taxonomies() as $taxonomy) {
	add_action("manage_edit-${taxonomy}_columns", 'csid_column');
	add_filter("manage_${taxonomy}_custom_column", 'csid_return_value', 10, 3);
}
add_action('manage_users_columns', 'csid_column');
add_filter('manage_users_custom_column', 'csid_return_value', 10, 3);

add_action('manage_edit-comments_columns', 'csid_column');
add_action('manage_comments_custom_column', 'csid_value', 10, 2);

// 启用webp图像文件的上载
function webp_upload_mimes($existing_mimes)
{
	$existing_mimes['webp'] = 'image/webp';
	return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

// 启用webp图像文件的预览/缩略图
function webp_is_displayable($result, $path)
{
	if ($result === false) {
		$displayable_image_types = array(IMAGETYPE_WEBP);
		$info = @getimagesize($path);
		if (empty($info)) {
			$result = false;
		} elseif (!in_array($info[2], $displayable_image_types)) {
			$result = false;
		} else {
			$result = true;
		}
	}
	return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

// 禁止生成默认尺寸缩略图，只允许自定义缩略图
function disable_image_sizes($sizes)
{
	unset($sizes['thumbnail']); // 150px
	unset($sizes['medium']); // 300px
	unset($sizes['2048x2048']);
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_image_sizes');

// 文章页添加自定义尺寸
function post_custom_image_sizes($sizes)
{
	return array_merge($sizes, array(
		'1536x1536'		=>	__('超大->1536'),
		'large'			=>	__('大->1024'),
		'medium_large'	=>	__('中等->768'),
	));
}
add_filter('image_size_names_choose', 'post_custom_image_sizes');

// 友情链接
add_filter('pre_option_link_manager_enabled', '__return_true');

// 移除顶部工具条
add_filter('show_admin_bar', '__return_false');

// 自定义媒体上传位置
if (get_option('upload_path') == 'wp-content/uploads' || get_option('upload_path') == null) {
	update_option('upload_path', WP_CONTENT_DIR . '/uploads');
}

// 当搜索出相关文章仅有一篇时，自动打开进入
function one_post_result()
{
	if (is_search()) {
		global $wp_query;
		if ($wp_query->post_count == 1) {
			wp_redirect(get_permalink($wp_query->posts['0']->ID));
		}
	}
}

//分类描述删除p标签
function delete_cat_p($description)
{
	$description	=	trim($description);
	$description	=	strip_tags($description, "");
	return ($description);
}
add_filter('category_description', 'delete_cat_p');

// 避免来自垃圾邮件发送者的许多恶意URL请求
global $user_ID;
if ($user_ID) {
	if (!current_user_can('administrator')) {
		if (
			strlen($_SERVER['REQUEST_URI']) > 255 ||
			stripos($_SERVER['REQUEST_URI'], "eval(") ||
			stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
			stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
			stripos($_SERVER['REQUEST_URI'], "base64")
		) {
			@header("HTTP/1.1 414 Request-URI Too Long");
			@header("Status: 414 Request-URI Too Long");
			@header("Connection: Close");
			@exit;
		}
	}
}

// 针对大陆无法访问信息和不必要的信息进行移除
remove_action('wp_head', 'wp_generator'); //移除版本号
remove_action('wp_head', 'rsd_link'); // 移除离线编辑器开放接口 EditURI
remove_action('wp_head', 'wlwmanifest_link'); // 移除 wlwmanifest
remove_action('wp_head', 'wp_shortlink_wp_head'); // 移除文章 shortlink 短链接
remove_action('wp_head', 'rel_canonical'); // 移除本页面链接 url
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // 移除上一篇 prev 和下一篇 next 文章链接
remove_action('wp_head', 'wp_resource_hints', 2); // 移除辅助获取表情包
remove_action('wp_head', 'print_emoji_detection_script', 7); // 删除表情符号
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
add_filter('xmlrpc_enabled', '__return_false'); // 禁用XML-RPC服务
add_filter('wpcf7_load_js', '__return_false'); // 禁用联系表7 CSS / JS
add_filter('wpcf7_load_css', '__return_false');
add_filter('avf_load_google_map_api', '__return_false'); // 移除整站谷歌地图

// 禁用Dashicons
function dequeue_dashicon()
{
	if (current_user_can('update_core')) {
		return;
	}
	wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', 'dequeue_dashicon');

// 从评论中删除nofollow
function xwp_dofollow($str)
{
	$str = preg_replace(
		'~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
		'<a ${1}${2}${3}>',
		$str
	);
	return str_replace(array(' rel=""', " rel=''"), '', $str);
}
remove_filter('pre_comment_content', 'wp_rel_nofollow');
add_filter('get_comment_author_link', 'xwp_dofollow');
add_filter('post_comments_link', 'xwp_dofollow');
add_filter('comment_reply_link', 'xwp_dofollow');
add_filter('comment_text', 'xwp_dofollow');

// 从静态资源中删除查询字符串
function remove_cssjs_ver($src)
{
	if (strpos($src, '?ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);

// 禁止PINGBACK内页
function disable_pingback(&$links)
{
	foreach ($links as $l => $link) {
		if (0 === strpos($link, get_option('home'))) {
			unset($links[$l]);
		}
	}
}
add_action('pre_ping', 'disable_pingback');
