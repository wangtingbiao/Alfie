<?php

$no_search		=	esc_html__('抱歉，请尝试换一个词搜索。', 'text-alfie');
$no_tag			=	esc_html__('抱歉，请返回上一页继续浏览。', 'text-alfie');
$no_article		=	esc_html__('抱歉，暂时还没有任何文章。', 'text-alfie');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('enty-list'); ?>>
	<?php
	if (is_search()) {
		echo $no_search;
	} elseif (is_tag()) {
		echo $no_tag;
	} else {
		echo $no_article;
	}
	?>
</article>