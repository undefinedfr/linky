<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

$active = $this->get('active');
?>
<?php if($active == 'yes'): ?>
    <?php $halfTextSize = $this->get('label_link') ? (strlen($this->get('label_link')) / 2) + 3 : 0 ?>
    <div class="separator">
        <div class="separator__line" style="max-width: calc(50% - <?php echo $halfTextSize ?>ch)">
            <span style="background-color: <?php echo $this->get('border_color'); ?>"></span>
        </div>
        <div class="separator__label" style="color: <?php echo $this->get('border_color'); ?>">
            <?php echo $this->get('label_link'); ?>
        </div>
        <div class="separator__line" style="max-width: calc(50% - <?php echo $halfTextSize ?>ch)">
            <span style="background-color: <?php echo $this->get('border_color'); ?>"></span>
        </div>
    </div>
<?php endif; ?>
