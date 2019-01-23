$(function() {
    $(".chat-header").on("mousedown", function(mousedownEvt) {
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

    $("#modalChat").on("show.bs.modal", function(e) {
        var $invoker = $(e.relatedTarget);
        var tgID = $invoker.attr("data-id");

        console.log("sdfds")
        /*if( tgID ) {
            var data = {
                bundle: {
                    tgID: tgID
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        swal("error", obj.errMsg);
                        return;
                    }
                    else {
                        $("#tgID").val( obj.data.tgID );
                        $("#groupTitle").val( obj.data.title );
                        $("#groupDescription").val( obj.data.description );
                        $("#parent").val( obj.data.parent ).trigger("change");
                    }
                }
            }
            Aurora.WebService.AJAX( "admin/payroll/getTaxGroup/" + tgID, data );
        }
        else {
            $("#tgID").val(0);
            $("#groupTitle").val("");
            $("#groupDescription").val("");
            $("#parent").val(0).trigger("change");
        }*/
    });

    $("#modalChat").on("shown.bs.modal", function(e) {
        $("body").removeClass("modal-open");
    });
});