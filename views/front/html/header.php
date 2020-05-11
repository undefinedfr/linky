<?php
global $wpLinky;
$indexController = $wpLinky->getIndexController();
$analytics = $indexController->getSettings()->get('code_ga')
?>
<html>
    <head>
        <?php wp_head(); ?>
        <?php if($analytics): ?>
            <script>
                <?php echo $analytics; ?>
            </script>
        <?php endif; ?>
    </head>
    <body>
