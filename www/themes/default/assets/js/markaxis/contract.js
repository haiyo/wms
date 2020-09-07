/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: contract.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisContract = (function( ) {


    /**
     * MarkaxisContract Constructor
     * @return void
     */
    MarkaxisContract = function( ) {
        this.table = null;
        this.modalContract = $("#modalContract");
        this.init( );
    };

    MarkaxisContract.prototype = {
        constructor: MarkaxisContract,

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

            $(document).on("click", ".contractDelete", function(e) {
                that.contractDelete( );
                e.preventDefault( );
            });

            $("#contractBulkDelete").on("click", function(e) {
                that.contractBulkDelete( );
                e.preventDefault( );
            });

            that.modalContract.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var cID = $invoker.attr("data-id");

                if( cID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalContract .modal-title").text( Markaxis.i18n.ContractRes.LANG_EDIT_CONTRACT );
                                $("#contractID").val( obj.data.cID );
                                $("#contractTitle").val( obj.data.type );
                                $("#contractDescript").val( obj.data.descript );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/employee/getContract/" + cID, data );
                }
                else {
                    $("#modalContract .modal-title").text( Markaxis.i18n.ContractRes.LANG_CREATE_NEW_CONTRACT );
                    $("#contractID").val(0);
                    $("#contractTitle").val("");
                    $("#contractDescript").val("");
                }
            });

            that.modalContract.on("shown.bs.modal", function(e) {
                $("#contractTitle").focus( );
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "contract" ) {
                    var cID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/contract/' + cID, function() {
                        $(".modal-title").text( $("#contractType" + cID).text( ) );
                    });
                }
            });

            $("#saveContract").validate({
                rules: {
                    contractTitle: { required: true }
                },
                messages: {
                    contractTitle: Markaxis.i18n.ContractRes.LANG_PLEASE_ENTER_CONTRACT_TITLE
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
                            data: Aurora.WebService.serializePost("#saveContract")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload();

                                swal({
                                    title: Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_CREATED.replace('{title}', $("#contractTitle").val( )),
                                    text: Aurora.i18n.GlobalRes.LANG_WHAT_TO_DO_NEXT,
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: Markaxis.i18n.ContractRes.LANG_CREATE_ANOTHER_CONTRACT,
                                    cancelButtonText: Aurora.i18n.GlobalRes.LANG_CLOSE_WINDOW,
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#contractID").val(0);
                                    $("#contractTitle").val("");
                                    $("#contractDescript").val("");

                                    if( isConfirm === false ) {
                                        $("#modalContract").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#contractTitle").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/saveContract", data );
                }
            });
        },


        /**
         * Delete
         * @return void
         */
        contractDelete: function( ) {
            var that = this;
            var id = $(this).attr("data-id");
            var title = $("#contractTable-row" + id).find("td").eq(1).text( );
            var cID = new Array( );
            cID.push( id );

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
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: cID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', title), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteContract", data);
            });
        },


        /**
         * Delete Bulk
         * @return void
         */
        contractBulkDelete: function( ) {
            var that = this;
            var cID = [];
            $("input[name='cID[]']:checked").each(function(i) {
                cID.push( $(this).val( ) );
            });

            if( cID.length == 0 ) {
                swal({
                    title: Markaxis.i18n.ContractRes.LANG_NO_CONTRACT_SELECTED,
                    type: "info"
                });
            }
            else {
                swal({
                    title: Markaxis.i18n.ContractRes.LANG_CONFIRM_DELETE_CONTRACT,
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
                            data: cID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload( );
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_ITEMS_SUCCESSFULLY_DELETED.replace('{count}', obj.count), "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/employee/deleteContract", data);
                });
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".contractTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'contractTable-row' + aData['cID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/employee/getContractResults",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
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
                    data: 'cID',
                    render: function( data, type, full, meta ) {
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="cID[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '160px',
                    data: 'type',
                    render: function( data, type, full, meta ) {
                        return '<span id="contractType' + full['cID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '400px',
                    data: 'descript'
                },{
                    targets: [3],
                    orderable: true,
                    width: '100px',
                    data: 'empCount',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data > 0 ) {
                            return '<a data-role="contract" data-id="' + full['cID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets: [4],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'cID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item contractEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalContract" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.ContractRes.LANG_EDIT_CONTRACT_TYPE + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item contractDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.ContractRes.LANG_DELETE_CONTRACT_TYPE + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                select: {
                    "style": "multi"
                },
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.ContractRes.LANG_SEARCH_CONTRACT_TYPE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(".contractTable [type=checkbox]").uniform();

                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".contract-list-action-btns").insertAfter("#contractList .dataTables_filter");

            // Alternative pagination
            $('#contractList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('#contractList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#contractList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#contractList .datatable tbody").on("mouseover", "td", function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#contractList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisContract;
})();
var markaxisContract = null;
$(document).ready( function( ) {
    markaxisContract = new MarkaxisContract( );
});