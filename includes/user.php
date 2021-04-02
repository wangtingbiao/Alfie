<?php

/**
 * 站点前台与用户中心
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
/*========================================================================================================
 全局
 ========================================================================================================*/

// 新用户注册邮件内容
function custom_wp_new_user_notification_email($wp_new_user_notification_email, $user, $blogname)
{
	$key = get_password_reset_key($user);

	$login_url      =  wp_login_url();
	$user_login     =  stripslashes($user->user_login);
	$user_email     =  stripslashes($user->user_email);

	$message        =  __('你好呀！', 'text-alfie') . "\r\n\r\n";
	$message        .=  sprintf(__('欢迎来到<strong>%s</strong>！登录方法如下：', 'text-alfie'), get_option('blogname')) . "\r\n\r\n";
	$message		.=  sprintf(__('登录地址：%s', 'text-alfie'), esc_url($login_url)) . "\r\n";
	$message        .=  sprintf(__('用户名: %s', 'text-alfie'), $user_login) . "\r\n";
	$message		.=  sprintf(__('邮箱: %s', 'text-alfie'), $user_email) . "\r\n";
	$message		.=  __('密码：您在注册时输入的密码（出于安全原因，我们已加密保存并隐藏）。', 'text-alfie') . "\r\n\r\n";
	$message		.=  __('如果您有任何问题，请通过以下方式与我联系！', 'text-alfie') . "\r\n";
	$message		.=  __(get_option('admin_email')) . "\r\n\r\n";
	$message		.=  __('再会！', 'text-alfie');

	$wp_new_user_notification_email['subject']    =    sprintf(__('【%1s】已成功创建账户 %2s，请牢记您的账户信息！', 'text-alfie'), $blogname, $user_login);
	$wp_new_user_notification_email['message']    =    $message;
	$wp_new_user_notification_email['headers']    =    ['Content-Type: text/html; charset=UTF-8'];

	return $wp_new_user_notification_email;
}
add_filter('wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3);

// 模板引入，数组序列
function get_template_html($template_name, $attributes = null)
{
	if (!$attributes) {
		$attributes = [];
	}
	ob_start();
	do_action('alfie_before_' . $template_name);
	require('user/' . $template_name . '.php');
	do_action('alfie_after_' . $template_name);
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}

// 是否管理员登录
function redirect_logged_in_user($redirect_to = null)
{
	$user = wp_get_current_user();
	if (user_can($user, 'manage_options')) {
		if ($redirect_to) {
			wp_safe_redirect($redirect_to);
		} else {
			wp_redirect(admin_url());
		}
	} else {
		wp_redirect(home_url('account'));
	}
}

// 呈现错误消息
function get_error_message($error_code)
{
	switch ($error_code) {

			// 登录
		case 'empty_username':
			return esc_html__('* 您有一个邮箱，对吗？', 'text-alfie');

		case 'empty_password':
			return esc_html__('* 您需要输入密码才能登录。', 'text-alfie');

		case 'invalid_username':
			return esc_html__('* 我们没有任何用户使用该邮箱也许您在注册时使用了其他邮箱？', 'text-alfie');

		case 'incorrect_password':
			return esc_html__('* 您输入的密码不正确。', 'text-alfie');

			// 注册
		case 'email':
			return esc_html__('* 您输入的邮箱无效。', 'text-alfie');

		case 'email_exists':
			return esc_html__('* 该邮箱已有帐户在使用。', 'text-alfie');

		case 'empty_user_login':
			return esc_html__('* 请填写用户名。', 'text-alfie');

		case 'login_exists':
			return esc_html__('* 该用户名已有帐户在使用。', 'text-alfie');

		case 'pass_exists':
			return esc_html__('* 密码必须至少有6个字符长。', 'text-alfie');

		case 're_pass_exists':
			return esc_html__('* 两次输入的密码不一至。', 'text-alfie');

		case 'closed':
			return esc_html__('* 当前不允许注册新用户。', 'text-alfie');

			// 重置密码
		case 'empty_username':
			return esc_html__('* 您需要输入邮箱才能继续。', 'text-alfie');

		case 'invalid_email':
		case 'invalidcombo':
			return esc_html__('* 没有使用此邮箱注册的用户。', 'text-alfie');

			// 重置密码
		case 'expiredkey':
		case 'invalidkey':
			return esc_html__('* 您使用的重置密码链接不再有效。', 'text-alfie');

		case 'password_reset_mismatch':
			return esc_html__('* 您输入的两个密码不匹配。', 'text-alfie');

		case 'password_reset_empty':
			return esc_html__('* 抱歉，我们不接受空密码。', 'text-alfie');

			return sprintf($err, wp_lostpassword_url());
		default:
			break;
	}

	return esc_html__('出现未知错误，请稍后再试。', 'text-alfie');
}

// 注销后跳转
function redirect_after_logout()
{
	$redirect_url	=	home_url('login?logged_out=true');
	wp_redirect($redirect_url);
	exit;
}
add_action('wp_logout', 'redirect_after_logout');


/*========================================================================================================
 用户中心
 ========================================================================================================*/

function account_info($attributes, $content = null)
{
	// 解码
	$default_attributes		=	['show_title' => false];
	$attributes				=	shortcode_atts($default_attributes, $attributes);
	// 模板
	return get_template_html('account_info', $attributes);
}
add_shortcode('account-info', 'account_info');


/*========================================================================================================
 登录页面
 ========================================================================================================*/
// 登录简码
function render_login_form($attributes, $content = null)
{
	// 解码
	$default_attributes					=	['show_title' => false];
	$attributes							=	shortcode_atts($default_attributes, $attributes);

	if (is_user_logged_in()) {
		return esc_html__('您已经登录。', 'text-alfie');
	}

	// 将redirect参数传递给WordPress登录功能
	// 默认情况下不指定重定向，但是如果有效的重定向URL已经是request参数，请使用它
	$attributes['redirect']				=	'';
	if (isset($_REQUEST['redirect_to'])) {
		$attributes['redirect']			=	wp_validate_redirect($_REQUEST['redirect_to'], $attributes['redirect']);
	}

	// 错误讯息
	$errors	=	[];
	if (isset($_REQUEST['login'])) {
		$error_codes = explode(',', $_REQUEST['login']);
		foreach ($error_codes as $code) {
			$errors[] = get_error_message($code);
		}
	}

	$attributes['errors']				=	$errors;
	$attributes['logged_out']			=	isset($_REQUEST['logged_out']) && $_REQUEST['logged_out'] == true; // 检查用户是否刚刚注销
	$attributes['registered']			=	isset($_REQUEST['registered']); // 检查用户是否刚刚注册
	$attributes['lost_password_sent']	=	isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'confirm'; // 检查用户是否刚刚请求了新密码
	$attributes['password_updated']		=	isset($_REQUEST['password']) && $_REQUEST['password'] == 'changed'; // 检查用户是否刚刚更新密码

	return get_template_html('login_form', $attributes); // 使用外部模板呈现登录表单
}
add_shortcode('login-form', 'render_login_form');

// 登录重定向
function redirect_to_custom_login()
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {

		// 是否管理员
		if (is_user_logged_in()) {
			redirect_logged_in_user();
			exit;
		}

		// 其余的重定向到登录页面
		$login_url = home_url('login');
		if (!empty($_REQUEST['redirect_to'])) {
			$login_url	=	add_query_arg('redirect_to', $_REQUEST['redirect_to'], $login_url);
		}

		if (!empty($_REQUEST['checkemail'])) {
			$login_url	=	add_query_arg('checkemail', $_REQUEST['checkemail'], $login_url);
		}

		wp_redirect($login_url);
		exit;
	}
}
add_action('login_form_login', 'redirect_to_custom_login');

