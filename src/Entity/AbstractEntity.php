<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

use LinkyApp\AbstractObject;
use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class AbstractEntity
 * @since 1.0.0
 */
class AbstractEntity extends AbstractObject
{
    public function __construct($data = [])
    {
        $this->_setData($data);
    }

    /**
     * Define is object is empty
     *
     * @return bool
     */
    public function isEmpty() {
        return empty(array_filter($this->getAll(), function($v, $k) {
            return !empty($v);
        }, ARRAY_FILTER_USE_BOTH));
    }
}
