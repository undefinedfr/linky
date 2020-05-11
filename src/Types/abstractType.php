<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;
use LinkyApp\Helpers\WPLinkyHelper;

/**
 * Class abstractType
 * @since 0.0.1
 */
class abstractType
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
     * Set var
     *
     * @return void;
     */
    public function set($var, $value)
    {
        $this->{$var} = $value;
    }

    /**
     * Get var
     * @param $var
     * @param bool $default
     * @return bool|array|string|int
     */
    public function get($var, $default = false)
    {
        return !empty($this->{$var}) ? WPLinkyHelper::unEscape($this->{$var}) : $default;
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
    public function getFrontTemplate()
    {
        require UNDFND_WP_LINKY_PLUGIN_DIR . 'views/front/types/' . $this->get('id')  . '.php';
    }

    /**
     * Set all vars
     *
     * @return void;
     */
    protected function _setData($data)
    {
        foreach($data as $var => $property) {
            if(property_exists($this, $var)) {
                $this->set($var, $property);
            }
        }
    }
}
