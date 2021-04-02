<?php

/**
 * 此主题的定制程序设置
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
function customizer_section($wp_customize)
{
	// 标题局部刷新
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->selective_refresh->add_partial(
		'blogname',
		[
			'selector'				=>	'.__app-title a',
			'render_callback'		=>	function () {
				bloginfo('name');
			},
		]
	);

	// 显示站点标题
	$wp_customize->add_setting(
		'alfie_header_title_switch',
		[
			'default'				=>	true,
			'sanitize_callback'		=>	'custom_sanitize_checkbox',
		]
	);
	$wp_customize->add_control(
		'alfie_header_title_switch',
		[
			'label'					=>	esc_html__('显示站点标题', 'text-alfie'),
			'section'				=>	'title_tagline',
			'type'					=>	'checkbox',
			'priority'				=>	9,
		]
	);

	// 关键词
	$wp_customize->add_setting('alfie_keywords')->sanitize_callback = 'wp_filter_nohtml_kses';
	$wp_customize->add_control(
		'alfie_keywords',
		[
			'label'					=>	esc_html__('站点关键词', 'text-alfie'),
			'description'			=>	esc_html__('多个词请用英文逗号隔开（ , ）', 'text-alfie'),
			'section'				=>	'title_tagline',
			'type'					=>	'textarea',
		]
	);


	header_customizer_section($wp_customize);
	home_customizer_section($wp_customize);
	post_customizer_section($wp_customize);
	social_customizer_section($wp_customize);
	footer_customizer_section($wp_customize);
	smtp_customizer_section($wp_customize);
	other_customizer_section($wp_customize);


	/**
	 * 单选按钮和选项清理 radio select
	 *
	 * 输入内容必须是小段文字：仅允许使用小写字母数字字符,破折号和下划线
	 * 获取可能的单选框选项列表
	 * 返回输入（如果有效）或返回默认选项
	 */
	function custom_sanitize_radio_select($input, $setting)
	{
		$input = sanitize_key($input);
		$choices = $setting->manager->get_control($setting->id)->choices;
		return (array_key_exists($input, $choices) ? $input : $setting->default);
	}

	/**
	 * 复选框清理 checkbox
	 *
	 * 如果选中复选框,则返回true
	 */
	function custom_sanitize_checkbox($input)
	{
		return (isset($input) ? true : false);
	}

	/**
	 * 文件输入清理
	 *
	 * 允许的文件类型
	 * 从文件名检查文件类型
	 * 如果文件具有有效的mime类型，则将其返回，否则返回默认值
	 */
	function custom_sanitize_file($file, $setting)
	{
		$mimes = [
			'jpg|jpeg|jpe'  =>  'image/jpeg',
			'gif'           =>  'image/gif',
			'png'           =>  'image/png',
			'bmp'           =>  'image/bmp',
			'tif|tiff'      =>  'image/tiff',
			'webp'          =>  'image/x-icon',
		];
		$file_ext			=	wp_check_filetype($file, $mimes);
		return ($file_ext['ext'] ? $file : $setting->default);
	}

	/**
	 * wp_kses_post 清理
	 *
	 * 设置允许的类型
	 */
	$allowed_html = [

		'a'             =>	[
			'href'      =>  [],
			'title'     =>  [],
		],

		'br'            =>  [],
		'em'            =>  [],
		'strong'        =>  [],
	];
	wp_kses($input, $allowed_html);

	/**
	 * 脚本输入清理
	 */
	function custom_sanitize_js_code($input)
	{
		return base64_encode($input);
	}
	/**
	 * 脚本输出转义
	 */
	function custom_escape_js_output($input)
	{
		return esc_textarea(base64_decode($input));
	}
}
add_action('customize_register', 'customizer_section');