// 登录后将重定向
function redirect_after_login($redirect_to, $requested_redirect_to, $user)
{
	$redirect_url	=	home_url();

	if (!isset($user->ID)) {
		return $redirect_url;
	}

	if (user_can($user, 'manage_options')) {
		// 如果设置了参数，请使用redirect_to参数，否则将重定向到管理仪表盘
		if ($requested_redirect_to == '') {
			$redirect_url	=	admin_url();
		} else {
			$redirect_url	=	$redirect_to;
		}
	} else {
		$redirect_url		=	home_url('account'); // 非管理员用户始终在登录后进入个人中心
	}

	return wp_validate_redirect($redirect_url, home_url());
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);


// 登录出现错误时重定向
function maybe_redirect_at_authenticate($user, $username, $password)
{
	// 检查早期的身份验证过滤器（很可能是默认的WordPress身份验证）功能是否发现错误
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (is_wp_error($user)) {

			$error_codes	=	join(',', $user->get_error_codes());
			$login_url		=	home_url('login');
			$login_url		=	add_query_arg('login', $error_codes, $login_url);

			wp_redirect($login_url);
			exit;
		}
	}

	return $user;
}
add_filter('authenticate', 'maybe_redirect_at_authenticate', 101, 3);

/*========================================================================================================
 注册页面
 ========================================================================================================*/
