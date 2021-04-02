<?php
function home_customizer_section($wp_customize)
{

	$wp_customize->add_section('alfie_home_section', [
		'title'						=>	esc_html__('首页 ===', 'text-alfie'),
		'priority'					=>	30,
	]);

	// 推荐类别ID
	$wp_customize->add_setting('alfie_rec')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_rec',
		[
			'label'					=>	esc_html__('推荐类别ID', 'text-alfie'),
			'description'			=>	esc_html__('全局顶部显示，默认显示所有分类，自定义多个ID请用英文逗号隔开（ , ）', 'text-alfie'),
			'section'				=>	'alfie_home_section',
		]
	);

	// 轮播模式
	$wp_customize->add_setting('alfie_swiper_select')->sanitize_callback = 'custom_sanitize_radio_select';
	$wp_customize->add_control(
		'alfie_swiper_select',
		[
			'label'					=>	esc_html__('轮播模式', 'text-alfie'),
			'section'				=>	'alfie_home_section',
			'type'					=>	'radio',
			'choices'				=>	[
				'category'			=>	esc_html__('分类', 'text-alfie'),
				'article'			=>	esc_html__('文章', 'text-alfie'),
			]
		]
	);

	// 分类ID
	$wp_customize->add_setting('alfie_swiper_category_id')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_swiper_category_id',
		[
			'label'					=>	esc_html__('分类ID', 'text-alfie'),
			'description'			=>	esc_html__('多个ID请用英文逗号隔开（ , ）', 'text-alfie'),
			'section'				=>	'alfie_home_section',
		]
	);

	// 分类文章显示数量
	$wp_customize->add_setting(
		'alfie_swiper_category_post_number',
		[
			'default'				=>	5,
			'sanitize_callback'		=>	'absint',
		]
	);

	$wp_customize->add_control(
		'alfie_swiper_category_post_number',
		[
			'label'					=>	esc_html__('分类文章显示数量', 'text-alfie'),
			'description'			=>	esc_html__('获取显示的文章数量，建议不要设置过多，5篇以下为宜，不可为空', 'text-alfie'),
			'section'				=>	'alfie_home_section',
			'type'					=>	'number',
		]
	);

	// 文章ID
	$wp_customize->add_setting('alfie_swiper_post_id')->sanitize_callback = 'sanitize_text_field';
	$wp_customize->add_control(
		'alfie_swiper_post_id',
		[
			'label'					=>	esc_html__('【文章ID】', 'text-alfie'),
			'description'			=>	esc_html__('多个ID请用英文逗号隔开（ , ）', 'text-alfie'),
			'section'				=>	'alfie_home_section',
		]
	);
}
