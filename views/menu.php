<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$menus = [
    $this->_themesMenuSlug      => 'Themes',
    $this->_appareanceMenuSlug  => 'Appearance',
    $this->_socialMenuSlug      => 'Social',
    $this->_linksMenuSlug       => 'Links',
]
?>

<nav class="menu-wp-linky">
    <a
        href="<?php echo esc_url( admin_url('admin.php?page=' . $this->_menuSlug) ); ?>"
        class="<?php echo esc_attr( (!empty($_GET['page']) && $_GET['page'] == $this->_menuSlug) ? 'active' : '' ) ?>"
    >
        <?php esc_html_e('Settings', 'linky'); ?>
    </a>
    <?php foreach ($menus as $link => $menu): ?>
        <a
                href="<?php echo esc_url( admin_url('admin.php?page=' . $this->_getMenuSlug($link)) ); ?>"
                class="<?php echo esc_attr( (!empty($_GET['page']) && $_GET['page'] == $this->_getMenuSlug($link)) ? 'active' : '' ) ?>"
        >
            <?php
            switch ( $menu ):
                case $menus[$this->_themesMenuSlug]:
                    esc_html_e('Themes', 'linky');
                    break;
                case $menus[$this->_appareanceMenuSlug]:
                    esc_html_e('Appearance', 'linky');
                    break;
                case $menus[$this->_socialMenuSlug]:
                    esc_html_e('Social', 'linky');
                    break;
                case $menus[$this->_linksMenuSlug]:
                    esc_html_e('Links', 'linky');
                    break;
            endswitch ?>
        </a>
    <?php endforeach; ?>
</nav>
