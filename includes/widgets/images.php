<?php
add_action('widgets_init', function () {
	register_widget('Images_Widget');
});

class Images_Widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array(
			'classname'							=>	'image_widget',
			'description'						=>	esc_html__('图片列表形式，一排4个。', 'text-alfie'),
			'customize_selective_refresh'		=>	true,
		);
		parent::__construct('image_widget', esc_html__('A 图片列表'), $widget_ops);
	}

	public function widget($args, $instance)
	{

		$title		=	(!empty($instance['title'])) ? $instance['title'] : '';
		$cat		=	(!empty($instance['cat'])) ? $instance['cat'] : '';
		$number		=	(!empty($instance['number'])) ? absint($instance['number']) : 6;

		if (!$cat) {
			$cat = 0;
		}

		if (!$number) {
			$number = 6;
		}

		echo $args['before_widget'];

		$query = new WP_Query(array(
			'posts_per_page' => $number,
			'cat' => $cat,
			'ignore_sticky_posts' => true,
		));

		if ($query->have_posts()) :
			echo '<div class="__breadcrumbs main-list-2">';

			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			} else {
				echo '<h2 class="enty-title">' . get_cat_name($cat) . '</h2>';
			}

			echo '<div class="enty-link"><a href="' . get_category_link($cat) . '">查看更多</a></div></div>';

			echo '<div class="__images" itemprop="ItemPage">';
			while ($query->have_posts()) : $query->the_post();

				get_template_part('templates-parts/content', 'image');

			endwhile;
			echo '</div>';
		endif;
		wp_reset_postdata();

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		$title		=	!empty($instance['title']) ? $instance['title'] : '';
		$cat		=	!empty($instance['cat']) ? $instance['cat'] : '';
		$number		=	!empty($instance['number']) ? $instance['number'] : 6;
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php esc_html_e('标题:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" placeholder="<?php esc_attr_e('默认显示所选分类名称，可自定义！', 'text-alfie'); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php esc_html_e('分类:', 'text-alfie'); ?>
			</label>
			<?php
			$args = array(
				'show_option_all'	=>	__('选择分类', 'text-alfie'),
				'show_count'		=>	true,
				'hide_empty'		=>	false,
				'hierarchical'		=>	true,
				'class'				=>	'widefat',
				'id'				=>	$this->get_field_name('cat'),
				'name'				=>	$this->get_field_name('cat'),
				'selected'			=>	esc_attr($cat),
				'value_field'		=>	esc_attr($cat),
			);
			wp_dropdown_categories($args);
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
				<?php esc_html_e('数量:', 'text-alfie'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo esc_attr($number); ?>">
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
