/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: designation.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisDesignation = (function( ) {


    /**
     * MarkaxisDesignation Constructor
     * @return void
     */
    MarkaxisDesignation = function( ) {
        this.table = null;
        this. groupColumn = 1;
        this.modalDesignation = $("#modalDesignation");

        this.init( );
    };

    MarkaxisDesignation.prototype = {
        constructor: MarkaxisDesignation,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initTable( );
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            $(document).on("click", ".designationDelete", function(e) {
                that.designationDelete( );
                e.preventDefault( );
            });

            $("#designationBulkDelete").on("click", function(e) {
                that.designationBulkDelete( );
                e.preventDefault( );
            });

            this.modalDesignation.on("hidden.bs.modal", function(e) {
                $(".modal-footer .error").remove();
            });

            this.modalDesignation.on("shown.bs.modal", function(e) {
                $("#designationTitle").focus( );
            });

            this.modalDesignation.on("show.bs.modal", function(e) {
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
                                $("#modalDesignation .modal-title").text("Edit Designation");
                                $("#designationID").val( obj.data.dID );
                                $("#designationTitle").val( obj.data.title );
                                $("#designationDescript").val( obj.data.descript );
                                $("#dID").val( obj.data.parent ).trigger("change");
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/employee/getDesignation/" + dID, data );
                }
                else {
                    $("#modalDesignation .modal-title").text("Create New Designation");
                    $("#designationID").val(0);
                    $("#designationTitle").val("");
                    $("#designationDescript").val("");
                    $("#dID").val("").trigger("change");
                }
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "designation" ) {
                    var dID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/designation/' + dID, function() {
                        $(".modal-title").text( $("#designationTitle" + dID).text( ) );
                    });
                }
            });

            $("#saveDesignation").validate({
                rules: {
                    dID: { required: true },
                    designationTitle: { required: true }
                },
                messages: {
                    dID: "Please select a Designation Group.",
                    designationTitle: "Please enter a Designation Title."
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
                            data: Aurora.WebService.serializePost("#saveDesignation"),
                            group: 0
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
                                    title: $("#designationTitle").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Designation",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#designationID").val(0);
                                    $("#designationTitle").val("");
                                    $("#designationDescript").val("");
                                    $("#dID").val("").trigger("change");

                                    if( isConfirm === false ) {
                                        $("#modalDesignation").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#designationTitle").focus( );
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
         * Delete
         * @return void
         */
        designationDelete: function( ) {
            var that = this;
            var id = $(this).attr("data-id");
            var title = $("#designationTable-row" + id).find("td").eq(1).text( );
            var dID = new Array( );
            dID.push( id );

            var text = "This action cannot be undone once deleted.";
            var group = 0;

            if( $(this).hasClass("group") ) {
                text = "All designations under this group will be deleted!";
                group = 1;
            }

            swal({
                title: "Are you sure you want to delete " + title + "?",
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: dID,
                        group: group
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            $("#dID").select2("destroy").remove( );
                            $("#groupUpdate").html( obj.groupListUpdate );
                            $("#dID").select2( );
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteDesignation", data);
            });
        },


        /**
         * Delete Bulk
         * @return void
         */
        designationBulkDelete: function( ) {
            var that = this;
            var dID = [];
            $("input[name='dID[]']:checked").each(function(i) {
                dID.push( $(this).val( ) );
            });

            if( dID.length == 0 ) {
                swal({
                    title: "No Designation Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected designations?",
                    text: "This action cannot be undone once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirm Delete",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function( isConfirm ) {
                    if( isConfirm === false ) return;

                    var data = {
                        bundle: {
                            data: dID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload( );
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/employee/deleteDesignation", data);
                });
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".designationTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr("id", 'designationTable-row' + aData['dID']);
                    $(nRow).addClass("designationRow-" + aData['parentID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/employee/getDesignationResults",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    }
                },
                initComplete: function( settings, json) {
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets:[0],
                    checkboxes: {
                        selectRow: true
                    },
                    width: '10px',
                    orderable: false,
                    searchable : false,
                    data: 'dID',
                    render: function (data, type, full, meta) {
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="dID[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                },{
                    targets:[1],
                    visible:false,
                    data:'idParentTitle'
                },{
                    targets:[2],
                    orderable:true,
                    width:'160px',
                    data:'title',
                    render: function( data, type, full, meta ) {
                        return '<span id="designationTitle' + full['dID'] + '">' + data + '</span>';
                    }
                },{
                    targets:[3],
                    orderable:true,
                    width:'400px',
                    data:'descript'
                },{
                    targets:[4],
                    orderable:true,
                    width:'100px',
                    data:'empCount',
                    className:"text-center",
                    render: function( data, type, full, meta ) {
                        if( data > 0 ) {
                            return '<a data-role="designation" data-id="' + full['dID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets:[5],
                    orderable:false,
                    searchable:false,
                    width:'100px',
                    className:"text-center",
                    data:'dID',
                    render: function( data, type, full, meta ) {
                        return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" ' +
                                'aria-expanded="false">' +
                                '<i class="icon-menu7"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" ' +
                                'x-placement="bottom-end">' +
                                '<a class="dropdown-item designationEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalDesignation" ' +
                                'data-backdrop="static" data-keyboard="false">' +
                                '<i class="icon-pencil5"></i> Edit Designation</a>' +
                                '<div class="divider"></div>' +
                                '<a class="dropdown-item designationDelete" data-id="' + data + '">' +
                                '<i class="icon-bin"></i> Delete Designation</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                    }
                }],
                select: {
                    "style": "multi"
                },
                order:[[that.groupColumn,"asc"]],
                dom:'<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search:'',
                    searchPlaceholder: 'Search Designation',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate:{'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                drawCallback: function ( settings ) {
                    $(".designationTable [type=checkbox]").uniform();

                    var api = this.api();
                    var rows = api.rows({page:'current'}).nodes();
                    var last = null;

                    api.column(that.groupColumn, {page:'current'}).data().each( function ( group, i ) {
                        if( last !== group ) {
                            var idTitle = group.split("-");

                            var menu = '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle caret-0" ' +
                                'data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="icon-menu7"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" ' +
                                'x-placement="bottom-end">' +
                                '<a class="dropdown-item group designationEdit" data-toggle="modal" data-target="#modalGroup" ' +
                                'data-backdrop="static" data-keyboard="false" data-id="' + idTitle[0] + '">' +
                                '<i class="icon-pencil5"></i> Edit Group</a>' +
                                '<div class="divider"></div>' +
                                '<a class="dropdown-item group designationDelete" data-id="' + idTitle[0] + '">' +
                                '<i class="icon-bin"></i> Delete Group</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            $(rows).eq(i).before('<tr id="designationTable-row' + idTitle[0] + '" data-id="' + idTitle[0] + '" ' +
                                'class="group parentGroupLit groupShow">' +
                                '<td class="text-center details-control">' +
                                '<i class="icon-enlarge7" id="groupIco-' + idTitle[0] + '"></i></td>' +
                                '<td colspan="3" class="details-control">' + idTitle[1] + '</td>' +
                                '<td class="text-center">' + menu + '</td>' +
                                '</tr>');
                            last = group;
                        }
                    });
                },
                preDrawCallback: function() {
                    $(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").removeClass("dropup");
                }
            });

            $(".designation-list-action-btns").insertAfter("#designationList .dataTables_filter");

            $("#designationList tbody").on("click", "td.details-control", function( ) {
                var id = $(this).parent( ).attr("data-id");

                if( !$(this).parent( ).hasClass("groupShow") ) {
                    $(".designationRow-" + id).removeClass("hide");
                    $(this).parent( ).addClass("groupShow parentGroupLit");
                    $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
                }
                else {
                    $(".designationRow-" + id).addClass("hide");
                    $(this).parent( ).removeClass("groupShow parentGroupLit");
                    $("#groupIco-" + id).removeClass("").addClass("icon-shrink7");
                }
            });

            // Alternative pagination
            $('#designationList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('#designationList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#designationList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#designationList .datatable tbody").on("mouseover", "td", function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if( colIdx !== null ) {
                    $(that.table.cells( ).nodes( )).removeClass('active');
                    $(that.table.column(colIdx).nodes( )).addClass('active');
                }
            }).on('mouseleave', function( ) {
                $(that.table.cells( ).nodes( )).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#designationList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisDesignation;
})();
var markaxisDesignation = null;
$(document).ready( function( ) {
    markaxisDesignation = new MarkaxisDesignation( );
});