/*!
*
* ColorPick jQuery plugin
* https://github.com/philzet/ColorPick.js
*
* Copyright (c) 2017-2019 Phil Zet (a.k.a. Phil Zakharchenko)
* Licensed under the MIT License
*
*/
(function( $ ) {

    $.fn.gradientPick = function(config) {

        return this.each(function() {
            new $.gradientPick(this, config || {});
        });

    };

    $.gradientPick = function (element, options) {
        options = options || {};
        this.options = $.extend({}, $.fn.gradientPick.defaults, options);
        if(options.str) {
            this.options.str = $.extend({}, $.fn.gradientPick.defaults.str, options.str);
        }
        $.fn.gradientPick.defaults = this.options;
        this.color   = this.options.initialColor.toUpperCase();
        this.element = $(element);

        var dataInitialColor = this.element.data('initialcolor');
        if (dataInitialColor) {
            this.color = dataInitialColor;
        }

        var uniquePalette = [];
        $.each($.fn.gradientPick.defaults.palette.map(function(x){ return x }), function(i, el){
            if($.inArray(el, uniquePalette) === -1) uniquePalette.push(el);
        });

        this.palette = uniquePalette;

        return this.element.hasClass(this.options.pickrclass) ? this : this.init();
    };

    $.fn.gradientPick.defaults = {
        'initialColor': 'linky',
        'paletteLabel': 'Default palette:',
        'palette': Object.keys(linky_args.gradients),
        'onColorSelected': function() {
            this.element.css({'backgroundImage': 'linear-gradient(120deg, ' + linky_args.gradients[this.color].join(',') + ')'});
        }
    };

    $.gradientPick.prototype = {

        init : function(){

            var self = this;
            var o = this.options;

            $.proxy($.fn.gradientPick.defaults.onColorSelected, this)();

            this.element.click(function(event) {
                event.preventDefault();
                self.show(event.pageX, event.pageY);

                $('.gradientPickButton').click(function(event) {
                    self.color = $(event.target).attr('hexValue');
                    self.hide();
                    $.proxy(self.options.onColorSelected, self)();
                    return false;
                });

                return false;
            }).blur(function() {
                self.element.val(self.color);
                $.proxy(self.options.onColorSelected, self)();
                self.hide();
                return false;
            });

            $(document).on('click', function(event) {
                self.hide();
                return true;
            });

            return this;
        },

        show: function(left, top) {

            $("#gradientPick").remove();

            $("body").append('<div id="gradientPick" style="display:none;top:' + top + 'px;left:' + left + 'px"><span>'+$.fn.gradientPick.defaults.paletteLabel+'</span></div>');
            jQuery.each(this.palette, function (index, item) {
                $("#gradientPick").append('<div class="gradientPickButton" hexValue="' + item + '" style="background-image:linear-gradient(120deg,' + linky_args.gradients[item].join(',') + ')"></div>');
            });
            $("#gradientPick").fadeIn(200);
        },

        hide: function() {
            $( "#gradientPick" ).fadeOut(200, function() {
                $("#gradientPick").remove();
                return this;
            });
        },

    };

}( jQuery ));
