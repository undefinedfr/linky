<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LinkyApp\Helper\WPLinkyHelper;
use LinkyApp\Type\defaultType;
use LinkyApp\Type\separatorType;

$data               = WPLinkyHelper::getPageOption();
$links              = WPLinkyHelper::getOptionValue('links', $data, []);
$global             = WPLinkyHelper::getOptionValue('global', $data, []);
?>
<div class="inside">
    <div class="form-control mg-b-20">
        <form
                method="POST"
                class="form-field _col-md-4 _col-xs-6 _js-links-form"
                data-position="prepend"
        >
            <input type="hidden" name="_type" value="default">
            <button type="submit" class="button button-new button-large"><?php esc_html_e('Add link', 'linky'); ?></button>
        </form>
        <form
                method="POST"
                class="form-field _col-md-4 _col-xs-6 _js-links-form"
                data-position="prepend"
        >
            <input type="hidden" name="_type" value="separator">
            <button type="submit" class="button button-new button-large"><?php esc_html_e('Add separator', 'linky'); ?></button>
        </form>
        <div class="form-field _col-md-4 _col-xs-12">
            <button type="submit" class="button button-primary button-large" form="links"><?php esc_html_e('Save'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>

    <form
            method="POST"
            action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
            class="_js-form"
            id="links"
            data-success-message="<?php esc_attr_e('Links saved', 'linky'); ?>"
    >
        <div class="links">
            <?php if(count($links) > 0): ?>
                <?php foreach($links as $link_id => $link):

                    $className = '\LinkyApp\Type\\' . $link['type'] . 'Type';
                    if(!class_exists($className)) {
                        continue;
                    }

                    /* @var \LinkyApp\Type\abstractType $typeInstance  */
                    $typeInstance = new $className($link);

                    $typeInstance->getAdminTemplate();

                    endforeach; ?>
            <?php else: ?>
                <div class="links__empty">
                    <p>
                        <strong><?php esc_html_e('No links found', 'linky'); ?></strong>
                    </p>
                    <p>
                        <?php esc_html_e('To begin, please add a new link, click here', 'linky'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <input type="hidden" name="action" value="save_form">
        <input type="hidden" name="_group" value="links">
    </form>

    <div class="form-control">
        <form
                method="POST"
                class="form-field _col-md-4 _col-xs-6 _js-links-form"
        >
            <input type="hidden" name="_type" value="default">
            <button type="submit" class="button button-new button-large"><?php esc_html_e('Add link', 'linky'); ?></button>
        </form>
        <form
                method="POST"
                class="form-field _col-md-4 _col-xs-6 _js-links-form"
        >
            <input type="hidden" name="_type" value="separator">
            <button type="submit" class="button button-new button-large"><?php esc_html_e('Add separator', 'linky'); ?></button>
        </form>
        <div class="form-field _col-md-4 _col-xs-12">
            <button type="submit" class="button button-primary button-large" form="links"><?php esc_html_e('Save'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
