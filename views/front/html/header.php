<?php
use LinkyApp\Helper\WPLinkyHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController    = $wpLinky->getIndexController();
$page               = $indexController->getPage();
$analytics          = WPLinkyHelper::codeFilter($indexController->getSettings()->get('code_ga', null, false));
$background         = $page->get('background_color', '#FFF');
?>
<html>
    <head>
        <meta name="theme-color" content="<?php echo $background; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page->get('title') ? $page->get('title') : __('My links', UNDFND_WP_LINKY_DOMAIN) . ' | ' . get_bloginfo('blogname'); ?></title>
        <?php wp_head(); ?>
        <?php if($analytics): ?>
            <?php echo html_entity_decode($analytics); ?>
        <?php endif; ?>
    </head>
    <body>
