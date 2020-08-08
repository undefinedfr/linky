<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use \LinkyApp\Helper\WPLinkyHelper;
use \LinkyApp\Entity\Image;

$data       = WPLinkyHelper::getPageOption();
$appareance = WPLinkyHelper::getOptionValue('appareance', $data, []);
$menus      = wp_get_nav_menus();

?>
<div class="inside no-gutter no-margin">
    <form
            id="appareance"
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            data-success-message="<?php echo __('Settings saved', 'linky'); ?>"
    >
        <h3><?php echo __('Header', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="links-informations">
                <p>
                    <?php echo __('It is recommended to upload a new image to have the module image sizes', 'linky'); ?>
                </p>
            </div>
            <div class="form-control form-control--upload">
                <div class="form-field">
                    <label for="avatar"><?php echo __('Avatar', 'linky'); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('avatar', $appareance);
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo !empty($image) ? 'is-filled' : ''; ?>" <?php echo !empty($image) ? 'style="background-image: url(' . $image->getImageUrl('thumbnail') . ')"' : ''; ?>>
                        <input type="hidden" name="avatar"  value="<?php echo !empty($image) ? $image->id : ''; ?>">
                        <button class="_js-remove-image" title="<?php echo __('Remove'); ?>"></button>
                    </div>
                </div>
                <div class="form-field">
                    <label for="title"><?php echo __('Title', 'linky'); ?></label>
                    <input type="text" id="title" name="title" placeholder="<?php echo get_bloginfo('name') ?>" value="<?php echo WPLinkyHelper::getOptionValue('title', $appareance); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="header_background_type"><?php echo __('Header background type', 'linky'); ?></label>
                    <?php $bgOptions = [
                        'none' =>  __('None', 'linky'),
                        'color' =>  __('Color', 'linky'),
                        'gradient' =>  __('Gradient', 'linky'),
                        'image' => __('Image', 'linky')
                    ] ?>
                    <select name="header_background_type" class="js-toggle-select">
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo WPLinkyHelper::getOptionValue('header_background_type', $appareance) == $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-gradient">
                    <label for="header_background_gradient_id"><?php echo __('Header background gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('header_background_gradient_id', $appareance, 'linky'); ?>"></div>
                    <input type="hidden" name="header_background_gradient_id" value="<?php echo WPLinkyHelper::getOptionValue('header_background_gradient_id', $appareance, 'linky'); ?>">
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-color">
                    <label for="header_background_color"><?php echo __('Header background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('header_background_color', $appareance, '#FFF'); ?>"></div>
                    <input type="text" id="header_background_color" name="header_background_color" value="<?php echo WPLinkyHelper::getOptionValue('header_background_color', $appareance, '#FFF'); ?>">
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-image">
                    <label for="header_background_image"><?php echo __('Image', 'linky'); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('header_background_image', $appareance);
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo !empty($image) ? 'is-filled' : ''; ?>" <?php echo !empty($image) ? 'style="background-image: url(' . $image->getImageUrl('thumbnail') . ')"' : ''; ?>>
                        <input type="hidden" name="header_background_image"  value="<?php echo !empty($image) ? $image->id : ''; ?>">
                        <button class="_js-remove-image" title="<?php echo __('Remove'); ?>"></button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="header_text_color"><?php echo __('Header text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('header_text_color', $appareance, '#000'); ?>"></div>
                    <input type="text" id="header_text_color" name="header_text_color" value="<?php echo WPLinkyHelper::getOptionValue('header_text_color', $appareance, '#000'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="menu"><?php echo __('Menu', 'linky'); ?></label>
                    <div class="minitext"><?php echo __('You can add one in Appareance > Menus', 'linky'); ?></div>
                    <select name="menu" id="menu">
                        <option value=""></option>
                        <?php foreach($menus as $menu): ?>
                            <option value="<?php echo $menu->term_id; ?>" <?php echo WPLinkyHelper::getOptionValue('menu', $appareance) == $menu->term_id ? 'selected' : ''; ?>><?php echo $menu->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field"></div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="social_display"><?php echo __('Display socials links with menu', 'linky'); ?></label>
                    <span class="minitext"><?php echo __('By default, socials links are visible everytime', 'linky'); ?></span>
                    <input type="radio" id="social_display" value="yes" name="social_display" <?php echo WPLinkyHelper::getOptionValue('social_display', $appareance) == 'yes' ? 'checked' : ''; ?>> <span><?php echo __('Yes', 'linky'); ?></span>
                    <input type="radio" value="no" name="social_display" <?php echo WPLinkyHelper::getOptionValue('social_display', $appareance) != 'yes' ? 'checked' : ''; ?>> <span><?php echo __('No', 'linky'); ?></span>
                </div>
                <div class="form-field">
                    <label for="menu"><?php echo __('Socials links position', 'linky'); ?></label>
                    <select name="social_position" id="social_position">
                        <?php foreach(['top', 'bottom', 'both'] as $position): ?>
                            <option value="<?php echo $position ?>" <?php echo WPLinkyHelper::getOptionValue('social_position', $appareance) == $position ? 'selected' : ''; ?>><?php echo __(ucfirst($position), 'linky'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="separator-form"></div>
        <h3><?php echo __('Body', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="form-control">
                <div class="form-field">
                    <label for="background_type"><?php echo __('Background Type', 'linky'); ?></label>
                    <select name="background_type" class="js-toggle-select">
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo WPLinkyHelper::getOptionValue('background_type', $appareance) == $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-background_type" id="background_type-gradient">
                    <label for="background_gradient_id"><?php echo __('Gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('background_gradient_id', $appareance, 'linky'); ?>"></div>
                    <input type="hidden" name="background_gradient_id" value="<?php echo WPLinkyHelper::getOptionValue('background_gradient_id', $appareance, 'linky'); ?>">
                </div>
                <div class="form-field toggle-background_type" id="background_type-color">
                    <label for="background_color"><?php echo __('Background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF'); ?>"></div>
                    <input type="text" id="background_color" name="background_color" value="<?php echo WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF'); ?>">
                </div>
                <div class="form-field toggle-background_type" id="background_type-image">
                    <label for="background_image"><?php echo __('Image', 'linky'); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('background_image', $appareance);
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo !empty($image) ? 'is-filled' : ''; ?>" <?php echo !empty($image) ? 'style="background-image: url(' . $image->getImageUrl('thumbnail') . ')"' : ''; ?>>
                        <input type="hidden" name="background_image"  value="<?php echo !empty($image) ? $image->id : ''; ?>">
                        <button class="_js-remove-image" title="<?php echo __('Remove'); ?>"></button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field" id="body_text_color">
                    <label for="body_text_color"><?php echo __('Body text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('body_text_color', $appareance, '#000'); ?>"></div>
                    <input type="text" id="body_text_color" name="body_text_color" value="<?php echo WPLinkyHelper::getOptionValue('body_text_color', $appareance, '#000'); ?>">
                </div>
                <div class="form-field"></div>
            </div>
        </div>
        <div class="separator-form"></div>
        <h3><?php echo __('Links', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="links-informations">
                <p>
                    <?php echo __('If you have already filled in links, they will not be modified so as not to lose the configuration already carried out.', 'linky'); ?>
                    <br>
                    <?php echo __('The above configuration will appear on your future links.', 'linky'); ?>
                </p>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_label_background_type"><?php echo __('Label background type', 'linky'); ?></label>
                    <select name="links_label_background_type" class="js-toggle-select">
                        <?php unset($bgOptions['image']) ?>
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo WPLinkyHelper::getOptionValue('links_label_background_type', $appareance) == $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-links_label_background_type" id="links_label_background_type-gradient">
                    <label for="links_label_background_gradient_id"><?php echo __('Label gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_label_background_gradient_id', $appareance, 'linky'); ?>"></div>
                    <input type="hidden" name="links_label_background_gradient_id" value="<?php echo WPLinkyHelper::getOptionValue('links_label_background_gradient_id', $appareance, 'linky'); ?>">
                </div>
                <div class="form-field toggle-links_label_background_type" id="links_label_background_type-color">
                    <label for="links_label_background_color"><?php echo __('Label background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_label_background_color', $appareance, '#000'); ?>"></div>
                    <input type="text" id="links_label_background_color" name="links_label_background_color" value="<?php echo WPLinkyHelper::getOptionValue('links_label_background_color', $appareance, '#000'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_label_text_color"><?php echo __('Label text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_label_text_color', $appareance, '#FFF'); ?>"></div>
                    <input type="text" id="links_label_text_color" name="links_label_text_color" value="<?php echo WPLinkyHelper::getOptionValue('links_label_text_color', $appareance, '#FFF'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="separator-form mg-b-20"></div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_border_color"><?php echo __('Links border color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_border_color', $appareance, '#E5E5E5'); ?>"></div>
                    <input type="text" id="links_border_color" name="links_border_color" value="<?php echo WPLinkyHelper::getOptionValue('links_border_color', $appareance, '#E5E5E5'); ?>">
                </div>
                <div class="form-field">
                    <label for="links_text_color"><?php echo __('Links text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_text_color', $appareance, '#000'); ?>"></div>
                    <input type="text" id="links_text_color" name="links_text_color" value="<?php echo WPLinkyHelper::getOptionValue('links_text_color', $appareance, '#000'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_background_color"><?php echo __('Links background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('links_background_color', $appareance, '#FFF'); ?>"></div>
                    <input type="text" id="links_background_color" name="links_background_color" value="<?php echo WPLinkyHelper::getOptionValue('links_background_color', $appareance, '#FFF'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="separator-form mg-b-20"></div>
            <div class="form-control">
                <div class="form-field">
                    <label for="separator_color"><?php echo __('Separators color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo WPLinkyHelper::getOptionValue('separator_color', $appareance, '#cccccc'); ?>"></div>
                    <input type="text" id="separator_color" name="separator_color" value="<?php echo WPLinkyHelper::getOptionValue('separator_color', $appareance, '#cccccc'); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-field">
                <div class="pull-right">
                    <button type="submit" class="button button-primary button-large"><?php echo __('Save'); ?></button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="appareance">
    </form>
</div>
