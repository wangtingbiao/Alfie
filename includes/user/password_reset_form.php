<?php

/**
 * 自定义重置密码页面
 *
 * @package Chief Wang
 * @link https://www.wangtingbiao.com
 */
?>
<div class="user-column">

    <?php
    if ($attributes['show_title']) {
        echo '<h3>' . esc_html__('输入一个新密码', 'text-alfie') . '</h3>';
    }
    ?>

    <form name="resetpassform" id="resetpassform" action="<?php echo site_url('wp-login.php?action=resetpass'); ?>" method="post" autocomplete="off">
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr($attributes['login']); ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo esc_attr($attributes['key']); ?>" />

        <?php
        if (count($attributes['errors']) > 0) {
            foreach ($attributes['errors'] as $error) :
                echo '<p class="user-error">' . $error . '</p>';
            endforeach;
        }
        ?>

        <p>
            <label for="pass1"><?php esc_html_e('新密码', 'text-alfie') ?></label>
            <input type="password" name="pass1" id="pass1" size="20" value="" autocomplete="off" />
        </p>
        <p>
            <label for="pass2"><?php esc_html_e('确认新密码', 'text-alfie') ?></label>
            <input type="password" name="pass2" id="pass2" size="20" value="" autocomplete="off" />
        </p>
        <p>
            <?php esc_html_e('提示：密码应该至少6个字符长。要创建强密码，请使用大写和小写字母、数字、以及符号。', 'text-alfie'); ?>
        </p>
        <p>
            <input type="submit" name="submit" value="<?php esc_attr_e('重置密码', 'text-alfie'); ?>" id="wp-submit" />
        </p>
    </form>
</div>