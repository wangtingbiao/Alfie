<?php
add_action('widgets_init', function () {
	register_widget('Recommend_widget');
});

class Recommend_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname'							=>	'recommend_widget',
			'description'						=>	esc_html__('类别推荐，自定义填写ID', 'text-alfie'),
			'customize_selective_refresh'		=>	true,
		);
		parent::__construct('recommend_widget', esc_html__('A 类别推荐'), $widget_ops);
	}

	public function widget($args, $instance)
	{

		echo $args['before_widget'];
		get_template_part('templates/template', 'recommend');
		echo $args['after_widget'];
	}

	public function form($instance)
	{
		echo '<p><a href="' . get_admin_url() . 'customize.php?return=%2Fwp-admin%2Fwidgets.php" target="_blank">' . __('（ 外观 -> 自定义 -> 主题设置 -> 首页设置 ）', 'text-alfie') . '</a></p>';
	}

	public function update($new_instance, $old_instance)
	{
		foreach ($new_instance as $key => $value) {
			$updated_instance[$key] = sanitize_text_field($value);
		}
		return $updated_instance;
	}
}
