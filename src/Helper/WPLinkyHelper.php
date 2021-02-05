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
    public static function getIndexController($page_id = false)
    {
        $indexController = new IndexController($page_id);

        return $indexController;
    }

    /**
     * Get page option key
     *
     * @return string
     */
    public static function getPageOptionKey($page_id = false)
    {
        return 'wp_linky_' . self::WP_LINKY_OPTION_PAGE_KEY . (!empty($page_id) ? '_' . $page_id : '');
    }

    /**
     * Get all pages options
     *
     * @return array
     */
    public static function getPageOption($page_id = false)
    {
        $options = get_option(self::getPageOptionKey($page_id));
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
    public static function getPage($group = false, $page_id = false)
    {
        $options = self::getPageOption($page_id);
        foreach(['global', 'appareance', 'social', 'links', 'themes', 'page_name'] as $item) {
            if(!array_key_exists($item, $options))
                $options[$item] = [];
        }

        return !empty($group) ? self::getOptionValue($group, $options) : $options;
    }

    /**
     * Get Links Pages
     *
     * @return array
     */
    public static function getPages()
    {
        global $wpdb;
        $pages = [];
        $pagesQ = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'wp_linky_page%'");
        if(!empty($pagesQ)) {
            foreach($pagesQ as $page) {
                $key = ($page->option_name == self::getPageOptionKey()) ? 0 : str_replace(self::getPageOptionKey() . '_', '', $page->option_name);
                $options = unserialize($page->option_value);
                $pages[$key] = !empty($options['page_name']) ? $options['page_name'] : __( 'Default page', 'linky' );
            }
        }

        return $pages;
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


    /**
     * Set Default Page content
     *
     * @param bool $page_id
     */
    public static function setDefaultContent($page_id = false, $slug = 'links', $page_name = false)
    {
        $options = get_option(self::getPageOptionKey($page_id));
        if(empty($options)) {
            $dbOptions = self::getPage(false, $page_id);
            $options = array_merge($dbOptions, [
                'page_name' => !empty($page_name) ? $page_name : __('Default page', 'linky'),
                'global' => [
                    'slug' => $slug,
                    'categories' => self::getDefaultCategories(),
                    'labels' => self::getDefaultLabels(),
                ],
                'appareance' => [],
                'themes' => [
                    'header_theme' => 'default',
                    'body_theme' => 'default',
                ]
            ]);

            $options['appareance'] = ThemesHelper::prepareThemeOverride($options);
            $options['appareance']['social_display']  = 'no';

            update_option(self::getPageOptionKey($page_id), $options);
            flush_rewrite_rules(true);
        }
    }

    /**
     * Get Next Page ID
     *
     * @return int
     */
    public static function getNextPageId()
    {
        $pageId = intval(get_option('linky_next_page_id'));
        update_option('linky_next_page_id', $pageId + 1);

        return $pageId + 1;
    }

    /**
     * Remove page
     */
    public static function removePage($page_id)
    {
        delete_option(self::getPageOptionKey($page_id));
    }

    /**
     * Get Total Stats
     * @todo
     * @return array;
     */
    public static function getTotals($links = [], $page_id = 0)
    {
        $stats = [
            'global' => [
                'weekly' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
                'monthly' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
                'total' => [
                    'views' => 0,
                    'clicks' => 0,
                ],
            ]
        ];

        foreach($links as &$link) {
            if(empty($link['link']) || $link['type'] == 'separator')
                continue;

            $link_stat = get_option('link_stat_' . $page_id . '_' . md5($link['link']));
            $link_stat = !empty($link_stat) ? $link_stat : [];

            $link['monthly_count']  = count(array_filter($link_stat, function($v) {
                return $v > strtotime("-1 month");
            }));

            $link['weekly_count']   = count(array_filter($link_stat, function($v) {
                return $v > strtotime("-1 week");
            }));

            $link['total_count']    = count($link_stat);

            $stats['global']['weekly']['clicks']    += $link['weekly_count'];
            $stats['global']['monthly']['clicks']   += $link['monthly_count'];
            $stats['global']['total']['clicks']     += $link['total_count'];
        }

        $page_stat = get_option('page_stat_' . $page_id);
        $page_stat = !empty($page_stat) ? $page_stat : [];

        $stats['global']['total']['views']      = count($page_stat);

        $stats['global']['weekly']['views']     = count(array_filter($page_stat, function($v) {
            return $v > strtotime("-1 week");
        }));
        $stats['global']['monthly']['views']    = count(array_filter($page_stat, function($v) {
            return $v > strtotime("-1 month");
        }));

        $stats['links'] = $links;

        return $stats;
    }
}
