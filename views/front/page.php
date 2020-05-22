<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

if(empty($wpLinky))
    global $wpLinky;
$indexController = $wpLinky->getIndexController();
$background = $indexController->getPage()->get('background_color', '#FFF');
$color = $indexController->getPage()->get('text_color', '#000');
?>
<div class="linky-page" style="background: <?php echo $background ?>; color: <?php echo $color ?>">
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/header.php'; ?>
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/links.php'; ?>
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/footer.php'; ?>
</div>