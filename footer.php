<?php

/**
 * 主题全局页脚
 *
 * 包含 #content div 和其后所有内容的关闭。
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
</main>
<footer class="__app-footer" role="contentinfo">
	<?php
	// 页脚上部
	alfie_get_foo_top();

	// 页脚下部
	alfie_get_foo_bot();
	?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>