<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;

$data   = WPLinkyHelper::getPageOption($this->getCurrentPage());
$links  = WPLinkyHelper::getOptionValue('links', $data, []);
$global = WPLinkyHelper::getOptionValue('global', $data, []);

$totals = WPLinkyHelper::getTotals($links, $this->getCurrentPage());
$links  = $totals['links'];
$stats  = $totals['global'];
?>
<div class="inside">
    <div class="stats">
        <div class="stats__col">
            <strong><?php echo __('Viewed page', 'linky'); ?></strong>

            <div class="stats__row">
                <div class="stats__col">
                    <strong><?php echo __('Last 7 days', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['weekly']['views']; ?>
                    </div>
                </div>
                <div class="stats__col">
                    <strong><?php echo __('Last 30 days', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['monthly']['views']; ?>
                    </div>
                </div>
                <div class="stats__col">
                    <strong><?php echo __('Total', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['total']['views']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="stats__col">
            <strong><?php echo __('Clicked links', 'linky'); ?></strong>

            <div class="stats__row">
                <div class="stats__col">
                    <strong><?php echo __('Last 7 days', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['total']['clicks']; ?>
                    </div>
                </div>
                <div class="stats__col">
                    <strong><?php echo __('Last 30 days', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['monthly']['clicks']; ?>
                    </div>
                </div>
                <div class="stats__col">
                    <strong><?php echo __('Total', 'linky'); ?></strong>
                    <div class="stats__count">
                        <?php echo $stats['total']['clicks']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="links links--stats">
        <div class="links--stats__head">
            <?php echo __('Link', 'linky'); ?>
            <div class="links--stats__head__counts">
                <span><?php echo __('Last 7 days', 'linky'); ?></span>
                <span><?php echo __('Last 30 days', 'linky'); ?></span>
                <span><?php echo __('Total', 'linky'); ?></span>
            </div>
        </div>
        <?php if(count($links) > 0): ?>
            <?php foreach($links as $link_id => $link):

                $className = '\LinkyApp\Type\\' . $link['type'] . 'Type';
                if(!class_exists($className) || $link['type'] == 'separator') {
                    continue;
                }

                /* @var \LinkyApp\Type\abstractType $typeInstance  */
                $typeInstance = new $className($link);

                $typeInstance->getAdminStatTemplate();

            endforeach; ?>
        <?php else: ?>
            <div class="links__empty">
                <p>
                    <strong><?php echo __('No links found', 'linky'); ?></strong>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
