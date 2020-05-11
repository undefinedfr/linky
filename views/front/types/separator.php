<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
?>
<?php if($this->get('label_link')): ?>
    <?php $halfTextSize = (strlen($this->get('label_link')) / 2) + 2 ?>
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
