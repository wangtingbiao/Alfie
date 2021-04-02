<?php

/**
 * 帖子页模板文件
 *
 * 这是WordPress主题中最通用的模板文件，一般作为默认文章模板
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
get_header();

$alfie_posts_pic_mobile_switch		=	get_theme_mod('alfie_posts_pic_mobile_switch', '');
$alfie_posts_share					=	esc_html(get_theme_mod('alfie_posts_share', 'weibo,qq,wechat,tencent,qzone'));
$alfie_posts_copytight_switch		=	get_theme_mod('alfie_posts_copytight_switch', '');
$alfie_posts_copytight				=	wp_kses_post(get_theme_mod('alfie_posts_copytight', __('本文是从Internet上收集的，版权属于原始作者或组织 如果此文章侵犯了您的权益，请通过邮箱<a href="mailto:hi@name.com">hi@name.com</a>与我们联系！', 'text-alfie')));

?>
<div class="max-w-2">
	<?php alfie_get_breadcrumbs(); ?>
	<div class="__post_page __post __layout">
		<?php while (have_posts()) : the_post(); ?>
			<?php if ($alfie_posts_pic_mobile_switch or !is_mobile_device()) : ?>
				<figure class="layout-full enty-pic">
					<?php alfie_get_large_thumbnail_img(); ?>
				</figure>
			<?php endif; ?>
			<article class="layout-left enty-conent" role="main">
				<div class="enty-box">
					<?php
					// 标题
					the_title('<h3 class="enty-title">', '</h3>');

					/* 编辑 */
					edit_post_link(esc_html__('编辑', 'text-alfie'));

					// 元数据
					alfie_get_post_meta();

					// 主体内容
					the_content();

					// 内容分页
					$link_pages		=	[
						'before'	=>	'<p class="__next wp-block-next">',
						'after'		=>	'</p>',
					];
					wp_link_pages($link_pages);
					?>
				</div>
			</article>
			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="layout-full enty-comment">
					<div class="enty-box">
						<?php comments_template(); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
		<aside class="layout-right enty-aside" role="complementary">
			<div class="enty-box">
				<div class="enty-link">
					<a id="enty-share" class="blue-btn-2">
						<?php esc_html_e('分享', 'text-alfie'); ?>
						<div class="enty-share share-component" data-sites="<?php echo $alfie_posts_share; ?>"></div>
					</a>
					<a id="enty-like" class="red-btn-2 enty-like<?php if (isset($_COOKIE['like_ding_' . $post->ID])) { echo ' done'; } ?>" οnclick="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>">
						<i class="fa<?php if (isset($_COOKIE['like_ding_' . $post->ID])) { echo ' fa-heart'; } else { echo ' fa-heart-o'; } ?>" aria-hidden="true"></i>
						<span class="count"><?php if (get_post_meta($post->ID, 'like_ding', true)) { echo absint(get_post_meta($post->ID, 'like_ding', true)); } else { echo absint('0');} ?></span>
					</a>
				</div>
				<?php the_tags('<div class="enty-tags"><h3>' . esc_html__('标签', 'text-alfie') . '</h3>', ' ', '</div>'); ?>
				<?php if ($alfie_posts_copytight_switch) : ?>
					<div class="enty-desc">
						<?php echo $alfie_posts_copytight; ?>
					</div>
				<?php endif; ?>
			</div>
		</aside>
	</div>
	<?php alfie_get_related_articles();	?>
</div>
<?php get_footer(); ?>