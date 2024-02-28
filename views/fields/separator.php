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
$id         = WPLinkyHelper::getRandomIdentifier();
$appareance = WPLinkyHelper::getOptionValue('appareance', $data, []);
$active     = $this->get('active', 'yes');
?>
<div class="link link--separator <?php echo esc_attr( $active == 'no' ? 'is-hidden' : '' ); ?>">
    <div class="link__active <?php echo esc_attr( $active == 'no' ? 'is-hidden' : '' ); ?>">
        <input type="hidden" name="links[active][]" value="<?php echo esc_attr( $active ); ?>">
        <input type="checkbox" <?php echo esc_attr( ($active  == 'yes') ? 'checked' : '' ); ?>>
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/onoff.svg'?>
    </div>
    <div class="link__sort">
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/drag.svg'?>
    </div>
    <div class="link__body">
        <div class="link__label-link form-field">
            <input type="text" name="links[label_link][]" placeholder="<?php esc_attr_e('Enter separator label', 'linky'); ?>" value="<?php echo esc_attr( $this->get('label_link') ); ?>">
        </div>

        <div class="link__delete" data-tooltip="<?php esc_attr_e('Delete', 'linky'); ?>">
            <label class="_js-delete" for="links_delete_<?php echo esc_attr( $id ) ?>"><?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/trash.svg'?></label>
            <input type="hidden" name="links[_delete][]" id="links_delete_<?php echo esc_attr( $id ) ?>" value="no">
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="link__customize">
        <div class="v-center">
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php esc_attr_e('Color', 'linky'); ?>" data-initialcolor="<?php echo esc_attr( $this->get('border_color', WPLinkyHelper::getOptionValue('separator_color', $appareance, '#cccccc', false)) ); ?>" data-property="sepColor" ></div>
                <input type="hidden" name="links[border_color][]" value="">
            </div>
        </div>
    </div>

    <?php // rest
    foreach(['color', 'size', 'link', 'image', 'category', 'label', 'background_color'] as $val): ?>
        <input type="hidden" name="links[<?php echo esc_attr( $val ) ?>][]" value="null">
    <?php endforeach; ?>
    <input type="hidden" name="links[type][]" value="separator">
</div>
