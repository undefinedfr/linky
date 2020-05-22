<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

$active = $this->get('active');
?>
<?php if($this->get('link') && $this->get('label_link') && $active == 'yes'): ?>
    <?php if($this->get('size') != 100): ?>
        <div class="_col-md-6">
    <?php endif; ?>

        <div class="link" style="border-color: <?php echo $this->get('border_color'); ?>; background-color: <?php echo $this->get('background_color'); ?>; color: <?php echo $this->get('color'); ?>">
            <?php if($this->get('label')): ?>
                <div class="link__label">
                    <?php echo $this->get('label'); ?>
                </div>
            <?php endif; ?>

            <?php
            /* @var $image \LinkyApp\Entity\Image */
            $image = $this->get('image');
            if(!empty($image)): ?>
                <img src="<?php echo $image->getImageUrl('icon'); ?>" alt="<?php echo $this->get('label'); ?>" class="link__image">
            <?php endif; ?>

            <div class="link__col">
                <?php if($this->get('category')): ?>
                    <div class="link__category">
                        <?php echo $this->get('category'); ?>
                    </div>
                <?php endif; ?>
                <a href="<?php echo $this->get('link') ?>" class="link__link" title="<?php echo $this->get('label_link'); ?>" <?php echo $this->_shouldBeBlank() ? 'target="_blank"' : ''; ?> style="color: <?php echo $this->get('color'); ?>">
                    <?php echo $this->get('label_link'); ?>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>

    <?php if($this->get('size') != 100): ?>
        </div>
    <?php endif; ?>

<?php endif; ?>
