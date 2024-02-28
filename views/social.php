<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LinkyApp\Helper\WPLinkyHelper;

$data       = WPLinkyHelper::getPageOption();
$s          = WPLinkyHelper::getOptionValue('social', $data, []);
$socials    = WPLinkyHelper::getSocials();

?>
<div class="inside">
    <form
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
            class="_js-form"
            data-success-message="<?php esc_attr_e('Setting saved', 'linky'); ?>"
    >
        <?php foreach($socials as $social): ?>
            <div class="form-field social-field">
                <label for="<?php echo esc_attr( $social ); ?>" class="<?php echo esc_attr( $social . '-color' ); ?>">
                    <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . sanitize_title($social) . '.svg' ?>
                    <?php echo esc_attr( ucfirst( $social ) ); ?>
                </label>
                <input type="text" id="<?php echo esc_attr( $social ); ?>" name="<?php echo esc_attr( sanitize_title($social) ); ?>" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue($social, $s, null, false) ); ?>">
            </div>
        <?php endforeach; ?>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php esc_html_e('Save'); ?></button>
            </div>
            <div class="clearfix"></div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="social">
    </form>
</div>
