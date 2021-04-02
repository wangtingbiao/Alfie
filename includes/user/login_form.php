<?php

/**
 * 自定义登录页面
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
<div class="user-column">
    <?php if (true) : ?>

        <?php
        if ($attributes['show_title']) {
            echo '<h3>' . esc_html__('登录', 'text-alfie') . '</h3>';
        }

        if (count($attributes['errors']) > 0) {
            foreach ($attributes['errors'] as $error) :
                echo '<p class="user-error">' . $error . '</p>';
            endforeach;
        }

        if ($attributes['logged_out']) {
            echo '<p class="login-info">' . esc_html__('您已退出，您要重新登录吗？', 'text-alfie') . '</p>';
        }

        if ($attributes['registered']) {
            echo '<p class="login-info">' . sprintf(__('您已在%s成功注册。 我们已经将相关信息发送到您输入的邮箱地址。', 'text-alfie'), get_bloginfo('name')) . '</p>';
        }

        if ($attributes['lost_password_sent']) {
            echo '<p class="login-info">' . esc_html__('检查您的邮箱以获取重置密码的链接。', 'text-alfie') . '</p>';
        }

        if ($attributes['password_updated']) {
            echo '<p class="login-info">' . esc_html__('您的密码已被更改。 您可以立即登录。', 'text-alfie') . '</p>';
        }

        wp_login_form(
            [
                'redirect' => $attributes['redirect'],
            ]
        );
        ?>

        <div class="__reg-log">
            <a class="__reglog-btn" href="<?php echo admin_url('register'); ?>">
                <?php esc_html_e('注册', 'text-alfie'); ?>
            </a>
            <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
                <?php esc_html_e('忘记密码？', 'text-alfie'); ?>
            </a>
        </div>
    <?php else : ?>
        <form method="post" action="<?php echo wp_login_url(); ?>">
            <p>
                <label for="user_login"><?php esc_html_e('邮箱', 'text-alfie'); ?></label>
                <input type="text" name="log" id="user_login">
            </p>
            <p>
                <label for="user_pass"><?php esc_html_e('密码', 'text-alfie'); ?></label>
                <input type="password" name="pwd" id="user_pass">
            </p>
            <p>
                <input type="submit" value="<?php esc_attr_e('登录', 'text-alfie'); ?>" id="wp-submit">
            </p>
        </form>
    <?php endif; ?>
</div>