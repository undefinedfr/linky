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
 * @since 1.0.0
 */
abstract class ThemesHelper
{
    const PLUGIN_DATA_APP_DIR = UNDFND_WP_LINKY_PLUGIN_DIR . 'data/themes';
    const THEME_DATA_APP_DIR  = UNDFND_WP_LINKY_THEME_DIR . 'data/themes';
    const PLUGIN_DATA_GRADIENT_APP_DIR = UNDFND_WP_LINKY_PLUGIN_DIR . 'data/gradients';
    const THEME_DATA_GRADIENT_APP_DIR  = UNDFND_WP_LINKY_THEME_DIR . 'data/gradients';

    /**
     * Get header themes
     *
     * @return array
     */
    public static function getHeaderThemes()
    {
        return self::_getThemeFilesByType('header');
    }

    /**
     * Get header themes
     *
     * @return array
     */
    public static function getBodyThemes()
    {
        return self::_getThemeFilesByType('body');
    }

    /**
     * Get gradients array
     *
     * @return array
     */
    public static function getGradients()
    {
        return self::_getGradientFiles();
    }

    /**
     * Get header theme by id
     *
     * @param string $themeId theme id
     *
     * @return object
     */
    public static function getHeaderThemeById($themeId = 'default')
    {
        return self::getThemeFileById($themeId, 'header');
    }

    /**
     * Get body theme by id
     *
     * @param string $themeId body id
     *
     * @return object
     */
    public static function getBodyThemeById($themeId = 'default')
    {
        return self::getThemeFileById($themeId, 'body');
    }

    /**
     * Get color for theme
     *
     * @return string
     */
    public static function getColorTheme($page_id = false)
    {
        global $wpLinky;
        $options = $wpLinky->getOptions($page_id);
        $themes = WPLinkyHelper::getOptionValue('themes', $options);
        $themeData = self::getThemeFileById($themes['body_theme'], 'body');
        return is_array($themeData) ? $themeData['text_color'] : $themeData->get('text_color') ;
    }

    /**
     * Get theme file by id
     *
     * @param string $theme theme name
     * @param string $type type (header|footer)
     *
     * @return object
     */
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

    /**
     * Prepare theme for override
     *
     * @param array $data
     *
     * @return array
     */
    public static function prepareThemeOverride($data)
    {
        $headerTheme = ThemesHelper::getHeaderThemeById($data['themes']['header_theme']);
        $data['appareance'] = array_merge($data['appareance'], $headerTheme->getAll());

        $bodyTheme = ThemesHelper::getBodyThemeById($data['themes']['body_theme']);
        $data['appareance'] = array_merge($data['appareance'], $bodyTheme->getAll());

        return $data['appareance'];
    }

    /**
     * Get google fonts
     *
     * @param \LinkyApp\Entity\Page $page
     */
    public static function getFonts($page)
    {
        $fonts = [
            'header_font_family',
            'links_label_font_family',
            'links_font_family',
            'separator_font_family',
        ];
        $fontsToInclude = [];
        foreach($fonts as $key) {
            $font = $page->get($key);
            $value = str_replace(' ', '+', $font) . ':wght@400;600';
            if(!in_array($value, $fontsToInclude) && $font)
                $fontsToInclude[] = $value;
        }

        $url = 'https://fonts.googleapis.com/css2?family=' . ($fontsToInclude ? implode('&family=', $fontsToInclude): 'Open+Sans:wght@400;600') . '&display=swap';
        $css = get_transient(md5($url));
        if(!$css) {
            $css = file_get_contents($url);
            set_transient(md5($url), $css);
        }

        return $css;
    }

    /**
     * Get themes files by type
     *
     * @param string $type type (header|footer)
     * @param bool $only_keys return only keys
     *
     * @return array
     */
    private static function _getThemeFilesByType($type, $only_keys = false)
    {
        return array_merge(self::_getFiles(self::PLUGIN_DATA_APP_DIR, $type, $only_keys), self::_getFiles(self::THEME_DATA_APP_DIR, $type, $only_keys));
    }

    /**
     * Get gradients files
     *
     * @return array
     */
    private static function _getGradientFiles()
    {
        return array_merge(self::_getGradientFilesData(self::PLUGIN_DATA_GRADIENT_APP_DIR), self::_getGradientFilesData(self::THEME_DATA_GRADIENT_APP_DIR));
    }

    /**
     * Get files
     *
     * @param string $dirPath path of dir
     * @param string $type type (header|footer)
     * @param bool $only_keys return only keys
     * @param bool $load load object or not
     *
     * @return array
     */
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

    /**
     * Get gradient file data
     *
     * @param string $dirPath path of dir
     *
     * @return array
     */
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
