<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp;

use LinkyApp\Helper\ThemesHelper;
use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class Linky
 * @since 1.0.0
 */
class Linky {

    /**
     * @var string Page title & Menu label
     */
    private $_pageTitle                 = 'Linky';

    /**
     * @var string Settings page slug
     */
    private $_menuSlug                  = UNDFND_WP_LINKY_SLUG;

    /**
     * @var string Appareance settings page slug
     */
    private $_appareanceMenuSlug        = 'appareance';

    /**
     * @var string Social settings page slug
     */
    private $_socialMenuSlug            = 'social';

    /**
     * @var string Links settings page slug
     */
    private $_linksMenuSlug             = 'links';

    /**
     * @var string Themes settings page slug
     */
    private $_themesMenuSlug             = 'themes';

    /**
     * @var string Stats settings page slug
     */
    private $_statsMenuSlug             = 'stats';

    /**
     * @var string Default front slug
     */
    private $_defaultSlug               = 'linky';

    /**
     * @var array
     */
    private $_options                   = [];

    /**
     * @var array
     */
    private $_pages                     = [];

    /**
     * @var array
     */
    private $_currentPage               = 0;


    public function __construct()
    {
        $this->_setCurrentPage();
        $this->_pageTitle = __($this->_pageTitle, 'linky');

        $this->_pages = $this->getPages();
        $this->_options = $this->getOptions($this->getCurrentPage());

        add_filter( 'plugin_action_links', [$this, 'addSettingsLink'], 10, 2 );
        add_filter( 'template_include', [$this, 'linkyTemplateInclude'], 99, 1 );

        add_action( 'activate_' . UNDFND_WP_LINKY_PLUGIN_REALDIRPATH, [$this, UNDFND_WP_LINKY_DOMAIN . '_install'] );
        add_action( 'admin_menu', [ $this, 'addMenu'] );
        add_action( 'admin_enqueue_scripts', [$this, 'linkyAdminPluginEnqueue'] );
        add_action( 'wp_enqueue_scripts', [$this, 'linkyPluginEnqueue'] );
        add_action( 'plugins_loaded', [$this, 'loadPluginTextdomain'] );
        $ps = get_option('permalink_structure');
        if(!empty($ps))
            add_action( 'init', [$this, 'linkyRewriteRule'], 10, 0);

        add_action( 'query_vars', [$this, 'linkyQueryParams'] );

        if(empty($this->_options['global']['theme_style']) || $this->_options['global']['theme_style'] == 'no')
            add_action( 'wp_print_styles', [$this, 'linkyRemoveAllStyles'], 100);

        add_action( 'admin_init', [$this, 'welcomeMessageHandler'], 10, 0);

        $this->addImageSizes();

        do_action(UNDFND_WP_LINKY_DOMAIN . '_after_construct', $this);

    }

    /**
     *  Hook plugin install
     *
     * @return void;
     */
    public function linky_install()
    {
        do_action(UNDFND_WP_LINKY_DOMAIN . '_install');

        WPLinkyHelper::setDefaultContent();

        @register_uninstall_hook( __FILE__, [ $this, UNDFND_WP_LINKY_DOMAIN . '_uninstall' ] );
    }

    /**
     *  Hook plugin uninstall
     *
     * @return void;
     */
    public function linky_uninstall()
    {
        do_action(UNDFND_WP_LINKY_DOMAIN . '_uninstall');
    }


    /**
     * Load plugin textdomain
     *
     * @return void;
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain( 'linky', FALSE, UNDFND_WP_LINKY_PLUGIN_REALPATH . '/languages/' );
    }


    /**
     * Enqueue scripts with parameters for admin
     *
     * @return void;
     */
    public function linkyAdminPluginEnqueue()
    {
        if(strpos(get_current_screen()->base,  'wp-linky') === false)
            return;

        do_action(UNDFND_WP_LINKY_DOMAIN . '_before_admin_enqueue', $this->_menuSlug);

        // Medias
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        // Script
        wp_enqueue_script(
                $this->_menuSlug,
                UNDFND_WP_LINKY_PLUGIN_URL . '/assets/dist/' . $this->_menuSlug . '.js',
                [
                    'jquery-ui-core',
                    'jquery-ui-sortable'
                ]
        );

        // Script variables
        wp_localize_script(
            $this->_menuSlug,
            'args',
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'promptMessage' => __('You have unsaved changes, are you sure ?', 'linky'),
                'gradients' => ThemesHelper::getGradients(),
            ]
        );

