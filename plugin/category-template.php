<?php
class Select_Category_Template
{
	public function __construct()
	{
		add_filter('category_template', array($this, 'get_custom_category_template'));
		add_action('category_edit_form_fields', array($this, 'category_template_meta_box'), 9);
		add_action('category_add_form_fields', array(&$this, 'category_template_meta_box'), 9);
		add_action('created_category', array(&$this, 'save_category_template'));
		add_action('edited_category', array($this, 'save_category_template'));
		do_action('Custom_Category_Template_constructor', $this);
	}

	public function category_template_meta_box($tag)
	{

		$t_id = $tag->term_id;

		$cat_meta = get_option("category_templates");
		$template = isset($cat_meta[$t_id]) ? $cat_meta[$t_id] : false;
?>
		<tr class="form-field">
			<th scope="row">
				<label for="cat_template">
					<?php esc_html_e('分类模板', 'text-mrw'); ?>
				</label>
			</th>
			<td>
				<select name="cat_template" id="cat_template" class="cat_template">
					<option value='default'>
						<?php esc_html_e('无', 'text-mrw'); ?>
					</option>
					<?php page_template_dropdown($template); ?>
				</select>
				<p class="description">
					<?php esc_html_e('为此分类选择一个模板', 'text-mrw'); ?>
				</p>
			</td>
		</tr>
<?php
		do_action('Custom_Category_Template_ADD_FIELDS', $tag);
	}

	public function save_category_template($term_id)
	{
		if (isset($_POST['cat_template'])) {
			$cat_meta = get_option("category_templates");
			$cat_meta[$term_id] = $_POST['cat_template'];
			update_option("category_templates", $cat_meta);
			do_action('Custom_Category_Template_SAVE_FIELDS', $term_id);
		}
	}

	function get_custom_category_template($category_template)
	{
		$cat_ID = absint(get_query_var('cat'));
		$cat_meta = get_option('category_templates');
		if (isset($cat_meta[$cat_ID]) && $cat_meta[$cat_ID] != 'default') {
			$temp = locate_template($cat_meta[$cat_ID]);
			if (!empty($temp))
				return apply_filters("Custom_Category_Template_found", $temp);
		}
		return $category_template;
	}
}

$cat_template = new Select_Category_Template();
