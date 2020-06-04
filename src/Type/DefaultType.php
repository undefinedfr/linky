<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Type;

use LinkyApp\Entity\Image;
use LinkyApp\Helper\WPLinkyHelper;

/**
 * Class DefaultType
 * @since 1.0.0
 */
class DefaultType extends AbstractType
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
     * @var bool Active
     */
    protected $active;

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

    /**
     * @var int Image
     */
    protected $image;

    /**
     * @var int Image
     */
    protected $size;

    public function __construct($data = [])
    {
        parent::__construct($this->id, $this->name, $data);
    }

    /**
     * Get var
     * @param $var
     * @param bool $default
     * @return bool|array|string|int
     */
    public function get($var, $default = false)
    {
        switch ($var) {
            case 'image':
                return !empty($this->{$var}) ? new Image($this->{$var}) : $default;
            default:
                return !empty($this->{$var}) ? WPLinkyHelper::unEscape($this->{$var}) : $default;
                break;
        }
    }

}