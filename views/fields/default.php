<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
use LinkyApp\Helpers\WPLinkyHelper;
$data               = WPLinkyHelper::getPageOption();
$defaultLabels      = WPLinkyHelper::getDefaultLabels();
$defaultCategories  = WPLinkyHelper::getDefaultCategories();
$global             = WPLinkyHelper::getOptionValue('global', $data, []);
$id = WPLinkyHelper::getRandomIdentifier();
$active = $this->get('active', 'yes');
$size = $this->get('size', 100);
?>
<div class="link <?php echo $active == 'no' ? 'is-hidden' : ''; ?> <?php echo $size == 50 ? 'half-size' : ''; ?>">
    <div class="link__active">
        <input type="hidden" name="links[active][]" value="<?php echo $active; ?>">
        <input type="checkbox" <?php echo ($active  == 'yes') ? 'checked' : ''; ?>>
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/onoff.svg'?>
    </div>
    <div class="link__sort">
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/drag.svg'?>
    </div>
    <div class="link__body">
        <div class="form-control">
            <div class="link__category form-field">
                <?php $categories = explode(',', $this->get('categories', $defaultCategories)); ?>
                <select name="links[category][]">
                    <option value=""><?php echo __('No category', UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category; ?>" <?php echo $this->get('category') ? 'selected' : ''; ?>><?php echo __($category, UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="link__label form-field">
                <?php $labels = explode(',', WPLinkyHelper::getOptionValue('labels', $global, $defaultLabels)); ?>
                <select name="links[label][]">
                    <option value=""><?php echo __('No label', UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php foreach($labels as $label): ?>
                        <option value="<?php echo $label; ?>" <?php echo $this->get('label') ? 'selected' : ''; ?>><?php echo __($label, UNDFND_WP_LINKY_DOMAIN); ?></option>
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
                <div class="image-uploader <?php echo !empty($image) ? 'is-filled' : ''; ?>" <?php echo !empty($image) ? 'style="background-image: url(' . $image->getImageUrl('thumbnail') . ')"' : ''; ?>>
                    <input type="hidden" name="links[image][]"  value="<?php echo !empty($image) ? $image->id : ''; ?>">
                    <button class="_js-remove-image" title="<?php echo __('Remove'); ?>"></button>
                </div>
            </div>
            <div class="form-field">
                <div class="link__label-link form-field">
                    <input type="text" name="links[label_link][]" placeholder="<?php echo __('Enter link label', UNDFND_WP_LINKY_DOMAIN); ?>" value="<?php echo $this->get('label_link'); ?>">
                </div>
                <div class="link__link form-field">
                    <input type="text" name="links[link][]" placeholder="<?php echo home_url() . '/my-best-blog-post'; ?>" value="<?php echo $this->get('link'); ?>">
                </div>
            </div>
        </div>

        <div class="link__delete" data-tooltip="<?php echo __('Delete', UNDFND_WP_LINKY_DOMAIN); ?>">
            <label class="_js-delete" for="links_delete_<?php echo $id ?>"><?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/trash.svg'?></label>
            <input type="hidden" name="links[_delete][]" id="links_delete_<?php echo $id ?>" value="no">
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="link__customize">
        <div class="v-center">
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php echo __('Border color', UNDFND_WP_LINKY_DOMAIN); ?>" data-initialcolor="<?php echo $this->get('border_color', '#E5E5E5'); ?>" data-property="borderColor" ></div>
                <input type="hidden" name="links[border_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php echo __('Background color', UNDFND_WP_LINKY_DOMAIN); ?>" data-initialcolor="<?php echo $this->get('background_color', '#fff'); ?>" data-property="backgroundColor" ></div>
                <input type="hidden" name="links[background_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php echo __('Text color', UNDFND_WP_LINKY_DOMAIN); ?>" data-initialcolor="<?php echo $this->get('color', '#000'); ?>" data-property="color" ></div>
                <input type="hidden" name="links[color][]" value="">
            </div>
        </div>
    </div>

    <div class="link__size">
        <div class="v-center">
            <input type="hidden" name="links[size][]" value="<?php echo $size; ?>">
            <button type="button" class="js-size-button <?php echo $size == 100 ? 'active' : ''; ?>" data-value="100">1/1</button>
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/width.svg'?>
            <button type="button" class="js-size-button <?php echo $size == 50 ? 'active' : ''; ?>" data-value="50">1/2</button>
        </div>
    </div>

    <input type="hidden" name="links[type][]" value="default">
</div>
