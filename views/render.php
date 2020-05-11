<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
global $wpLinky;
$url = home_url() . '/' . $wpLinky->getIndexController()->getSettings()->get('slug', 'linky');

?>
<h2 class="hndle ui-sortable-handle">
    <?php echo __('Render', UNDFND_WP_LINKY_DOMAIN); ?>
    <a href="<?php echo $url; ?>" target="_blank" class="button button-secondary pull-right"><?php echo __('View page', UNDFND_WP_LINKY_DOMAIN); ?></a>
</h2>
<div class="render-view" id="render-view">
    <div class="iphone-x">
        <div class="iphoneside">
            <div class="screen">
                <?php $wpLinky->getIndexController()->getContent(); ?>
            </div>
        </div>
        <div class="line"></div>
        <div class="volume-button"></div>
        <div class="power-button"></div>
    </div>
</div>