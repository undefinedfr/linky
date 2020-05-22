<?php
use \LinkyApp\Helpers\WPLinkyHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController = $wpLinky->getIndexController();
$analytics = WPLinkyHelper::codeFilter($indexController->getSettings()->get('code_ga', null, false));
$background = $indexController->getPage()->get('background_color', '#FFF');
?>
<html>
    <head>
        <meta name="theme-color" content="<?php echo $background; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $indexController->getPage()->get('title'); ?></title>
        <?php wp_head(); ?>
        <?php if($analytics): ?>
            <?php echo $analytics; ?>
        <?php endif; ?>
    </head>
    <body>
