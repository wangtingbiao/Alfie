<?php
class Easy_Thumbnail_Switcher
{
	public $add_new_str;
	public $change_str;
	public $remove_str;
	public $upload_title;
	public $upload_add;
	public $confirm_str;

	public function __construct()
	{
		$this->add_new_str = __('添加', 'text-alfie');
		$this->change_str = __('更改', 'text-alfie');
		$this->remove_str = __('移除', 'text-alfie');
		$this->upload_title = __('上传图片', 'text-alfie');
		$this->upload_add = __('确定', 'text-alfie');
		$this->confirm_str = __('你确定?', 'text-alfie');

		add_filter('manage_posts_columns', array($this, 'add_column'));
		add_action('manage_posts_custom_column', array($this, 'thumb_column'), 10, 2);
		add_action('admin_footer', array($this, 'add_nonce'));
		add_action('admin_enqueue_scripts', array($this, 'scripts'));

		add_action('wp_ajax_ts_ets_update', array($this, 'update'));
		add_action('wp_ajax_ts_ets_remove', array($this, 'remove'));

		add_image_size('ts-ets-thumb', 'auto', 40, array('center', 'center'));
	}

	public function add_nonce()
	{

		global $pagenow;

		if ($pagenow !== 'edit.php') {
			return;
		}
		wp_nonce_field('ts_ets_nonce', 'ts_ets_nonce');
	}

	public function scripts($pagenow)
	{
		if ($pagenow !== 'edit.php') {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script('doocii-ets-js', get_template_directory_uri() . '/assets/js/easy-thumbnail.js', array('jquery', 'media-upload', 'thickbox'), '1.0', true);

		wp_localize_script('doocii-ets-js', 'ets_strings', array(
			'upload_title' => $this->upload_title,
			'upload_add' => $this->upload_add,
			'confirm' => $this->confirm_str,
		));
	}

	public function add_column($columns)
	{
		$columns['ts-ets-option'] = __('缩略图', 'text-alfie');
		return $columns;
	}

	public function thumb_column($column, $id)
	{
		switch ($column) {
			case 'ts-ets-option':
				if (has_post_thumbnail()) {
					the_post_thumbnail('ts-ets-thumb');
					echo '<br>';
					echo sprintf('<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr($id), $this->change_str);
					echo sprintf(' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr($id), $this->remove_str);
				} else {
					echo sprintf('<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr($id), $this->add_new_str);
				}
				break;
		}
	}

	public function update()
	{
		if (!isset($_POST['nonce']) || !isset($_POST['post_id']) || !isset($_POST['thumb_id'])) {
			wp_die();
		}

		if (!wp_verify_nonce($_POST['nonce'], 'ts_ets_nonce')) {
			wp_die();
		}

		$id = $_POST['post_id'];
		$thumb_id = $_POST['thumb_id'];

		set_post_thumbnail($id, $thumb_id);

		echo wp_get_attachment_image($thumb_id, 'ts-ets-thumb');
		echo '<br>';
		echo sprintf('<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr($id), $this->change_str);
		echo sprintf(' <button type="button" class="button-secondary ts-ets-remove" data-id="%s">%s</button>', esc_attr($id), $this->remove_str);

		wp_die();
	}

	public function remove()
	{
		if (!isset($_POST['nonce']) || !isset($_POST['post_id'])) {
			wp_die();
		}

		if (!wp_verify_nonce($_POST['nonce'], 'ts_ets_nonce')) {
			wp_die();
		}

		$id = $_POST['post_id'];
		delete_post_thumbnail($id);
		echo sprintf('<button type="button" class="button-primary ts-ets-add" data-id="%s">%s</button>', esc_attr($id), $this->add_new_str);
		wp_die();
	}
}

new Easy_Thumbnail_Switcher();
