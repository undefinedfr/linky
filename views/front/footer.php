<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

if(empty($wpLinky))
    global $wpLinky;
?>
<footer class="footer">
    <div class="copyright" style="color: <?php echo $wpLinky->getIndexController()->getPage()->get('text_color') ?>">
        <span><?php echo __('powered by', UNDFND_WP_LINKY_DOMAIN); ?></span>
        <a href="https://www.undefined.fr" target="_blank"><?php require 'logo.php' ?></a>
    </div>
</footer>