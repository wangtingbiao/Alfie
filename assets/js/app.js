/**
 * 主题全局脚本
 *
 * 所有页面公用，盲目切勿修改。
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
(function ($) {
	'use strict';

	var _Body = $('body'),
		_SeaBtn = $('#__sea-btn'), // 搜索按钮
		_Search = $('#__search'), // 搜索盒子
		_NavBtn = $('#__nav-btn'), // 移动菜单按钮
		_AppNav = $('#__app-nav'), // 移动菜单
		_SubMenu = $('.sub-menu'), // 移动子菜单
		_Clerk = $('#clerk'), // 在线客服
		_ToTop = $('#totop'); // 返回顶部

	/*------------------------------------------------
	  弹出搜索
	-------------------------------------------------*/
	_SeaBtn.on('click', function (e) {
		_Search.slideToggle();
		e.stopPropagation();
	});

	/*------------------------------------------------
	  浮动菜单按钮
	-------------------------------------------------*/
	_NavBtn.on('click', function (e) {
		if (_Body.hasClass('nav-active')) {
			_Body.removeClass('nav-active');
			_AppNav.slideUp();
		} else {
			_Body.addClass('nav-active');
			_AppNav.slideDown();
		}
		e.stopPropagation();
	});

	/*------------------------------------------------
	  移动菜单
	-------------------------------------------------*/
	_SubMenu.prev('a').attr('onclick', "javascript:void(0);return false;");
	_SubMenu.prev('a').on('click', function (e) {
		$(this).removeAttr('onclick').next('ul').slideDown();
		e.stopPropagation();
	});

	/*------------------------------------------------
	  返回顶部
	-------------------------------------------------*/
	_ToTop.on('click', function (e) {
		$('html,body').animate({
				scrollTop: '0',
			},
			800
		);
		e.stopPropagation();
	});

	// 距离顶部300显示->到底部隐藏
	$(window).scroll(function (e) {

		if ($(document).scrollTop() <= 300) {
			_ToTop.fadeOut();
		} else if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
			_Clerk.fadeOut();
			_ToTop.fadeOut();
		} else {
			_Clerk.fadeIn();
			_ToTop.fadeIn();
		}

		e.stopPropagation();
	});

})(jQuery);