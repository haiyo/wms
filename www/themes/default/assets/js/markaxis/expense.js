/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: expense.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisExpense = (function( ) {


    /**
     * MarkaxisExpense Constructor
     * @return void
     */
    MarkaxisExpense = function( ) {
        this.table = null;
        this.modalExpense = $("#modalExpense");

        this.init( );
    };

    MarkaxisExpense.prototype = {
        constructor: MarkaxisExpense,

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

            $("#expenseCountry").select2( );

            $(document).on("click", ".deleteExpense", function(e) {
                that.deleteExpense( $(this).attr("data-id") );
                e.preventDefault( );
            });

            $("#expenseCountry").on("change", function( ) {
                if( $(this).val( ) != null ) {
                    that.setCurrency( $(this).val( ) );
                }
            });

            that.modalExpense.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var eiID = $invoker.attr("data-id");

                if( eiID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                console.log(obj.data)
                                $("#modalExpense .modal-title").text( Markaxis.i18n.ExpenseRes.LANG_EDIT_EXPENSE_TYPE );
                                $("#eiID").val( obj.data.eiID );
                                $("#expenseTitle").val( obj.data.title );
                                $("#expenseCountry").val( obj.data.countryID ).trigger("change");
                                $("#expenseAmount").val( obj.data.currencyCode + obj.data.currencySymbol + obj.data.max_amount );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/expense/getExpense/" + eiID, data );
                }
                else {
                    $("#modalExpense .modal-title").text( Markaxis.i18n.ExpenseRes.LANG_CREATE_NEW_EXPENSE_TYPE );
                    $("#eiID").val(0);
                    $("#expenseTitle").val("");
                    $("#expenseCountry").val("").trigger("change");
                    $("#expenseAmount").val("");
                }
            });

            that.modalExpense.on("shown.bs.modal", function(e) {
                $("#expenseTitle").focus( );
            });

            that.modalExpense.on("hidden.bs.modal", function() {
                $("#eiID").val(0);
                $("#expenseTitle").val("");
                $("#expenseCountry").val("").trigger("change");
                $("#expenseAmount").val("");
            });

            $("#saveExpenseType").validate({
                rules: {
                    expenseTitle: { required: true },
                    expenseAmount: { required: true },
                    expenseCountry: { required: true }
                },
                messages: {
                    expenseTitle: Markaxis.i18n.ExpenseRes.LANG_ENTER_EXPENSE_TYPE,
                    expenseAmount: Markaxis.i18n.ExpenseRes.LANG_ENTER_MAX_AMOUNT,
                    expenseCountry: Markaxis.i18n.ExpenseRes.LANG_PLEASE_SELECT_COUNTRY
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
                            data: Aurora.WebService.serializePost("#saveExpenseType")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool === 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            }
                            else {
                                if( $("#eiID").val( ) == 0 ) {
                                    var title = Markaxis.i18n.ExpenseRes.LANG_EXPENSE_CREATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.ExpenseRes.LANG_EXPENSE_CREATED_SUCCESSFULLY_DESCRIPT;
                                }
                                else {
                                    var title = Markaxis.i18n.ExpenseRes.LANG_EXPENSE_UPDATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.ExpenseRes.LANG_EXPENSE_UPDATED_SUCCESSFULLY_DESCRIPT;
                                }

                                swal({
                                    title: title,
                                    text: text,
                                    type: "success"
                                }, function( isConfirm ) {
                                    that.table.ajax.reload( );
                                    $("#modalExpense").modal("hide");
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/expense/saveExpenseType", data );
                }
            });
        },


        /**
         * setCurrency
         * @return void
         */
        setCurrency: function( cID ) {
            var that = this;

            var data = {
                bundle: {
                    cID: cID
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $("#expenseAmount").attr("data-currency", obj.data.currencyCode + obj.data.currencySymbol );
                    }
                }
            };
            Aurora.WebService.AJAX("admin/expense/getCurrency", data);
        },


        /**
         * Delete
         * @return void
         */
        deleteExpense: function( eiID ) {
            var that = this;
            var title = $("#expenseTable-row" + eiID).find("td").eq(0).text( );

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
                        eiID: eiID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', title), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/expense/deleteExpense", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".expenseTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData ) {
                    $(nRow).attr('id', 'expenseTable-row' + aData['eiID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/expense/getExpensesResults",
                    type: "POST",
                    data: function(d) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function () {
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    searchable: false,
                    width: "300px",
                    data: "title",
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "300px",
                    data: "country",
                },{
                    targets: [2],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "max_amount",
                    render: function( data ) {
                        if( data == null ) {
                            return ' &mdash; ';
                        }
                        return data;
                    }
                },{
                    targets: [3],
                    orderable: false,
                    searchable: false,
                    width:"100px",
                    className:"text-center",
                    data:"eiID",
                    render: function( data ) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalExpense">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.ExpenseRes.LANG_EDIT_EXPENSE_ITEM + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deleteExpense" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.ExpenseRes.LANG_DELETE_EXPENSE_ITEM + '</a>' +
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
                    searchPlaceholder: Markaxis.i18n.ExpenseRes.LANG_SEARCH_EXPENSE_TYPE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $(".expenseTable [type=checkbox]").uniform();
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".expense-list-action-btns").insertAfter("#expenses .dataTables_filter");

            $('.expenseTable tbody').on('mouseover', 'td', function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function( ) {
                $(that.table.cells( ).nodes( )).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#expense .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisExpense;
})();
var markaxisExpense = null;
$(document).ready( function( ) {
    markaxisExpense = new MarkaxisExpense( );
});