<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

/**
 * Class Links
 * @since 1.0.0
 */
class Links extends AbstractEntity
{
    public $links = [];

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    /**
     * Set all links
     *
     * @param array $links
     *
     * @return void;
     */
    protected function _setData($links = [])
    {
        foreach($links as &$link) {
            $link = new Link($link);
        }
        $this->set('links', $links);
    }

    /**
     * Set all links
     *
     * @return array;
     */
    public function getAll()
    {
        return $this->get('links');
    }
}
