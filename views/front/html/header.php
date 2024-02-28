<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use LinkyApp\Helper\ThemesHelper;
use LinkyApp\Helper\WPLinkyHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController    = $wpLinky->getIndexController();
$page               = $indexController->getPage();
$analytics_safe     = WPLinkyHelper::codeFilter($indexController->getSettings()->get('code_ga', null, false));
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

$title = $page->get('title') ? $page->get('title') : __('My links', 'linky') . ' | ' . get_bloginfo('blogname');
$yoastExist = WPLinkyHelper::pluginsExists(['wordpress-seo/wp-seo.php','wordpress-seo-premium/wp-seo-premium.php'] );
add_filter(($yoastExist ? 'wpseo_title' : 'pre_get_document_title'), function() use ($title) {
    return $title;
});
?>
<html>
    <head>
        <meta name="theme-color" content="<?php echo esc_attr( $background ); ?>">
        <meta name="msapplication-navbutton-color" content="<?php echo esc_attr( $background ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
        <?php if( $analytics_safe ): ?>
            <?php echo html_entity_decode( wp_kses( $analytics_safe, 'linky') ); ?>
        <?php endif; ?>
    </head>
    <body>
