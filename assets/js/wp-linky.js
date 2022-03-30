/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
var $ = jQuery;
var paletteLinky = ["transparent", "#6be39c", "#39cb75", "#1a7e43", "#06421f", "#68e0c6", "#29bb9c", "#23a085", "#0e5f4d", "#043a2e", "#6fcade", "#3b99d9", "#2f81b7", "#2f59b7", "#354a5d", "#d988de", "#9a5cb4", "#8d48ab", "#6a2887", "#410c58", "#ea827b", "#e54d42", "#be3a31", "#94241c", "#580f0a", "#f1d372", "#f0c330", "#f19b2c", "#e47e31", "#d15519", "#ffffff", "#ecf0f1", "#bdc3c7", "#808c8d", "#1d1d1d"];

$(document).ready(function() {
    window.readyLinky();
});

window.readyLinky = function(onload) {
    var render      = new renderComponent('.linky-page', {});
    var imgUploader = new imageUploader('.image-uploader', {});
    var linkyForm   = new WPLinkyAdminForm('.settings-wp-linky', {
        imgUploader: imgUploader,
        renderComponent: render
    });
    new linksComponent('._js-form .links', {
        linkyForm: linkyForm
    });

    if(onload == void 0) {
        $(window).load(function() {
            linkyForm.dirtyEvent();
        });
    } else {
        linkyForm.dirtyEvent();
    }
};

$(window).load(function() {
    // Sticky iphone
    if($(window).width() > 1024) {
        $('.render-view').height($('._col-8').height() - 110);
        $('.iphone-x').stickit({
            top: 50,
            scope: StickScope.Parent
        });
    }
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
    plugin.formIsDirty = true;
    window.formIsDirty = plugin.formIsDirty;

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

        // Override button event
        $('.js-override').click(function() {
            $('input[name="_override"]').val($(this).data('override'))
        });

        // Override button event
        $('.js-toggle-select').on('change', function() {
            var $el = $(this);
            var val = $(this).val();
            $('.toggle-' + $el.attr('name')).hide();
            $('#' + $el.attr('name') + '-' + val).show();
        }).trigger('change');

        window.onbeforeunload = function(e) {
            e = e || window.event;
            if (plugin.formIsDirty) {
                // For IE and Firefox
                if (e) {
                    e.returnValue = linky_args.promptMessage;
                }
                // For Safari
                return linky_args.promptMessage;
            }
        };

        // On Submit form
        plugin.form.on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);
            $.ajax({
                url: linky_args.ajax_url,
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

                        if (response.data.global != void 0 && response.data.global.slug != void 0)
                            plugin.renderButton.attr('href', plugin.renderButton.data('prefix') + response.data.global.slug);

                        plugin.settings.renderComponent.refresh();
                        plugin.form.find('.is-deleted').remove();

                        plugin.formIsDirty = false;
                        window.formIsDirty = plugin.formIsDirty;
                    }
                }
            });
        });

        plugin.form.find('.links').sortable({
            handle: ".link__sort"
        });
        plugin.form.find('.links').disableSelection();
    };

    // Set Events
    plugin.dirtyEvent = function () {
        plugin.formIsDirty = false;
        window.formIsDirty = plugin.formIsDirty;
        plugin.form.find('input, select').change(function() {
            plugin.formIsDirty = true;
            window.formIsDirty = plugin.formIsDirty;
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
            paletteLabel: '',
            palette: paletteLinky,
            allowCustomColor: true,
            onColorSelected: function() {
                this.element.css({'backgroundColor': this.color, 'color': this.color}).removeClass('is-transparent').toggleClass('is-transparent', (this.color.toLowerCase() == 'transparent'));
                this.element.siblings('input[type="text"]').val(this.color).trigger('change');
            }
        });

        $(".gradientpicker").gradientPick({
            paletteLabel: '',
            onColorSelected: function() {
                this.element.css({'backgroundImage': 'linear-gradient(120deg, ' + linky_args.gradients[this.color].join(',') + ')'});
                this.element.siblings('input[type="hidden"]').val(this.color).trigger('change');
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
            palette: paletteLinky,
            allowCustomColor: true,
            onColorSelected: function() {
                this.element.siblings('input[type="hidden"]').val(this.color).trigger('change');
                var property = this.element.data('property');
                this.element.css({'backgroundColor': this.color}).removeClass('is-transparent').toggleClass('is-transparent', (this.color.toLowerCase() == 'transparent'));
                var $el = this.element.closest('.link');
                var obj = {};
                obj[property] = this.color;
                // if(property === 'color' || property === 'sepColor') {
                //     $el.find('select, input[type="text"]').css({'color': this.color});
                // }
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
        $(document).on('keyup', '.link__label-link input', function() {
            var $input = $(this);
            var $formField = $input.closest('.form-field');
            $formField.find('.link__autocomplete').html('');
            $formField.removeClass('is-autocomplete');
            if(!$input.val()) {
                $formField.removeClass('is-loading');
                return;
            }
            $formField.addClass('is-loading');

            $.ajax({
                url: linky_args.ajax_url,
                method: 'GET',
                dataType: 'html',
                data: {
                    action: 'get_suggests',
                    s: $input.val()
                },
                success: function(html) {
                    $formField.removeClass('is-loading');
                    if (html) {
                        $formField.addClass('is-autocomplete');
                        $formField.find('.link__autocomplete').html(html);
                    } else {
                        $(this).closest('.form-field').removeClass('is-loading is-autocomplete');
                    }

                }
            });
        });

        $(document).on('click', '.link__autocomplete li', function(e) {
            e.preventDefault();

            var $li             = $(this);
            var $link           = $li.closest('.link');
            var $imageButton    = $link.find('.image-uploader');
            var id              = $li.data('thumbnail-id');

            $link.find('.link__label-link input').val($li.find('.label-link').text().trim());
            $link.find('._js-remove-image').trigger('click');
            $link.find('.link__link input').val($li.data('link'));
            if (id) {
                $imageButton.addClass('is-filled');
                $imageButton.find('input[type="hidden"]').val(id).trigger('change');
                $imageButton.css('background-image', 'url(' + $li.find('img').attr('src') + ')');
            }
            $link.find('.link__autocomplete').html('');
        });

        $(document).on('click', function(e) {
            if(!$(e.target).hasClass('link__autocomplete'))
                $('.form-field').removeClass('is-loading is-autocomplete');
        });
    };

    plugin.refresh = function () {
        $.ajax({
            url: linky_args.ajax_url,
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
                $element.attr('class', el.attr('class'));
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
            var position = form.data('position');

            $.ajax({
                url: linky_args.ajax_url,
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
                    plugin.addLink(html, position);
                }
            });
        });
    };

    plugin.addLink = function (html, position) {
        position = position != void 0 ? position : 'append';
        var el = $(html);
        $element.find('.links__empty').remove();
        if(position == 'prepend')
            $element.prepend(el);
        else
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

            if($(this).data('custom') != void 0) {
                return false;
            }

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
                    button.find('input[type="hidden"]').val(attachment.id).trigger('change');
                    button.css('background-image', 'url(' + attachment.url + ')');
                }).open();
        });

        $(document).on('click', '._js-remove-image', function(e){
            if ($(this).closest('.image-uploader').data('custom') == void 0) {
                e.preventDefault();
                e.stopPropagation();

                var el = $(this).closest(element);
                el.removeClass('is-filled')
                el.find('input[type="hidden"]').val('').trigger('change');
                el.attr('style', '');

                return false;
            }
        });
    };

    /* --- INITIALISATION --- */
    // Init Plugin
    plugin.init();
}
