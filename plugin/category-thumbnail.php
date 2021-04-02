<?php
if (!defined('A_PLUGIN_URL'))
	define('A_PLUGIN_URL', untrailingslashit(plugins_url('', __FILE__)));
define('A_IMAGE_PLACEHOLDER', get_bloginfo("template_url") . "/assets/images/thumbnail.jpg");

function rec_init()
{
	$rec_taxonomies = get_taxonomies();
	if (is_array($rec_taxonomies)) {
		$rec_options = get_option('rec_options');
		if (empty($rec_options['excluded_taxonomies'])) {
			$rec_options['excluded_taxonomies'] = array();
		}
		foreach ($rec_taxonomies as $rec_taxonomy) {
			if (in_array($rec_taxonomy, $rec_options['excluded_taxonomies'])) {
				continue;
			}
			add_action($rec_taxonomy . '_add_form_fields', 'rec_add_texonomy_field', 9);
			add_action($rec_taxonomy . '_edit_form_fields', 'rec_edit_texonomy_field', 9);
			add_filter('manage_edit-' . $rec_taxonomy . '_columns', 'rec_taxonomy_columns');
			add_filter('manage_' . $rec_taxonomy . '_custom_column', 'rec_taxonomy_column', 10, 3);
		}
	}
}
add_action('admin_init', 'rec_init');

function rec_add_style()
{
	echo '<style type="text/css" media="screen">th.column-thumb {width:60px;}.form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px;}.inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block;}.column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block;}.inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px;}</style>';
}

function rec_add_texonomy_field()
{
	if (get_bloginfo('version') >= 3.5) {
		wp_enqueue_media();
	} else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
	}
	echo '<div class="form-field">
			<label for="taxonomy_image">' . __('分类图像', 'text-alfie') . '</label>
			<input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
			<br />
			<br />
			<button class="rec_upload_image_button button">' . __('添加图像', 'text-alfie') . '</button>
		</div>' . rec_script();
}

function rec_edit_texonomy_field($taxonomy)
{
	if (get_bloginfo('version') >= 3.5) {
		wp_enqueue_media();
	} else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
	}
	if (get_taxonomy_image_url($taxonomy->term_id, NULL, TRUE) == A_IMAGE_PLACEHOLDER) {
		$image_text = "";
	} else {
		$image_text = get_taxonomy_image_url($taxonomy->term_id, NULL, TRUE);
	}
	echo '<tr class="form-field">
			<th scope="row" valign="top">
				<label for="taxonomy_image">' . __('分类图像', 'text-alfie') . '</label>
			</th>
			<td>
				<img class="taxonomy-image" src="' . get_taxonomy_image_url($taxonomy->term_id, NULL, TRUE) . '" style="max-height:100px;"/>
				<br />
				<input type="text" name="taxonomy_image" id="taxonomy_image" value="' . $image_text . '" />
				<br />
				<br />
				<button class="rec_upload_image_button button">' . __('添加图像', 'text-alfie') . '</button>
				<button class="rec_remove_image_button button">' . __('删除图像', 'text-alfie') . '</button>
			</td>
		</tr>' . rec_script();
}

