<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helper;

/**
 * Class ThemesHelper
 * @since 0.0.1
 */
abstract class ThemesHelper
{
    const PLUGIN_DATA_APP_DIR = UNDFND_WP_LINKY_PLUGIN_DIR . 'data/themes';
    const THEME_DATA_APP_DIR  = UNDFND_WP_LINKY_THEME_DIR . 'data/themes';
    const PLUGIN_DATA_GRADIENT_APP_DIR = UNDFND_WP_LINKY_PLUGIN_DIR . 'data/gradients';
    const THEME_DATA_GRADIENT_APP_DIR  = UNDFND_WP_LINKY_THEME_DIR . 'data/gradients';

    public static function getHeaderThemes()
    {
        return self::_getThemeFilesByType('header');
    }

    public static function getBodyThemes()
    {
        return self::_getThemeFilesByType('body');
    }

    public static function getGradients()
    {
        return self::_getGradientFiles();
    }

    public static function getHeaderThemeById($themeId = 'default')
    {
        return self::getThemeFileById($themeId, 'header');
    }

    public static function getColorTheme()
    {
        global $wpLinky;
        $options = $wpLinky->getOptions();
        $themes = WPLinkyHelper::getOptionValue('themes', $options);
        $themeData = self::getThemeFileById($themes['body_theme'], 'body');
        return is_array($themeData) ?$themeData['text_color'] : $themeData->get('text_color') ;
    }

    public static function getBodyThemeById($themeId = 'default')
    {
        return self::getThemeFileById($themeId, 'body');
    }

    public static function getThemeFileById($theme, $type)
    {
        $suffix = $type . '/' . $theme . '.json';
        $themeFile = self::THEME_DATA_APP_DIR . '/' . $suffix;
        if(!file_exists($themeFile)) {
            $themeFile = self::PLUGIN_DATA_APP_DIR . '/' . $suffix;
        }

        $content = file_get_contents($themeFile);
        $json = json_decode($content, true);
        $className = '\LinkyApp\Theme\\' . ucfirst($type) . '\Abstract' . ucfirst($type) . 'Theme';
        return new $className($theme, $json);
    }

    private static function _getThemeFilesByType($type, $only_keys = false)
    {
        return array_merge(self::_getFiles(self::PLUGIN_DATA_APP_DIR, $type, $only_keys), self::_getFiles(self::THEME_DATA_APP_DIR, $type, $only_keys));
    }

    private static function _getGradientFiles()
    {
        return array_merge(self::_getGradientFilesData(self::PLUGIN_DATA_GRADIENT_APP_DIR), self::_getGradientFilesData(self::THEME_DATA_GRADIENT_APP_DIR));
    }

    private static function _getFiles($dirPath, $type, $only_keys = false, $load = true)
    {
        $data = [];
        if(is_dir($dirPath . '/' . $type)) {
            $files = scandir($dirPath . '/' . $type);
            foreach($files as $file){
                if(preg_match('#.json#i', $file)){
                    $id = str_replace( '.json', '', $file);
                    $data[$id] = [];
                    if(!$only_keys) {
                        $content = file_get_contents($dirPath . '/' . $type . '/' . $file);
                        $json = json_decode($content, true);
                        if($load) {
                            $className = '\LinkyApp\Theme\\' . ucfirst($type) . '\Abstract' . ucfirst($type) . 'Theme';
                            $data[$id] = new $className($id, $json);
                        } else {
                            $data[$id] = $json;
                        }
                    }
                }
            }
        }

        return ((bool) $only_keys) ? array_keys($data) : $data;
    }

    private static function _getGradientFilesData($dirPath)
    {
        $data = [];
        if(is_dir($dirPath)) {
            $files = scandir($dirPath);
            foreach($files as $file){
                if(preg_match('#.json#i', $file)){
                    $id = str_replace( '.json', '', $file);
                    $content = file_get_contents($dirPath . '/' . $file);
                    $data[$id] = json_decode($content, true);
                }
            }
        }

        return $data;
    }
}