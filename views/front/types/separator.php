<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

if(empty($wpLinky))
    global $wpLinky;

$active     = $this->get('active');
$page       = $wpLinky->getIndexController()->getPage();
$theme_id   = $page->get('body_theme', 'default');

$background = 'none';
?>
<?php if($active == 'yes'): ?>
    <?php $halfTextSize = $this->get('label_link') ? (strlen($this->get('label_link')) / 2) + 3 : 0 ?>
    <div class="separator" style="border-color: <?php echo $this->get('border_color', $page->get('separator_color')); ?>">
        <div class="separator__line" style="max-width: calc(50% - <?php echo $halfTextSize ?>ch - 1.5px)">
            <span style="background-color: <?php echo $this->get('border_color', $page->get('separator_color')); ?>"></span>
        </div>
        <?php if($this->get('label_link')): ?>
            <div class="separator__label" style="color: <?php echo $this->get('border_color'); ?>">
                <?php echo $this->get('label_link'); ?>
            </div>
        <?php endif; ?>
        <div class="separator__line" style="max-width: calc(50% - <?php echo $halfTextSize ?>ch - 1.5px)">
            <span style="background-color: <?php echo $this->get('border_color', $page->get('separator_color')); ?>"></span>
        </div>
        <?php if($theme_id == 'full' || $theme_id == 'full-variant') { ?>
           <div class="separator__background" style="background: <?php echo $this->get('border_color', $page->get('separator_color')) ?>"></div>
        <?php } ?>
    </div>
<?php endif; ?>
