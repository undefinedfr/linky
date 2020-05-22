<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
$menus = [
    $this->_linksMenuSlug       => 'Links',
    $this->_appareanceMenuSlug  => 'Appareance',
    $this->_socialMenuSlug      => 'Social',
    $this->_themesMenuSlug      => 'Themes',
]
?>

<nav class="menu-wp-linky">
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_menuSlug); ?>"
        class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_menuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Settings', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
    <?php foreach ($menus as $link => $menu): ?>
        <a
                href="<?php echo admin_url('admin.php?page=' . $this->_getMenuSlug($link)); ?>"
                class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_getMenuSlug($link)) ? 'active' : '' ?>"
        >
            <?php echo __($menu, UNDFND_WP_LINKY_DOMAIN); ?>
        </a>
    <?php endforeach; ?>
</nav>