<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

/*
  Plugin Name: Linky
  Plugin URI: https://www.undefined.fr
  Description: Create & manage link’s hub for your  social profile directly in your websites
  Version: 1.1.1
  Author Name: Nicolas RIVIERE (hello@undefined.fr)
  Author: Nicolas RIVIERE (Undefined)
  Domain Path: /languages
  Text Domain: linky
  Author URI: https://www.undefined.fr/#about
 */

namespace LinkyApp;

use LinkyApp\Helper\WPLinkyHelper;

define('UNDFND_WP_LINKY_DOMAIN', 'linky');
define('UNDFND_WP_LINKY_SLUG', 'wp-linky');
define('UNDFND_WP_LINKY_PLUGIN_URL', plugins_url('', __FILE__));
define('UNDFND_WP_LINKY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UNDFND_WP_LINKY_PLUGIN_REALPATH', dirname( plugin_basename( __FILE__ ) ));
define('UNDFND_WP_LINKY_PLUGIN_REALDIRPATH', plugin_basename( __FILE__ ));
define('UNDFND_WP_LINKY_PLUGIN_APP_DIR', UNDFND_WP_LINKY_PLUGIN_DIR . 'src');
define('UNDFND_WP_LINKY_THEME_DIR', get_template_directory() . '/' . UNDFND_WP_LINKY_SLUG);
define('UNDFND_WP_LINKY_THEME_APP_DIR', UNDFND_WP_LINKY_THEME_DIR . 'src');

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Linky Helper
require_once( UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Helper/WPLinkyHelper.php' );

/**
 * Include App
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR);

/**
 * Include Helpers
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Helper', ['WPLinkyHelper']);

/**
 * Include Controllers
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Controllers');

/**
 * Include Entities
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Entity');

/**
 * Include Types
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Type'); // from plugin
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_THEME_APP_DIR . '/Type'); // from theme

/**
 * Include Themes
 */
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Theme');
// Header
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Theme/Header'); // from plugin
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_THEME_APP_DIR . '/Theme/Header'); // from theme

// Body
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_PLUGIN_APP_DIR . '/Theme/Body'); // plugin
WPLinkyHelper::includesFiles(UNDFND_WP_LINKY_THEME_APP_DIR . '/Theme/Body'); // from theme

$wpLinky = new Linky();
