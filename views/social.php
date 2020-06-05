<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;

$data       = WPLinkyHelper::getPageOption();
$s          = WPLinkyHelper::getOptionValue('social', $data, []);
$socials    = WPLinkyHelper::getSocials();

?>
<div class="inside">
    <form
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', 'linky'); ?>"
    >
        <?php foreach($socials as $social): ?>
            <div class="form-field social-field">
                <label for="<?php echo $social; ?>" class="<?php echo $social . '-color'; ?>">
                    <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . sanitize_title($social) . '.svg' ?>
                    <?php echo ucfirst(__($social, 'linky')); ?>
                </label>
                <input type="text" id="<?php echo $social; ?>" name="<?php echo sanitize_title($social); ?>" value="<?php echo WPLinkyHelper::getOptionValue($social, $s); ?>">
            </div>
        <?php endforeach; ?>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
            </div>
            <div class="clearfix"></div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="social">
    </form>
</div>