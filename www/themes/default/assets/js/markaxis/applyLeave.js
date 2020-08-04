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
        this.validator = false;
        this.rules = false;
        this.fileSelected = false;
        this.saveResult = [];
        this.pickerStart = null;
        this.pickerEnd = null;
        this.pickerHolidays = [];
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

            that.pickerStart = $(".pickadate-start").pickadate({
                format:"dd mmmm yyyy",
                onOpen: function ( ) {
                    markaxisPickerExtend.setPickerHolidays( "#startDate_table", that.pickerStart );
                },
                onSet: function ( context ) {
                    markaxisPickerExtend.setPickerHolidays( "#startDate_table", that.pickerStart, context );
                    $("div[role=tooltip]").remove();
                }
            });

            $(".pickadate-end").pickadate({
                showMonthsShort: true,
                ///disable:datesToDisable,
                format:"dd mmm yyyy"
            });

            $(".form-check-input-styled").uniform( );

            $("#ltID").change(function( ) {
                if( $(this).val( ) != "" ) {
                    if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                        $("#applyLeaveForm").validate( that.rules );
                        $("#applyLeaveForm").valid( );
                    }
                }
            });

            $("#startDate").change(function( ) {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    $("#applyLeaveForm").validate( that.rules );
                    $("#applyLeaveForm").valid( );
                }
            });

            $("#endDate").change(function( ) {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    $("#applyLeaveForm").validate( that.rules );
                    $("#applyLeaveForm").valid( );
                }
            });

            $("#firstHalf").change(function( ) {
                that.getDaysDiff( );
            });

            $("#secondHalf").change(function( ) {
                that.getDaysDiff( );
            });

            $("#saveApplyLeave").on("click", function ( ) {
                that.validator = $("#applyLeaveForm").validate( that.rules );

                if( $("#applyLeaveForm").valid( ) ) {
                    that.saveApplyLeave( );
                    return false;
                }
            });

            $("#modalApplyLeave").on("shown.bs.modal", function(e) {
                var markaxisUSuggest = new MarkaxisUSuggest( );
                markaxisUSuggest.getSuggestToken("admin/user/getSuggestToken" );
            });

            $(document).on("click", ".leaveAction", function ( ) {
                that.setLeaveAction( $(this).attr("data-id"), $(this).hasClass("approve") ? 1 : "-1" );
                return false;
            });

            $(document).on("click", ".cancelApplyLeave", function ( ) {
                that.cancelApplyLeave( $(this).attr("data-id") );
                return false;
            });

            $(".fileInput").fileinput({
                uploadUrl: Aurora.ROOT_URL + "admin/leave/upload/",
                uploadAsync: false,
                showUpload: false,
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'pdf', 'doc', 'docx'],
                showPreview: false,
                uploadExtraData: function(previewId, index) {
                    var data = {
                        laID: $("#laID").val( ),
                        csrfToken: Aurora.CSRF_TOKEN
                    };
                    return data;
                }

            }).on('fileuploaderror', function(event, data, msg) {
                that.fileSelected = false;
                console.log('File uploaded', data, msg);

            }).on('filebatchuploadsuccess', function(event, data) {
                that.updateAll( );
            });

            $(".fileInput").change(function () {
                that.fileSelected = true;
            });

            $.validator.addMethod("validDateRange", function(value, element, params) {
                return that.getDaysDiff();
            }, "Invalid date range selected");

            that.rules = {
                ignore: "",
                rules: {
                    ltID: { required: true },
                    startDate: { required: true },
                    endDate: { required: true,
                               validDateRange: true
                    }
                },
                messages: {
                    ltID: "Please provide all required fields."
                },
                highlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).addClass("border-danger");
                    }
                    else {
                        elem.addClass("border-danger");
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).removeClass("border-danger");
                    }
                    else {
                        elem.removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length > 0 ) {
                        $(".modal-footer .error").remove( );
                    }
                    $(".modal-footer").append( error );
                }
            };
        },


        getDaysDiff: function( ) {
            var startDate = new Date( $("#startDate").val( ) );
            var endDate = new Date( $("#endDate").val( ) );

            if( startDate == "Invalid Date" || endDate == "Invalid Date" ) {
                return;
            }
            if( startDate > endDate ) {
                $("#dateHelpWrapper").addClass("hide");
                $("#daysHelp").text("");
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
                    $(".modal-footer .error").remove( );

                    if( obj.bool == 0 && obj.errMsg ) {
                        $(".modal-footer").append( '<label class="error">' + obj.errMsg + '</label>' );
                        return;
                    }

                    if( obj.text ) {
                        $("#daysHelp").text(obj.text);
                        $("#dateHelpWrapper").removeClass("hide");
                    }
                }
            };
            Aurora.WebService.AJAX("admin/leave/getDateDiff", data );
            return true;
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


        saveApplyLeave: function( ) {
            var that = this;
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
                        that.saveResult = obj.data;
                        $("#laID").val( obj.data.laID );

                        if( that.fileSelected ) {
                            $(".fileInput").fileinput("upload");
                        }
                        else {
                            that.updateAll( );
                        }
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/apply", data );
        },


        updateAll: function( ) {
            var ltID = $("#ltID").val( );
            $("#ltID" + ltID).text( this.saveResult.balance );
            $("#ltID").select2("val", false);
            $("#reason").val("");
            $("#startDate").val("");
            $("#endDate").val("");
            $("#firstHalf").prop("checked", false).parent( ).removeClass("checked");
            $("#secondHalf").prop("checked", false).parent( ).removeClass("checked");
            $(".fileInput").fileinput("clear");
            $(".modal-footer .error").remove( );

            if( this.saveResult.hasSup ) {
                text = "Your leave application is not confirm yet and is subject to your manager(s) approval.";
            }
            else {
                text = "";
            }
            swal({
                title: "Leave Applied Successfully",
                text: text,
                type: "success"
            }, function( isConfirm ) {
                if( $(".leaveHistoryTable").length ) {
                    $(".leaveHistoryTable").DataTable().ajax.reload( );
                }
                $("#modalApplyLeave").modal("hide");
            });

            this.saveResult = [];
        },


        cancelApplyLeave: function( laID ) {
            swal({
                title: "Cancel Applied Leave?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Cancel",
                closeOnConfirm: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        laID: laID
                    },
                    success: function( res ) {
                        swal({
                            title: "Leave Cancelled Successfully",
                            text: "Please hold while the page reload.",
                            type: 'success'
                        }, function( isConfirm ) {
                            window.location.reload(false);
                        });
                    }
                };
                Aurora.WebService.AJAX( "admin/leave/cancel", data );
            });
        }
    }
    return MarkaxisApplyLeave;
})();
var markaxisApplyLeave = null;
$(document).ready( function( ) {
    markaxisApplyLeave = new MarkaxisApplyLeave( );
});