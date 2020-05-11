<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
?>

<nav class="menu-wp-linky">
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_menuSlug); ?>"
        class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_menuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Settings', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_linksMenuSlug); ?>"
        class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_linksMenuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Links', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_appareanceMenuSlug); ?>"
       class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_appareanceMenuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Appareance', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_socialMenuSlug); ?>"
       class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_socialMenuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Social', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
    <a
        href="<?php echo admin_url('admin.php?page=' . $this->_themesMenuSlug); ?>"
       class="<?php echo (!empty($_GET['page']) && $_GET['page'] == $this->_themesMenuSlug) ? 'active' : '' ?>"
    >
        <?php echo __('Themes', UNDFND_WP_LINKY_DOMAIN); ?>
    </a>
</nav>