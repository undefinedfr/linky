<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;
use LinkyApp\Helper\ThemesHelper;

$data                   = WPLinkyHelper::getPageOption();
$themes                 = WPLinkyHelper::getOptionValue('themes', $data, []);
$defaultHeaderThemes    = ThemesHelper::getHeaderThemes();
$defaultBodyThemes      = ThemesHelper::getBodyThemes();
?>

<div class="inside no-gutter no-margin">
    <div class="info-message"><?php echo __('Choose a theme and customize it in Appareance tab', 'linky'); ?></div>
    <form
            id="themes"
            method="POST"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', 'linky'); ?>"
    >
        <div class="form-control">
            <label for="header_theme_default"><?php echo __('Header Theme', 'linky'); ?></label>
            <?php foreach($defaultHeaderThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('header_theme', $themes, 'default') == $themeId) ?>
                    <div class="theme-input <?php echo $checked ? 'is-checked' : ''; ?>">
                        <div class="theme-input__image">
                            <img src="<?php echo $theme->getImageSrc(); ?>" alt="">
                        </div>
                        <input type="radio" id="header_theme_<?php echo $themeId ?>" name="header_theme" value="<?php echo $themeId ?>" <?php echo $checked ? 'checked' : ''; ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-control">
            <label for="body_theme_0"><?php echo __('Body Theme', 'linky'); ?></label>
            <?php foreach($defaultBodyThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('body_theme', $themes, 'default') == $themeId) ?>
                    <div class="theme-input <?php echo $checked ? 'is-checked' : ''; ?>">
                        <div class="theme-input__image">
                            <img src="<?php echo $theme->getImageSrc(); ?>" alt="">
                        </div>
                        <input type="radio" id="body_theme_<?php echo $themeId ?>" name="body_theme" value="<?php echo $themeId ?>" <?php echo $checked ? 'checked' : ''; ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-large js-override" data-override="true"><?php echo __('Save and overwrite appareance', 'linky'); ?></button>
                <button type="submit" class="button button-primary button-large js-override" data-override="false"><?php echo __('Save'); ?></button>
            </div>
            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_override" value="false">
        <input type="hidden" name="_group" value="themes">
    </form>
</div>