function rec_script()
{
	return '<script type="text/javascript">
				jQuery(document).ready(function($) {
					var wordpress_ver = "' . get_bloginfo("version") . '", upload_button;
					$(".rec_upload_image_button").click(function(event) {
						upload_button = $(this);
						var frame;
						if (wordpress_ver >= "3.5") {
							event.preventDefault();
							if (frame) {
								frame.open();
								return;
							}
							frame = wp.media();
							frame.on( "select", function() {
								var attachment = frame.state().get("selection").first();
								frame.close();
								if (upload_button.parent().prev().children().hasClass("tax_list")) {
								upload_button.parent().prev().children().val(attachment.attributes.url);
								upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
								} else {
									$("#taxonomy_image").val(attachment.attributes.url);
								}
							});
							frame.open();
						} else {
							tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
							return false;
						}
					});

					$(".rec_remove_image_button").click(function() {
						$("#taxonomy_image").val("");
						$(this).parent().siblings(".title").children("img").attr("src","' . A_IMAGE_PLACEHOLDER . '");
						$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
						return false;
					});

					if (wordpress_ver < "3.5") {
						window.send_to_editor = function(html) {
							imgurl = $("img",html).attr("src");
							if (upload_button.parent().prev().children().hasClass("tax_list")) {
								upload_button.parent().prev().children().val(imgurl);
								upload_button.parent().prev().prev().children().attr("src", imgurl);
							} else {
								$("#taxonomy_image").val(imgurl);
								tb_remove();
							}
						}
					}

					$(".editinline").live("click", function(){
						var tax_id = $(this).parents("tr").attr("id").substr(4);
						var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");
						if (thumb != "' . A_IMAGE_PLACEHOLDER . '") {
							$(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
						} else {
							$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
						}
						$(".inline-edit-col .title img").attr("src",thumb);
						return false;
					});
				});
			</script>';
}

add_action('edit_term', 'rec_save_taxonomy_image');
add_action('create_term', 'rec_save_taxonomy_image');

function rec_save_taxonomy_image($term_id)
{
	if (isset($_POST['taxonomy_image'])) {
		update_option('rec_taxonomy_image' . $term_id, $_POST['taxonomy_image']);
	}
}

function rec_get_attachment_id_by_url($image_src)
{
	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$image_src'";
	$id = $wpdb->get_var($query);
	return (!empty($id)) ? $id : NULL;
}

function get_taxonomy_image_url($term_id = NULL, $size = NULL, $return_placeholder = FALSE)
{
	if (!$term_id) {
		if (is_category()) {
			$term_id = get_query_var('cat');
		} elseif (is_tax()) {
			$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$term_id = $current_term->term_id;
		}
	}
	$taxonomy_image_url = get_option('rec_taxonomy_image' . $term_id);
	if (!empty($taxonomy_image_url)) {
		$attachment_id = rec_get_attachment_id_by_url($taxonomy_image_url);
		if (!empty($attachment_id)) {
			if (empty($size)) {
				$size = 'alfie-small';
			}
			$taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
			$taxonomy_image_url = $taxonomy_image_url[0];
		}
	}
	if ($return_placeholder) {
		return ($taxonomy_image_url != '') ? $taxonomy_image_url : A_IMAGE_PLACEHOLDER;
	} else {
		return $taxonomy_image_url;
	}
}

function rec_quick_edit_custom_box($column_name, $screen, $name)
{
	if ($column_name == 'thumb')
		echo '<fieldset>
				<div class="thumb inline-edit-col">
					<label>
						<span class="title"><img src="" alt="Thumbnail"/></span>
						<span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
						<span class="input-text-wrap">
							<button class="rec_upload_image_button button">' . __('添加图像', 'text-alfie') . '</button>
							<button class="rec_remove_image_button button">' . __('删除图像', 'text-alfie') . '</button>
						</span>
					</label>
				</div>
			</fieldset>';
}

function rec_taxonomy_columns($columns)
{
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = __('图像', 'text-alfie');
	unset($columns['cb']);
	return array_merge($new_columns, $columns);
}

function rec_taxonomy_column($columns, $column, $id)
{
	if ($column == 'thumb')
		$columns = '<span><img src="' . get_taxonomy_image_url($id, NULL, TRUE) . '" alt="' . __('缩略图', 'text-alfie') . '" class="wp-post-image" /></span>';
	return $columns;
}

function rec_change_insert_button_text($safe_text, $text)
{
	return str_replace("Insert into Post", "Use this image", $text);
}

if (strpos($_SERVER['SCRIPT_NAME'], 'edit-tags.php') > 0) {
	add_action('admin_head', 'rec_add_style');
	add_action('quick_edit_custom_box', 'rec_quick_edit_custom_box', 10, 3);
	add_filter("attribute_escape", "rec_change_insert_button_text", 10, 2);
}

function rec_options_menu()
{
	add_posts_page(__('图像设置', 'text-alfie'), __('图像设置', 'text-alfie'), 'manage_options', 'rec-options', 'rec_options');
	add_action('admin_init', 'rec_register_settings');
}
add_action('admin_menu', 'rec_options_menu');

function rec_register_settings()
{
	register_setting('rec_options', 'rec_options', 'rec_options_validate');
	add_settings_section('rec_settings', __('', 'text-alfie'), 'rec_section_text', 'rec-options');
	add_settings_field('rec_excluded_taxonomies', __('排除分类', 'text-alfie'), 'rec_excluded_taxonomies', 'rec-options', 'rec_settings');
}

function rec_section_text()
{
	echo '<p>' . __('', 'text-alfie') . '</p>';
}

function rec_excluded_taxonomies()
{
	$options = get_option('rec_options');
	$disabled_taxonomies = array('nav_menu', 'link_category', 'post_format');
	foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue;
?>
		<input type="checkbox" name="rec_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> />
		<?php echo $tax; ?> <br />
	<?php
	endforeach;
}

function rec_options_validate($input)
{
	return $input;
}

function rec_options()
{
	if (!current_user_can('manage_options'))
		wp_die(__('您没有足够的权限访问此页面。', 'text-alfie'));
	$options = get_option('rec_options');
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>
			<?php esc_html_e('分类图像设置', 'text-alfie'); ?>
		</h2>
		<form method="post" action="options.php">
			<?php settings_fields('rec_options'); ?>
			<?php do_settings_sections('rec-options'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}
