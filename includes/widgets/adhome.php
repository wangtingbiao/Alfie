<?php

/**
 * 大图广告小工具
 *
 * @package alfie
 */

add_action('widgets_init', function () {
	register_widget('ADhome_widget');
});

class ADhome_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname'							=>	'ad_home_widget',
			'description'						=>	esc_html__('自定义大图广告', 'text-alfie'),
			'customize_selective_refresh'		=>	true,
		);
		parent::__construct('ad_home_widget', esc_html__('A 大图广告'), $widget_ops);
	}

	public function widget($args, $instance)
	{

		$title		=	(!empty($instance['title'])) ? $instance['title'] : '';
		$image		=	(!empty($instance['image'])) ? $instance['image'] : '';
		$url		=	(!empty($instance['url'])) ? $instance['url'] : '';
		$url_text	=	(!empty($instance['url_text'])) ? $instance['url_text'] : esc_html__('查看详情', 'text-alfie');

		if (!$url_text) {
			$url_text = esc_html__('查看详情', 'text-alfie');
		}

		echo $args['before_widget'];

		echo '<div class="__adhome main-list"><img src="' . $image . '" alt="">
				<div class="enty-box">
					<h3 class="enty-title"><a href="' . $url . '">' . $title . '</a></h3>
					<a href="' . $url . '" class="enty-link">' . $url_text . '</a>
				</div>
				<span>' . esc_html__('广告', 'text-alfie') . '</span>
			</div>';

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		$title		=	(!empty($instance['title'])) ? $instance['title'] : '';
		$image		=	(!empty($instance['image'])) ? $instance['image'] : '';
		$url_text	=	(!empty($instance['url_text'])) ? $instance['url_text'] : esc_html__('查看详情', 'text-alfie');
		$url		=	(!empty($instance['url'])) ? $instance['url'] : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php esc_html_e('标题:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>">
				<?php esc_html_e('图像:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="url" value="<?php echo esc_attr($image); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>">
				<?php esc_html_e('链接:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="url" value="<?php echo esc_attr($url); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('url_text'); ?>">
				<?php esc_html_e('链接标题:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('url_text'); ?>" name="<?php echo $this->get_field_name('url_text'); ?>" type="text" value="<?php echo esc_attr($url_text); ?>">
		</p>
<?php
	}

	public function update($new_instance, $old_instance)
	{
		foreach ($new_instance as $key => $value) {
			$updated_instance[$key] = sanitize_text_field($value);
		}
		return $updated_instance;
	}
}
