<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

global $wpLinky;
$indexController = $wpLinky->getIndexController();
$socials = $indexController->getSocials();
$menuItems = $indexController->getMenu()->getMenuItems();
?>
<header class="header">
    <div class="header__avatar">
        <img src="<?php echo $indexController->getPage()->get('avatar')->url; ?>" alt="<?php echo $indexController->getPage()->get('title'); ?>">
    </div>
    <div class="header__name">
        <?php echo $indexController->getPage()->get('title'); ?>
    </div>
    <div class="header__burger">
        <div class="js-toggle-menu">
            <?php require_once apply_filters(UNDFND_WP_LINKY_DOMAIN . '_menu_icon', UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/menu.svg') ?>
        </div>
    </div>
</header>
<?php if(!$socials->isEmpty()): ?>
    <nav class="header__social-bar <?php echo $indexController->getPage()->get('social_display') == 'yes' ? 'social-hide' : ''; ?>">
        <?php foreach ($socials->getAll() as $social => $value): ?>
            <?php if(!empty($value)): ?>
                <a href="<?php echo $value; ?>" class="<?php echo sanitize_title($social); ?>" title="<?php echo ucfirst($social); ?>">
                    <?php require_once UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . sanitize_title($social) . '.svg' ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
<?php if(!empty($menuItems)): ?>
    <nav class="header__menu">
        <?php foreach ($menuItems as $menuItem): ?>
            <?php if(!empty($menuItem->url) && empty($menuItem->menu_item_parent)): ?>
                <a href="<?php echo $menuItem->url; ?>">
                    <?php echo $menuItem->title; ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>