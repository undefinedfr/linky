<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

global $wpLinky;
$indexController = $wpLinky->getIndexController();
$links = $indexController->getLinks()->getAll();
?>
<div class="links">
    <?php
    foreach($links as $link):
        /* @var \LinkyApp\Type\abstractType $linkInstance  */
        $linkInstance = $link->get('data');
        $linkInstance->getFrontTemplate();
    endforeach; ?>
</div>
