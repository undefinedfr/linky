<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use \LinkyApp\Helpers\WPLinkyHelper;
$data = WPLinkyHelper::getPageOption();
$s = WPLinkyHelper::getOptionValue('social', $data, []);
$socials = WPLinkyHelper::getSocials();

?>
<div class="inside">
    <form
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', UNDFND_WP_LINKY_DOMAIN); ?>"
    >
        <?php foreach($socials as $social): ?>
            <div class="form-field">
                <label for="<?php echo $social; ?>"><?php echo ucfirst(__($social, UNDFND_WP_LINKY_DOMAIN)); ?></label>
                <input type="text" id="<?php echo $social; ?>" name="<?php echo sanitize_title($social); ?>" value="<?php echo WPLinkyHelper::getOptionValue($social, $s); ?>">
            </div>
        <?php endforeach; ?>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
            </div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="social">
    </form>
</div>