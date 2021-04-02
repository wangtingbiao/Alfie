<?php
function header_customizer_section($wp_customize)
{

	$wp_customize->add_section(
		'alfie_header_section',
		[
			'title'					=>	esc_html__('顶部 ===', 'text-alfie'),
			'priority'				=>	30,
		]
	);

	// 显示登录/注册
	$wp_customize->add_setting('alfie_register_login_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_register_login_switch',
		[
			'label'					=>	esc_html__('显示登录', 'text-alfie'),
			'description'			=>	__('注册请到后台 <a href="' . get_admin_url() . 'options-general.php" target="_blank">成员资格</a> 勾选任何人都可以注册<br /><br />开启注册可能需要SMTP服务支持，请配置SMTP数据', 'text-alfie'),
			'section'				=>	'alfie_header_section',
			'type'					=>	'checkbox',
		]
	);

	// 前台登录/注册/重置密码/个人中心
	$wp_customize->add_setting('alfie_rlra_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_rlra_switch',
		[
			'label'					=>	esc_html__('开启前台功能', 'text-alfie'),
			'description'			=>	__('必需设置（伪静态/SMTP服务）切勿删除/更改后台对应的五个页面【别名】与【简码】设置。<br />（登录/注册/个人中心/忘记密码/重置密码）', 'text-alfie'),
			'section'				=>	'alfie_header_section',
			'type'					=>	'checkbox',
		]
	);

	// 显示二维码
	$wp_customize->add_setting('alfie_qrcode_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_qrcode_switch',
		[
			'label'					=>	esc_html__('显示二维码', 'text-alfie'),
			'section'				=>	'alfie_header_section',
			'type'					=>	'checkbox',
		]
	);

	// 二维码按钮文字
	$wp_customize->add_setting(
		'alfie_qrcode_title',
		[
			'default'				=>	esc_html__('关注我', 'text-alfie'),
			'transport'				=>	'postMessage',
			'sanitize_callback'		=>	'sanitize_text_field',
		]
	);
	$wp_customize->add_control(
		'alfie_qrcode_title',
		[
			'label'					=>	esc_html__('二维码按钮文字', 'text-alfie'),
			'section'				=>	'alfie_header_section',
		]
	);
	$wp_customize->selective_refresh->add_partial(
		'alfie_qrcode_title',
		[
			'selector'			=>	'.__qrcode-btn span',
			'settings'			=>	'alfie_qrcode_title',
			'render_callback'	=>	function () {
				return get_theme_mod('alfie_qrcode_title');
			},
		]
	);

	// 二维码图片 1
	$wp_customize->add_setting('alfie_qrcode_img_1')->sanitize_callback = 'esc_url_raw';
	$wp_customize->add_control(new WP_Customize_Image_Control(
		$wp_customize,
		'alfie_qrcode_img_1',
		[
			'label'					=>	esc_html__('二维码图片 1', 'text-alfie'),
			'section'				=>	'alfie_header_section',
		]
	));

	// 二维码图片 2
	$wp_customize->add_setting('alfie_qrcode_img_2')->sanitize_callback = 'esc_url_raw';
	$wp_customize->add_control(new WP_Customize_Image_Control(
		$wp_customize,
		'alfie_qrcode_img_2',
		[
			'label'					=>	esc_html__('二维码图片 2', 'text-alfie'),
			'section'				=>	'alfie_header_section',
		]
	));

	// 二维码图片 3
	$wp_customize->add_setting('alfie_qrcode_img_3')->sanitize_callback = 'esc_url_raw';
	$wp_customize->add_control(new WP_Customize_Image_Control(
		$wp_customize,
		'alfie_qrcode_img_3',
		[
			'label'					=>	esc_html__('二维码图片 3', 'text-alfie'),
			'section'				=>	'alfie_header_section',
		]
	));
}