// 注册重定向
function redirect_to_custom_register()
{
	if ('GET' == $_SERVER['REQUEST_METHOD']) {
		if (is_user_logged_in()) {
			redirect_logged_in_user();
		} else {
			wp_redirect(home_url('register'));
		}
		exit;
	}
}
add_action('login_form_register', 'redirect_to_custom_register');

// 注册简码
function render_register_form($attributes, $content = null)
{
	// 解析简码属性
	$default_attributes					=	['show_title' => false];
	$attributes							=	shortcode_atts($default_attributes, $attributes);

	if (is_user_logged_in()) {
		return esc_html__('您已经登录。', 'text-alfie');
	} elseif (!get_option('users_can_register')) {
		return esc_html__('当前不允许注册新用户。', 'text-alfie');
	} else {
		// 从请求参数中检索可能的错误
		$attributes['errors']			=	[];
		if (isset($_REQUEST['register-errors'])) {
			$error_codes				=	explode(',', $_REQUEST['register-errors']);

			foreach ($error_codes as $error_code) {
				$attributes['errors'][]	=	get_error_message($error_code);
			}
		}
		return get_template_html('register_form', $attributes);
	}
}
add_shortcode('register-form', 'render_register_form');

// 建立使用者
function register_user($login, $email, $password)
{
	$errors	=	new WP_Error();

	// 邮箱同时用作用户名和邮箱 这也是唯一的
	// 我们需要验证的参数

	if (username_exists($login)) {
		$errors->add('login_exists', get_error_message('login_exists'));
		return $errors;
	}

	if (!is_email($email)) {
		$errors->add('email', get_error_message('email'));
		return $errors;
	}

	if (email_exists($email)) {
		$errors->add('email_exists', get_error_message('email_exists'));
		return $errors;
	}

	if (strlen($_POST['password']) < 6) {
		$errors->add('pass_exists', get_error_message('pass_exists'));
		return $errors;
	}

	if ($_POST['password'] !== $_POST['repeat_password']) {
		$errors->add('re_pass_exists', get_error_message('re_pass_exists'));
		return $errors;
	}

	// 生成密码，以便订户必须检查邮箱...
	// $password = wp_generate_password(12, false);

	$user_data	=	[
		'user_email'	=>	$email,
		'user_login'	=>	$login,
		'user_pass'		=>	$password,
	];
	$user_id			=	wp_insert_user(wp_slash($user_data));
	wp_new_user_notification($user_id, $password);

	return $user_id;
}

