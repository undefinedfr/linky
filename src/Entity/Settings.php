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
 * Class Settings
 * @since 0.0.1
 */
class Settings extends AbstractEntity
{
    public $code_ga;
    public $slug;
    public $labels;
    public $catagories;
    public $theme_style;
}
