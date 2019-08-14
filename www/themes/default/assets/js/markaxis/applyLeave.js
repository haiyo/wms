/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: applyLeave.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisApplyLeave = (function( ) {

    /**
     * MarkaxisApplyLeave Constructor
     * @return void
     */
    MarkaxisApplyLeave = function( ) {
        this.init( );
    };

    MarkaxisApplyLeave.prototype = {
        constructor: MarkaxisApplyLeave,

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

            $("#ltID").select2({minimumResultsForSearch: -1});
            //$("#applyFor").select2({minimumResultsForSearch: -1});

            var datesToDisable = [ [2019,1,5], [2019,1,6] ]

            $(".pickadate-start").pickadate({
                showMonthsShort: true,
                disable:datesToDisable,
                format:"dd mmm yyyy"
            });

            $(".pickadate-end").pickadate({
                showMonthsShort: true,
                ///disable:datesToDisable,
                format:"dd mmm yyyy"
            });

            $(".form-check-input-styled").uniform( );

            $("#ltID").change(function( ) {
                that.getDaysDiff( );
            });
            $("#startDate").change(function( ) {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });
            $("#endDate").change(function( ) {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });
            $("#firstHalf").change(function( ) {
                that.getDaysDiff( );
            });
            $("#secondHalf").change(function( ) {
                that.getDaysDiff( );
            });

            $("#saveApplyLeave").on("click", function ( ) {
                that.saveApplyLeave( );
                return false;
            });

            $("#modalApplyLeave").on("shown.bs.modal", function(e) {
                var markaxisUSuggest = new MarkaxisUSuggest( false );
                markaxisUSuggest.getSuggestToken("admin/employee/getSuggestToken" );
            });

            $(document).on("click", ".leaveAction", function ( ) {
                that.setLeaveAction( $(this).attr("data-id"), $(this).hasClass("approve") ? 1 : "-1" );
                return false;
            });
        },

        setLeaveAction: function( laID, approved ) {
            var data = {
                bundle: {
                    laID: laID,
                    approved: approved
                },
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 1 ) {
                        $("#list-" + laID).fadeOut("slow", function( ) {
                            $(this).remove( );

                            if( $(".pendingList").length == 0 ) {
                                $("#tableRequest").remove( );
                                $("#noPendingAction").show( );
                            }
                            else if( $(".leaveAction").length == 0 ) {
                                $("#group-leave").remove( );
                            }
                            return;
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/setLeaveAction", data );
        },

        getDaysDiff: function( ) {
            var startDate = new Date( $("#startDate").val( ) );
            var endDate = new Date( $("#endDate").val( ) );

            if( startDate > endDate ) {
                swal("Error!", "Invalid date range selected", "error");
                return false;
            }
            var data = {
                bundle: {
                    ltID: $("#ltID").val( ),
                    startDate: $("#startDate").val( ),
                    endDate: $("#endDate").val( ),
                    firstHalf: $("#firstHalf").is(':checked') ? 1 : 0,
                    secondHalf: $("#secondHalf").is(':checked') ? 1 : 0
                },
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 0 && obj.errMsg ) {
                        $("#daysHelp").text(obj.errMsg);
                        $("#dateHelpWrapper").removeClass("hide");
                        return;
                    }

                    if( obj.text ) {
                        $("#daysHelp").text(obj.text);
                        $("#dateHelpWrapper").removeClass("hide");
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/getDateDiff", data );
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
                        $("#ltID" + ltID).text( obj.data.balance );

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
    return MarkaxisApplyLeave;
})();
var markaxisApplyLeave = null;
$(document).ready( function( ) {
    markaxisApplyLeave = new MarkaxisApplyLeave( );
});