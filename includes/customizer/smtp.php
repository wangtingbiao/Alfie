<?php
function smtp_customizer_section($wp_customize)
{

	$wp_customize->add_section(
		'alfie_smtp_section',
		[
			'title'					=>	esc_html__('SMTP配置 ===', 'text-alfie'),
			'priority'				=>	30,
		]
	);

	// 发件人名称
	$wp_customize->add_setting('alfie_smtp_name')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_smtp_name',
		[
			'label'					=>	esc_html__('发件人名称（默认站点标题）', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
		]
	);

	// 邮箱
	$wp_customize->add_setting('alfie_smtp_email')->sanitize_callback = 'sanitize_email';
	$wp_customize->add_control(
		'alfie_smtp_email',
		[
			'label'					=>	esc_html__('邮箱', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
			'type'					=>	'email',
		]
	);

	// 密码
	$wp_customize->add_setting('alfie_smtp_pass')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_smtp_pass',
		[
			'label'					=>	esc_html__('密码', 'text-alfie'),
			'description'			=>	esc_html__('腾讯为授权码', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
		]
	);

	// 服务器
	$wp_customize->add_setting('alfie_smtp_host')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_smtp_host',
		[
			'label'					=>	esc_html__('服务器', 'text-alfie'),
			'description'			=>	__('腾讯个人：smtp.qq.com<br />腾讯企业：smtp.exmail.qq.com<br />阿里云企业：smtp.mxhichina.com<br />其他服务商自行查询', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
		]
	);

	// 端口
	$wp_customize->add_setting('alfie_smtp_port')->sanitize_callback = 'absint';
	$wp_customize->add_control(
		'alfie_smtp_port',
		[
			'label'					=>	esc_html__('端口(默认25)', 'text-alfie'),
			'description'			=>	esc_html__('（非加密25）（加密465）', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
			'type'					=>	'number',
		]
	);

	// 加密
	$wp_customize->add_setting('alfie_smtp_ssl')->sanitize_callback = 'wp_filter_nohtml_kses';
	$wp_customize->add_control(
		'alfie_smtp_ssl',
		[
			'label'					=>	esc_html__('协议（默认tls）', 'text-alfie'),
			'description'			=>	esc_html__('端口25->tls(留空)，端口465->ssl', 'text-alfie'),
			'section'				=>	'alfie_smtp_section',
		]
	);
}
