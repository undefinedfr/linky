/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
var $ = (typeof $ == 'undefined') ? jQuery : $;

$(document).ready(function() {
    $('.js-toggle-menu').click(function() {
        $(this).closest('.header__burger').toggleClass('is-open');
        $('.linky-page').toggleClass('menu-open');
    });
});

$(window).load(function() {
    //fix themes with lazyload
    $('img').each(function() {
        var $img = $(this);
        var imgData = $img.data();
        var objKeys = Object.keys(imgData);
        if (objKeys.length > 0) {
            for(var i = 0; i < objKeys.length; i++) {
                if (objKeys[i].toLowerCase().indexOf('src') >= 0) {
                    $img.attr('src', $img.data(objKeys[i]));
                    $img.addClass('lazyloaded');
                }
            }
        }
    });
});
