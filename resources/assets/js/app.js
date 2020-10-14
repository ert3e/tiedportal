var debounce = function(func, wait, immediate) {
    var timeout, result;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) result = func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) result = func.apply(context, args);
        return result;
    };
}

function resizeitems(){
    if($.isArray(resizefunc)){
        for (i = 0; i < resizefunc.length; i++) {
            if( typeof window[resizefunc[i]] != 'undefined' ) {
                window[resizefunc[i]]();
            }
        }
    }
}

function hookupEvents() {
    $('#pjax-container .editable:not(.select2)').editable({
        error: function(errors) {
            var msg = '';
            if(errors && errors.responseText) { //ajax error, errors = xhr object
                var errors = JSON.parse(errors.responseText);
                $.each(errors, function(k, v) {
                    msg += v + '<br/>';
                });
            }
            $(this).siblings('.editable-container').find('.editable-error-block').html(msg).show();
        }
    });
    $('#pjax-container .editable.select2').editable({
        inputclass: 'input-large',
        select2: {
            tokenSeparators: [",", " "],
            multiple: true
        },
        error: function (errors) {
            var msg = '';
            if (errors && errors.responseText) { //ajax error, errors = xhr object
                var errors = JSON.parse(errors.responseText);
                $.each(errors, function (k, v) {
                    msg += v + '<br/>';
                });
            }
            $(this).siblings('.editable-container').find('.editable-error-block').html(msg).show();
        }
    });
    $(':file').filestyle();
    $('.colorselector').colorselector();
    $('.select2:not(.editable)').select2();
    $('.typeahead').each(function() {
        var lookupSource = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: $(this).data('url')+'/%QUERY',
                wildcard: '%QUERY'
            }
        });
        var field = $($(this).data('field'));
        $(this).typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        },
        {
            source: lookupSource,
            displayKey: 'name'
        }).bind('typeahead:selected', function (e, suggestion, name) {
            field.val(suggestion.id);
        });
    });
    $.Components.init();
    $('[data-type="autosubmit"]:not(.autosubmit)').each(function() {
        $(this).addClass('autosubmit').change(function() {
            $.post($(this).data('url'), { _token: $(this).data('token'), name: $(this).attr('name'), value: $(this).val() });
        });
    });
}

function initscrolls(){
    if(jQuery.browser.mobile !== true){
        //SLIM SCROLL
        $('.slimscroller').slimscroll({
            height: 'auto',
            size: "5px"
        });

        $('.slimscrollleft').slimScroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#dcdcdc',
            wheelStep: 5
        });
    }
}

// Sweet alerts
!function($) {
    "use strict";

    /**
     Portlet Widget
     */
    var Portlet = function() {
        this.$body = $("body"),
            this.$portletIdentifier = ".portlet",
            this.$portletCloser = '.portlet a[data-toggle="remove"]',
            this.$portletRefresher = '.portlet a[data-toggle="reload"]'
    };

    //on init
    Portlet.prototype.init = function() {
        // Panel closest
        var $this = this;
        $(document).on("click",this.$portletCloser, function (ev) {
            ev.preventDefault();
            var $portlet = $(this).closest($this.$portletIdentifier);
            var $portlet_parent = $portlet.parent();
            $portlet.remove();
            if ($portlet_parent.children().length == 0) {
                $portlet_parent.remove();
            }
        });

        // Panel Reload
        $(document).on("click",this.$portletRefresher, function (ev) {
            ev.preventDefault();
            var $portlet = $(this).closest($this.$portletIdentifier);
            // This is just a simulation, nothing is going to be reloaded
            $portlet.append('<div class="panel-disabled"><div class="loader-1"></div></div>');
            var $pd = $portlet.find('.panel-disabled');
            setTimeout(function () {
                $pd.fadeOut('fast', function () {
                    $pd.remove();
                });
            }, 500 + 300 * (Math.random() * 5));
        });
    },
        //
        $.Portlet = new Portlet, $.Portlet.Constructor = Portlet

}(window.jQuery),

