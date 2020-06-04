<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp;

use \LinkyApp\Helper\WPLinkyHelper;

/**
 * Class AbstractObject
 *
 * @since 1.0.0
 */
class AbstractObject
{
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
     * Set all vars
     *
     * @return void;
     */
    protected function _setData($data = [])
    {
        if(!empty($data)) {
            foreach($data as $var => $property) {
                if(property_exists($this, $var)) {
                    $this->set($var, $property);
                }
            }
        }
    }

    /**
     * Get all vars
     */
    public function getAll(){
        $properties = get_class_vars(get_class($this));
        $vars = [];
        foreach ($properties as $key => $property) {
            $vars[$key] = $this->get($key);
        }

        return $vars;
    }
}
