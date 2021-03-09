<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Controllers;

use LinkyApp\Helper\ThemesHelper;
use LinkyApp\Helper\WPLinkyHelper;
use LinkyApp\Theme\Body\AbstractBodyTheme;
use LinkyApp\Theme\Header\AbstractHeaderTheme;
use LinkyApp\Type\DefaultType;
use LinkyApp\Type\SeparatorType;

/**
 * Class AjaxController
 * @since 1.0.0
 */
class AjaxController
{
    private $_formData = [];
    private $_dbData = [];
    private $_pageId = false;
    private $_methods = [
        'save_form' => 'saveForm',
        'edit_page' => 'editPage',
        'page_viewed' => 'pageViewed',
        'link_clicked' => 'linkClicked',
        'get_admin_page_content' => 'getAdminPageContent',
        'get_link_template' => 'getLinkTemplate',
        'get_suggests' => 'getSuggests',
        'get_qr_code' => 'getQRCode',
    ];

    private $_methods_front = ['page_viewed', 'link_clicked'];

    public function __construct()
    {
        foreach($this->_methods as $action => $method) {
            add_action( 'wp_ajax_' . $action, [ $this, $method ] );
            if(in_array($action, $this->_methods_front))
                add_action( 'wp_ajax_nopriv_' . $action, [ $this, $method ] );
        }
    }

    public function saveForm()
    {
        if(!empty($_POST['_group'])){
            $this->_pageId = !empty($_POST['page_id']) ? $_POST['page_id'] : false;
            $this->_dbData = get_option(WPLinkyHelper::getPageOptionKey($this->_pageId));
            if(!is_array($this->_dbData))
                $this->_dbData = [];

            $data = $this->_save();
            wp_send_json_success($data);
        }
    }

    public function pageViewed()
    {
        if(isset($_GET['page_id'])) {
            $page_stat = get_option('page_stat_' . $_GET['page_id']);
            $page_stat = !empty($page_stat) ? $page_stat : [];

            $page_stat[] = strtotime(date('YmdHis'));
            update_option('page_stat_' . $_GET['page_id'], $page_stat);
        }
    }

    public function linkClicked()
    {
        if(isset($_GET['page_id']) && isset($_GET['link_url'])) {
            $link_stat = get_option('link_stat_' . $_GET['page_id'] . '_' . md5($_GET['link_url']));
            $link_stat = !empty($link_stat) ? $link_stat : [];

            $link_stat[] = strtotime(date('YmdHis'));
            update_option('link_stat_' . $_GET['page_id'] . '_' . md5($_GET['link_url']), $link_stat);
        }
    }

    public function editPage()
    {
        $this->_pageId = $_POST['page_id'] != '' ? $_POST['page_id'] : false;
        $actionType = !empty($_POST['action_type']) ? $_POST['action_type'] : false;

        $args = [];
        if ($actionType == 'save') {
            $args['reload'] = $this->_pageId !== false;
            $pname = reset(WPLinkyHelper::recursiveSanitizeTextField([$_POST['page_name']]));

            // Edit page
            if ($this->_pageId !== false) {
                // Set page name
                $this->_dbData = get_option(WPLinkyHelper::getPageOptionKey($this->_pageId));

                $this->_saveData('page_name', $pname, $this->_pageId);
            } else { // Add page
                $page_id = WPLinkyHelper::getNextPageId();
                $slug = !empty($_POST['slug']) ? $_POST['slug'] : 'linky_' . $page_id;
                WPLinkyHelper::setDefaultContent($page_id, $slug, $pname);
                flush_rewrite_rules(true);
                $args['reloadPage'] = admin_url('admin.php') . '?page=wp-linky&page_id=' . $page_id;
            }
        }

        if ($actionType == 'remove' && $this->_pageId > 0) {
            WPLinkyHelper::removePage($this->_pageId);
            $args['reloadPage'] = admin_url('admin.php') . '?page=wp-linky';
        }

        wp_send_json_success($args);
    }

    /**
     * get Link Template
     *
     * @return void
     */
    public function getLinkTemplate()
    {
        $type = !empty($_POST['_type']) ? sanitize_text_field($_POST['_type']) : '';
        $className = '\LinkyApp\Type\\' . $type . 'Type';
        if(!class_exists($className)) {
            wp_send_json_error();
        }

        /* @var \LinkyApp\Type\abstractType $typeInstance  */
        $typeInstance = new $className();

        ob_start();

        $typeInstance->getAdminTemplate();

        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
        die;
    }

