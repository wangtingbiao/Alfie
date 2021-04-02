<?php
function post_customizer_section($wp_customize)
{

	$wp_customize->add_section(
		'alfie_post_section',
		[
			'title'					=>	esc_html__('文章页 ===', 'text-alfie'),
			'priority'				=>	30,
		]
	);

	// 手机是否显示头图
	$wp_customize->add_setting('alfie_posts_pic_mobile_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_posts_pic_mobile_switch',
		[
			'label'					=>	esc_html__('手机是否显示头图', 'text-alfie'),
			'section'				=>	'alfie_post_section',
			'type'					=>	'checkbox',
		]
	);

	// 分享设置
	$wp_customize->add_setting('alfie_posts_share')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_posts_share',
		[
			'label'					=>	esc_html__('分享设置', 'text-alfie'),
			'description'			=>	__('英文逗号隔开（ , ）支持列表：<br />weibo,qq,wechat,tencent,douban,qzone,<br />linkedin,diandian,facebook,twitter,google', 'text-alfie'),
			'section'				=>	'alfie_post_section',
		]
	);

	// 显示文章版权
	$wp_customize->add_setting('alfie_posts_copytight_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_posts_copytight_switch',
		[
			'label'					=>	esc_html__('显示文章版权', 'text-alfie'),
			'section'				=>	'alfie_post_section',
			'type'					=>	'checkbox',
		]
	);

	// 版权内容
	$wp_customize->add_setting('alfie_posts_copytight')->sanitize_callback = 'wp_kses_post';
	$wp_customize->add_control(
		'alfie_posts_copytight',
		[
			'label'					=>	esc_html__('版权内容', 'text-alfie'),
			'description'			=>	esc_html__('文章全局版权，可以使用html  例如： <a href="mailto:hi@name.com">hi@name.com</a>', 'text-alfie'),
			'section'				=>	'alfie_post_section',
			'type'					=>	'textarea',
		]
	);

	// 显示相关文章
	$wp_customize->add_setting('alfie_related_post_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_related_post_switch',
		[
			'label'					=>	esc_html__('显示相关文章', 'text-alfie'),
			'section'				=>	'alfie_post_section',
			'type'					=>	'checkbox',
		]
	);

	// 显示文章数量
	$wp_customize->add_setting(
		'alfie_related_post',
		[
			'default'				=>	'3',
			'sanitize_callback'		=>	'absint',
		]
	);
	$wp_customize->add_control(
		'alfie_related_post',
		[
			'label'					=>	esc_html__('显示文章数量', 'text-alfie'),
			'section'				=>	'alfie_post_section',
			'type'					=>	'number',
		]
	);
}
