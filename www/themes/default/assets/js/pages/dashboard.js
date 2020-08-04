$(function() {
    $(".chat-header").on("mousedown", function(mousedownEvt) {
        mousedownEvt.preventDefault()
        var $draggable = $(this);
        var x = mousedownEvt.pageX - $draggable.offset().left,
            y = mousedownEvt.pageY - $draggable.offset().top;
        $("body").on("mousemove.draggable", function(mousemoveEvt) {
            $draggable.closest(".modal-dialog").offset({
                "left": mousemoveEvt.pageX - x,
                "top": mousemoveEvt.pageY - y
            });
        });
        $("body").one("mouseup", function() {
            $("body").off("mousemove.draggable");
        });
        $draggable.closest(".modal").one("bs.modal.hide", function() {
            $("body").off("mousemove.draggable");
        });
    });

    $(".modalClose").click(function( ) {
        $("#modalChat").hide( );
    });

    $(".modalChat").click(function( ) {
        $("#modalChat").css({
            top: "-2%",
            left: "17%",
            bottom: "0"
        });
        $("#modalChat").show( );
        $("#message").focus( );
    });

    $("#modalChat").on("shown.bs.modal", function(e) {
        $("body").removeClass("modal-open");
    });

    var data = {
        success: function(res) {
            if( res ) {
                var obj = $.parseJSON(res);

                if( obj.bool == 1 ) {
                    $("#noPendingAction").hide( );
                    $("#pendingAction").html( obj.data );

                    if( $("#noRequest").is(":visible") ) {
                        $("#pendingWrapper").insertBefore( $("#requestWrapper") );
                    }
                }
            }
        }
    };
    Aurora.WebService.AJAX( "admin/dashboard/getPendingAction", data );

    var data1 = {
        success: function(res) {
            if( res ) {
                var obj = $.parseJSON(res);

                if( obj.bool == 1 ) {
                    $("#noRequest").hide( );
                    $("#latestRequest").html( obj.data );

                    if( $("#noPendingAction").is(":visible") ) {
                        $("#requestWrapper").insertBefore( $("#pendingWrapper") );
                    }
                }
            }
        }
    };
    Aurora.WebService.AJAX( "admin/dashboard/getRequest", data1 );
});