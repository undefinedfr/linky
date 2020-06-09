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
 * @since 1.0.0
 */
abstract class WPLinkyHelper
{
    const WP_LINKY_OPTION_PAGE_KEY = 'page';

    /**
     * Get index cotroller class
     *
     * @return \LinkyApp\Controllers\IndexController
     */
    public static function getIndexController()
    {
        $indexController = new IndexController();

        return $indexController;
    }

    /**
     * Get page option key
     *
     * @return string
     */
    public static function getPageOptionKey()
    {
        return 'wp_linky_' . self::WP_LINKY_OPTION_PAGE_KEY;
    }

    /**
     * Get all pages options
     *
     * @return array
     */
    public static function getPageOption()
    {
        $options = get_option(self::getPageOptionKey());
        return !empty($options) ? $options : [];
    }

    /**
     * Get random identifier (sanitized)
     *
     * @return string
     */
    public static function getRandomIdentifier()
    {
        return sanitize_title(wp_generate_uuid4());
    }

    /**
     * Get default labels
     *
     * @return string
     */
    public static function getDefaultLabels()
    {
        $link = new Link();
        return implode(',', $link->get('defaultLabels'));
    }

    /**
     * Get default categories
     *
     * @return string
     */
    public static function getDefaultCategories()
    {
        $link = new Link();
        return implode(',', $link->get('defaultCategories'));
    }

    /**
     * Get option value from option key, and return default value if value is empty
     *
     * @param string $key option key
     * @param array $data options array
     * @param mixed $default default value return
     * @param string $callback callback function name
     *
     * @return mixed
     */
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

    /**
     * Get social keys
     *
     * @return array
     */
    public static function getSocials()
    {
        return array_keys(get_class_vars(Socials::class));
    }

    /**
     * Return view path form partial name
     *
     * @param string $partial partial name
     *
     * @return string
     */
    public static function getViewPath($partial = null)
    {
        return UNDFND_WP_LINKY_PLUGIN_DIR . 'views/' . ($partial ? $partial . '.php' : '');
    }

    /**
     * Get Options Page
     *
     * @param string|bool $group group needed
     *
     * @return string|array
     */
    public static function getPage($group = false)
    {
        $options = self::getPageOption();
        foreach(['global', 'appareance', 'social', 'links', 'themes'] as $item) {
            if(!array_key_exists($item, $options))
                $options[$item] = [];
        }

        return !empty($group) ? self::getOptionValue($group, $options) : $options;
    }

    /**
     * Unescape string
     *
     * @param string $field string
     * @param bool $escape
     *
     * @return string
     */
    public static function unEscape($field, $escape = true)
    {
        if(is_string($field) && $escape):
            $field = stripslashes($field);
            $field = str_replace('"', '&quot;', $field);
        endif;

        return $field;
    }

    /**
     * Filter code string
     *
     * @param string $code string code
     *
     * @return string
     */
    public static function codeFilter($code)
    {
        $code = str_replace("\'", "'", $code);
        $code = str_replace('\"', '"', $code);
        return $code;
    }

    /**
     * Include files from dir path
     *
     * @param string $dirPath dir path
     * @param array $exclude exclude files
     *
     * @return void
     */
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

    /**
     * Recursive sanitation for an array
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function recursiveSanitizeTextField($array) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = self::recursiveSanitizeTextField($value);
            }
            else if($key !== 'code_ga') {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }
}