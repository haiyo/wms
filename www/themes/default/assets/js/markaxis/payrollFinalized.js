/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payrollFinalized.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayrollFinalized = (function( ) {

    /**
     * MarkaxisPayrollFinalized Constructor
     * @return void
     */
    MarkaxisPayrollFinalized = function( ) {
        this.table = null;
        this.init( );
    };

    MarkaxisPayrollFinalized.prototype = {
        constructor: MarkaxisPayrollFinalized,

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

            $("#employeeForm-step-1 .stepy-navigator").insertAfter("#employeeForm-step-1 .dataTables_filter");

            $(document).on("click", "#release", function(e) {
                that.release( );
                e.preventDefault( );
            });

            $(document).on("click", "#releaseAll", function(e) {
                that.releaseAll( );
                e.preventDefault( );
            });
        },


        updateResults: function( ) {
            this.table.ajax.url( Aurora.ROOT_URL + "admin/payroll/getAllFinalized/" + $("#processDate").val( ) + "/" + $("#office").val( ) ).load();
        },



        release: function( ) {
            var that = this;
            var userIDs = [];

            $("input[name='userID[]']:checked").each(function(i) {
                userIDs.push( $(this).val( ) );
            });

            if( userIDs.length == 0 ) {
                swal({
                    title: Markaxis.i18n.PayrollRes.LANG_NO_EMPLOYEE_SELECTED,
                    type: "info"
                });
            }
            else {
                swal({
                    title: Markaxis.i18n.PayrollRes.LANG_CONFIRM_RELEASE_PAYSLIP.replace('{count}', userIDs.length),
                    text: Markaxis.i18n.PayrollRes.LANG_SELECTED_EMPLOYEE_EMAIL,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: Markaxis.i18n.PayrollRes.LANG_CONFIRM_RELEASE,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function( isConfirm ) {
                    if( isConfirm === false ) return;

                    var data = {
                        bundle: {
                            userIDs: userIDs,
                            pID: $("#pID").val( )
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload( );
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.PayrollRes.LANG_PAYSLIP_SUCCESSFULLY_RELEASED.replace('{count}', obj.count), "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/payroll/release", data);
                });
            }
        },


        releaseAll: function( ) {
            var that = this;

            swal({
                title: Markaxis.i18n.PayrollRes.LANG_CONFIRM_RELEASE_ALL_PAYSLIP,
                text: Markaxis.i18n.PayrollRes.LANG_ALL_EMPLOYEE_EMAIL,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Markaxis.i18n.PayrollRes.LANG_CONFIRM_RELEASE_ALL,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if( isConfirm === false ) return;

                var data = {
                    bundle: {
                        pID: $("#pID").val( )
                    },
                    success: function(res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload( );
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.PayrollRes.LANG_ALL_PAYSLIP_SUCCESSFULLY_RELEASED, "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/releaseAll", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".finalizedTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/getAllFinalized/" + $("#processDate").val( ) + "/" + $("#office").val( ),
                    type: "POST",
                    data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
                },
                initComplete: function() {
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
                    data: 'userID',
                    render: function (data, type, full, meta) {
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="userID[]" value="' + data + '">';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '200px',
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" width="32" height="32" style="margin-right:10px" />' + data;
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '220px',
                    data: 'method'
                },{
                    targets: [3],
                    orderable: true,
                    width: '220px',
                    data: 'bankName'
                },{
                    targets: [4],
                    orderable: true,
                    width: '220px',
                    data: 'number'
                },{
                    targets: [5],
                    orderable: true,
                    width: '220px',
                    data: 'net',
                    render: function( data, type, full, meta ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data, full["currency"] );
                    }
                },{
                    targets: [6],
                    orderable: true,
                    width: '50px',
                    className : "text-center",
                    data: 'userID',
                    render: function( data ) {
                        return '<a href="' + Aurora.ROOT_URL + 'admin/payroll/processPayroll/' + data + '/' +
                            $("#processDate").val( ) + '/slip" target="_blank">' + Markaxis.i18n.PayrollRes.LANG_VIEW_PDF + '</a>';
                    }
                },{
                    targets: [7],
                    orderable: true,
                    width: '100px',
                    className : "text-center",
                    data: 'released',
                    render: function( data ) {
                        return data == 1 ? Aurora.i18n.GlobalRes.LANG_YES : Aurora.i18n.GlobalRes.LANG_NO;
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
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE_NAME,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(".finalizedTable [type=checkbox]").uniform();
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });
        }
    }
    return MarkaxisPayrollFinalized;
})();
var markaxisPayrollFinalized = null;
$(document).ready( function( ) {
    markaxisPayrollFinalized = new MarkaxisPayrollFinalized( );
});