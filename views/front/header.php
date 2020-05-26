<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\ThemesHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController = $wpLinky->getIndexController();
$page = $indexController->getPage();
$socials = $indexController->getSocials();
$menuItems = $indexController->getMenu()->getMenuItems();
$backgroundType    = $page->get('header_background_type', 'color');
$textColor         = $page->get('header_text_color', '#000');
if($backgroundType == 'gradient') {
    $gradients = ThemesHelper::getGradients();
    $gradient = $page->get('header_background_gradient_id', 'linky');
    $background = 'linear-gradient(120deg,' . implode(',', $gradients[$gradient])  . ')';
} else if ($backgroundType == 'image') {
    $background = 'url(' . $page->get('header_background_image')->getImageUrl('large') . ') no-repeat center center; background-size: cover';
} else {
    $background = ($backgroundType == 'none') ? $backgroundType : $page->get('header_background_color', '#FFF');
}

// Include correct theme
require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/header/' . $page->get('header_theme', 'default') . '.php'
?>
