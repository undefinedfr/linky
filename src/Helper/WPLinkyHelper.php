<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helper;

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
        $indexController = new IndexController();

        return $indexController;
    }

    public static function getPageOptionKey()
    {
        return UNDFND_WP_LINKY_DOMAIN . '_' . self::WP_LINKY_OPTION_PAGE_KEY;
    }

    public static function getPageOption()
    {
        $options = get_option(self::getPageOptionKey());
        return !empty($options) ? $options : [];
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

    public static function getOptionValue($key, $data, $default = null, $callback = false)
    {
        $value = !empty($data[$key]) ? $data[$key] : $default;
        if((bool) $callback) {
            if(is_array($callback)) {
                return ($callback[0] == self::class) ? $callback[0]::{$callback[1]}($value) : $callback[0]->{$callback[1]}($value);
            } else {
                return call_user_func($callback, $value);
            }
        } else {
            return $value;
        }
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
        foreach(['global', 'appareance', 'social', 'links', 'themes'] as $item) {
            if(!array_key_exists($item, $options))
                $options[$item] = [];
        }

        return !empty($group) ? self::getOptionValue($group, $options) : $options;
    }

    public static function unEscape($field, $escape = true)
    {
        if(is_string($field) && $escape):
            $field = stripslashes($field);
            $field = str_replace('"', '&quot;', $field);
        endif;

        return $field;
    }

    public static function codeFilter($value)
    {
        $value = str_replace("\'", "'", $value);
        $value = str_replace('\"', '"', $value);
        return $value;
    }

    public static function includesFiles($dirPath, $exclude = [])
    {
        if(is_dir($dirPath)) {
            $files = scandir($dirPath);
            foreach($files as $file){
                if(!in_array($file, $exclude) && preg_match('#.php$#i', $file)){
                    include_once( $dirPath . '/' . $file );
                }
            }
        }
    }
}