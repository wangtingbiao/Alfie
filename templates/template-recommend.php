<?php if (is_home()) : ?>

	<?php

	$alfie_rec			=	explode(",", get_theme_mod('alfie_rec', '')); // 填写自定义ID，默认显示全部
	$categories			=	get_categories(['include'	=>	$alfie_rec,]);	// 引入自定义ID
	$items				=	''; // 给定一个默认值，空

	if ($categories) { ?>
		<div id="__rec-category" class="__rec-category swiper-container main-list">
			<ul class="swiper-wrapper">
				<?php
				foreach ($categories as $category) {
					$items .= '
					<li class="swiper-slide" style="background-image: url(' . esc_url(get_taxonomy_image_url($category->term_id)) . ')">
						<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>
					</li>';
				}
				echo $items;
				?>
			</ul>
			<div class="swiper-prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
			<div class="swiper-next"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
		</div>
	<?php swiper_script_open();
	} ?>

<?php else : ?>

	<?php
	$categories			=	get_term(get_query_var('cat'), 'category'); // 父级
	$sub_categories		=	get_terms('category', 'parent=' . get_query_var('cat'));  // 子级
	$items				=	''; // 给定一个默认值，空
	if (empty($sub_categories) && $categories->parent != 0) {
		$sub_categories	=	get_terms('category', 'parent=' . $categories->parent . '');
	?>
		<div id="__rec-category" class="__rec-category swiper-container main-list">
			<ul class="swiper-wrapper">
				<?php
				foreach ($sub_categories as $subcat) {
					if ($categories->term_id == $subcat->term_id) $current = ' sub-current';
					else $current = '';
					$items .= '
					  <li class="swiper-slide cat-item-' . $subcat->term_id . $current . '" style="background-image: url(' . esc_url(get_taxonomy_image_url($subcat->term_id)) . ')">
						  <a href="' . esc_url(get_category_link($subcat->term_id)) . '">' . $subcat->name . '</a>
					  </li>';
				}
				echo $items;
				?>
			</ul>
			<div class="swiper-prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
			<div class="swiper-next"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
		</div>
	<?php
		swiper_script_open();
	}
	?>

<?php endif; ?>

<?php
function swiper_script_open()
{
	echo '
		<script>
			var __rec_category = new Swiper("#__rec-category", {
				/* 同屏数量 */
				slidesPerView: 2.5,
				/* 块间距 */
				spaceBetween: 10,
				/* free模式 */
				freeMode: true,
				/* 分页按钮 */
				navigation: {
					nextEl: ".swiper-next",
					prevEl: ".swiper-prev",
				},
				/* 分页按钮隐藏 */
				on: {
					slideChangeTransitionEnd: function() {
						if (this.isEnd) {
							this.navigation.$nextEl.css("display", "none");
						} else {
							this.navigation.$nextEl.css("display", "block");
						}
					},
				},
				/* 断点 */
				breakpoints: {
					640: {
						slidesPerView: 4.5,
						spaceBetween: 10,
					},
					992: {
						slidesPerView: 5.5,
						spaceBetween: 20,
					},
					1200: {
						slidesPerView: 6.5,
						spaceBetween: 20,
					},
					1600: {
						slidesPerView: 7.5,
						spaceBetween: 20,
					},
				},
			});
		</script>
	';
}
?>