// 用户提交表单时，调用注册码
function do_register_user()
{
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		$redirect_url = home_url('register');

		if (!get_option('users_can_register')) {
			// 注册已关闭，显示错误
			$redirect_url		=	add_query_arg('register-errors', 'closed', $redirect_url);
		} else {

			$email				=	$_POST['email'];
			$login				=	$_POST['login'];
			$password			=	$_POST['password'];
			$result				=	register_user($login, $email,  $password);

			if (is_wp_error($result)) {
				// 将错误解析为字符串并附加为参数以进行重定向
				$errors			= join(',', $result->get_error_codes());
				$redirect_url	=	add_query_arg('register-errors', $errors, $redirect_url);
			} else {
				// 成功，重定向到登录页面
				$redirect_url	=	home_url('login');
				$redirect_url	=	add_query_arg('registered', $email, $redirect_url);
			}
		}

		wp_redirect($redirect_url);
		exit;
	}
}
add_action('login_form_register', 'do_register_user');

/*========================================================================================================
 忘记密码页面
 ========================================================================================================*/
// 将用户重定向到自定义页面
function redirect_to_custom_lostpassword()
{
	if ('GET' == $_SERVER['REQUEST_METHOD']) {
		if (is_user_logged_in()) {
			redirect_logged_in_user();
			exit;
		}

		wp_redirect(home_url('password-lost'));
		exit;
	}
}
add_action('login_form_lostpassword', 'redirect_to_custom_lostpassword');

// 忘记密码简码
function render_password_lost_form($attributes, $content = null)
{
	// 解析简码属性
	$default_attributes			=	['show_title' => false];
	$attributes					=	shortcode_atts($default_attributes, $attributes);

	if (is_user_logged_in()) {
		return esc_html__('您已经登录。', 'text-alfie');
	} else {
		// 从请求参数中检索可能的错误
		$attributes['errors']	=	[];

		if (isset($_REQUEST['errors'])) {
			$error_codes		=	explode(',', $_REQUEST['errors']);
			foreach ($error_codes as $error_code) {
				$attributes['errors'][] = get_error_message($error_code);
			}
		}
		return get_template_html('password_lost_form', $attributes);
	}
}
add_shortcode('password-lost-form', 'render_password_lost_form');

// 处理表单提交
function do_password_lost()
{
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		$errors = retrieve_password();
		if (is_wp_error($errors)) {
			// 发现错误
			$redirect_url		=	home_url('password-lost');
			$redirect_url		=	add_query_arg('errors', join(',', $errors->get_error_codes()), $redirect_url);
		} else {
			// 邮件已发送
			$redirect_url		=	home_url('login');
			$redirect_url		=	add_query_arg('checkemail', 'confirm', $redirect_url);
			if (!empty($_REQUEST['redirect_to'])) {
				$redirect_url	=	$_REQUEST['redirect_to'];
			}
		}

		wp_redirect($redirect_url);
		exit;
	}
}
add_action('login_form_lostpassword', 'do_password_lost');

// 自定义重置密码邮箱信息
function replace_retrieve_password_message($message, $key, $user_login, $user_data)
{
	$msg	.=	sprintf(__('尊敬的 %s 您好！', 'text-alfie'), rawurlencode($user_login)) . "\r\n\r\n";
	$msg	.=	__('您通过邮箱要求我们重置您的帐户密码。', 'text-alfie') . "\r\n\r\n";
	$msg	.=	__('如果这是一个错误，或者您没有要求重置密码，请忽略此电子邮件。', 'text-alfie') . "\r\n\r\n";
	$msg	.=	__('要重置密码，请访问以下地址：', 'text-alfie') . "\r\n\r\n";
	$msg	.=	site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n\r\n";
	$msg	.=	__('谢谢！', 'text-alfie') . "\r\n";

	return $msg;
}
add_filter('retrieve_password_message', 'replace_retrieve_password_message', 10, 4);


