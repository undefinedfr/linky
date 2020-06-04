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


    public function __construct()
    {
        add_action( 'wp_ajax_save_form', [ $this, 'saveForm' ] );
        add_action( 'wp_ajax_get_admin_page_content', [ $this, 'getAdminPageContent' ] );
        add_action( 'wp_ajax_get_link_template', [ $this, 'getLinkTemplate' ] );

        $this->_dbData = get_option(WPLinkyHelper::getPageOptionKey());
        if(!is_array($this->_dbData))
            $this->_dbData = [];
    }

    public function saveForm()
    {
        if(!empty($_POST['_group'])){
            $data = $this->_save();
            wp_send_json_success($data);
        }
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
     * getAdminPageContent
     *
     * @return bool;
     */
    public function getAdminPageContent()
    {
        global $wpLinky;

        $html = $wpLinky->getIndexController()->getContent(false);

        echo $html;
        die;
    }

    /**
     * Save
     *
     * @return mixed;
     */
    private function _save()
    {
        if(!empty($_POST['_group'])) {
            $this->_formData = WPLinkyHelper::recursiveSanitizeTextField($_POST);
            $group = $this->_formData['_group'];
            unset($this->_formData['_group']);

            switch($group) {
                case 'links':
                    return $this->_processLinksAction();
                    break;
                case 'global':
                    $data = $this->_saveData($group, $this->_formData);
                    flush_rewrite_rules(true);
                    return $data;
                    break;
                case 'themes':
                    $override = $this->_formData['_override'];
                    unset($this->_formData['_override']);
                    $data = $this->_saveData($group, $this->_formData);
                    if($override == 'true') {
                        $this->_overridePageWithTheme();
                    }
                    return $data;
                    break;
                case 'appareance':
                    $this->_formData['text_color'] = ThemesHelper::getColorTheme();
                    $data = $this->_saveData($group, $this->_formData);
                    return $data;
                    break;
                default:
                    return $this->_saveData($group, $this->_formData);
                    break;
            }
        }
    }

    /**
     * Save classic group
     *
     * @return mixed;
     */
    private function _saveData($group, $data = [])
    {
        $this->_dbData[$group] = $data;

        update_option(WPLinkyHelper::getPageOptionKey(), $this->_dbData);

        return $this->_dbData;
    }

    /**
     * Save classic group
     *
     * @return mixed;
     */
    private function _overridePageWithTheme()
    {
        $this->_dbData['appareance'] = ThemesHelper::prepareThemeOverride($this->_dbData);

        $this->_saveData('appareance', $this->_dbData['appareance']);
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

        return $this->_saveData($group, $this->_formData[$group]);
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