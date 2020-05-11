<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
?>
<?php if($this->get('link') && $this->get('label_link')): ?>
    <div class="link" style="border-color: <?php echo $this->get('border_color'); ?>; background-color: <?php echo $this->get('background_color'); ?>; color: <?php echo $this->get('color'); ?>">
        <?php if($this->get('label')): ?>
            <div class="link__label">
                <?php echo $this->get('label'); ?>
            </div>
        <?php endif; ?>
        
        <?php if($this->get('category')): ?>
            <div class="link__category">
                <?php echo $this->get('category'); ?>
            </div>
        <?php endif; ?>

        <a href="<?php echo $this->get('link') ?>" class="link__link" title="<?php echo $this->get('label_link'); ?>">
            <?php echo $this->get('label_link'); ?>
        </a>
    </div>
<?php endif; ?>
