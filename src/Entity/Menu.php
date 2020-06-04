<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

/**
 * Class Socials
 * @since 1.0.0
 */
class Menu
{
    public $items = [];

    public function __construct($menuId = false)
    {
        if($menuId) {
            $this->items = wp_get_nav_menu_items($menuId);
        }
    }

    /**
     * Return Menu items
     *
     * @return array|false
     */
    public function getMenuItems()
    {
        return $this->items;
    }
}
