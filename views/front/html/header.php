<?php

use LinkyApp\Helper\ThemesHelper;
use LinkyApp\Helper\WPLinkyHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController    = $wpLinky->getIndexController();
$page               = $indexController->getPage();
$analytics          = WPLinkyHelper::codeFilter($indexController->getSettings()->get('code_ga', null, false));
$background         = $page->get('background_color', '#FFF');
$backgroundType    = $page->get('header_background_type', 'color');
if($backgroundType == 'gradient') {
    $gradients = ThemesHelper::getGradients();
    $gradient = $page->get('header_background_gradient_id', 'linky');
    $background = $gradients[$gradient][0];
} else if ($backgroundType == 'image') {
    $background = '#FFF';
} else {
    $background = ($backgroundType == 'none') ? '#FFF' : $page->get('header_background_color', '#FFF');
}
?>
<html>
    <head>
        <meta name="theme-color" content="<?php echo $background; ?>">
        <meta name="msapplication-navbutton-color" content="<?php echo $background; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page->get('title') ? $page->get('title') : __('My links', 'linky') . ' | ' . get_bloginfo('blogname'); ?></title>
        <?php wp_head(); ?>
        <?php if($analytics): ?>
            <?php echo html_entity_decode($analytics); ?>
        <?php endif; ?>
    </head>
    <body>
