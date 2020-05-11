<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helpers;

/**
 * Class ThemesHelper
 * @since 0.0.1
 */
abstract class ThemesHelper
{
    const HEADER_THEMES = [0];
    const BODY_THEMES   = [0,1];

    public static function getHeaderThemes()
    {
        return self::HEADER_THEMES;
    }

    public static function getBodyThemes()
    {
        return self::BODY_THEMES;
    }
}