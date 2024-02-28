<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LinkyApp\Helper\WPLinkyHelper;
use LinkyApp\Helper\ThemesHelper;

$data                   = WPLinkyHelper::getPageOption();
$themes                 = WPLinkyHelper::getOptionValue('themes', $data, []);
$defaultHeaderThemes    = ThemesHelper::getHeaderThemes();
$defaultBodyThemes      = ThemesHelper::getBodyThemes();
?>

<div class="inside no-gutter no-margin">
    <div class="info-message"><?php esc_html_e('Choose a theme and customize it in Appearance tab', 'linky'); ?></div>
    <form
            id="themes"
            method="POST"
            action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
            class="_js-form"
            data-success-message="<?php esc_attr_e('Setting saved', 'linky'); ?>"
    >
        <div class="form-control">
            <label for="header_theme_default"><?php esc_html_e('Header Theme', 'linky'); ?></label>
            <?php foreach($defaultHeaderThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('header_theme', $themes, 'default', false, 'attr') == $themeId) ?>
                    <div class="theme-input <?php echo esc_attr( $checked ? 'is-checked' : '' ); ?>">
                        <div class="theme-input__image">
                            <img src="<?php echo esc_attr( $theme->getImageSrc() ); ?>" alt="">
                        </div>
                        <input type="radio" id="header_theme_<?php echo esc_attr( $themeId ) ?>" name="header_theme" value="<?php echo esc_attr( $themeId ) ?>" <?php echo esc_attr( $checked ? 'checked' : '' ); ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-control">
            <label for="body_theme_0"><?php esc_html_e('Body Theme', 'linky'); ?></label>
            <?php foreach($defaultBodyThemes as $themeId => $theme): ?>
                <div class="form-field">
                    <?php $checked = (WPLinkyHelper::getOptionValue('body_theme', $themes, 'default', false, 'attr') == $themeId) ?>
                    <div class="theme-input <?php echo esc_attr( $checked ? 'is-checked' : '' ); ?>">
                        <div class="theme-input__image">
                            <img src="<?php echo esc_url( $theme->getImageSrc() ); ?>" alt="">
                        </div>
                        <input type="radio" id="body_theme_<?php echo esc_attr( $themeId ) ?>" name="body_theme" value="<?php echo esc_attr( $themeId ) ?>" <?php echo esc_attr( $checked ? 'checked' : '' ); ?>>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="clearfix"></div>
        </div>
        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-large js-override" data-override="true"><?php esc_html_e('Save and overwrite appearance', 'linky'); ?></button>
                <button type="submit" class="button button-primary button-large js-override" data-override="false"><?php esc_html_e('Save'); ?></button>
            </div>
            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_override" value="false">
        <input type="hidden" name="_group" value="themes">
    </form>
</div>
