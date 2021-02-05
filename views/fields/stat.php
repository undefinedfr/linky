<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\WPLinkyHelper;

$link           = $this->get('link');
$total_count    = $this->get('total_count');
$monthly_count  = $this->get('monthly_count');
$weekly_count   = $this->get('weekly_count');
?>
<div class="link-stat">
    <div class="link-stat__url">
        <?php echo $link; ?>
    </div>
    <div class="link-stat__counts">
        <div class="link-stat__count">
            <?php echo $weekly_count ? $weekly_count : 0; ?>
        </div>
        <div class="link-stat__count">
            <?php echo $monthly_count ? $monthly_count : 0; ?>
        </div>
        <div class="link-stat__count">
            <?php echo $total_count ? $total_count : 0; ?>
        </div>
    </div>
</div>
