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

            $(".styled").uniform({
                radioClass: 'choice'
            });

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

            $('input:radio[name="category"]').change(function( ) {
                if( $(this).val( ) == 'a' ) {
                    $("#allowanceType").removeClass("hide");
                }
                else {
                    $("#allowanceType").addClass("hide");
                }

                if( $(this).val( ) == 'l' ) {
                    $("#lumpSumType").removeClass("hide");
                }
                else {
                    $("#lumpSumType").addClass("hide");
                }
            });

            that.modalPayItem.on("hidden.bs.modal", function (e) {
                $("#piID").val(0);
                $("#payItemTitle").val("");
                $("#formula").val("");
                $("#taxable").prop("checked", false);
                $("#category1").prop("checked", true);
                $("#allowanceType3").prop("checked", true);
                $.uniform.update( );
                $("#allowanceType").addClass("hide");
                $("#lumpSumType").addClass("hide");
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
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalPayItem .modal-title").text( Markaxis.i18n.PayrollRes.LANG_EDIT_PAY_ITEM );
                                $("#piID").val( obj.data.piID );
                                $("#payItemTitle").val( obj.data.title );
                                $("#formula").val( obj.data.formula );

                                if( obj.data.taxable == 1 ) {
                                    $("#taxable").prop("checked", true);
                                }

                                if( obj.data.transport == 1 || obj.data.entertainment == 1 || obj.data.allowanceOthers == 1 ) {
                                    $("#category2").prop("checked", true);
                                    $("#allowanceType").removeClass("hide");
                                    if( obj.data.transport == 1 ) $("#allowanceType1").prop("checked", true);
                                    if( obj.data.entertainment == 1 ) $("#allowanceType2").prop("checked", true);
                                    if( obj.data.allowanceOthers == 1 ) $("#allowanceType3").prop("checked", true);
                                }

                                if( obj.data.gratuity == 1 || obj.data.notice == 1 || obj.data.exgratia == 1 || obj.data.lumpSumOthers == 1 ) {
                                    $("#category5").prop("checked", true);
                                    $("#lumpSumType").removeClass("hide");
                                    if( obj.data.gratuity == 1 ) $("#lumpSumType1").prop("checked", true);
                                    if( obj.data.notice == 1 ) $("#lumpSumType2").prop("checked", true);
                                    if( obj.data.exgratia == 1 ) $("#lumpSumType3").prop("checked", true);
                                    if( obj.data.lumpSumOthers == 1 ) $("#lumpSumType4").prop("checked", true);
                                }

                                if( obj.data.directorFee == 1 ) {
                                    $("#category3").prop("checked", true);
                                }

                                if( obj.data.commission == 1 ) {
                                    $("#category4").prop("checked", true);
                                }

                                if( obj.data.pension == 1 ) {
                                    $("#category5").prop("checked", true);
                                }

                                if( obj.data.benefits == 1 ) {
                                    $("#category7").prop("checked", true);
                                }

                                if( obj.data.stock == 1 ) {
                                    $("#category8").prop("checked", true);
                                }

                                $.uniform.update( );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/payroll/getPayItem/" + piID, data );
                }
                else {
                    $("#modalPayItem .modal-title").text( Markaxis.i18n.PayrollRes.LANG_CREATE_NEW_PAY_ITEM );
                    $("#payItemTitle").val("");
                    $("#formula").val("");
                    $("#taxable").prop("checked", false);
                    $("#category1").prop("checked", true);
                    $("#allowanceType3").prop("checked", true);
                    $("#allowanceType").addClass("hide");
                    $("#lumpSumType").addClass("hide");
                    $.uniform.update( );
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
                    payItemTitle: Markaxis.i18n.PayrollRes.LANG_PLEASE_ENTER_PAY_ITEM_TITLE
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
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            }
                            else {
                                swal({
                                    title: Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_CREATED.replace('{title}', $("#payItemTitle").val( )),
                                    text: Aurora.i18n.GlobalRes.LANG_WHAT_TO_DO_NEXT,
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: Markaxis.i18n.PayrollRes.LANG_CREATE_ANOTHER_PAY_ITEM,
                                    cancelButtonText: Aurora.i18n.GlobalRes.LANG_CLOSE_WINDOW,
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
            else if( type === "additional" ) {
                $("#payItemAdditional").addClass("btn-green");
                $("#payItemType").val("additional");
            }
        },


        payItemDelete: function( id ) {
            var that = this;
            var title = $("#payItemTable-row" + id).find("td").eq(0).text( );
            var piID = [];
            piID.push( id );

            swal({
                title: Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', title),
                text: Aurora.i18n.GlobalRes.LANG_CANNOT_UNDONE_DELETED,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE,
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
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        }
                        else {
                            that.table.ajax.reload();
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', title), "success");
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
                    title: Markaxis.i18n.PayrollRes.LANG_NO_PAY_ITEM_SELECTED,
                    type: "info"
                });
            }
            else {
                swal({
                    title: Markaxis.i18n.PayrollRes.LANG_DELETE_SELECTED_PAY_ITEMS,
                    text: Aurora.i18n.GlobalRes.LANG_CANNOT_UNDONE_DELETED,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE,
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
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            }
                            else {
                                that.table.ajax.reload();
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_ITEMS_SUCCESSFULLY_DELETED.replace('{count}', obj.count), "success");
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
                    width: "500px",
                    data: "title"
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "taxable",
                    className : "text-center",
                    render: function( data, type, full ) {
                        if( data === '0' ) {
                            return '<span id="additional' + full['piID'] + '" class="label label-pending">' + Aurora.i18n.GlobalRes.LANG_NO + '</span>';
                        }
                        else {
                            return '<span id="additional' + full['piID'] + '" class="label label-success">' + Aurora.i18n.GlobalRes.LANG_YES + '</span>';
                        }
                    }
                },{
                    targets: [2],
                    orderable: false,
                    searchable: false,
                    width:"80px",
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
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.PayrollRes.LANG_EDIT_PAY_ITEM + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item payItemDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.PayrollRes.LANG_DELETE_PAY_ITEM + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_PAY_ITEM,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
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