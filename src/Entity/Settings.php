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
 * @since 1.0.0
 */
class Settings extends AbstractEntity
{
    /**
     * @var string $code_ga
     */
    public $code_ga;

    /**
     * @var string $slug
     */
    public $slug;

    /**
     * @var string $labels
     */
    public $labels;

    /**
     * @var string $categories
     */
    public $categories;

    /**
     * @var bool $theme_style
     */
    public $theme_style;
}