/*========================================================================================================
 重置密码页面
 ========================================================================================================*/
// 将用户重定向到重置密码自定义页面
function redirect_to_custom_password_reset()
{
	if ('GET' == $_SERVER['REQUEST_METHOD']) {

		// 验证密钥/登录组合
		$user	=	check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);

		if (!$user || is_wp_error($user)) {
			if ($user && $user->get_error_code() === 'expired_key') {
				wp_redirect(home_url('login?login=expiredkey'));
			} else {
				wp_redirect(home_url('login?login=invalidkey'));
			}
			exit;
		}

		$redirect_url	=	home_url('password-reset');
		$redirect_url	=	add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
		$redirect_url	=	add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);

		wp_redirect($redirect_url);
		exit;
	}
}
add_action('login_form_rp', 'redirect_to_custom_password_reset');
add_action('login_form_resetpass', 'redirect_to_custom_password_reset');

// 重置密码表单简码
function render_password_reset_form($attributes, $content = null)
{
	// 解析简码属性
	$default_attributes				=	['show_title' => false];
	$attributes						=	shortcode_atts($default_attributes, $attributes);

	if (is_user_logged_in()) {
		return esc_html__('您已经登录。', 'text-alfie');
	} else {
		if (isset($_REQUEST['login']) && isset($_REQUEST['key'])) {

			$attributes['login']	=	$_REQUEST['login'];
			$attributes['key']		=	$_REQUEST['key'];
			$errors					=	[];

			if (isset($_REQUEST['error'])) {
				$error_codes		=	explode(',', $_REQUEST['error']);
				foreach ($error_codes as $code) {
					$errors[]		=	get_error_message($code);
				}
			}

			$attributes['errors'] = $errors;

			return get_template_html('password_reset_form', $attributes);
		} else {
			return esc_html__('无效的重置密码链接。', 'text-alfie');
		}
	}
}
add_shortcode('password-reset-form', 'render_password_reset_form');

// 处理「重置密码」动作
function do_password_reset()
{
	if ('POST' == $_SERVER['REQUEST_METHOD']) {

		$rp_key		=	$_REQUEST['rp_key'];
		$rp_login	=	$_REQUEST['rp_login'];
		$user		=	check_password_reset_key($rp_key, $rp_login);

		if (!$user || is_wp_error($user)) {
			if ($user && $user->get_error_code() === 'expired_key') {
				wp_redirect(home_url('login?login=expiredkey'));
			} else {
				wp_redirect(home_url('login?login=invalidkey'));
			}
			exit;
		}
		if (isset($_POST['pass1'])) {
			// 密码不匹配
			if ($_POST['pass1'] != $_POST['pass2']) {

				$redirect_url	=	home_url('password-reset');
				$redirect_url	=	add_query_arg('key', $rp_key, $redirect_url);
				$redirect_url	=	add_query_arg('login', $rp_login, $redirect_url);
				$redirect_url	=	add_query_arg('error', 'password_reset_mismatch', $redirect_url);

				wp_redirect($redirect_url);
				exit;
			}
			// 密码为空
			if (empty($_POST['pass1'])) {

				$redirect_url	=	home_url('password-reset');
				$redirect_url	=	add_query_arg('key', $rp_key, $redirect_url);
				$redirect_url	=	add_query_arg('login', $rp_login, $redirect_url);
				$redirect_url	=	add_query_arg('error', 'password_reset_empty', $redirect_url);

				wp_redirect($redirect_url);
				exit;
			}
			// 参数检查OK，重置密码
			reset_password($user, $_POST['pass1']);
			wp_redirect(home_url('login?password=changed'));
		} else {
			return esc_html__('无效的重置密码链接。', 'text-alfie');
		}
		exit;
	}
}
add_action('login_form_rp', 'do_password_reset');
add_action('login_form_resetpass', 'do_password_reset');
