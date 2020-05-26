<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;

$data               = WPLinkyHelper::getPageOption();
$defaultLabels      = WPLinkyHelper::getDefaultLabels();
$defaultCategories  = WPLinkyHelper::getDefaultCategories();
$global             = WPLinkyHelper::getOptionValue('global', $data, []);
$homeUrl            = home_url();

?>
<div class="inside">
    <form
            method="POST"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Setting saved', UNDFND_WP_LINKY_DOMAIN); ?>"
    >
        <div class="form-field">
            <label for="slug"><?php echo __('Slug URL', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <div class="link_url">
                <span style="width: <?php echo strlen($homeUrl) - 2 ?>ch"><?php echo home_url(); ?></span>
                <input  style="max-width: calc(100% - <?php echo strlen($homeUrl) - 2 ?>ch)" type="text" id="slug" name="slug" placeholder="linky" value="<?php echo WPLinkyHelper::getOptionValue('slug', $global); ?>">
            </div>
        </div>
        <div class="form-field">
            <label for="categories"><?php echo __('Links categories', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <input type="text" id="categories" name="categories" placeholder="<?php echo __('Type category and press enter', UNDFND_WP_LINKY_DOMAIN); ?>" class="js-choices" value="<?php echo WPLinkyHelper::getOptionValue('categories', $global, $defaultCategories); ?>">
        </div>
        <div class="form-field">
            <label for="labels"><?php echo __('Links labels', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <input type="text" id="labels" name="labels" placeholder="<?php echo __('Type label and press enter', UNDFND_WP_LINKY_DOMAIN); ?>" class="js-choices" value="<?php echo WPLinkyHelper::getOptionValue('labels', $global, $defaultLabels); ?>">
        </div>
        <div class="form-field">
            <label for="code_ga"><?php echo __('Google Analytics', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <textarea type="text" id="code_ga" name="code_ga" placeholder="<?php echo __('Your analytics code (or other JS tag)', UNDFND_WP_LINKY_DOMAIN); ?>"><?php echo WPLinkyHelper::getOptionValue('code_ga', $global, '', [WPLinkyHelper::class, 'codeFilter']); ?></textarea>
        </div>
        <div class="form-field">
            <label for="theme_style"><?php echo __('Add theme style', UNDFND_WP_LINKY_DOMAIN); ?></label>
            <span class="minitext"><?php echo __('This can create conflicts', UNDFND_WP_LINKY_DOMAIN); ?></span>
            <?php $value = WPLinkyHelper::getOptionValue('theme_style', $global); ?>
            <input type="radio" id="theme_style" value="yes" name="theme_style" <?php echo $value == 'yes' ? 'checked' : ''; ?>> <span><?php echo __('Yes', UNDFND_WP_LINKY_DOMAIN); ?></span>
            <input type="radio" value="no" name="theme_style" <?php echo empty($value) || $value == 'no' ? 'checked' : ''; ?>> <span><?php echo __('No', UNDFND_WP_LINKY_DOMAIN); ?></span>
        </div>

        <div class="form-field">
            <div class="pull-right">
                <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
            </div>
        </div>

        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="global">
    </form>
</div>
