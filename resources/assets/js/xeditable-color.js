(function ($) {
    "use strict";
    var Color = function (options) {
        this.init('color', options, Color.defaults);
    };
    $.fn.editableutils.inherit(Color, $.fn.editabletypes.abstractinput);
    $.extend(Color.prototype, {
        render: function() {
            this.$input = this.$tpl.find('input');
            this.$input.parent().colorselector();
        },
        autosubmit: function() {
            this.$input.keydown(function (e) {
                if (e.which === 13) {
                    $(this).closest('form').submit();
                }
            });
        }
    });

    Color.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div class="editable-color"><input type="hidden" class="form-control" value="" /></div>'
    });
    $.fn.editabletypes.color = Color;

}(window.jQuery));