$(document).ready(function( ) {
    $("#modalContent").on("show.bs.modal", function(e) {
        var $invoker = $(e.relatedTarget);

        var data = {
            success: function( res   ) {
                var obj = $.parseJSON( res );

                if( obj.bool == 0 ) {
                    $("#modalContent .modal-body").html( obj.errMsg );
                    return;
                }
                $("#modalContent .modal-title").text( obj.data.title );
                $("#modalContent .modal-body").html( obj.data.content );
            }
        };
        Aurora.WebService.AJAX("admin/newsAnnouncement/getContent/" + $invoker.attr("data-id"), data );
    });
});