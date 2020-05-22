<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

use LinkyApp\Helpers\WPLinkyHelper;

/**
 * Class AbstractEntity
 * @since 0.0.1
 */
class AbstractEntity
{
    public function __construct($data = [])
    {
        $this->_setData($data);
    }

    /**
     * Set var
     *
     * @return void;
     */
    public function set($var, $value){
        $this->{$var} = $value;
    }

    /**
     * Get var
     * @param $var
     * @param bool $default
     * @return bool|array|string|int
     */
    public function get($var, $default = false, $escape = true)
    {
        return !empty($this->{$var}) ? WPLinkyHelper::unEscape($this->{$var}, $escape) : $default;
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


    public function isEmpty() {
        return empty(array_filter($this->getAll(), function($v, $k) {
            return !empty($v);
        }, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * Set all vars
     *
     * @return void;
     */
    protected function _setData($data)
    {
        if(!empty($data)):
            foreach($data as $var => $property) {
                if(property_exists($this, $var)) {
                    $this->set($var, $property);
                }
            }
        endif;
    }
}
