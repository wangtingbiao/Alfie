<?php

/**
 * 用于显示评论的模板
 *
 * 这是显示页面区域的模板，该区域包含当前评论和评论表单。
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */

/*
 * 如果当前帖子受密码保护，而访问者尚未输入密码，我们将在不加载评论的情况下尽早返回。
 */
if (post_password_required()) {
	return;
}

if ($comments) {
	if (have_comments()) {
?>
		<div id="comments" class="comments">
			<h2 class="comment-reply-title">
				<?php

				$comments_number		=	absint(get_comments_number());

				if (have_comments()) {
					esc_html__('发表评论', 'text-alfie');
				} elseif (1 === $comments_number) {
					esc_html__('1 评论', 'text-alfie');
				} else {
					esc_html__($comments_number, ' 评论', 'text-alfie');
				}

				?>
			</h2>
			<?php

			wp_list_comments(
				[
					'walker'			=>	new Walker_Comment_List(),
					'avatar_size'		=>	60,
					'style'				=>	'div',
				]
			);

			echo '<div class="__next">';
			paginate_comments_links(
				[
					'prev_text'			=>	'<i class="fa fa-angle-left" aria-hidden="true"></i> ',
					'next_text'			=>	'<i class="fa fa-angle-right" aria-hidden="true"></i>',
				]
			);
			echo '</div>';

			?>
		</div>
	<?php
	}
}
if (comments_open()) {

	$comment_author			=	esc_html__('名称*', 'text-alfie');
	$comment_email			=	esc_html__('邮箱*', 'text-alfie');
	$comment_url			=	esc_html__('网址', 'text-alfie');
	$comment_body			=	esc_html__('你熬夜有什么用，又没人陪你聊天，早点休息吧！(๑•̀ㅂ•́)و✧', 'text-alfie');

	$class_submit			=	esc_attr('blue-btn-2');
	$label_submit			=	esc_html__('发表评价', 'text-alfie');
	$title_reply			=	esc_html__('点评一下', 'text-alfie');

	comment_form(
		[
			'fields'			=>	[
				'author'		=>	'<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . $comment_author . '" aria-required="true"></p>',
				'email'			=>	'<p class="comment-form-email"><input id="email" name="email" type="email" placeholder="' . $comment_email . '" aria-required="true"></p>',
				'url'			=>	'<p class="comment-form-url"><input id="url" name="url" type="url" placeholder="' . $comment_url . '"></p>',
			],

			'comment_field'		=>	'<p class="comment-form-comment"><textarea id="comment" name="comment" rows="4" placeholder="' . $comment_body . '" aria-required="true"></textarea></p>',
			'class_submit'		=>	$class_submit,
			'label_submit'		=>	$label_submit,
			'title_reply'		=>	$title_reply,
		]
	);
} else {
	?>
	<div class="comment-respond" id="respond">
		<p class="comments-closed">
			<?php esc_html_e('评论被关闭', 'text-alfie'); ?>
		</p>
	</div>
<?php
}
