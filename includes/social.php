<?php

/**
 * 社会化类
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
class Walker_Social_List
{
	public static function alfie_socials()
	{
		$follow_links		=	[];
		$follow_selected	=	[
			'qq'			=>	get_theme_mod('alfie_social_qq', ''),
			'weibo'			=>	get_theme_mod('alfie_social_weibo', ''),
			'behance'		=>	get_theme_mod('alfie_social_behance', ''),
			'dribbble'		=>	get_theme_mod('alfie_social_dribbble', ''),
			'github'		=>	get_theme_mod('alfie_social_github', ''),
			'vimeo'			=>	get_theme_mod('alfie_social_vimeo', ''),
			'youtube'		=>	get_theme_mod('alfie_social_youtube', ''),
		];
		foreach ($follow_selected as $c_key => $c_value) {
			$link_builder = 'alfie_link_' . $c_key;
			if ('' !== $c_key && '' !== $c_value) {
				if (filter_var($c_value, FILTER_VALIDATE_URL)) {
					$follow_links[$c_key] = self::$link_builder(sanitize_text_field(esc_url($c_value)), 'url');
				} else {
					$follow_links[$c_key] = self::$link_builder(sanitize_text_field(esc_attr($c_value)), 'username');
				}
			}
		}
		return $follow_links;
	}

	public static function alfie_link_qq($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//wpa.qq.com/msgrd?v=3&uin=' . $input . '&site=qq&menu=yes" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_weibo($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//weibo.com/' . $input . '" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_behance($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//behance.net/' . $input . '" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_dribbble($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-dribbble" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//dribbble.com/' . $input . '" target="_blank"><i class="fa fa-dribbble" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_github($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//github.com/' . $input . '" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_vimeo($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-vimeo" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//vimeo.com/' . $input . '" target="_blank"><i class="fa fa-vimeo" aria-hidden="true"></i></a>';
		}
		return $link;
	}

	public static function alfie_link_youtube($input, $type)
	{
		if ('url' === $type) {
			$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
		} else {
			$link = '<a href="//youtube.com/channel/' . $input . '" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
		}
		return $link;
	}
}
