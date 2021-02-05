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

    $('.link__link').click(function(e) {
        e.preventDefault();

        let link = $(this).attr('href');
        // Add clicked link stat
        $.ajax({
            url: linky.ajax_url,
            method: 'GET',
            data: {
                'action': 'link_clicked',
                'link_url': link,
                'page_id': $('.linky-page').data('page-id')
            },
            success: function() {
                window.location.href = link
            }
        });
    });

    // Add viewed page stat
    $.ajax({
        url: linky.ajax_url,
        method: 'GET',
        data: {
            'action': 'page_viewed',
            'page_id': $('.linky-page').data('page-id')
        }
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
