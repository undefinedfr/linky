<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;

/**
 * Class BlankType
 * @since 1.0.0
 */
class BlankType extends AbstractType
{
    /**
     * @var string Type ID
     */
    protected $id;

    /**
     * @var string Type Name
     */
    protected $name;

    /**
     * @var bool Active
     */
    protected $active;

    public function __construct($data = [])
    {
        parent::__construct($this->id, $this->name, $data);
    }
}