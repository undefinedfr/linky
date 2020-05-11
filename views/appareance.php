<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use \LinkyApp\Helpers\WPLinkyHelper;
$data = WPLinkyHelper::getPageOption();
$appareance = WPLinkyHelper::getOptionValue('appareance', $data, []);
$menus = wp_get_nav_menus();

?>
<div class="inside">
    <form
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', UNDFND_WP_LINKY_DOMAIN); ?>"
    >
        <div class="form-field">
            <label for="avatar"><?php echo __('Avatar', UNDFND_WP_LINKY_DOMAIN); ?></label>
<!--            <input type="file" name="_avatar">-->
            <input type="text" id="avatar" name="avatar" value="<?php echo WPLinkyHelper::getOptionValue('avatar', $appareance); ?>">
        </div>
        <div class="form-field">
            <label for="title"><?php echo __('Title', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <input type="text" id="title" name="title" placeholder="<?php echo get_bloginfo('name') ?>" value="<?php echo WPLinkyHelper::getOptionValue('title', $appareance); ?>">
        </div>
        <div class="form-control">
            <div class="form-field">
                <label for="color"><?php echo __('Text color', UNDFND_WP_LINKY_DOMAIN); ?></label>
                <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('text_color', $appareance, '#000'); ?>"></div>
                <input type="text" id="text_color" name="text_color" value="<?php echo WPLinkyHelper::getOptionValue('text_color', $appareance, '#000'); ?>">
            </div>
            <div class="form-field">
                <label for="background_color"><?php echo __('Background color', UNDFND_WP_LINKY_DOMAIN); ?></label>
                <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF'); ?>"></div>
                <input type="text" id="background_color" name="background_color" value="<?php echo WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF'); ?>">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-field">
            <label for="social_display"><?php echo __('Display socials links with menu', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <span class="minitext"><?php echo __('By default, socials links are visible everytime', UNDFND_WP_LINKY_DOMAIN); ?></span>
            <input type="radio" id="social_display" value="yes" name="social_display" <?php echo WPLinkyHelper::getOptionValue('social_display', $appareance) == 'yes' ? 'checked' : ''; ?>> <span><?php echo __('Yes', UNDFND_WP_LINKY_DOMAIN); ?></span>
            <input type="radio" value="no" name="social_display" <?php echo WPLinkyHelper::getOptionValue('social_display', $appareance) == 'no' ? 'checked' : ''; ?>> <span><?php echo __('No', UNDFND_WP_LINKY_DOMAIN); ?></span>
        </div>
        <div class="form-field">
            <label for="menu"><?php echo __('Menu', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <select name="menu" id="menu">
                <option value=""></option>
                <?php foreach($menus as $menu): ?>
                    <option value="<?php echo $menu->term_id; ?>" <?php echo WPLinkyHelper::getOptionValue('menu', $appareance) == $menu->term_id ? 'selected' : ''; ?>><?php echo $menu->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
            </div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="appareance">
    </form>
</div>