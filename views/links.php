<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;
use LinkyApp\Type\defaultType;
use LinkyApp\Type\separatorType;

$data               = WPLinkyHelper::getPageOption();
$links              = WPLinkyHelper::getOptionValue('links', $data, []);
$global             = WPLinkyHelper::getOptionValue('global', $data, []);
?>
<div class="inside">
    <form
            method="POST"
            action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
            class="_js-form"
            id="links"
            data-success-message="<?php echo __('Links saved', 'linky'); ?>"
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
                        <strong><?php echo __('No links found', 'linky'); ?></strong>
                    </p>
                    <p>
                        <?php echo __('To begin, please add a new link, click here', 'linky'); ?>
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
            <button type="submit" class="button button-new button-large"><?php echo __('Add link', 'linky'); ?></button>
        </form>
        <form
                method="POST"
                class="form-field _col-md-4 _col-xs-6 _js-links-form"
        >
            <input type="hidden" name="_type" value="separator">
            <button type="submit" class="button button-new button-large"><?php echo __('Add separator', 'linky'); ?></button>
        </form>
        <div class="form-field _col-md-4 _col-xs-12">
            <button type="submit" class="button button-primary button-large" form="links"><?php echo __('Save'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
