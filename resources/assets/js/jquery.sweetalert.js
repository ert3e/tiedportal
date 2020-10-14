!function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples 
    SweetAlert.prototype.init = function() {

        //Warning Message
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            var href = $(this).data('href');
            var confirmation = $(this).data('confirm');
            var element = $(this).data('element');
            var redirect = $(this).data('redirect');
            swal({
                title: $(this).data('title'),
                text: $(this).data('message'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#CC0000",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function(){
                $.post(href, {}, function() {
                    swal("Deleted!", confirmation, "success");
                    if( typeof redirect == 'undefined' )
                        $.pjax.reload('#pjax-container');
                    else
                        $.pjax({url: redirect, container: '#pjax-container'});
                }).fail(function() {
                    swal("An error occurred", "Please check your connection and try again.", "error");
                });
            });
        });

        $(document).on('click', '.confirm-button', function(e) {
            e.preventDefault();
            var href = $(this).data('href');
            var confirmation = $(this).data('confirm');
            var element = $(this).data('element');
            var redirect = $(this).data('redirect');
            swal({
                title: $(this).data('title'),
                text: $(this).data('message'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#CC0000",
                confirmButtonText: "Yes, do it!",
                closeOnConfirm: false
            }, function(){
                $.post(href, {}, function() {
                    swal("Complete!", confirmation, "success");
                    if( typeof redirect == 'undefined' )
                        $.pjax.reload('#pjax-container');
                    else
                        $.pjax({url: redirect, container: '#pjax-container'});
                }).fail(function() {
                    swal("An error occurred", "Please check your connection and try again.", "error");
                });
            });
        });

    },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing 
    function($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);