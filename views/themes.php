<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use \LinkyApp\Helpers\WPLinkyHelper;
use \LinkyApp\Helpers\ThemesHelper;
$data = WPLinkyHelper::getPageOption();
$themes = WPLinkyHelper::getOptionValue('themes', $data, []);
$defaultHeaderThemes = ThemesHelper::getHeaderThemes();
$defaultBodyThemes = ThemesHelper::getBodyThemes();

?>
<div class="inside">
    <form
            method="POST"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', UNDFND_WP_LINKY_DOMAIN); ?>"
    >
        <div class="form-control">
            <label for="header_theme_0"><?php echo __('Header Theme', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <?php foreach($defaultHeaderThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('header_theme', $themes) == $themeId) ?>
                    <div class="theme-input <?php echo $checked ? 'is-checked' : ''; ?>">
                        <img src="<?php echo UNDFND_WP_LINKY_PLUGIN_URL . '/assets/images/themes/header/header-' . $themeId . '.png'; ?>" alt="">
                        <input type="radio" id="header_theme_<?php echo $themeId ?>" value="yes" name="header_theme" value="<?php echo $themeId ?>" <?php echo $checked ? 'checked' : ''; ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-control">
            <label for="body_theme_0"><?php echo __('Body Theme', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <?php foreach($defaultBodyThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('body_theme', $themes) == $themeId) ?>
                    <div class="theme-input <?php echo $checked ? 'is-checked' : ''; ?>">
                        <img src="<?php echo UNDFND_WP_LINKY_PLUGIN_URL . '/assets/images/themes/body/body-' . $themeId . '.png'; ?>" alt="">
                        <input type="radio" id="body_theme_<?php echo $themeId ?>" value="yes" name="body_theme" value="<?php echo $themeId ?>" <?php echo WPLinkyHelper::getOptionValue('body_theme', $themes) == $themeId ? 'checked' : ''; ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
            </div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="themes">
    </form>
</div>