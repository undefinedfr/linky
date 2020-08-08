<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use \LinkyApp\Helper\ThemesHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController = $wpLinky->getIndexController();
$page = $indexController->getPage();
$theme_id = $page->get('body_theme', 'default');

$backgroundType = $page->get('background_type', 'color');
if($backgroundType == 'gradient') {
    $gradients = ThemesHelper::getGradients();
    $gradient = $page->get('background_gradient_id', 'linky');
    $background = 'linear-gradient(120deg,' . implode(',', $gradients[$gradient])  . ')';
} else if ($backgroundType == 'image') {
    $background = 'url(' . $page->get('background_image')->getImageUrl('large') . ') no-repeat center center; background-size: cover';
} else {
    $background = ($backgroundType == 'none') ? $backgroundType : $page->get('background_color', '#FFF');
}
$color = $page->get('body_text_color', '#000');
?>
<div class="linky-page linky-page--<?php echo $theme_id ?>" style="background: <?php echo $background ?>; color: <?php echo $color ?>">
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/header.php'; ?>
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/links.php'; ?>
    <?php if($page->get('social_position', 'top') != 'top'): ?>
        <div class="social-footer">
            <?php $textColor = $color ?>
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/socials.php'; ?>
        </div>
    <?php endif; ?>
    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/footer.php'; ?>
</div>
