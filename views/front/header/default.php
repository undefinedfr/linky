<div class="header-wrapper <?php echo ($page->get('social_display') == 'yes' && !$socials->isEmpty()) ? 'is-social-hide' : ''; ?>">
    <header class="header <?php echo 'header--' . $page->get('header_theme', 'default'); ?>" style="background: <?php echo $background ?>; color: <?php echo $textColor ?>">
        <div class="_row <?php echo empty($menuItems) ? 'hidden-burger' : ''; ?>">
            <?php if(!empty($header_row_before)): ?>
                <?php echo $header_row_before; ?>
            <?php endif; ?>
            <?php if(empty($hide_avatar) && $page->get('avatar')->id != 0): ?>
                <div class="header__avatar">
                    <img src="<?php echo $page->get('avatar')->getImageUrl(!empty($image_size) ? $image_size : 'icon'); ?>" alt="<?php echo $page->get('title'); ?>">
                </div>
            <?php endif; ?>
            <?php if($page->get('title')): ?>
                <div class="header__name">
                    <?php echo $page->get('title'); ?>
                </div>
            <?php endif; ?>
            <div class="header__burger">
                <div class="js-toggle-menu" style="fill: <?php echo $textColor ?>">
                    <?php require_once apply_filters(UNDFND_WP_LINKY_DOMAIN . '_menu_icon', UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . (!empty($menu_icon) ? $menu_icon : 'menu') .'.svg') ?>
                </div>
            </div>
            <?php if(!empty($header_row_after)): ?>
                <?php echo $header_row_after; ?>
            <?php endif; ?>
            <div class="clearfix"></div>
            <div class="header__row-border" style="background-color: <?php echo $textColor ?>"></div>
        </div>
        <?php if($page->get('social_position', 'top') != 'bottom'): ?>
            <?php require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/socials.php'; ?>
        <?php endif ?>
    </header>
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

</div>
