/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payItem.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayItem = (function( ) {

    /**
     * MarkaxisPayItem Constructor
     * @return void
     */
    MarkaxisPayItem = function( ) {
        this.table = null;
        this.modalPayItem = $("#modalPayItem");
        this.init( );
    };

    MarkaxisPayItem.prototype = {
        constructor: MarkaxisPayItem,

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

            $(".payItemBtn").on("click", function(e) {
                that.selectPayItemType( $(this).val( ) );
                e.preventDefault( );
            });

            $(document).on("click", ".payItemDelete", function(e) {
                that.payItemDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            $("#payItemBulkDelete").on("click", function(e) {
                that.payItemBulkDelete( );
                e.preventDefault( );
            });

            that.modalPayItem.on("hidden.bs.modal", function (e) {
                $("#piID").val(0);
                $("#payItemTitle").val("");
                that.selectPayItemType( "none" );
            });

            that.modalPayItem.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var piID = $invoker.attr("data-id");

                if( piID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#piID").val( obj.data.piID );
                                $("#payItemTitle").val( obj.data.title );

                                if( obj.data.ordinary == 1 ) {
                                    that.selectPayItemType("ordinary");
                                }
                                else if( obj.data.deduction == 1 ) {
                                    that.selectPayItemType("deduction");
                                }
                                else if( obj.data.deductionAW == 1 ) {
                                    that.selectPayItemType("deductionAW");
                                }
                                else if( obj.data.additional == 1 ) {
                                    that.selectPayItemType("additional");
                                }
                                else {
                                    that.selectPayItemType("none");
                                }
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/payroll/getPayItem/" + piID, data );
                }
                else {
                    $("#payItemTitle").val("")
                }
            });

            that.modalPayItem.on("shown.bs.modal", function(e) {
                $("#payItemTitle").focus( );
            });

            $("#savePayItem").validate({
                rules: {
                    payItemTitle: { required: true }
                },
                messages: {
                    payItemTitle: "Please enter a Pay Item Title."
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
                            data: Aurora.WebService.serializePost("#savePayItem")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool === 0 ) {
                                swal("error", obj.errMsg);
                            }
                            else {
                                swal({
                                    title: $("#payItemTitle").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Pay Item",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    that.table.ajax.reload( );
                                    $("#payItemTitle").val("");
                                    that.selectPayItemType( "none" );

                                    if( isConfirm === false ) {
                                        $("#modalPayItem").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#payItemTitle").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/payroll/savePayItem", data );
                }
            });
        },


        selectPayItemType: function( type ) {
            $(".payItemBtn").addClass("btn-light").removeClass("btn-dark btn-green");

            if( type === "ordinary" ) {
                $("#payItemOrdinary").addClass("btn-green");
                $("#payItemType").val("ordinary");
            }
            else if( type === "deduction" ) {
                $("#payItemDeduction").addClass("btn-green");
                $("#payItemType").val("deduction");
            }
            else if( type === "deductionAW" ) {
                $("#payItemDeductionAW").addClass("btn-green");
                $("#payItemType").val("deductionAW");
            }
            else if( type === "additional" ) {
                $("#payItemAdditional").addClass("btn-green");
                $("#payItemType").val("additional");
            }
            else {
                $("#payItemNone").addClass("btn-dark");
                $("#payItemType").val("none");
            }
        },


        payItemDelete: function( id ) {
            var title = $("#payItemTable-row" + id).find("td").eq(0).text( );
            var piID = [];
            piID.push( id );

            swal({
                title: "Are you sure you want to delete " + title + "?",
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
                        data: piID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal("Error!", obj.errMsg, "error");
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/deletePayItem", data);
            });
        },


        payItemBulkDelete: function( ) {
            var piID = [];
            $("input[name='piID[]']:checked").each(function(i) {
                piID.push( $(this).val( ) );
            });

            if( piID.length === 0 ) {
                swal({
                    title: "No Pay Item Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected pay Items?",
                    text: "This action cannot be undone once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirm Delete",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function (isConfirm) {
                    if (isConfirm === false) return;

                    var data = {
                        bundle: {
                            data: piID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal("Error!", obj.errMsg, "error");
                            }
                            else {
                                that.table.ajax.reload();
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/payroll/deletePayItem", data);
                });
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".payItemTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', 'payItemTable-row' + aData['piID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/getItemResults",
                    type: "POST",
                    data: function(d) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function( ) {
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    width: "200px",
                    data: "title"
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "ordinary",
                    className : "text-center",
                    render: function( data ) {
                        if( data === '0' ) {
                            return '<span class="label label-pending">No</span>';
                        }
                        else {
                            return '<span class="label label-success">Yes</span>';
                        }
                    }
                },{
                    targets: [2],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "deduction",
                    className : "text-center",
                    render: function( data, type, full ) {
                        if( data === '0' ) {
                            return '<span id="deduction' + full['piID'] + '" class="label label-pending">No</span>';
                        }
                        else {
                            return '<span id="deduction' + full['piID'] + '" class="label label-success">Yes</span>';
                        }
                    }
                },{
                    targets: [3],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "deductionAW",
                    className : "text-center",
                    render: function( data, type, full ) {
                        if( data === '0' ) {
                            return '<span id="deductionAW' + full['piID'] + '" class="label label-pending">No</span>';
                        }
                        else {
                            return '<span id="deductionAW' + full['piID'] + '" class="label label-success">Yes</span>';
                        }
                    }
                },{
                    targets: [4],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "additional",
                    className : "text-center",
                    render: function( data, type, full ) {
                        if( data === '0' ) {
                            return '<span id="additional' + full['piID'] + '" class="label label-pending">No</span>';
                        }
                        else {
                            return '<span id="additional' + full['piID'] + '" class="label label-success">Yes</span>';
                        }
                    }
                }, {
                    targets: [5],
                    orderable: false,
                    searchable: false,
                    width:"100px",
                    className:"text-center",
                    data:"piID",
                    render: function( data ) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalPayItem">' +
                            '<i class="icon-pencil5"></i> Edit Pay Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item payItemDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Pay Item</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Pay Item',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $(".payItemTable [type=checkbox]").uniform();
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".payItems-list-action-btns").insertAfter("#payItems .dataTables_filter");

            $('.payItemTable tbody').on('mouseover', 'td', function() {
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function( ) {
                $(that.table.cells( ).nodes( )).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#payItems .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisPayItem;
})();
var markaxisPayItem = null;
$(document).ready( function( ) {
    markaxisPayItem = new MarkaxisPayItem( );
});