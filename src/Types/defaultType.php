<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;

/**
 * Class defaultType
 * @since 0.0.1
 */
class defaultType extends abstractType
{
    /**
     * @var string Type ID
     */
    protected $id = 'default';

    /**
     * @var string Type Name
     */
    protected $name = 'Link';

    /**
     * @var string Label
     */
    protected $label;

    /**
     * @var string Link label
     */
    protected $label_link;

    /**
     * @var string Link
     */
    protected $link;

    /**
     * @var string Category
     */
    protected $category;

    /**
     * @var string Border color
     */
    protected $border_color;

    /**
     * @var string Background color
     */
    protected $background_color;

    /**
     * @var string Text color
     */
    protected $color;

    public function __construct($data = [])
    {
        parent::__construct($this->id, $this->name, $data);
    }

}