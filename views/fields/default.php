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
$appareance         = WPLinkyHelper::getOptionValue('appareance', $data, []);
$id                 = WPLinkyHelper::getRandomIdentifier();
$active             = $this->get('active', 'yes');
$size               = $this->get('size', 100);
?>
<div class="link <?php echo esc_attr( $active == 'no' ? 'is-hidden' : '' ); ?> <?php echo esc_attr( $size == 50 ? 'half-size' : '' ); ?>">
    <div class="link__active">
        <input type="hidden" name="links[active][]" value="<?php echo esc_attr( $active ); ?>">
        <input type="checkbox" <?php echo esc_attr( ($active  == 'yes') ? 'checked' : '' ); ?>>
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/onoff.svg'?>
    </div>
    <div class="link__sort">
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/drag.svg'?>
    </div>
    <div class="link__body">
        <div class="form-control">
            <div class="link__category form-field">
                <?php $categories = explode(',', WPLinkyHelper::getOptionValue('categories', $global)); ?>
                <select name="links[category][]">
                    <option <?php echo esc_attr( empty($this->get('category')) ? 'selected' : '' ); ?> value=""><?php esc_attr_e('No category', 'linky'); ?></option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo esc_attr( $category ); ?>" <?php echo esc_attr( ($this->get('category') == $category) ? 'selected' : '' ); ?>><?php echo esc_html( $category ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="link__label form-field">
                <?php $labels = explode(',', WPLinkyHelper::getOptionValue('labels', $global)); ?>
                <select name="links[label][]">
                    <option <?php echo esc_attr( empty($this->get('label')) ? 'selected' : '' ); ?> value=""><?php esc_attr_e('No label', 'linky'); ?></option>
                    <?php foreach($labels as $label): ?>
                        <option value="<?php echo esc_attr($label); ?>" <?php echo esc_attr( ($this->get('label') == $label) ? 'selected' : '' ); ?>><?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-control form-control--upload">
            <div class="form-field">
                <?php
                /* @var $image \LinkyApp\Entity\Image */
                $image = $this->get('image');
                ?>
                <div class="image-uploader <?php echo esc_attr( !empty($image) ? 'is-filled' : '' ); ?>" <?php echo !empty($image) ? 'style="background-image: url(' . esc_url( $image->getImageUrl('thumbnail') ) . ')"' : ''; ?>>
                    <input type="hidden" name="links[image][]"  value="<?php echo esc_attr( !empty($image) ? $image->id : '' ); ?>">
                    <button class="_js-remove-image" title="<?php esc_attr_e('Remove'); ?>"></button>
                </div>
            </div>
            <div class="form-field">
                <div class="link__label-link form-field">
                    <input type="text" name="links[label_link][]" autocomplete="off" placeholder="<?php esc_attr_e('Enter link label', 'linky'); ?>" value="<?php echo esc_attr( $this->get('label_link') ); ?>">
                    <div class="link__autocomplete"></div>
                </div>
                <div class="link__link form-field">
                    <input type="text" name="links[link][]" placeholder="<?php echo esc_attr( home_url() . '/my-best-blog-post' ); ?>" value="<?php echo esc_attr( $this->get('link') ); ?>">
                </div>
            </div>
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
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php esc_attr_e('Border color', 'linky'); ?>" data-initialcolor="<?php echo esc_attr( $this->get('border_color', WPLinkyHelper::getOptionValue('links_border_color', $appareance, '#E5E5E5', false)) ); ?>" data-property="borderColor" ></div>
                <input type="hidden" name="links[border_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php esc_attr_e('Background color', 'linky'); ?>" data-initialcolor="<?php echo esc_attr( $this->get('background_color', WPLinkyHelper::getOptionValue('links_background_color', $appareance, '#fff', false)) ); ?>" data-property="backgroundColor" ></div>
                <input type="hidden" name="links[background_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php esc_attr_e('Text color', 'linky'); ?>" data-initialcolor="<?php echo esc_attr( $this->get('color', WPLinkyHelper::getOptionValue('links_text_color', $appareance, '#000', false)) ); ?>" data-property="color" ></div>
                <input type="hidden" name="links[color][]" value="">
            </div>
        </div>
    </div>

    <div class="link__size">
        <div class="v-center">
            <input type="hidden" name="links[size][]" value="<?php echo esc_attr( $size ); ?>">
            <button type="button" class="js-size-button <?php echo esc_attr( $size == 100 ? 'active' : '' ); ?>" data-value="100">1/1</button>
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/width.svg'?>
            <button type="button" class="js-size-button <?php echo esc_attr( $size == 50 ? 'active' : '' ); ?>" data-value="50">1/2</button>
        </div>
    </div>

    <input type="hidden" name="links[type][]" value="default">
</div>
