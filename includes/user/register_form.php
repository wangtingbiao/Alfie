<?php

/**
 * 自定义注册页面
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
<div class="user-column">

    <?php
    if ($attributes['show_title']) {
        echo '<h3>' . esc_html__('注册', 'text-alfie') . '</h3>';
    }
    if (count($attributes['errors']) > 0) {
        foreach ($attributes['errors'] as $error) :
            echo '<p class="user-error">' . $error . '</p>';
        endforeach;
    }
    ?>

    <form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
        <p>
            <label for="login"><?php esc_html_e('用户名', 'text-alfie'); ?></label>
            <input type="text" name="login" id="login">
        </p>
        <p>
            <label for="email"><?php esc_html_e('邮箱', 'text-alfie'); ?></label>
            <input type="text" name="email" id="email">
        </p>
        <p>
            <label for="password"><?php esc_html_e('密码', 'text-alfie'); ?></label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <label for="repeat_password"><?php esc_html_e('确认密码', 'text-alfie'); ?></label>
            <input type="password" name="repeat_password" id="repeat_password">
        </p>
        <p>
            <input type="submit" name="submit" value="<?php esc_attr_e('注册', 'text-alfie'); ?>" id="wp-submit" />
        </p>
    </form>

    <div class="__reg-log">
        <a href="<?php echo admin_url('login'); ?>">
            <?php esc_html_e('登录', 'text-alfie'); ?>
        </a>
        <a href="<?php echo wp_lostpassword_url(); ?>">
            <?php esc_html_e('忘记密码？', 'text-alfie'); ?>
        </a>
    </div>
</div>