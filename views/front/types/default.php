<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

use LinkyApp\Helper\ThemesHelper;

if(empty($wpLinky))
    global $wpLinky;

$indexController        = $wpLinky->getIndexController();
$page                   = $indexController->getPage();
$active                 = $this->get('active');
$theme_id               = $page->get('body_theme', 'default');
$labelLength            = ((!$this->get('category') || ($theme_id == 'rounded-left' || $theme_id == 'roundedeft-variant')) && $this->get('label')) ? strlen($this->get('label')) : 0;
$labelBackgroundType    = $page->get('links_label_background_type', 'color');
$labelTextColor         = $page->get('links_label_text_color', '#FFF');
if($labelBackgroundType == 'gradient') {
    $gradients = ThemesHelper::getGradients();
    $gradient = $page->get('links_label_background_gradient_id', 'linky');
    $labelBackground = 'linear-gradient(120deg,' . implode(',', $gradients[$gradient])  . ')';
} else {
    $labelBackground = ($labelBackgroundType == 'none') ? $labelBackgroundType : $page->get('links_label_background_color', '#FFF');
}

if($labelLength
    && $theme_id != 'rounded'
    && $theme_id != 'rounded-variant') {
    $padding_right = $labelLength + 4 . 'ch';
} else {
    $padding_right = 'inherit';
}
?>
<?php if($this->get('link') && $this->get('label_link') && $active == 'yes'): ?>
    <?php if($this->get('size') != 100): ?>
        <div class="_col-md-6">
    <?php endif; ?>

        <div class="link <?php echo $this->get('label') ? 'has-label' : ''; ?>" style="border-color: <?php echo $this->get('border_color'); ?>; background-color: <?php echo $this->get('background_color'); ?>; color: <?php echo $this->get('color'); ?>; padding-right: <?php echo $padding_right ?>;">
            <?php if($this->get('label')): ?>
                <div class="link__label" style="background: <?php echo $labelBackground ?>; color: <?php echo $labelTextColor ?>">
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
