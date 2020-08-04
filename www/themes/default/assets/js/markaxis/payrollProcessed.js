/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payrollProcessed.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayrollProcessed = (function( ) {

    /**
     * MarkaxisPayrollProcessed Constructor
     * @return void
     */
    MarkaxisPayrollProcessed = function( ) {
        this.table = null;
        this.init( );
    };

    MarkaxisPayrollProcessed.prototype = {
        constructor: MarkaxisPayrollProcessed,

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
            var processDate = $("#processDate").val( );
            var startDate = moment( processDate ).format("MMM Do YYYY");
            var endDate = moment( processDate ).endOf('month').format("MMM Do YYYY");
            $(".daterange").val( startDate + " - " + endDate );
            $(".payroll-range").insertAfter(".dataTables_filter");
            $(".officeFilter").insertAfter(".dataTables_filter");
            $("#employeeForm-step-0 .stepy-navigator").insertAfter("#employeeForm-step-0 .dataTables_filter");
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".processedTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/getAllProcessed/" + $("#processDate").val( ),
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
                    width: '200px',
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" width="32" height="32" style="margin-right:10px" />' + data;
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '220px',
                    data: 'gross',
                    render: function( data ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data );
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '220px',
                    data: 'claim',
                    render: function( data ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data );
                    }
                },{
                    targets: [3],
                    orderable: true,
                    width: '220px',
                    data: 'levies',
                    render: function( data ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data );
                    }
                },{
                    targets: [4],
                    orderable: true,
                    width: '220px',
                    data: 'contributions',
                    render: function( data ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data );
                    }
                },{
                    targets: [5],
                    orderable: true,
                    width: '220px',
                    data: 'net',
                    render: function( data ) {
                        if( typeof data !== 'string' ) {
                            data = "0";
                        }
                        return Aurora.String.formatMoney( data );
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Employee Name',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                },
                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ? i : 0;
                    };

                    // Total over all pages
                    /*total = api.column( 4 ).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );*/

                    // Total over this page
                    var grossTotal = api.column(1, {page:"current"} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var netTotal = api.column(2, {page:"current"} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var claimTotal = api.column(3, {page:"current"} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var levyTotal = api.column(4, {page:"current"} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var contriTotal = api.column(5, {page:"current"} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
                    $(api.column(1).footer( )).html( Aurora.String.formatMoney( grossTotal.toString( ) ) );
                    $(api.column(2).footer( )).html( Aurora.String.formatMoney( netTotal.toString( ) ) );
                    $(api.column(3).footer( )).html( Aurora.String.formatMoney( claimTotal.toString( ) ) );
                    $(api.column(4).footer( )).html( Aurora.String.formatMoney( levyTotal.toString( ) ) );
                    $(api.column(5).footer( )).html( Aurora.String.formatMoney( contriTotal.toString( ) ) );
                }
            });

            $('.processedTable tbody').on('mouseover', 'td', function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if( colIdx !== null ) {
                    $(that.table.cells( ).nodes( )).removeClass('active');
                    $(that.table.column(colIdx).nodes( )).addClass('active');
                }
            }).on('mouseleave', function() {
                $(that.table.cells( ).nodes( )).removeClass("active");
            });
        }
    }
    return MarkaxisPayrollProcessed;
})();
var markaxisPayrollProcessed = null;
$(document).ready( function( ) {
    markaxisPayrollProcessed = new MarkaxisPayrollProcessed( );
});