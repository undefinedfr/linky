/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
var $ = jQuery;

$(document).ready(function() {
    var render = new renderComponent('.linky-page', {});
    var linkyForm = new WPLinkyAdminForm('.settings-wp-linky', {
        renderComponent: render
    });
    new linksComponent('.links', {
        linkyForm: linkyForm
    });
});

var WPLinkyAdminForm = function (element, options) {
    /* --- VARIABLES --- */
    var defaults = {};

    var plugin = this;
    plugin.settings = {};

    var $element = $(element),
        element = element;

    plugin.form = $element.find('form._js-form');

    /* --- PUBLIC FUNCTIONS --- */
    plugin.init = function () {
        // Global plugin settings
        plugin.settings = $.extend({}, defaults, options);

        // Events
        plugin._events();

        // Instance libs
        plugin._libInstance();
    };

    // Set Events
    plugin._events = function () {
        $element.find('.theme-input').click(function() {
            $element.find('.theme-input').removeClass('is-checked');
            $(this).addClass('is-checked');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        $element.find('._js-delete').click(function() {
            $(this).closest('.link').toggleClass('is-deleted');
            var $hiddenEl = $(this).siblings('input[type="hidden"]');
            $hiddenEl.val($hiddenEl.val() == 'no' ? 'yes' : 'no');
        });

        plugin.form.on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    plugin.form.find('.message').remove();
                },
                success: function(response) {
                    if(response.success != void 0) {
                        var message = plugin.getMessage('success',  plugin.form.data('success-message'));
                        plugin.form.prepend(message);

                        plugin.settings.renderComponent.refresh();
                        plugin.form.find('.is-deleted').remove();
                    }
                }
            });
        });
    };

    plugin._libInstance = function () {
        const elements = document.querySelectorAll('.js-choices');
        for (var j = 0; j < elements.length; j++) {
            new Choices(elements[j], {
                placeholderValue: elements[j].placeholder,
                editItems: true
            });
        }

        $(".colorpicker").colorPick({
            initialColor: '#fff',
            paletteLabel: 'Linky',
            allowCustomColor: true,
            onColorSelected: function() {
                this.element.css({'backgroundColor': this.color, 'color': this.color});
                this.element.siblings('input[type="text"]').val(this.color);
            }
        });

        plugin.loadColorPicker();
    };

    plugin.getMessage = function (type, message) {
        return '<div class="message ' + type + '">' + message + '</div>'
    };

    plugin.loadColorPicker = function () {
        $(".link_colorpicker").not('.loaded').colorPick({
            initialColor: '#fff',
            paletteLabel: 'Linky',
            allowCustomColor: true,
            onColorSelected: function() {
                this.element.siblings('input[type="hidden"]').val(this.color);
                var property = this.element.data('property');
                this.element.css({'backgroundColor': this.color});
                var $el = this.element.closest('.link');
                var obj = {};
                obj[property] = this.color;
                if(property === 'color' || property === 'sepColor') {
                    $el.find('select, input[type="text"]').css({'color': this.color});
                }
                if(property === 'sepColor') {
                    obj = {'borderColor': this.color, 'color': this.color}
                }
                $el.css(obj);
            }
        }).addClass('loaded');
    };

    /* --- INITIALISATION --- */
    // Init Plugin
    plugin.init();
};

var renderComponent = function (element, options) {
    /* --- VARIABLES --- */
    var defaults = {};

    var plugin = this;
    plugin.settings = {};

    var $element = $(element),
        element = element;

    /* --- PUBLIC FUNCTIONS --- */
    plugin.init = function () {
        // Global plugin settings
        plugin.settings = $.extend({}, defaults, options);

        // Events
        plugin._events();
    };

    // Set Events
    plugin._events = function () {

    };

    plugin.refresh = function () {
        $.ajax({
            url: args.ajaxurl,
            method: 'POST',
            dataType: 'html',
            data: {
                action: 'get_admin_page_content'
            },
            beforeSend: function() {
                $('body').addClass('render-loading');
            },
            success: function(html) {
                $('body').removeClass('render-loading');
                var el = $(html);
                $element.html(el.html());
                $element.attr('style', el.attr('style'));
            }
        });
        //
    };

    /* --- INITIALISATION --- */
    // Init Plugin
    plugin.init();
}


var linksComponent = function (element, options) {
    /* --- VARIABLES --- */
    var defaults = {};

    var plugin = this;
    plugin.settings = {};

    var $element = $(element),
        element = element;

    plugin.form = $('form._js-links-form');

    /* --- PUBLIC FUNCTIONS --- */
    plugin.init = function () {
        // Global plugin settings
        plugin.settings = $.extend({}, defaults, options);

        // Events
        plugin._events();
    };

    // Set Events
    plugin._events = function () {
        plugin.form.on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                url: args.ajaxurl,
                method: 'POST',
                data: {
                    action: 'get_link_template',
                    _type: form.find('[name="_type"]').val()
                },
                dataType: 'html',
                beforeSend: function() {
                    plugin.form.find('button').prop('disabled', true);
                },
                success: function(html) {
                    plugin.form.find('button').prop('disabled', false);
                    plugin.addLink(html);
                }
            });
        });
    };

    plugin.addLink = function (html) {
        var el = $(html);
        $element.find('.links__empty').remove();
        $element.append(el);

        plugin.settings.linkyForm.loadColorPicker();
    };

    /* --- INITIALISATION --- */
    // Init Plugin
    plugin.init();
}