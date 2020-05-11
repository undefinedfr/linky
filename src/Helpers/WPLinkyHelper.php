<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helpers;

use LinkyApp\Controllers\indexController;
use LinkyApp\Entity\Link;
use LinkyApp\Entity\Socials;

/**
 * Class WPLinkyHelper
 * @since 0.0.1
 */
abstract class WPLinkyHelper
{
    const WP_LINKY_OPTION_PAGE_KEY = 'page';

    public static function getIndexController()
    {
        $indexController = new indexController();

        return $indexController;
    }

    public static function getPageOptionKey()
    {
        return UNDFND_WP_LINKY_DOMAIN . '_' . self::WP_LINKY_OPTION_PAGE_KEY;
    }

    public static function getPageOption()
    {
        return get_option(self::getPageOptionKey());
    }

    public static function getRandomIdentifier()
    {
        return sanitize_title(wp_generate_uuid4());
    }

    public static function getDefaultLabels()
    {
        $link = new Link();
        return implode(',', $link->get('defaultLabels'));
    }

    public static function getDefaultCategories()
    {
        $link = new Link();
        return implode(',', $link->get('defaultCategories'));
    }

    public static function getOptionValue($key, $data, $default = null)
    {
        return !empty($data[$key]) ? $data[$key] : $default;
    }

    public static function getSocials()
    {
        return array_keys(get_class_vars(Socials::class));
    }

    public static function getViewPath($partial = null)
    {
        return UNDFND_WP_LINKY_PLUGIN_DIR . 'views/' . ($partial ? $partial . '.php' : '');
    }

    public static function getPage($group = false)
    {
        $options = self::getPageOption();
        foreach(['global', 'appareance', 'social', 'links'] as $item) {
            if(!array_key_exists($item, $options))
                $options[$item] = [];
        }

        return !empty($group) ? self::getOptionValue($group, $options) : $options;
    }

    public static function unEscape($field)
    {
        if(is_string($field)):
            $field = stripslashes($field);
            $field = str_replace('"', '&quot;', $field);
        endif;

        return $field;
    }
}