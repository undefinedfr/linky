/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
var $ = jQuery;

$(document).ready(function() {
    var render      = new renderComponent('.linky-page', {});
    var imgUploader = new imageUploader('.image-uploader', {});
    var linkyForm   = new WPLinkyAdminForm('.settings-wp-linky', {
        imgUploader: imgUploader,
        renderComponent: render
    });
    new linksComponent('._js-form .links', {
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
    plugin.renderButton = $('._js-linky-button');

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
        // Choose a theme
        $element.find('.theme-input').click(function() {
            $element.find('.theme-input').removeClass('is-checked');
            $(this).addClass('is-checked');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        // Delete link event
        $(document).on('click', '._js-delete', function() {
            $(this).closest('.link').toggleClass('is-deleted');
            var $hiddenEl = $(this).siblings('input[type="hidden"]');
            $hiddenEl.val($hiddenEl.val() == 'no' ? 'yes' : 'no');
        });

        // Hide link event
        $(document).on('click', '.link__active', function() {
            var $hiddenEl = $(this).find('input[type="hidden"]');
            $(this).closest('.link').toggleClass('is-hidden');
            $hiddenEl.val($hiddenEl.val() == 'no' ? 'yes' : 'no');
        });

        // Choose link sive event
        $(document).on('click', '.js-size-button', function() {
            var $buttonEl = $(this);
            var $hiddenEl = $buttonEl.siblings('input[type="hidden"]');
            var val = $buttonEl.data('value');
            $buttonEl.closest('.link').toggleClass('half-size', (val == 50));
            $('.js-size-button').removeClass('active');
            $buttonEl.addClass('active');
            $hiddenEl.val(val);
        });


        // On Submit form
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

                        plugin.renderButton.attr('href', plugin.renderButton.data('prefix') + response.data.global.slug);

                        plugin.settings.renderComponent.refresh();
                        plugin.form.find('.is-deleted').remove();
                    }
                }
            });
        });

        plugin.form.find('.links').sortable({
            handle: ".link__sort"
        });
        plugin.form.find('.links').disableSelection();
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


var imageUploader = function (element, options) {
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
        $(document).on('click', element, function(e) {
            e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
                    title: 'Insert image',
                    library : {
                        type : 'image'
                    },
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.addClass('is-filled');
                    button.find('input[type="hidden"]').val(attachment.id);
                    button.css('background-image', 'url(' + attachment.url + ')');
                }).open();
        });

        $(document).on('click', '._js-remove-image', function(e){
            e.preventDefault();
            e.stopPropagation();

            var el = $(this).closest(element);
            el.removeClass('is-filled')
            el.find('input[type="hidden"]').val('');
            el.attr('style', '');

            return false;
        });
    };

    /* --- INITIALISATION --- */
    // Init Plugin
    plugin.init();
}