<?php
function footer_customizer_section($wp_customize)
{
	$wp_customize->add_section(
		'alfie_footer_section',
		[
			'title'					=>	esc_html__('底部 ===', 'text-alfie'),
			'priority'				=>	30,
		]
	);

	// 显示底部logo
	$wp_customize->add_setting('alfie_footer_title_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_footer_title_switch',
		[
			'label'					=>	esc_html__('显示底部站点标题', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'checkbox',
		]
	);

	// 显示返回顶部
	$wp_customize->add_setting('alfie_totop_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_totop_switch',
		[
			'label'					=>	esc_html__('显示返回顶部', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'checkbox',
		]
	);

	// 底部介绍
	$wp_customize->add_setting(
		'alfie_footer_desc',
		[
			'transport'				=>	'postMessage',
			'sanitize_callback'		=>	'wp_kses_post',
		]
	);
	$wp_customize->add_control(
		'alfie_footer_desc',
		[
			'label'					=>	esc_html__('底部介绍', 'text-alfie'),
			'description'			=>	esc_html__('可以使用html 例如： <a href="">♥ 捐赠 ♥</a>', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'textarea',
		]
	);
	$wp_customize->selective_refresh->add_partial(
		'alfie_footer_desc',
		[
			'selector'				=>	'.foo-desc',
			'settings'				=>	'alfie_footer_desc',
			'render_callback'		=>	function () {
				return get_theme_mod('alfie_footer_desc');
			},
		]
	);

	// 备案号
	$wp_customize->add_setting(
		'alfie_record',
		[
			'transport'				=>	'postMessage',
			'sanitize_callback'		=>	'sanitize_text_field',
		]
	);
	$wp_customize->add_control(
		'alfie_record',
		[
			'label'					=>	esc_html__('备案号', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
		]
	);
	$wp_customize->selective_refresh->add_partial(
		'alfie_record',
		[
			'selector'				=>	'.record',
			'settings'				=>	'alfie_record',
			'render_callback'		=>	function () {
				return get_theme_mod('alfie_record');
			},
		]
	);

	// 统计代码
	$wp_customize->add_setting(
		'alfie_statistics',
		[
			'transport'				=>	'postMessage',
			'sanitize_callback'		=>	'custom_sanitize_js_code',
			'sanitize_js_callback'	=>	'custom_escape_js_output',
		]
	);
	$wp_customize->add_control(
		'alfie_statistics',
		[
			'label'					=>	esc_html__('统计代码', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'textarea',
		]
	);
	$wp_customize->selective_refresh->add_partial(
		'alfie_statistics',
		[
			'selector'				=>	'.statistics',
			'settings'				=>	'alfie_statistics',
			'render_callback'		=>	function () {
				return get_theme_mod('alfie_statistics');
			},
		]
	);

	// 显示客服
	$wp_customize->add_setting('alfie_clerk_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_clerk_switch',
		[
			'label'					=>	esc_html__('显示客服', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'checkbox',
		]
	);

	// 客服方式
	$wp_customize->add_setting('alfie_clerk_setup')->sanitize_callback = 'custom_sanitize_radio_select';
	$wp_customize->add_control(
		'alfie_clerk_setup',
		[
			'label'					=>	esc_html__('客服显示模式', 'text-alfie'),
			'description'			=>	__('请在云智服后台获取->设定->网站渠道 <a href="https://yzf.qq.com/" target="_blank">获取链接地址</a>', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'select',
			'choices'				=>	[
				'clerk_url'			=>	esc_html__('连接版', 'text-alfie'),
				'clerk_js'			=>	esc_html__('代码版', 'text-alfie'),
			]
		]
	);

	// 连接版
	$wp_customize->add_setting('alfie_clerk_url')->sanitize_callback = 'esc_url_raw';
	$wp_customize->add_control(
		'alfie_clerk_url',
		[
			'label'					=>	esc_html__('连接版', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'url',
		]
	);

	// 代码版
	$wp_customize->add_setting(
		'alfie_clerk_js',
		[
			'sanitize_callback'		=>	'custom_sanitize_js_code',
			'sanitize_js_callback'	=>	'custom_escape_js_output',
		]
	);
	$wp_customize->add_control(
		'alfie_clerk_js',
		[
			'label'					=>	esc_html__('代码版', 'text-alfie'),
			'section'				=>	'alfie_footer_section',
			'type'					=>	'textarea',
		]
	);
}
