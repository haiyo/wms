/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payCal.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayCal = (function( ) {

    /**
     * MarkaxisPayCal Constructor
     * @return void
     */
    MarkaxisPayCal = function( ) {
        this.table = null;
        this.modalAddPayCal = $("#modalAddPayCal");
        this.init( );
    };

    MarkaxisPayCal.prototype = {
        constructor: MarkaxisPayCal,

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

            $("#payPeriod").select2({minimumResultsForSearch: Infinity});

            $("#payPeriod option").filter(function() {
                return !this.value || $.trim(this.value).length == 0 || $.trim(this.text).length == 0;
            }).remove();

            $("#payPeriod option[value='month']").attr( "selected", true );

            $(".pickadate-paymentDate").pickadate({
                showMonthsShort: true
            });

            $("#payPeriod").change(function() {
                that.getPaymentRecur( );
            });

            $(".pickadate-paymentDate").change(function() {
                that.getPaymentRecur( );
            });

            $(document).on("click", ".deletePayCal", function(e) {
                that.deletePayCal( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.modalAddPayCal.on("hidden.bs.modal", function (e) {
                $("#pcID").val(0);
                $("#title").val("");
                $("#payPeriod").val("month").trigger("change");
                $("#paymentCycle").addClass("hide");

                var paymentDate = $(".pickadate-paymentDate").pickadate("picker");
                paymentDate.clear();
            });

            that.modalAddPayCal.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var pcID = $invoker.attr("data-id");

                if( pcID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalAddPayCal .modal-title").text( Markaxis.i18n.PayrollRes.LANG_EDIT_PAY_CAL );
                                $("#pcID").val( obj.data.pcID );
                                $("#payPeriod").val( obj.data.payPeriod ).trigger("change");
                                $("#title").val( obj.data.title );

                                var year  = moment(obj.data.paymentDate).format("YYYY");
                                var month = moment(obj.data.paymentDate).format("MM");
                                var day   = moment(obj.data.paymentDate).format("DD");

                                var paymentDate = $(".pickadate-paymentDate").pickadate("picker");
                                paymentDate.set( "select", new Date( year, parseInt(month)-1, day ) );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/payroll/getPayCal/" + pcID, data );
                }
                else {
                    $("#modalAddPayCal .modal-title").text( Markaxis.i18n.PayrollRes.LANG_CREATE_NEW_PAY_CALENDAR );
                    $("#pcID").val(0);
                    $("#title").val("");
                    $("#payPeriod").val("month").trigger("change");
                    $("#paymentCycle").addClass("hide");

                    var paymentDate = $(".pickadate-paymentDate").pickadate("picker");
                    paymentDate.clear();
                }
            });

            $("#savePayCal").validate({
                rules: {
                    title: { required: true },
                    payPeriod: { required: true },
                    paymentDate: { required: true }
                },
                messages: {
                    title: Markaxis.i18n.PayrollRes.LANG_PLEASE_ENTER_TITLE,
                    payPeriod: Markaxis.i18n.PayrollRes.LANG_PLEASE_SELECT_PERIOD,
                    paymentDate: Markaxis.i18n.PayrollRes.LANG_PLEASE_SELECT_DATE
                },
                submitHandler: function( ) {
                    var data = {
                        bundle: {
                            pcID: $("#pcID").val( ),
                            title: $("#title").val( ),
                            payPeriod: $("#payPeriod").val( ),
                            paymentDate: $("#paymentDate").val( )
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                if( $("#pcID").val( ) == 0 ) {
                                    var title = Markaxis.i18n.PayrollRes.LANG_PAY_CAL_CREATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.PayrollRes.LANG_PAY_CAL_CREATED_SUCCESSFULLY_DESCRIPT;
                                }
                                else {
                                    var title = Markaxis.i18n.PayrollRes.LANG_PAY_CAL_UPDATED_SUCCESSFULLY;
                                    var text = Markaxis.i18n.PayrollRes.LANG_PAY_CAL_UPDATED_SUCCESSFULLY_DESCRIPT;
                                }

                                swal({
                                    title: title,
                                    text: text,
                                    type: "success"
                                }, function( isConfirm ) {
                                    that.table.ajax.reload( );
                                    $("#modalAddPayCal").modal("hide");
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/payroll/savePayCal", data );
                }
            });
        },


        getPaymentRecur: function( ) {
            if( $("#payPeriod").val( ) != "" && $(".pickadate-paymentDate").val( ) != "" ) {
                var data = {
                    bundle: {
                        payPeriod : $("#payPeriod").val( ),
                        paymentDate: $(".pickadate-paymentDate").val( )
                    },
                    success: function( res ) {
                        var obj = $.parseJSON(res);
                        if (obj.bool == 0) {
                            alert(obj.errMsg);
                            return;
                        }
                        else {
                            $(".paymentDateHelp").text( obj.data );
                            $("#paymentCycle").removeClass("hide");
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/getPaymentRecur", data );
            }
        },


        deletePayCal: function( pcID ) {
            var that = this;
            var title = $("#payCalTable-row" + pcID).find("td").eq(1).text( );

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
                        pcID: pcID
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
                Aurora.WebService.AJAX("admin/payroll/deletePayCal", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".payCalTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'payCalTable-row' + aData['pcID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/getCalResults",
                    type: "POST",
                    data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
                },
                initComplete: function() {
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    width: '250px',
                    data: 'title'
                },{
                    targets: [1],
                    orderable: true,
                    width: '280px',
                    data: 'payPeriod'
                },{
                    targets: [2],
                    orderable: true,
                    width: '220px',
                    data: 'paymentCycle'
                },{
                    targets: [3],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'pcID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalAddPayCal">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.PayrollRes.LANG_EDIT_PAY_CAL + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item deletePayCal" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.PayrollRes.LANG_DELETE_PAY_CAL + '</a>' +
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
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_PAY_CAL,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $(".payCalTable [type=checkbox]").uniform();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            // Alternative pagination
            $('.datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('.datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $('.payCalTable tbody').on('mouseover', 'td', function() {
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
            $(".dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });

            $(".calendars-list-action-btns").insertAfter("#calendars .dataTables_filter");
        }
    }
    return MarkaxisPayCal;
})();
var markaxisPayCal = null;
$(document).ready( function( ) {
    markaxisPayCal = new MarkaxisPayCal( );
});