<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp;

/*
  Plugin Name: Linky
  Plugin URI: https://www.undefined.fr
  Description: Create Link Hub Page for your site
  Version: 0.0.1
  Author Name: Nicolas RIVIERE (hello@undefined.fr)
  Author: Nicolas RIVIERE (Undefined)
  Author URI: https://www.undefined.fr
 */


use LinkyApp\Helpers\WPLinkyHelper;

define('UNDFND_WP_LINKY_PLUGIN_URL', plugins_url('', __FILE__));
define('UNDFND_WP_LINKY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UNDFND_WP_LINKY_DOMAIN', 'wp_linky');
define('UNDFND_WP_LINKY_SLUG', 'wp-linky');

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//require_once __DIR__ . '/vendor/autoload.php';

// Helpers
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Helpers/WPLinkyHelper.php' );
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Helpers/ThemesHelper.php' );
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Helpers/PostHelper.php' );

// Controllers
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Controllers/ajaxController.php' );
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Controllers/indexController.php' );

// Types
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Types/abstractType.php' );
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Types/defaultType.php' );
require_once( UNDFND_WP_LINKY_PLUGIN_DIR . 'src/Types/defaultType.php' );

$entityDirClasses = __DIR__ . '/src/Entity';
if(is_dir($entityDirClasses)) {
    $files = scandir($entityDirClasses);
    foreach($files as $file){
        if(preg_match('#.php$#i', $file)){
            include_once( $entityDirClasses . '/' . $file );
        }
    }
}
$typesDirClasses = __DIR__ . '/src/Types';
if(is_dir($typesDirClasses)) {
    $files = scandir($typesDirClasses);
    foreach($files as $file){
        if(preg_match('#Type.php$#i', $file)){
            include_once( $typesDirClasses . '/' . $file );
        }
    }
}

$themeDirClasses = get_template_directory() . '/' . UNDFND_WP_LINKY_SLUG . '/src/Type';
if(is_dir($themeDirClasses)) {
    $files = scandir($themeDirClasses);
    foreach($files as $file){
        if(preg_match('#Type.php$#i', $file)){
            include_once( $themeDirClasses . '/' . $file );
        }
    }
}

/**
 * Class WP_Linky
 * @since 0.0.1
 */
class WP_Linky {

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
     * @var string Default front slug
     */
    private $_defaultSlug               = 'linky';

    /**
     * @var array
     */
    private $_defaultTypes              = [
            'link'
    ];

    /**
     * @var array
     */
    private $_options                   = [];


    public function __construct()
    {
        $this->_pageTitle = __($this->_pageTitle, UNDFND_WP_LINKY_DOMAIN);

        $this->_options = $this->getOptions();

        register_activation_hook( __FILE__, [$this, UNDFND_WP_LINKY_DOMAIN . '_install'] );

        add_filter( 'plugin_action_links', [$this, 'addSettingsLink'], 10, 2 );
        add_filter( 'template_include', [$this, 'linkyTemplateInclude'] );

        add_action( 'admin_menu', [ $this, 'addMenu'] );
        add_action( 'admin_enqueue_scripts', [$this, 'linkyAdminPluginEnqueue'] );
        add_action( 'wp_enqueue_scripts', [$this, 'linkyPluginEnqueue'] );
        add_action( 'plugins_loaded', [$this, 'loadPluginTextdomain'] );
        add_action( 'init', [$this, 'linkyRewriteRule'], 10, 0);
        add_action( 'query_vars', [$this, 'linkyQueryParams'] );

        if(empty($this->_options['global']['theme_style']) || $this->_options['global']['theme_style'] == 'no')
            add_action( 'wp_print_styles', [$this, 'linkyRemoveAllStyles'], 100);

        if(!empty($_GET['saved']) && !empty($_GET['page']) && $_GET['page'] == UNDFND_WP_LINKY_SLUG){
            add_action( 'admin_notices', [$this, 'displayAdminNotice'] );
        }

//        if(!empty($_GET['page']) && $_GET['page'] == UNDFND_WP_LINKY_SLUG) {
//            add_action('init', [$this, 'submitForm']);
//        }
        $this->instanceTypes();
        $this->addImageSizes();

        do_action(UNDFND_WP_LINKY_DOMAIN . '_after_construct', $this);

    }

    /**
     *  Hook plugin install
     *
     * @return void;
     */
    public function wp_linky_install()
    {
        do_action(UNDFND_WP_LINKY_DOMAIN . '_install');

        @register_uninstall_hook( __FILE__, [ $this, UNDFND_WP_LINKY_DOMAIN . '_uninstall' ] );
    }

    /**
     *  Hook plugin uninstall
     *
     * @return void;
     */
    public function wp_linky_uninstall()
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
        load_plugin_textdomain( UNDFND_WP_LINKY_DOMAIN, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }


