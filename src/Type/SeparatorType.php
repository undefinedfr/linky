<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;

/**
 * Class SeparatorType
 * @since 1.0.0
 */
class SeparatorType extends AbstractType
{
    /**
     * @var string Type ID
     */
    protected $id = 'separator';

    /**
     * @var string Type Name
     */
    protected $name = 'Separator';

    /**
     * @var bool Active
     */
    protected $active;

    /**
     * @var string Link label
     */
    protected $label_link;

    /**
     * @var string Border color
     */
    protected $border_color;

    public function __construct($data = [])
    {
        parent::__construct($this->id, $this->name, $data);
    }
}