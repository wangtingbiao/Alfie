<?php

/**
 * 自定义忘记密码页面
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
<div class="user-column">

    <?php
    if ($attributes['show_title']) {
        echo '<h3>' . esc_html__('忘记密码了吗？', 'text-alfie') . '</h3>';
    }

    if (count($attributes['errors']) > 0) {
        foreach ($attributes['errors'] as $error) :
            echo '<p class="user-error">' . $error . '</p>';
        endforeach;
    }
    ?>

    <p>
        <?php esc_html_e('输入您的邮箱，我们将向您发送一个链接，您可以使用该链接设置一个新密码。', 'text-alfie'); ?>
    </p>

    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
        <p>
            <label for="user_login"><?php esc_html_e('邮箱', 'text-alfie'); ?></label>
            <input type="text" name="user_login" id="user_login">
        </p>
        <p>
            <input type="submit" name="submit" value="<?php esc_attr_e('找回密码', 'text-alfie'); ?>" id="wp-submit" />
        </p>
    </form>

    <div class="__reg-log">
        <a class="__reglog-btn" href="<?php echo admin_url('login'); ?>">
            <?php esc_html_e('登陆', 'text-alfie'); ?>
        </a>
        <a class="__reglog-btn" href="<?php echo admin_url('register'); ?>">
            <?php esc_html_e('注册', 'text-alfie'); ?>
        </a>
    </div>
</div>