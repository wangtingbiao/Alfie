<?php

$alfie_swiper_select				=	esc_html(get_theme_mod('alfie_swiper_select', 'category'));
$alfie_swiper_category_id			=	explode(",", get_theme_mod('alfie_swiper_category_id', ''));
$alfie_swiper_category_post_number	=	absint(get_theme_mod('alfie_swiper_category_post_number', 5));
$alfie_swiper_post_id				=	explode(",", get_theme_mod('alfie_swiper_post_id', ''));
$alfie_swiper_post_link				=	esc_html__('查看详情', 'text-alfie');

if ($alfie_swiper_select == 'category') {
	$swiper_query					=	[
		'ignore_sticky_posts'		=>	true,
		'cat'						=>	$alfie_swiper_category_id,
		'posts_per_page'			=>	$alfie_swiper_category_post_number,
	];
} elseif ($alfie_swiper_select == 'article') {
	$swiper_query					=	[
		'ignore_sticky_posts'		=>	true,
		'post__in'					=>	$alfie_swiper_post_id,
	];
};

$swipers_query = new WP_Query($swiper_query);
if ($swipers_query->have_posts()) {
?>
	<div class="__poster swiper-container main-list" itemprop="ItemPage">
		<ul class="swiper-wrapper">
			<?php while ($swipers_query->have_posts()) : $swipers_query->the_post(); ?>
				<li class="swiper-slide">
					<?php alfie_get_large_thumbnail_img(); ?>
					<div class="enty-box">
						<?php the_title('<h3 class="enty-title" data-swiper-parallax="-600" data-swiper-parallax-duration="600"><a href="' . esc_url(get_permalink()) . '">', '</a></h3>'); ?>
						<p class="enty-link blue-btn" data-swiper-parallax="-300" data-swiper-parallax-duration="600">
							<a href="<?php the_permalink(); ?>">
								<?php $alfie_swiper_post_link; ?>
							</a>
						</p>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
		<div class="swiper-pagination"></div>
	</div>
	<div class="__poster-thumb swiper-container">
		<ul class="swiper-wrapper">
			<?php while ($swipers_query->have_posts()) : $swipers_query->the_post(); ?>
				<li class="swiper-slide">
					<?php the_post_thumbnail('alfie-small'); ?>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<script type="text/javascript">
		var __poster_thumb = new Swiper('.__poster-thumb', {
			/* 同屏数量 */
			slidesPerView: 2.5,
			/* 小手 */
			grabCursor: true,
			/* 断点 */
			breakpoints: {
				640: {
					slidesPerView: 3.5,
				},
				992: {
					slidesPerView: 5,
				},
			},
		});
		var __poster = new Swiper('.__poster', {
			/* 视差效果 */
			parallax: true,
			/* 分页 */
			pagination: {
				el: '.swiper-pagination',
				type: 'progressbar',
			},
			/* 缩略图 */
			thumbs: {
				swiper: __poster_thumb,
			},
		});
	</script>
<?php
}
wp_reset_postdata();
?>