/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: designationGroup.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisDesignationGroup = (function( ) {


    /**
     * MarkaxisDesignationGroup Constructor
     * @return void
     */
    MarkaxisDesignationGroup = function( ) {
        this.modalDesignationGroup = $("#modalGroup");
        this.init( );
    };

    MarkaxisDesignationGroup.prototype = {
        constructor: MarkaxisDesignationGroup,

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

            $("#orphanGroupDelete").on("click", function(e) {
                that.orphanGroupDelete( );
                e.preventDefault( );
            });

            that.modalDesignationGroup.on("shown.bs.modal", function(e) {
                $("#groupTitle").focus( );
            });

            that.modalDesignationGroup.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var dID = $invoker.attr("data-id");

                if( dID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#modalGroup .modal-title").text("Edit Group");
                                $("#groupID").val( obj.data.dID );
                                $("#groupTitle").val( obj.data.title );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/employee/getDesignation/" + dID, data );
                }
                else {
                    $("#modalGroup .modal-title").text("Create New Group");
                    $("#groupID").val(0);
                    $("#groupTitle").val("");
                }
            });

            that.modalDesignationGroup.on("hidden.bs.modal", function (e) {
                $("#groupTitle").removeClass("border-danger");
                $(".modal-footer .error").remove();
            });

            $("#saveGroup").validate({
                onfocusout: false,
                rules: {
                    groupTitle: { required: true }
                },
                messages: {
                    groupTitle: "Please enter a Group Title."
                },
                highlight: function(element, errorClass) {
                    $(element).addClass("border-danger");
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass("border-danger");
                    $(".modal-footer .error").remove();
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length == 0 )
                        $(".modal-footer").append(error);
                },
                submitHandler: function( ) {
                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveGroup"),
                            group: 1
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                that.table.ajax.reload();

                                swal({
                                    title: $("#groupTitle").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Group",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#groupID").val(0);
                                    $("#groupTitle").val("");

                                    // Update designation selectlist
                                    $("#dID").select2("destroy").remove( );
                                    $("#groupUpdate").html( obj.groupListUpdate );
                                    $("#dID").select2( );

                                    if( isConfirm === false ) {
                                        $("#modalGroup").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#groupTitle").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/saveDesignation", data );
                }
            });
        },


        /**
         * Delete Orphan Group(s)
         * @return void
         */
        orphanGroupDelete: function( ) {
            swal({
                title: "Are you sure you want to delete all orphan groups?",
                text: "All groups with empty designation will be deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if( isConfirm === false ) return;

                var data = {
                    success: function(res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( obj.count > 0 ) {
                                $("#dID").select2("destroy").remove( );
                                $("#groupUpdate").html( obj.groupListUpdate );
                                $("#dID").select2( );
                                swal("Done!", obj.count + " orphan groups has been successfully deleted!", "success");
                            }
                            else {
                                swal("Done!", "There are currently no orphan group.", "success");
                            }
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteOrphanGroups", data);
            });
        }
    }
    return MarkaxisDesignationGroup;
})();
var markaxisDesignationGroup = null;
$(document).ready( function( ) {
    markaxisDesignationGroup = new MarkaxisDesignationGroup( );
});