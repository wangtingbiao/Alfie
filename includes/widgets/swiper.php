<?php
add_action('widgets_init', function () {
	register_widget('Swiper_widget');
});

class Swiper_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname'							=>	'swiper_widget',
			'description'						=>	esc_html__('轮播海报图', 'text-alfie'),
			'customize_selective_refresh'		=>	true,
		);
		parent::__construct('swiper_widget', esc_html__('A 轮播图'), $widget_ops);
	}

	public function widget($args, $instance)
	{

		echo $args['before_widget'];

		get_template_part('templates/template', 'swiper');

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		echo '<p><a href="' . get_admin_url() . 'customize.php?return=%2Fwp-admin%2Fwidgets.php" target="_blank">' . __('（ 外观 -> 自定义 -> 主题设置 -> 轮播 ）', 'text-alfie') . '</a></p>';
	}

	public function update($new_instance, $old_instance)
	{
		foreach ($new_instance as $key => $value) {
			$updated_instance[$key] = sanitize_text_field($value);
		}
		return $updated_instance;
	}
}
