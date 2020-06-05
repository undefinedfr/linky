<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
?>
<div class="wrap settings-wp-linky">
    <h1></h1>
    <div class="h--1">
        <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/linky.svg'?>
        <div class="pull-right">
            <div class="copyright">
                <span><?php echo __('powered by', 'linky'); ?></span>
                <a href="https://www.undefined.fr" target="_blank"><?php require 'front/logo.php' ?></a>
            </div>
        </div>
    </div>
    <div id="poststuff">
        <div class="postbox _col-8">
        <?php require_once __DIR__ . '/menu.php' ?>