<?php
function social_customizer_section($wp_customize)
{
	$wp_customize->add_section(
		'alfie_social_section',
		[
			'title'				=>	esc_html__('社交 ===', 'text-alfie'),
			'priority'			=>	30,
		]
	);

	// 显示社交图标
	$wp_customize->add_setting('alfie_social_switch')->sanitize_callback = 'custom_sanitize_checkbox';
	$wp_customize->add_control(
		'alfie_social_switch',
		[
			'label'				=>	esc_html__('显示社交图标', 'text-alfie'),
			'description'		=>	__('一、填写带有http://或https://的完整链接<br />二、填写用户ID或用户名', 'text-alfie'),
			'section'			=>	'alfie_social_section',
			'type'				=>	'checkbox',
		]
	);

	// QQ
	$wp_customize->add_setting('alfie_social_qq')->sanitize_callback = 'absint';
	$wp_customize->add_control(
		'alfie_social_qq',
		[
			'label'				=>	esc_html__('QQ', 'text-alfie'),
			'description'		=>	esc_html__('123456'),
			'section'			=>	'alfie_social_section',
			'type'				=>	'number',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('阿拉伯数字', 'text-alfie'),
			]
		]
	);

	// Weibo
	$wp_customize->add_setting('alfie_social_weibo')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_weibo',
		[
			'label'				=>	esc_html__('Weibo', 'text-alfie'),
			'description'		=>	esc_html__('http://weibo.com/yourname'),
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);

	// Behance
	$wp_customize->add_setting('alfie_social_behance')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_behance',
		[
			'label'				=>	esc_html__('Behance', 'text-alfie'),
			'description'		=>	'http://behance.net/yourname',
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);

	// Dribbble
	$wp_customize->add_setting('alfie_social_dribbble')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_dribbble',
		[
			'label'				=>	esc_html__('Dribbble', 'text-alfie'),
			'description'		=>	'http://dribbble.com/yourname',
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);

	// Github
	$wp_customize->add_setting('alfie_social_github')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_github',
		[
			'label'				=>	esc_html__('Github', 'text-alfie'),
			'description'		=>	'http://github.com/yourname',
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);

	// Vimeo
	$wp_customize->add_setting('alfie_social_vimeo')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_vimeo',
		[
			'label'				=>	esc_html__('Vimeo', 'text-alfie'),
			'description'		=>	'http://vimeo.com/yourname',
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);

	// Youtube
	$wp_customize->add_setting('alfie_social_youtube')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_social_youtube',
		[
			'label'				=>	esc_html__('Youtube', 'text-alfie'),
			'description'		=>	'http://youtube.com/channel/yourname',
			'section'			=>	'alfie_social_section',
			'input_attrs'		=>	[
				'placeholder'	=>	esc_html__('ID或用户名', 'text-alfie'),
			]
		]
	);
}
