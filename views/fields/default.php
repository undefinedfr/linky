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
?>
<div class="link">
    <div class="link__sort">
        <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/dots.svg'?>
    </div>
    <div class="link__body">
        <div class="form-control">
            <div class="link__category form-field">
                <?php $categories = explode(',', $this->get('categories', $defaultCategories)); ?>
                <select name="links[category][]" id="category">
                    <option value=""><?php echo __('No category', UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category; ?>" <?php echo $this->get('category') ? 'selected' : ''; ?>><?php echo __($category, UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="link__label form-field">
                <?php $labels = explode(',', WPLinkyHelper::getOptionValue('labels', $global, $defaultLabels)); ?>
                <select name="links[label][]" id="label">
                    <option value=""><?php echo __('No label', UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php foreach($labels as $label): ?>
                        <option value="<?php echo $label; ?>" <?php echo $this->get('label') ? 'selected' : ''; ?>><?php echo __($label, UNDFND_WP_LINKY_DOMAIN); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="link__label-link form-field">
            <input type="text" name="links[label_link][]" placeholder="<?php echo __('Enter link label', UNDFND_WP_LINKY_DOMAIN); ?>" value="<?php echo $this->get('label_link'); ?>">
        </div>
        <div class="link__link form-field">
            <input type="text" name="links[link][]" placeholder="<?php echo home_url() . '/my-best-blog-post'; ?>" value="<?php echo $this->get('link'); ?>">
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
                <input type="hidden" id="border_color" name="links[border_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php echo __('Background color', UNDFND_WP_LINKY_DOMAIN); ?>" data-initialcolor="<?php echo $this->get('background_color', '#fff'); ?>" data-property="backgroundColor" ></div>
                <input type="hidden" id="background_color" name="links[background_color][]" value="">
            </div>
            <div class="link__color">
                <div class="_colorpicker link_colorpicker" data-tooltip="<?php echo __('Text color', UNDFND_WP_LINKY_DOMAIN); ?>" data-initialcolor="<?php echo $this->get('color', '#000'); ?>" data-property="color" ></div>
                <input type="hidden" id="color" name="links[color][]" value="">
            </div>
        </div>
    </div>

    <input type="hidden" name="links[type][]" value="default">
</div>
