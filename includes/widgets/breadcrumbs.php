<?php
add_action('widgets_init', function () {
	register_widget('Breadcrumbs_widget');
});

class Breadcrumbs_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname'							=>	'Breadcrumbs_widget',
			'description'						=>	esc_html__('带搜索与标题', 'text-alfie'),
			'customize_selective_refresh'		=>	true,
		);
		parent::__construct('Breadcrumbs_widget', esc_html__('A 横向栏目'), $widget_ops);
	}

	public function widget($args, $instance)
	{

		echo $args['before_widget'];

		alfie_get_breadcrumbs();

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		echo '<p>' . esc_html__('无需设置参数。', 'text-alfie') . '</p>';
	}

	public function update($new_instance, $old_instance)
	{
		foreach ($new_instance as $key => $value) {
			$updated_instance[$key] = sanitize_text_field($value);
		}
		return $updated_instance;
	}
}
