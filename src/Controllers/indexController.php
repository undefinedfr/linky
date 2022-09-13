<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Controllers;

use LinkyApp\Entity\Links;
use LinkyApp\Entity\Menu;
use LinkyApp\Entity\Page;
use LinkyApp\Entity\Socials;
use LinkyApp\Entity\Settings;
use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class IndexController
 * @since 1.0.0
 */
class IndexController
{
    public $page;
    public $socials;
    public $settings;
    public $menu;
    public $links;

    public function __construct()
    {
        $data               = WPLinkyHelper::getPage();
        $data               = !empty($data) ? $data : [];
        $this->settings     = new Settings($data['global']);
        $this->page         = new Page(array_merge($data['appareance'], $data['themes']));
        $this->socials      = new Socials($data['social']);
        $this->menu         = new Menu(!empty($data['appareance']['menu']) ? $data['appareance']['menu'] : false);
        $this->links        = new Links($data['links']);

        if ( WPLinkyHelper::pluginsExists(['wordpress-seo/wp-seo.php','wordpress-seo-premium/wp-seo-premium.php'] ) ) {
            foreach(['robots','canonical','metadesc','metakeywords','opengraph_title','opengraph_desc','opengraph_url','opengraph_type','opengraph_image','opengraph_site_name','opengraph_admin','opengraph_author_facebook','opengraph_show_publish_date','twitter_title','twitter_description','twitter_card_type','twitter_site','twitter_image','twitter_creator_account','json_ld_output'] as $filter) {
                add_filter('wpseo_' . $filter, [$this, 'remove_yoast_metas']);
            }
        }
    }

    public function getPage() {
        return $this->page;
    }

    public function getSocials() {
        return $this->socials;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getSettings() {
        return $this->settings;
    }

    public function getLinks() {
        return $this->links;
    }

    public function getHeader()
    {
        require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/html/header.php';
    }

    public function getFooter()
    {
        require_once UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/html/footer.php';
    }

    public function getContent($require = true)
    {
        $path = UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/page.php';
        if(!$require) {
            ob_start();
        }

        require_once $path;

        if(!$require) {
            $page = ob_get_contents();
            ob_end_clean();
            return $page;
        }
    }

    /**
     * Remove yoast meta for linky page
     *
     * @param $content
     * @return false|mixed
     */
    public function remove_yoast_metas( $content ) {
        if(!empty( get_query_var( 'is_linky' ) )) {
            return apply_filters(UNDFND_WP_LINKY_DOMAIN . '_yoast_meta_' . current_filter(), false);
        }

        return $content;
    }
}
