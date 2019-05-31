/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: claim.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisClaim = (function( ) {

    /**
     * MarkaxisClaim Constructor
     * @return void
     */
    MarkaxisClaim = function( ) {
        this.init( );
    };

    MarkaxisClaim.prototype = {
        constructor: MarkaxisClaim,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            $(document).on("click", ".claimAction", function ( ) {
                that.setClaimAction( $(this).attr("data-id"), $(this).hasClass("approve") ? 1 : "-1" );
                return false;
            });
        },

        setClaimAction: function( ecID, approved ) {
            var data = {
                bundle: {
                    ecID: ecID,
                    approved: approved
                },
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 1 ) {
                        $("#list-" + ecID).fadeOut("slow", function( ) {
                            $(this).remove( );

                            if( $(".pendingList").length == 0 ) {
                                $("#tableRequest").remove( );
                                $("#noPendingAction").show( );
                            }
                            else if( $(".claimAction").length == 0 ) {
                                $("#group-claim").remove( );
                            }
                            return;
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/expense/setClaimAction", data );
        },


        saveApplyLeave: function( ) {
            var formData = Aurora.WebService.serializePost("#applyLeaveForm");

            var data = {
                bundle: {
                    laddaClass: "#saveApplyLeave",
                    data: formData
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        var ltID = $("#ltID").val( );
                        var count = parseInt( $("#ltID" + ltID).text( ) );
                        $("#ltID" + ltID).text( count-obj.data.days );

                        if( obj.data.hasSup ) {
                            text = "Your leave application is not confirm yet and is subject to Manager(s) approval.";
                        }
                        else {
                            text = "";
                        }
                        swal({
                            title: "Leave Applied Successfully",
                            text: text,
                            type: 'success'
                        }, function( isConfirm ) {
                            $("#modalApplyLeave").modal('hide');
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/apply", data );
        }
    }
    return MarkaxisClaim;
})();
var markaxisClaim = null;
$(document).ready( function( ) {
    markaxisClaim = new MarkaxisClaim( );
});