    /**
     * Enqueue scripts with parameters for admin
     *
     * @return void;
     */
    public function linkyAdminPluginEnqueue()
    {
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
        do_action(UNDFND_WP_LINKY_DOMAIN . '_before_enqueue', $this->_menuSlug);

//        wp_enqueue_script( $this->_menuSlug, UNDFND_WP_LINKY_PLUGIN_URL . '/assets/dist/' . $this->_menuSlug . '.js' );
//        wp_localize_script( $this->_menuSlug, 'args', [
//            'ajaxurl' => admin_url( 'admin-ajax.php' ),
//        ] );
        if(!empty(get_query_var( 'is_linky' ))) {
            wp_enqueue_style($this->_menuSlug, UNDFND_WP_LINKY_PLUGIN_URL . '/assets/css/themes.css');
        }

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
                __($this->_pageTitle, UNDFND_WP_LINKY_DOMAIN),
                __($this->_pageTitle, UNDFND_WP_LINKY_DOMAIN),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_menu_page_capalibilty', 'manage_options'),
                $this->_menuSlug,
                [ &$this, 'addPage' ],
                'dashicons-editor-table'
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Appareance', UNDFND_WP_LINKY_DOMAIN),
                __('Appareance', UNDFND_WP_LINKY_DOMAIN),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_appareanceMenuSlug),
                [ &$this, 'addAppareancePage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Social', UNDFND_WP_LINKY_DOMAIN),
                __('Social', UNDFND_WP_LINKY_DOMAIN),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_socialMenuSlug),
                [ &$this, 'addSocialPage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Links', UNDFND_WP_LINKY_DOMAIN),
                __('Links', UNDFND_WP_LINKY_DOMAIN),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_linksMenuSlug),
                [ &$this, 'addLinksPage' ]
        );

        add_submenu_page(
                $this->_menuSlug,
                __('Themes', UNDFND_WP_LINKY_DOMAIN),
                __('Themes', UNDFND_WP_LINKY_DOMAIN),
                apply_filters(UNDFND_WP_LINKY_DOMAIN . '_submenu_page_capalibilty', 'manage_options'),
                $this->_getMenuSlug($this->_themesMenuSlug),
                [ &$this, 'addThemesPage' ]
        );
    }

    /**
     * Instanciate Types
     *
     * @return void;
     */
    public function instanceTypes()
    {
        $types = $this->_defaultTypes;
        if($types) {
            foreach($types as $k => $type){
                $className = $k . 'Type';
                if(class_exists($className)) {
                    $type = new $className();

                    do_action(UNDFND_WP_LINKY_DOMAIN . '_after_type_instance', $type);
                    do_action(UNDFND_WP_LINKY_DOMAIN . '_after_type_' . $k . '_instance', $type);
                }
            }
        }
    }

    /**
     * Add image size
     *
     * @return void;
     */
    public function addImageSizes()
    {
        add_image_size( 'icon', 50, 50, true );
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
     * Get Plugin Options
     *
     * @return array;
     */
    public function getOptions()
    {
        if(empty($this->options)) {
            $this->_options = WPLinkyHelper::getPage();
        }
        return $this->_options;
    }

    public function displayAdminNotice()
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo __( 'Settings saved', UNDFND_WP_LINKY_DOMAIN ); ?></p>
        </div>
        <?php
    }

    public function getIndexController()
    {
        if(empty($this->indexController))
            $this->indexController = WPLinkyHelper::getIndexController();

        return $this->indexController;
    }

    public function linkyRewriteRule()
    {
        $options = WPLinkyHelper::getPage('global');
        add_rewrite_rule('^' . (!empty($options['slug']) ? $options['slug'] : $this->_defaultSlug) . '/?' ,'index.php?is_linky=1','top');
    }

    public function linkyTemplateInclude( $template )
    {
        if ( empty(get_query_var( 'is_linky' )) ) {
            return $template;
        }

        return WPLinkyHelper::getViewPath('front/index');
    }

    public function linkyRemoveAllStyles()
    {
        if ( empty(get_query_var( 'is_linky' )) || is_admin() ) {
            return;
        }

        global $wp_styles;
        $wp_styles->queue = [$this->_menuSlug];
    }

    public function linkyQueryParams( $query_vars )
    {
        $query_vars[] = 'is_linky';
        return $query_vars;
    }

    private function _getPage($page = 'settings')
    {
        include WPLinkyHelper::getViewPath('header');
        include WPLinkyHelper::getViewPath($page);
        include WPLinkyHelper::getViewPath('footer');
    }

    private function _getMenuSlug($slug)
    {
        return $this->_menuSlug . '-' . $slug;
    }
}

$wpLinky = new WP_Linky();