/**
 * Notifications
 */
    function($) {
        "use strict";

        var Notification = function() {};

        //simple notificaiton
        Notification.prototype.notify = function(style,position, title, text) {
            var icon = 'fa fa-adjust';
            if(style == "error"){
                icon = "fa fa-exclamation";
            }else if(style == "warning"){
                icon = "fa fa-warning";
            }else if(style == "success"){
                icon = "fa fa-check";
            }else if(style == "custom"){
                icon = "md md-album";
            }else if(style == "info"){
                icon = "fa fa-question";
            }else{
                icon = "fa fa-adjust";
            }
            $.notify({
                title: title,
                text: text,
                image: "<i class='"+icon+"'></i>"
            }, {
                style: 'metro',
                className: style,
                globalPosition:position,
                showAnimation: "show",
                showDuration: 0,
                hideDuration: 0,
                autoHide: true,
                clickToHide: true
            });
        },

            //auto hide notification
            Notification.prototype.autoHideNotify = function (style,position, title, text) {
                var icon = "fa fa-adjust";
                if(style == "error"){
                    icon = "fa fa-exclamation";
                }else if(style == "warning"){
                    icon = "fa fa-warning";
                }else if(style == "success"){
                    icon = "fa fa-check";
                }else if(style == "custom"){
                    icon = "md md-album";
                }else if(style == "info"){
                    icon = "fa fa-question";
                }else{
                    icon = "fa fa-adjust";
                }
                $.notify({
                    title: title,
                    text: text,
                    image: "<i class='"+icon+"'></i>"
                }, {
                    style: 'metro',
                    className: style,
                    globalPosition:position,
                    showAnimation: "show",
                    showDuration: 0,
                    hideDuration: 0,
                    autoHideDelay: 5000,
                    autoHide: true,
                    clickToHide: true
                });
            },
            //confirmation notification
            Notification.prototype.confirm = function(style,position, title) {
                var icon = "fa fa-adjust";
                if(style == "error"){
                    icon = "fa fa-exclamation";
                }else if(style == "warning"){
                    icon = "fa fa-warning";
                }else if(style == "success"){
                    icon = "fa fa-check";
                }else if(style == "custom"){
                    icon = "md md-album";
                }else if(style == "info"){
                    icon = "fa fa-question";
                }else{
                    icon = "fa fa-adjust";
                }
                $.notify({
                    title: title,
                    text: 'Are you sure you want to do nothing?<div class="clearfix"></div><br><a class="btn btn-sm btn-white yes">Yes</a> <a class="btn btn-sm btn-danger no">No</a>',
                    image: "<i class='"+icon+"'></i>"
                }, {
                    style: 'metro',
                    className: style,
                    globalPosition:position,
                    showAnimation: "show",
                    showDuration: 0,
                    hideDuration: 0,
                    autoHide: false,
                    clickToHide: false
                });
                //listen for click events from this style
                $(document).on('click', '.notifyjs-metro-base .no', function() {
                    //programmatically trigger propogating hide event
                    $(this).trigger('notify-hide');
                });
                $(document).on('click', '.notifyjs-metro-base .yes', function() {
                    //show button text
                    alert($(this).text() + " clicked!");
                    //hide notification
                    $(this).trigger('notify-hide');
                });
            },
            //init - examples
            Notification.prototype.init = function() {

            },
            //init
            $.Notification = new Notification, $.Notification.Constructor = Notification
    }(window.jQuery),