    /**
     * get Posts Suggests
     *
     * @return void
     */
    public function getSuggests()
    {
        $s = !empty($_POST['s']) ? $_POST['s'] : '';

        $posts = new \WP_Query([
            'post_type'         => 'any',
            'posts_per_page'    => 5,
            's'                 => $s,
        ]);

        require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/parts/suggests.php';
        die;
    }

    /**
     * getAdminPageContent
     *
     * @return bool;
     */
    public function getAdminPageContent()
    {
        global $wpLinky;
        $this->_pageId = !empty($_POST['page_id']) ? $_POST['page_id'] : false;

        $html = $wpLinky->getIndexController($this->_pageId)->getContent(false);

        echo $html;
        die;
    }

    /**
     * getQRCode
     *
     * @return string;
     */
    public function getQRCode()
    {
        $page_id = !empty($_GET['page_id']) ? $_GET['page_id'] : 0;
        require_once UNDFND_WP_LINKY_PLUGIN_DIR . '/vendor/qrcodegenerator/phpqrcode.php';

        $options = WPLinkyHelper::getPage('global', $page_id);
        \QRcode::png(site_url() . '/' . $options['slug'], false, QR_ECLEVEL_L, 10, 3);

        if(!empty($_GET['download'])) {
            $filename = sanitize_title($options['slug']).'.png';
            header('Pragma: public');   // required
            header('Expires: 0');       // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private',false);
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($filename));    // provide file size
            readfile($filename);
        }
    }

    /**
     * Save
     *
     * @return mixed;
     */
    private function _save()
    {
        if(!empty($_POST['_group'])) {
            $this->_formData    = WPLinkyHelper::recursiveSanitizeTextField($_POST);
            $group              = $this->_formData['_group'];
            unset($this->_formData['_group']);
            unset($this->_formData['page_id']);

            switch($group) {
                case 'links':
                    return $this->_processLinksAction();
                    break;
                case 'global':
                    $data = $this->_saveData($group, $this->_formData, $this->_pageId);
                    flush_rewrite_rules(true);
                    return $data;
                    break;
                case 'themes':
                    $override = $this->_formData['_override'];
                    unset($this->_formData['_override']);
                    $data = $this->_saveData($group, $this->_formData, $this->_pageId);
                    if($override == 'true') {
                        $this->_overridePageWithTheme($this->_pageId);
                    }
                    return $data;
                    break;
                case 'appareance':
                    $this->_formData['text_color'] = ThemesHelper::getColorTheme($this->_pageId);
                    $data = $this->_saveData($group, $this->_formData, $this->_pageId);
                    return $data;
                    break;
                default:
                    return $this->_saveData($group, $this->_formData, $this->_pageId);
                    break;
            }
        }
    }

    /**
     * Save classic group
     *
     * @return mixed;
     */
    private function _saveData($group, $data = [], $page_id = false)
    {
        $this->_dbData[$group] = $data;

        update_option(WPLinkyHelper::getPageOptionKey($page_id), $this->_dbData);

        return $this->_dbData;
    }

    /**
     * Save classic group
     *
     * @return mixed;
     */
    private function _overridePageWithTheme($page_id = false)
    {
        $this->_dbData['appareance'] = ThemesHelper::prepareThemeOverride($this->_dbData);

        $this->_saveData('appareance', $this->_dbData['appareance'], $page_id);
    }

    /**
     * Process links data form action
     *
     * @return array;
     */
    private function _processLinksAction()
    {
        $group = 'links';
        $this->_formData[$group] = $this->_reorderLinks($this->_formData[$group]);

        foreach($this->_formData[$group] as $link_id => &$link) {
            if(!empty($link['_delete']) && $link['_delete'] == 'yes') {
                unset($this->_formData[$group][$link_id]);
            } else {
                unset($link['_delete']);
            }
        }

        return $this->_saveData($group, $this->_formData[$group], $this->_pageId);
    }

    /**
     * Reorder links
     *
     * @return array;
     */
    private function _reorderLinks($data)
    {
        $newArray = array();
        foreach (array_keys($data) as $fieldKey) {
            foreach ($data[$fieldKey] as $key=>$value) {
                $newArray[$key][$fieldKey] = $value;
            }
        }

        return $newArray;
    }
}

new AjaxController();
