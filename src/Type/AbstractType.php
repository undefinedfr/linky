<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;

use LinkyApp\AbstractObject;
use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class AbstractType
 * @since 1.0.0
 */
class AbstractType extends AbstractObject
{

    /**
     * @var string Type ID
     */
    protected $id;

    /**
     * @var string Type Name
     */
    protected $name;


    public function __construct($id = null, $name = null, $data = [])
    {
        $this->set('id', $id);
        $this->set('name', __($name));

        $this->_setData($data);
    }

    /**
     * Get admin template
     * @return void
     */
    public function getAdminTemplate()
    {
        require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/fields/' . $this->get('id')  . '.php';
    }

    /**
     * Get front template
     * @return void
     */
    public function getFrontTemplate($wpLinky)
    {
        require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/types/' . $this->get('id')  . '.php';
    }

    /**
     * Target should be blank
     *
     * @return bool;
     */
    protected function _shouldBeBlank()
    {
        $link = $this->get('link');
        if (substr($link, 0, 1) == '/')
            return false;

        $pattern = "#^[^:/.]*[:/]+#i";
        $link = preg_replace($pattern, '', $link);

        return strpos($link, preg_replace($pattern, '', home_url())) === FALSE;

    }
}
