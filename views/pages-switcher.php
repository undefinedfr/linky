<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

$pages          = $this->_pages;
$currentPage    = $this->getCurrentPage();
$homeUrl        = home_url();
?>

<div class="pages-switcher">
    <div class="pull-left">
        <form action="<?php echo admin_url('admin.php'); ?>">
            <label for="pages">
                <?php echo __('Choose page', 'linky'); ?> :
            </label>
            <?php if(!empty($pages)): ?>
                <select name="page_id" id="pages" class="_js-submit-on-change">
                    <?php foreach($pages as $key => $p) { ?>
                        <option <?php echo ($currentPage == $key) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $p; ?></option>
                    <?php } ?>
                </select>
            <?php endif; ?>
            <input type="hidden" name="page" value="<?php echo !empty($_GET['page']) ? $_GET['page'] : ''; ?>">
        </form>
        <button type="button" title="<?php echo __('Edit page', 'linky'); ?>" data-page-name="<?php echo $pages[$currentPage]; ?>" data-page-id="<?php echo $currentPage; ?>" class="_js-open-modal settings-button">
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/settings.svg' ?>
        </button>
    </div>
    <div class="pull-right">
        <button type="button" class="_js-open-modal button button-primary button-large">
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/plus.svg' ?>
            <span class="text"><?php echo __('Add page', 'linky'); ?></span>
        </button>
    </div>
</div>
<div class="page-modal">
    <div class="page-modal__content">
        <div class="page-modal__header">
            <h3 class="add-title"><?php echo __('Add page', 'linky'); ?></h3>
            <h3 class="edit-title" style="display:none"><?php echo __('Edit page', 'linky'); ?></h3>
            <button class="close _js-open-modal">
                <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/plus.svg' ?>
            </button>
        </div>
        <div class="page-modal__body ">
            <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                <div class="form-field">
                    <label for="page_name"><?php echo __('Page name', 'linky'); ?></label>
                    <input type="text" id="page_name" required name="page_name" value="">
                </div>
                <div class="form-field add-title">
                    <label for="slug"><?php echo __('Slug URL', 'linky'); ?></label>
                    <div class="link_url">
                        <span style="width: <?php echo strlen($homeUrl) - 3.5 ?>ch"><?php echo home_url(); ?></span>
                        <input  style="max-width: calc(100% - <?php echo strlen($homeUrl) - 2 ?>ch)" type="text" id="slug" required name="slug" placeholder="linky" value="">
                    </div>
                </div>
                <input type="hidden" name="page_id">
                <input type="hidden" name="action" value="edit_page">
                <div class="page-modal__footer">
                    <input value="<?php echo __('Remove page', 'linky'); ?>" name="remove" data-action="remove" type="submit" class="button button-error button-large _js-edit-form-submit" data-confirm="<?php echo __('Are you sure ?', 'linky'); ?>">
                    <div class="save">
                        <input value="<?php echo __('Save'); ?>" name="save" data-action="save" type="submit" class="button button-primary button-large _js-edit-form-submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
