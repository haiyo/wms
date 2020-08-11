/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payslip.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayslip = (function( ) {

    /**
     * MarkaxisPayslip Constructor
     * @return void
     */
    MarkaxisPayslip = function( ) {
        this.table = null;
        this.init( );
    };

    MarkaxisPayslip.prototype = {
        constructor: MarkaxisPayslip,

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
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".payslipTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', 'claimTable-row' + aData['ecID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/getPayslipResults",
                    type: "POST",
                    data: function(d) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function() {
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    searchable: false,
                    width: "180px",
                    data: "period"
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "180px",
                    data: "paymentMethod"
                },{
                    targets: [2],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "bankName"
                },{
                    targets: [3],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "acctNumber"
                },{
                    targets: [4],
                    orderable: true,
                    searchable: false,
                    width: "110px",
                    data: "userID",
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data ) {
                            return '<a href="' + Aurora.ROOT_URL + 'admin/payroll/processPayroll/' + data + '/' +
                                full['startDate'] + '/slip" target="_blank">View PDF</a>';
                        }
                        else {
                            return '';
                        }
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Claim',
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
        }
    }
    return MarkaxisPayslip;
})();
var markaxisPayslip = null;
$(document).ready( function( ) {
    markaxisPayslip = new MarkaxisPayslip( );
});