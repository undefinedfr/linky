<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LinkyApp\Helper\WPLinkyHelper;

$data               = WPLinkyHelper::getPageOption();
$global             = WPLinkyHelper::getOptionValue('global', $data, []);
$homeUrl            = home_url();

?>
<div class="inside">
    <form
            method="POST"
            action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
            class="_js-form"
            data-success-message="<?php esc_attr_e('Setting saved', 'linky'); ?>"
    >
        <div class="form-field">
            <label for="slug"><?php esc_attr_e('Slug URL', 'linky'); ?></label>
            <div class="link_url">
                <span style="width: <?php echo esc_attr( strlen($homeUrl) - 2 ) ?>ch"><?php echo esc_url( home_url() ); ?></span>
                <input  style="max-width: calc(100% - <?php echo esc_attr( strlen($homeUrl) - 2 ) ?>ch)" type="text" id="slug" name="slug" placeholder="linky" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('slug', $global, null, false) ); ?>">
            </div>
        </div>
        <div class="form-field">
            <label for="categories"><?php esc_html_e('Links categories', 'linky'); ?></label>
            <input type="text" id="categories" name="categories" placeholder="<?php esc_attr_e('Type category and press enter', 'linky'); ?>" class="js-choices" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('categories', $global, null, false) ); ?>">
        </div>
        <div class="form-field">
            <label for="labels"><?php esc_html_e('Links labels', 'linky'); ?></label>
            <input type="text" id="labels" name="labels" placeholder="<?php esc_html_e('Type label and press enter', 'linky'); ?>" class="js-choices" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('labels', $global, null, false) ); ?>">
        </div>
        <div class="form-field">
            <label for="code_ga"><?php esc_attr_e('Google Analytics', 'linky'); ?></label>
            <?php $code_ga_safe = WPLinkyHelper::getOptionValue('code_ga', $global, '', [WPLinkyHelper::class, 'codeFilter']) ?>
            <textarea type="text" id="code_ga" name="code_ga" placeholder="<?php esc_attr_e('Your analytics code (or other JS tag)', 'linky'); ?>"><?php echo wp_kses($code_ga_safe, 'linky'); ?></textarea>
        </div>
        <div class="form-field">
            <label for="theme_style"><?php esc_html_e('Add theme style', 'linky'); ?></label>
            <span class="minitext"><?php esc_html_e('This can create conflicts', 'linky'); ?></span>
            <?php $value = WPLinkyHelper::getOptionValue('theme_style', $global, null, false, 'attr'); ?>
            <input type="radio" id="theme_style" value="yes" name="theme_style" <?php echo esc_attr( $value == 'yes' ? 'checked' : '' ); ?>> <span><?php esc_html_e('Yes', 'linky'); ?></span>
            <input type="radio" value="no" name="theme_style" <?php echo esc_attr( empty($value) || $value == 'no' ? 'checked' : '' ); ?>> <span><?php esc_html_e('No', 'linky'); ?></span>
        </div>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php esc_html_e('Save'); ?></button>
            </div>
            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="global">
    </form>
</div>
