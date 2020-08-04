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

            $(document).on("click", ".deleteExpense", function(e) {
                that.deleteExpense( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.modalExpense.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var eiID = $invoker.attr("data-id");

                if( eiID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#eiID").val( obj.data.eiID );
                                $("#expenseTitle").val( obj.data.title );
                                $("#expenseAmount").val( obj.data.max_amount ).blur();
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/expense/getExpense/" + eiID, data );
                }
                else {
                    $("#eiID").val(0);
                    $("#expenseTitle").val("");
                    $("#expenseAmount").val("");
                }
            });

            that.modalExpense.on("shown.bs.modal", function(e) {
                $("#expenseTitle").focus( );
            });

            $("#saveExpenseType").validate({
                rules: {
                    expenseTitle: { required: true },
                    expenseAmount: { required: true }
                },
                messages: {
                    expenseTitle: "Please enter a Expense Type Title.",
                    expenseAmount: "Please enter a maximum amount."
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
                                swal("error", obj.errMsg);
                            }
                            else {
                                if( $("#eiID").val( ) == 0 ) {
                                    var title = "Expense Type Created Successfully";
                                    var text = "New expense type has been successfully created.";
                                }
                                else {
                                    var title = "Expense Type Updated Successfully";
                                    var text = "Expense type has been successfully updated.";
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
         * Delete
         * @return void
         */
        deleteExpense: function( eiID ) {
            var that = this;
            var title = $("#expenseTable-row" + eiID).find("td").eq(0).text( );

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
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        eiID: eiID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
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
                    width: "450px",
                    data: "title",
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "max_amount",
                    render: function( data ) {
                        if( data == null ) {
                            return ' &mdash; ';
                        }
                        return Aurora.currency + data;
                    }
                },{
                    targets: [2],
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
                            '<i class="icon-pencil5"></i> Edit Expense Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deleteExpense" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Expense Item</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Expense Type',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: { "first" : 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
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