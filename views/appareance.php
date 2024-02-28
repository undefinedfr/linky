<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
            action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>"
            class="_js-form"
            data-success-message="<?php esc_attr_e('Settings saved', 'linky'); ?>"
    >
        <h3><?php esc_html_e('Header', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="links-informations">
                <p>
                    <?php esc_html_e('It is recommended to upload a new image to have the module image sizes', 'linky'); ?>.<br>
                    <?php esc_html_e('Recommended size: 50x50 pixels', 'linky'); ?>
                </p>
            </div>
            <div class="form-control form-control--upload with-two-fields">
                <div class="form-field">
                    <label for="avatar"><?php esc_attr_e( 'Avatar', 'linky' ); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('avatar', $appareance, null, false, 'html');
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo esc_attr( !empty($image) ? 'is-filled' : '' ); ?>" <?php echo !empty($image) ? 'style="background-image: url(' . esc_attr( $image->getImageUrl('thumbnail') ) . ')"' : ''; ?>>
                        <input type="hidden" name="avatar"  value="<?php echo esc_attr( !empty($image) ? $image->id : '' ); ?>">
                        <button class="_js-remove-image" title="<?php esc_attr_e('Remove'); ?>"></button>
                    </div>
                </div>
                <div class="form-control">
                    <div class="form-field">
                        <label for="title"><?php esc_html_e('Title', 'linky'); ?></label>
                        <input type="text" id="title" name="title" placeholder="<?php echo esc_attr( get_bloginfo('name') ) ?>" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('title', $appareance, null, false) ); ?>">
                    </div>
                    <div class="form-field">
                        <div class="form-field">
                            <label for="avatar_link"><?php esc_html_e('Avatar link', 'linky'); ?></label>
                            <input type="text" id="avatar_link" name="avatar_link" placeholder="<?php esc_attr_e('Optional', 'linky' ) ?>" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('avatar_link', $appareance, null, false) ); ?>">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="header_background_type"><?php esc_html_e('Header background type', 'linky'); ?></label>
                    <?php $bgOptions = [
                        'none' =>  __('None', 'linky'),
                        'color' =>  __('Color', 'linky'),
                        'gradient' =>  __('Gradient', 'linky'),
                        'image' => __('Image', 'linky')
                    ] ?>
                    <select name="header_background_type" class="js-toggle-select">
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( WPLinkyHelper::getOptionValue('header_background_type', $appareance, null, false) == $value ? 'selected' : '' ); ?>><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-gradient">
                    <label for="header_background_gradient_id"><?php esc_html_e('Header background gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_background_gradient_id', $appareance, 'linky', false) ); ?>"></div>
                    <input type="hidden" name="header_background_gradient_id" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_background_gradient_id', $appareance, 'linky', false) ); ?>">
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-color">
                    <label for="header_background_color"><?php esc_html_e('Header background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_background_color', $appareance, '#FFF', false) ); ?>"></div>
                    <input type="text" id="header_background_color" name="header_background_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_background_color', $appareance, '#FFF', false) ); ?>">
                </div>
                <div class="form-field toggle-header_background_type" id="header_background_type-image">
                    <label for="header_background_image"><?php esc_html_e('Image', 'linky'); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('header_background_image', $appareance, null, false, 'html');
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo esc_attr( !empty($image) ? 'is-filled' : '' ); ?>" <?php echo !empty($image) ? 'style="background-image: url(' . esc_url( $image->getImageUrl('thumbnail') ) . ')"' : ''; ?>>
                        <input type="hidden" name="header_background_image"  value="<?php echo esc_attr( !empty($image) ? $image->id : '' ); ?>">
                        <button class="_js-remove-image" title="<?php esc_attr_e( 'Remove' ); ?>"></button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="header_text_color"><?php esc_html_e( 'Header text color', 'linky' ); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_text_color', $appareance, '#000', false) ); ?>"></div>
                    <input type="text" id="header_text_color" name="header_text_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('header_text_color', $appareance, '#000', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="menu"><?php esc_html_e('Menu', 'linky') ; ?></label>
                    <div class="minitext"><?php esc_html_e('You can add one in Appearance > Menus', 'linky'); ?></div>
                    <select name="menu" id="menu">
                        <option value=""></option>
                        <?php foreach($menus as $menu): ?>
                            <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php echo esc_attr( WPLinkyHelper::getOptionValue('menu', $appareance, null, false) == $menu->term_id ? 'selected' : ''); ?>><?php echo esc_html( $menu->name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field"></div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="social_display"><?php esc_html_e('Display socials links with menu', 'linky'); ?></label>
                    <span class="minitext"><?php esc_html_e('By default, socials links are visible everytime', 'linky'); ?></span>
                    <input type="radio" id="social_display" value="yes" name="social_display" <?php echo esc_attr( WPLinkyHelper::getOptionValue('social_display', $appareance, null, false) == 'yes' ? 'checked' : '' ); ?>> <span><?php esc_html_e('Yes', 'linky'); ?></span>
                    <input type="radio" value="no" name="social_display" <?php echo esc_attr( WPLinkyHelper::getOptionValue('social_display', $appareance, null, false) != 'yes' ? 'checked' : '' ); ?>> <span><?php esc_html_e('No', 'linky'); ?></span>
                </div>
                <div class="form-field">
                    <label for="menu"><?php esc_html_e('Socials links position', 'linky'); ?></label>
                    <select name="social_position" id="social_position">
                        <?php foreach(['top', 'bottom', 'both'] as $position): ?>
                            <option value="<?php echo esc_attr( $position ) ?>" <?php echo esc_attr( WPLinkyHelper::getOptionValue('social_position', $appareance, null, false) == $position ? 'selected' : '' ); ?>>
                                <?php
                                switch ( $position ):
                                    case 'top':
                                        esc_html_e('Top', 'linky');
                                        break;
                                    case 'bottom':
                                        esc_html_e('Bottom', 'linky');
                                        break;
                                    case 'both':
                                        esc_html_e('Both', 'linky');
                                        break;
                                endswitch ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="separator-form"></div>
        <h3><?php esc_html_e('Body', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="form-control">
                <div class="form-field">
                    <label for="background_type"><?php esc_html_e('Background Type', 'linky'); ?></label>
                    <select name="background_type" class="js-toggle-select">
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( WPLinkyHelper::getOptionValue('background_type', $appareance) == $value ? 'selected' : '' ); ?>><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-background_type" id="background_type-gradient">
                    <label for="background_gradient_id"><?php esc_html_e('Gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('background_gradient_id', $appareance, 'linky', false) ); ?>"></div>
                    <input type="hidden" name="background_gradient_id" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('background_gradient_id', $appareance, 'linky', false) ); ?>">
                </div>
                <div class="form-field toggle-background_type" id="background_type-color">
                    <label for="background_color"><?php esc_html_e('Background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF', false) ); ?>"></div>
                    <input type="text" id="background_color" name="background_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('background_color', $appareance, '#FFF', false) ); ?>">
                </div>
                <div class="form-field toggle-background_type" id="background_type-image">
                    <label for="background_image"><?php esc_html_e('Image', 'linky'); ?></label>
                    <?php
                    $imageId = WPLinkyHelper::getOptionValue('background_image', $appareance, null, false, 'html');
                    $image = !empty($imageId) ? new Image($imageId) : false;
                    ?>
                    <div class="image-uploader <?php echo esc_attr( !empty($image) ? 'is-filled' : '' ); ?>" <?php echo !empty($image) ? 'style="background-image: url(' . esc_url( $image->getImageUrl('thumbnail') ) . ')"' : ''; ?>>
                        <input type="hidden" name="background_image"  value="<?php echo esc_attr( !empty($image) ?  $image->id  : '' ); ?>">
                        <button class="_js-remove-image" title="<?php esc_attr_e('Remove'); ?>"></button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field" id="body_text_color">
                    <label for="body_text_color"><?php esc_html_e('Body text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('body_text_color', $appareance, '#000', false) ); ?>"></div>
                    <input type="text" id="body_text_color" name="body_text_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('body_text_color', $appareance, '#000', false) ); ?>">
                </div>
                <div class="form-field"></div>
            </div>
        </div>
        <div class="separator-form"></div>
        <h3><?php esc_html_e('Links', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="links-informations">
                <p>
                    <?php esc_html_e('If you have already filled in links, they will not be modified so as not to lose the configuration already carried out.', 'linky'); ?>
                    <br>
                    <?php esc_html_e('The above configuration will appear on your future links.', 'linky'); ?>
                </p>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_label_background_type"><?php esc_html_e('Label background type', 'linky'); ?></label>
                    <select name="links_label_background_type" class="js-toggle-select">
                        <?php unset($bgOptions['image']) ?>
                        <?php foreach($bgOptions as $value => $label): ?>
                            <option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_background_type', $appareance, null, false) == $value ? 'selected' : '' ); ?>><?php echo esc_attr( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field toggle-links_label_background_type" id="links_label_background_type-gradient">
                    <label for="links_label_background_gradient_id"><?php esc_html_e('Label gradient', 'linky'); ?></label>
                    <div class="_colorpicker gradientpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_background_gradient_id', $appareance, 'linky', false) ); ?>"></div>
                    <input type="hidden" name="links_label_background_gradient_id" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_background_gradient_id', $appareance, 'linky', false) ); ?>">
                </div>
                <div class="form-field toggle-links_label_background_type" id="links_label_background_type-color">
                    <label for="links_label_background_color"><?php esc_html_e('Label background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_background_color', $appareance, '#000', false) ); ?>"></div>
                    <input type="text" id="links_label_background_color" name="links_label_background_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_background_color', $appareance, '#000', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_label_text_color"><?php esc_html_e('Label text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_text_color', $appareance, '#FFF', false) ); ?>"></div>
                    <input type="text" id="links_label_text_color" name="links_label_text_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_label_text_color', $appareance, '#FFF', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="separator-form mg-b-20"></div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_border_color"><?php esc_html_e('Links border color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_border_color', $appareance, '#E5E5E5', false) ); ?>"></div>
                    <input type="text" id="links_border_color" name="links_border_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_border_color', $appareance, '#E5E5E5', false) ); ?>">
                </div>
                <div class="form-field">
                    <label for="links_text_color"><?php esc_html_e('Links text color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_text_color', $appareance, '#000', false) ); ?>"></div>
                    <input type="text" id="links_text_color" name="links_text_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_text_color', $appareance, '#000', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-control">
                <div class="form-field">
                    <label for="links_background_color"><?php esc_html_e('Links background color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_background_color', $appareance, '#FFF', false) ); ?>"></div>
                    <input type="text" id="links_background_color" name="links_background_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('links_background_color', $appareance, '#FFF', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="separator-form mg-b-20"></div>
            <div class="form-control">
                <div class="form-field">
                    <label for="separator_color"><?php esc_html_e('Separators color', 'linky'); ?></label>
                    <div class="_colorpicker colorpicker" data-initialcolor="<?php echo esc_attr( WPLinkyHelper::getOptionValue('separator_color', $appareance, '#cccccc', false) ); ?>"></div>
                    <input type="text" id="separator_color" name="separator_color" value="<?php echo esc_attr( WPLinkyHelper::getOptionValue('separator_color', $appareance, '#cccccc', false) ); ?>">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="separator-form"></div>
        <h3><?php esc_html_e('Footer', 'linky'); ?></h3>
        <div class="col-lr">
            <div class="fom-control">
                <div class="form-field">
                    <?php $show_footer = WPLinkyHelper::getOptionValue('show_footer', $appareance, null, false, 'html'); ?>
                    <label for="show_footer"><?php esc_html_e('Display "Powered by Undefined"', 'linky'); ?></label>
                    <input type="radio" id="show_footer" value="yes" name="show_footer" <?php echo esc_attr( $show_footer == 'yes' ? 'checked' : '' ); ?>> <span><?php esc_html_e('Yes', 'linky'); ?></span>
                    <input type="radio" value="no" name="show_footer" <?php echo esc_attr( empty($show_footer) || $show_footer != 'yes' ? 'checked' : '' ); ?>> <span><?php esc_html_e('No', 'linky'); ?></span>
                </div>
            </div>
            <div class="form-field">
                <div class="pull-right">
                    <button type="submit" class="button button-primary button-large"><?php esc_html_e('Save'); ?></button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="appareance">
    </form>
</div>