        // Style
        wp_enqueue_style(
            $this->_menuSlug,
            UNDFND_WP_LINKY_PLUGIN_URL . '/assets/css/' . $this->_menuSlug . '.css'
        );

        do_action(UNDFND_WP_LINKY_DOMAIN . '_after_admin_enqueue', $this->_menuSlug);
    }


    /**
     * Enqueue scripts with parameters for front
     *
     * @return void;
     */
    public function linkyPluginEnqueue()
    {
        if(empty(get_query_var( 'is_linky' )))
            return;

        do_action(UNDFND_WP_LINKY_DOMAIN . '_before_enqueue', $this->_menuSlug);

        wp_enqueue_script( $this->_menuSlug . '-front', UNDFND_WP_LINKY_PLUGIN_URL . '/assets/dist/linky.js', ['jquery'] );
        wp_localize_script( $this->_menuSlug . '-front', 'linky_args', [ 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ewww_lazyload' => (bool) (is_plugin_active('ewww-image-optimizer/ewww-image-optimizer.php')) && get_option('ewww_image_optimizer_lazy_load') ] );


        wp_enqueue_style($this->_menuSlug . '-kaushan-font', 'https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap', false);

        wp_enqueue_style($this->_menuSlug, UNDFND_WP_LINKY_PLUGIN_URL . '/assets/css/themes.css');

        do_action(UNDFND_WP_LINKY_DOMAIN . '_after_enqueue', $this->_menuSlug);
    }

    /**
     * Add settings link on plugin row
     *
     * @return array
     *
     */
    public function addSettingsLink( $links, $file )
    {
        if ( $file === $this->_menuSlug . '/' . $this->_menuSlug . '.php' && current_user_can( 'manage_options' ) ) {
            $settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=' . $this->_menuSlug ), __( 'Settings' ) );
            array_unshift( $links, $settings_link );
        }

        return $links;
    }

    /**
     * Add Settings Menu
     *
     * @return void
     *
     */
    public function addMenu()
    {
        add_menu_page(
                __($this->_pageTitle, 'linky'),
                __($this->_pageTitle, 'linky'),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_menu_page_capalibilty', 'manage_options'),
                $this->_menuSlug,
                [ &$this, 'addPage' ],
                'dashicons-editor-table'
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Appearance', 'linky'),
                __('Appearance', 'linky'),
            apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_appareance_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_appareanceMenuSlug),
                [ &$this, 'addAppareancePage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Social', 'linky'),
                __('Social', 'linky'),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_social_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_socialMenuSlug),
                [ &$this, 'addSocialPage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Links', 'linky'),
                __('Links', 'linky'),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_links_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_linksMenuSlug),
                [ &$this, 'addLinksPage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Themes', 'linky'),
                __('Themes', 'linky'),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_themes_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_themesMenuSlug),
                [ &$this, 'addThemesPage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Stats', 'linky'),
                __('Stats', 'linky'),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_stats_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_statsMenuSlug),
                [ &$this, 'addStatsPage' ]
        );
    }

    /**
     * Add image size
     *
     * @return void;
     */
    public function addImageSizes()
    {
        add_image_size( 'icon', 50, 50, true );
        add_image_size( 'icon_h', 0, 50, false );
    }

    /**
     * Add Settings Page
     *
     * @return void;
     */
    public function addPage()
    {
        $this->_getPage();
    }

    /**
     * Add Appareance Page
     *
     * @return void;
     */
    public function addAppareancePage()
    {
        $this->_getPage('appareance');
    }

    /**
     * Add Social Page
     *
     * @return void;
     */
    public function addSocialPage()
    {
        $this->_getPage('social');
    }

    /**
     * Add Social Page
     *
     * @return void;
     */
    public function addLinksPage()
    {
        $this->_getPage('links');
    }

    /**
     * Add Themes Page
     *
     * @return void;
     */
    public function addThemesPage()
    {
        $this->_getPage('themes');
    }

    /**
     * Add Stats Page
     *
     * @return void;
     */
    public function addStatsPage()
    {
        $this->_getPage('stats');
    }

    /**
     * Get Plugin Options
     *
     * @return array;
     */
    public function getOptions($page_id = false)
    {
        if(empty($this->_options)) {
            $this->_options = WPLinkyHelper::getPage(false, $page_id);
        }
        return $this->_options;
    }

    /**
     * Get Links Pages
     *
     * @return array;
     */
    public function getPages()
    {
        if(empty($this->_pages)) {
            $this->_pages = WPLinkyHelper::getPages();
        }
        return $this->_pages;
    }

    /**
     * Get Current Links Page
     *
     * @return array;
     */
    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    /**
     * Display admin notice
     */
    public function displayAdminNotice()
    {
        include_once WPLinkyHelper::getViewPath('welcome-notice');
    }

    /**
     * Get index controller
     *
     * @return Controllers\IndexController
     */
    public function getIndexController($page_id = false)
    {
        if(!is_admin())
            $page_id = get_query_var('linky_pageid');

        if(empty($this->indexController))
            $this->indexController = WPLinkyHelper::getIndexController(!empty($page_id) ? $page_id : $this->getCurrentPage());

        return $this->indexController;
    }

    /**
     * Add linky url rewrite
     */
    public function linkyRewriteRule()
    {
        foreach($this->getPages() as $page_id => $v) {
            $options = WPLinkyHelper::getPage('global', $page_id);
            add_rewrite_rule('^' . (!empty($options['slug']) ? $options['slug'] : $this->_defaultSlug) . '/?' ,'index.php?is_linky=1&linky_pageid=' . $page_id,'top');
        }
    }

    /**
     * Include linky template
     *
     * @param $template
     *
     * @return string
     */
    public function linkyTemplateInclude( $template )
    {
        if ( empty(get_query_var( 'is_linky' )) ) {
            return $template;
        }

        return WPLinkyHelper::getViewPath('front/index');
    }

    /**
     * Remove all style if necessary
     */
    public function linkyRemoveAllStyles()
    {
        if ( empty(get_query_var( 'is_linky' )) || is_admin() ) {
            return;
        }

        global $wp_styles;
        $wp_styles->queue = [$this->_menuSlug];
    }

    /**
     * Remove notice after button click or display it
     */
    public function welcomeMessageHandler()
    {
        if(isset($_GET['admin_notice_dismissed'])) {
            update_user_meta(get_current_user_id(), 'wp_linky_notice', 1);
        }

        $noticeDisplayed = get_user_meta(get_current_user_id(), 'wp_linky_notice');
        if(!empty($_GET['page']) && strpos($_GET['page'], UNDFND_WP_LINKY_SLUG) !== false && empty($noticeDisplayed)){
            add_action( 'admin_notices', [$this, 'displayAdminNotice'] );
        }
    }

    /**
     * Add linky query var param
     *
     * @param $query_vars
     *
     * @return array
     */
    public function linkyQueryParams( $query_vars )
    {
        $query_vars[] = 'is_linky';
        $query_vars[] = 'linky_pageid';
        return $query_vars;
    }

    /**
     * Include page files
     *
     * @param string $page
     */
    private function _getPage($page = 'settings')
    {
        include WPLinkyHelper::getViewPath('header');
        include WPLinkyHelper::getViewPath($page);
        include WPLinkyHelper::getViewPath('footer');
    }

    /**
     * Return menu slug
     *
     * @param $slug
     *
     * @return string
     */
    private function _getMenuSlug($slug)
    {
        return $this->_menuSlug . '-' . $slug;
    }

    /**
     * Set Current page id
     *
     * @return int;
     */
    private function _setCurrentPage()
    {
        $this->_currentPage = !empty($_GET['page_id']) ? $_GET['page_id'] : $this->_currentPage;
    }
}
