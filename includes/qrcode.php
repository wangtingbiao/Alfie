<?php

/**
 * 头部二维码类
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
class Walker_Qrcode_List
{
	public static function alfie_qrcodes()
	{
		$qrcode_links		=	[];
		$qrcode_selected	=	[
			'img_1'			=>	get_theme_mod('alfie_qrcode_img_1', ''),
			'img_2'			=>	get_theme_mod('alfie_qrcode_img_2', ''),
			'img_3'			=>	get_theme_mod('alfie_qrcode_img_3', ''),
		];
		foreach ($qrcode_selected as $c_key => $c_value) {
			$img_builder = 'alfie_' . $c_key;
			if ('' !== $c_key && '' !== $c_value) {
				if (filter_var($c_value, FILTER_VALIDATE_URL)) {
					$qrcode_links[$c_key] = self::$img_builder(sanitize_text_field(esc_url($c_value)), 'url');
				}
			}
		}
		return $qrcode_links;
	}

	public static function alfie_img_1($input, $type)
	{
		if ('url' === $type) {
			$img = '<img src="' . $input . '">';
		}
		return $img;
	}

	public static function alfie_img_2($input, $type)
	{
		if ('url' === $type) {
			$img = '<img src="' . $input . '">';
		}
		return $img;
	}

	public static function alfie_img_3($input, $type)
	{
		if ('url' === $type) {
			$img = '<img src="' . $input . '">';
		}
		return $img;
	}
}
