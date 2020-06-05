<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class Link
 * @since 1.0.0
 */
class Link extends AbstractEntity
{
    public $defaultLabels = [];
    public $data = [];

    public function __construct($data = [])
    {
        $labels = WPLinkyHelper::getOptionValue('labels', $data, []);
        $this->set('defaultLabels', array_merge([
            __('New', 'linky'),
        ], $labels));

        $categories = WPLinkyHelper::getOptionValue('categories', $data, []);
        $this->set('defaultCategories', array_merge([
            __('Blog post', 'linky'),
            __('Product', 'linky'),
            __('About', 'linky'),
        ], $categories));

        if(!empty($data['type']))
            $this->_addData($data);

        parent::__construct($data);
    }

    /**
     * Fill data to object
     *
     * @param $link
     */
    private function _addData($link)
    {
        $className = '\LinkyApp\Type\\' . $link['type'] . 'Type';

        /* @var \LinkyApp\Type\abstractType $typeInstance  */
        $typeInstance = new $className($link);

        $this->set('data', $typeInstance);
    }
}