/**
 * Components
 */
    function($) {
        "use strict";

        var Components = function() {};

        //initializing tooltip
        Components.prototype.initTooltipPlugin = function() {
            $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip()
        },

            //initializing popover
            Components.prototype.initPopoverPlugin = function() {
                $.fn.popover && $('[data-toggle="popover"]').popover()
            },

            //initializing custom modal
            Components.prototype.initCustomModalPlugin = function() {
                $('[data-plugin="custommodal"]').click(function(e) {
                    Custombox.open({
                        target: $(this).attr("href"),
                        effect: $(this).attr("data-animation"),
                        overlaySpeed: $(this).attr("data-overlaySpeed"),
                        overlayColor: $(this).attr("data-overlayColor")
                    });
                    e.preventDefault();
                });
                $('[data-plugin="ajaxmodal"]').click(function(e) {
                    Custombox.open({
                        target: $(this).attr("href"),
                        effect: $(this).attr("data-animation"),
                        overlaySpeed: $(this).attr("data-overlaySpeed"),
                        overlayColor: $(this).attr("data-overlayColor"),
                        cache: false,
                        complete: function() {
                            hookupEvents();
                        }
                    });
                    e.preventDefault();
                });
            },

            //initializing nicescroll
            Components.prototype.initNiceScrollPlugin = function() {
                //You can change the color of scroll bar here
                $.fn.niceScroll &&  $(".nicescroll").niceScroll({ cursorcolor: '#98a6ad',cursorwidth:'6px', cursorborderradius: '5px'});
            },

            //range slider
            Components.prototype.initRangeSlider = function() {
                $.fn.slider && $('[data-plugin="range-slider"]').slider({});
            },

            /* -------------
             * Form related controls
             */
            //switch
            Components.prototype.initSwitchery = function() {
                $('[data-plugin="switchery"]').each(function (idx, obj) {
                    new Switchery($(this)[0], $(this).data());
                });
            },
            //multiselect
            Components.prototype.initMultiSelect = function() {
                if($('[data-plugin="multiselect"]').length > 0)
                    $('[data-plugin="multiselect"]').multiSelect($(this).data());
            },

            /* -------------
             * small charts related widgets
             */
            //peity charts
            Components.prototype.initPeityCharts = function() {
                $('[data-plugin="peity-pie"]').each(function(idx, obj) {
                    var colors = $(this).attr('data-colors')?$(this).attr('data-colors').split(","):[];
                    var width = $(this).attr('data-width')?$(this).attr('data-width'):20; //default is 20
                    var height = $(this).attr('data-height')?$(this).attr('data-height'):20; //default is 20
                    $(this).peity("pie", {
                        fill: colors,
                        width: width,
                        height: height
                    });
                });
                //donut
                $('[data-plugin="peity-donut"]').each(function(idx, obj) {
                    var colors = $(this).attr('data-colors')?$(this).attr('data-colors').split(","):[];
                    var width = $(this).attr('data-width')?$(this).attr('data-width'):20; //default is 20
                    var height = $(this).attr('data-height')?$(this).attr('data-height'):20; //default is 20
                    $(this).peity("donut", {
                        fill: colors,
                        width: width,
                        height: height
                    });
                });

                $('[data-plugin="peity-donut-alt"]').each(function(idx, obj) {
                    $(this).peity("donut");
                });

                // line
                $('[data-plugin="peity-line"]').each(function(idx, obj) {
                    $(this).peity("line", $(this).data());
                });

                // bar
                $('[data-plugin="peity-bar"]').each(function(idx, obj) {
                    var colors = $(this).attr('data-colors')?$(this).attr('data-colors').split(","):[];
                    var width = $(this).attr('data-width')?$(this).attr('data-width'):20; //default is 20
                    var height = $(this).attr('data-height')?$(this).attr('data-height'):20; //default is 20
                    $(this).peity("bar", {
                        fill: colors,
                        width: width,
                        height: height
                    });
                });
            },



            //initilizing
            Components.prototype.init = function() {
                var $this = this;
                this.initTooltipPlugin(),
                this.initPopoverPlugin(),
                this.initNiceScrollPlugin(),
                this.initCustomModalPlugin(),
                this.initSwitchery(),
                this.initMultiSelect(),
                $.Portlet.init();
            },

            $.Components = new Components, $.Components.Constructor = Components

    }(window.jQuery),


    function($) {
        "use strict";

        var App = function() {
            this.VERSION = "1.0.0",
                this.AUTHOR = "Blush Digital",
                this.SUPPORT = "hello@weareblush.co.uk",
                this.pageScrollElement = "html, body",
                this.$body = $("body")
        };

        //on doc load
        App.prototype.onDocReady = function(e) {
            FastClick.attach(document.body);
            resizefunc.push("initscrolls");
            resizefunc.push("changeptype");

            $('.animate-number').each(function(){
                $(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-duration")));
            });

            //RUN RESIZE ITEMS
            $(window).resize(debounce(resizeitems,100));
            $("body").trigger("resize");

            // right side-bar toggle
            $('.right-bar-toggle').on('click', function(e){

                $('#wrapper').toggleClass('right-bar-enabled');
            });

            // does current browser support PJAX
            if ($.support.pjax) {
                $.pjax.defaults.timeout = 5000; // time in milliseconds
                $(document).pjax('a:not(.not-pjax)', '#pjax-container');
            }

            $.fn.editable.defaults.mode = 'inline';

            hookupEvents();
        },
            //initilizing
            App.prototype.init = function() {
                var $this = this;
                //document load initialization
                $(document).ready($this.onDocReady);
                $(document).on('pjax:success', function() {
                    hookupEvents();
                });
                $(document).on('pjax:clicked', function(options) {
                    $('a.active').removeClass('active');
                    $(options.target).addClass('active');
                });
            },

            $.App = new App, $.App.Constructor = App

    }(window.jQuery),

    //initializing main application module
    function($) {
        "use strict";
        $.App.init();
    }(window.jQuery);


$(window).load(function() {
    $(".loader").delay(300).fadeOut();
    $(".animationload").delay(600).fadeOut("slow");
});

(function($){

    'use strict';

    function initNavbar () {

        $('.navbar-toggle').on('click', function(event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
            $('.cart, .search').removeClass('open');
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function(e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    }

    function init () {
        initNavbar();
    }

    init();

})(jQuery);

