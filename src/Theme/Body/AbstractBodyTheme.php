<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Theme\Body;

use LinkyApp\Theme\AbstractTheme;

/**
 * Class AbstractTheme
 * @since 1.0.0
 */
class AbstractBodyTheme extends AbstractTheme
{
    /**
     * @var string Theme ID
     */
    protected $id;

    /**
     * @var string Background type
     */
    protected $background_type = 'color';

    /**
     * @var string Background color
     */
    protected $background_color = '#FFF';

    /**
     * @var string Background gradient id
     */
    protected $background_gradient_id;

    /**
     * @var string Links background color
     */
    protected $links_background_color;

    /**
     * @var string text color
     */
    protected $text_color;

    /**
     * @var string Links background color
     */
    protected $links_border_color;

    /**
     * @var string Links background color
     */
    protected $links_text_color;

    /**
     * @var string Links label background type
     */
    protected $links_label_background_type;

    /**
     * @var string Links label background gradient id
     */
    protected $links_label_background_gradient_id;

    /**
     * @var string Links label background color
     */
    protected $links_label_background_color;

    /**
     * @var string Links label text color
     */
    protected $links_label_text_color;

    /**
     * @var string Separator color
     */
    protected $separator_color;
}
