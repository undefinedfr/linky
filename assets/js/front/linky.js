/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
var $ = jQuery;

$(document).ready(function() {
    $('.js-toggle-menu').click(function() {
        $(this).closest('.header__burger').toggleClass('is-open');
        $('.linky-page').toggleClass('menu-open');
    });
});