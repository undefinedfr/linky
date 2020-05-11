<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

/**
 * Class Link
 * @since 0.0.1
 */
class Link extends AbstractEntity
{
    public $defaultLabels = [];
    public $data = [];

    public function __construct($data = [])
    {
        $labels = !empty($data['labels']) ? $data['labels'] : [];
        $this->set('defaultLabels', array_merge([
            __('New', UNDFND_WP_LINKY_DOMAIN),
        ], $labels));

        $categories = !empty($data['categories']) ? $data['categories'] : [];
        $this->set('defaultCategories', array_merge([
            __('Blog post', UNDFND_WP_LINKY_DOMAIN),
            __('Product', UNDFND_WP_LINKY_DOMAIN),
            __('About', UNDFND_WP_LINKY_DOMAIN),
        ], $categories));

        if(!empty($data['type']))
            $this->_addData($data);

        parent::__construct($data);
    }

    private function _addData($link)
    {
        $className = '\LinkyApp\Type\\' . $link['type'] . 'Type';

        /* @var \LinkyApp\Type\abstractType $typeInstance  */
        $typeInstance = new $className($link);

        $this->set('data', $typeInstance);
    }
}
