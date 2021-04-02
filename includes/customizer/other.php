<?php
function other_customizer_section($wp_customize)
{

	$wp_customize->add_section(
		'alfie_other_section',
		[
			'title'					=>	esc_html__('其他功能 ===', 'text-alfie'),
			'priority'				=>	30,
		]
	);

	// 站长认证
	$wp_customize->add_setting(
		'alfie_html_verify',
		[
			'sanitize_callback'		=>	'custom_sanitize_js_code',
			'sanitize_js_callback'	=>	'custom_escape_js_output',
		]
	);
	$wp_customize->add_control(
		'alfie_html_verify',
		[
			'label'					=>	esc_html__('站长认证（HTML标签验证）', 'text-alfie'),
			'description'			=>	esc_html__('含各类平台，填写完整meta标签，为保持验证通过的状态，建议成功验证后请不要删除该标签。', 'text-alfie'),
			'section'				=>	'alfie_other_section',
			'type'					=>	'textarea',
		]
	);

	// 开启百度自动推送JS
	$wp_customize->add_setting('alfie_baidu_auto_js_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_baidu_auto_js_switch',
		[
			'label'					=>	esc_html__('开启百度自动推送JS', 'text-alfie'),
			'description'			=>	__('无需人工干预，有访问自动推送。', 'text-alfie'),
			'section'				=>	'alfie_other_section',
			'type'					=>	'checkbox',
		]
	);

	// 开启百度快速收录
	$wp_customize->add_setting('alfie_baidu_submit_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_baidu_submit_switch',
		[
			'label'					=>	esc_html__('开启百度快速收录', 'text-alfie'),
			'description'			=>	__('快速收录 <a href="https://ziyuan.baidu.com/linksubmit/index" target="_blank">获取密钥Token</a>', 'text-alfie'),
			'section'				=>	'alfie_other_section',
			'type'					=>	'checkbox',
		]
	);

	// 百度token
	$wp_customize->add_setting('alfie_baidu_token')->sanitize_callback = 'wp_filter_nohtml_kses';
	$wp_customize->add_control(
		'alfie_baidu_token',
		[
			'label'					=>	esc_html__('百度Token', 'text-alfie'),
			'section'				=>	'alfie_other_section',
		]
	);

	// 删除core_updater.lock
	$wp_customize->add_setting('alfie_delete_updater_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_delete_updater_switch',
		[
			'label'					=>	esc_html__('删除core_updater.lock', 'text-alfie'),
			'description'			=>	__('Wordpress在线更新升级失败失败删除core_updater.lock文件。<br />勾选后->刷新后台->取消勾选->再次更新。', 'text-alfie'),
			'section'				=>	'alfie_other_section',
			'type'					=>	'checkbox',
		]
	);
}
