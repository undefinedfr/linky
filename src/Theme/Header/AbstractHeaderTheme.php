<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Theme\Header;

use LinkyApp\Theme\AbstractTheme;

/**
 * Class AbstractTheme
 * @since 1.0.0
 */
class AbstractHeaderTheme extends AbstractTheme
{
    /**
     * @var string Theme ID
     */
    protected $id;

    /**
     * @var string Header background type
     */
    protected $header_background_type = 'color';

    /**
     * @var string Header background color
     */
    protected $header_background_color = '#FFF';

    /**
     * @var string Header background gradient id
     */
    protected $header_background_gradient_id;

    /**
     * @var string Header text color
     */
    protected $header_text_color = '#000';
}
