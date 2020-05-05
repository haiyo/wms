$(document).ready(function( ) {
    var haveSaved = false;
    var processDate = $("#processDate").val( );
    var startDate = moment( processDate ).format("MMM Do YYYY");
    var endDate = moment( processDate ).endOf('month').format("MMM Do YYYY");
    $(".daterange").val( startDate + " - " + endDate );

    var ids = [];

    $(document).on("change", "input[class='dt-checkboxes']", function(e) {
        var found = $.inArray( $(this).val( ), ids );

        if( e.target.checked ) {
            if( found < 0 ) {
                ids.push( $(this).val( ) );
            }
            else {
                ids.splice( found, 1);
            }
        }
    });

    $(".employeeTable").on("click", "tr", function (e) {
        if( e.target.type != "checkbox" ){
            var cb = $(this).find("input[class=dt-checkboxes]");
            cb.prop("checked", true).trigger("change");
        }
    });

    // Override defaults
    $.fn.stepy.defaults.legend = false;
    $.fn.stepy.defaults.transition = 'fade';
    $.fn.stepy.defaults.duration = 150;
    $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> Back';
    $.fn.stepy.defaults.nextLabel = 'Next <i class="icon-arrow-right14 position-right"></i>';

    $(".stepy").stepy({
        titleClick: true,
        validate: false,
        block: true,
        next: function(index) {
            if( $("#completed").val( ) == 0 ) {
                if( !haveSaved ) {
                    return false;
                }
            }
            pt.ajax.reload();
        },
        finish: function( index ) {
            confirmFinalize();
            return false;
        }
    });

    var stepy = $(".stepy-step");
    stepy.find(".button-next").addClass("btn btn-primary btn-next");
    stepy.find(".button-back").addClass("btn btn-default");

    if( $("#completed").val( ) == 1 ) {
        $(".stepy-finish").remove( );

        $("#employeeForm-step-0 .stepy-navigator a")
            .html('View Account Details <i class="icon-arrow-right14 position-right"></i>');
    }
    else {
        $("#employeeForm-step-0 .stepy-navigator a")
            .attr("disabled", true)
            .html('Complete Process <i class="icon-arrow-right14 position-right"></i>');

        $(".stepy-finish")
            .removeClass("bg-purple-400")
            .addClass("bg-warning-400")
            .attr("id", "confirm")
            .html('Confirm &amp; Finalize <i class="icon-check position-right"></i>');
    }

    $("#employeeForm-step-2 .stepy-navigator button span")
        .html('Download CPF File <i class="icon-check position-right"></i>');

    var dt = $(".employeeTable").DataTable({
        "processing": true,
        "serverSide": true,
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'row' + aData['userID']);
        },
        ajax: {
            url: Aurora.ROOT_URL + "admin/payroll/employee",
            type: "POST",
            data: function ( d ) {
                d.ajaxCall = 1;
                d.csrfToken = Aurora.CSRF_TOKEN;
                d.processDate = $("#processDate").val( );
            },
        },
        initComplete: function() {
            /*var api = this.api();
            var that = this;
            $('input').on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });*/
        },
        autoWidth: false,
        mark: true,
        columnDefs: [{
            targets: [0],
            orderable: true,
            width: '150px',
            data: 'idnumber'
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
            width: '180px',
            data: 'designation'
        },{
            targets: [3],
            orderable: true,
            width: '220px',
            data: 'type'
        },{
            targets: [4],
            searchable : false,
            data: 'status',
            width: '130px',
            className : "text-center",
            render: function(data, type, full, meta) {
                var reason = full['suspendReason'] ? ' title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";

                if( full['suspended'] == 1 ) {
                    return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>Suspended</span>';
                }
                else {
                    if( full['endDate'] ) {
                        if( dateDiff( full['endDate'] ) <= 30 ) {
                            reason = ' title="" data-placement="bottom" data-original-title="Expire on ' + full['endDate'] + '"'
                            return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>Expired Soon</span>';
                        }
                    }
                    return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>Active</span>';
                }
            }
        },{
            targets: [5],
            orderable: false,
            searchable : false,
            width: '100px',
            className : "text-center",
            data: 'userID',
            render: function(data, type, full, meta) {
                if( full["puCount"] > 0 ) {
                    haveSaved = true;
                    $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", false);

                    return '<a id="process' + full['userID'] + '" data-id="' + full['userID'] + '" data-saved="1" ' +
                            'data-toggle="modal" data-target="#modalCalPayroll">Saved</a>';
                }
                else {
                    return '<a id="process' + full['userID'] + '" data-id="' + full['userID'] + '" data-saved="0" ' +
                            'data-toggle="modal" data-target="#modalCalPayroll">Process</a>';
                }
            }
        }],
        order: [],
        dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
        language: {
            search: '',
            searchPlaceholder: 'Search Employee, Designation or Contract Type',
            lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    var pt = $(".processedTable").DataTable({
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
            /*var api = this.api();
            var that = this;
            $('input').on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });*/
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
        },{
            targets: [6],
            orderable: true,
            width: '100px',
            className : "text-center",
            data: 'userID',
            render: function( data ) {
                return '<a href="' + Aurora.ROOT_URL + 'admin/payroll/processPayroll/' + data + '/' +
                        $("#processDate").val( ) + '/slip" target="_blank">View PDF</a>';
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


    var ft = $(".finalizedTable").DataTable({
        "processing": true,
        "serverSide": true,
        "fnCreatedRow": function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'row' + aData['userID']);
        },
        ajax: {
            url: Aurora.ROOT_URL + "admin/payroll/getAllFinalized/" + $("#processDate").val( ),
            type: "POST",
            data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
        },
        initComplete: function() {
            /*var api = this.api();
            var that = this;
            $('input').on('keyup change', function() {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });*/
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
            data: 'method'
        },{
            targets: [2],
            orderable: true,
            width: '220px',
            data: 'bankName'
        },{
            targets: [3],
            orderable: true,
            width: '220px',
            data: 'number'
        },{
            targets: [4],
            orderable: true,
            width: '220px',
            data: 'net',
            render: function( data ) {
                if( typeof data !== 'string' ) {
                    data = "0";
                }
                return Aurora.String.formatMoney( data );
            }
        },{
            targets: [5],
            orderable: true,
            width: '100px',
            className : "text-center",
            data: 'userID',
            render: function( data ) {
                return '<a href="' + Aurora.ROOT_URL + 'admin/payroll/processPayroll/' + data + '/' +
                    $("#processDate").val( ) + '/slip" target="_blank">View PDF</a>';
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
        /*footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ? i : 0;
            };

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
        }*/
    });

    $("#modalCalPayroll").on("show.bs.modal", function(e) {
        var $invoker = $(e.relatedTarget);

        $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/payroll/processPayroll/' +
            $invoker.attr("data-id") + "/" + $("#processDate").val( ), function() {
            $(".itemType").select2( );

            var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
            var icon = iconWrapper.find(".icon")

            icon.removeClass("icon-minus-circle2").addClass("icon-plus-circle2");
            icon.parent().attr( "class", "addItem" );

            if( $invoker.attr("data-saved") == 1 ) {
                $(".processBtn").attr("id", "reprocessPayroll");
                $(".processBtn").text("Reprocess Payroll");
            }
            else {
                $(".processBtn").attr("id", "savePayroll");
                $(".processBtn").text("Save Payroll");
            }
        });
    });

    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $(document).on("click", ".addRow", function () {
        var userID = $(this).attr("data-id");
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    });

    // Alternative pagination
    $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
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

    // Highlighting rows and columns on mouseover
    var lastIdx = null;
    var table = $('.datatable').DataTable();

    $('.datatable tbody').on('mouseover', 'td', function() {
        if( typeof table.cell(this).index() == "undefined" ) return;
        var colIdx = table.cell(this).index().column;

        if( colIdx !== lastIdx ) {
            $(table.cells( ).nodes( )).removeClass('active');
            $(table.column(colIdx).nodes( )).addClass('active');
        }
    }).on('mouseleave', function() {
        $(table.cells( ).nodes( )).removeClass("active");
    });

    // Enable Select2 select for the length option
    $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto"
    });

    var processedTable = $(".processedTable").DataTable( );

    $('.processedTable tbody').on('mouseover', 'td', function() {
        if( typeof processedTable.cell(this).index() == "undefined" ) return;
        var colIdx = processedTable.cell(this).index().column;

        if( colIdx !== lastIdx ) {
            $(processedTable.cells( ).nodes( )).removeClass('active');
            $(processedTable.column(colIdx).nodes( )).addClass('active');
        }
    }).on('mouseleave', function() {
        $(processedTable.cells( ).nodes( )).removeClass("active");
    });

    // Enable Select2 select for the length option
    $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto"
    });

    function dateDiff( date ) {
        var date = date.split('-');
        var firstDate = new Date( );
        var secondDate = new Date( date[0], (date[1]-1), date[2] );
        return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
    }

    $(".payroll-range").insertAfter(".dataTables_filter");
    $(".officeFilter").insertAfter(".dataTables_filter");
    $("#employeeForm-step-0 .stepy-navigator").insertAfter("#employeeForm-step-0 .dataTables_filter");
    $("#employeeForm-step-1 .stepy-navigator").insertAfter("#employeeForm-step-1 .dataTables_filter");
    $("#employeeForm-step-2 .stepy-navigator").insertAfter("#employeeForm-step-2 .dataTables_filter");

    $("#office").select2( );
    $(".select").select2({minimumResultsForSearch: -1});

    var itemAdded = false;

    $(document).on("click", ".addItem", function ( ) {
        itemAdded = addItem( false );
        return false;
    });

    $(document).on("click", ".removeItem", function ( ) {
        var href = $(this).attr("href");
        var id = $(this).attr("id");
        $("#itemRowWrapper_" + href).remove();
        $("#" + id).remove();
        return false;
    });

    $(document).on("blur", ".amountInput", function(e) {
        if( !itemAdded ) {
            return;
        }
        var data = {
            bundle: {
                itemType: $("#itemType_" + itemAdded).val( ),
                amountInput: $(this).val( ),
                data: Aurora.WebService.serializePost("#processForm")
            },
            success: function( res ) {
                if( res ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool === 0 ) {
                        swal( "error", obj.errMsg );
                        return;
                    }
                    else {
                        if( obj.data.addItem && obj.data.addItem.length > 0 ) {
                            var deduction = false;

                            for( var i=0; i<obj.data.addItem.length; i++ ) {
                                if( obj.data.addItem[i]['deduction'] === 1 ) {
                                    deduction = true;
                                }

                                var id = addItem( deduction );
                                itemAdded--;

                                $("#itemType_" + id).val( "p-" + obj.data.addItem[i]['piID'] ).trigger("change");
                                $("#amount_" + id).val( Aurora.String.formatMoney( obj.data.addItem[i]['amount'] + "" ) );
                                $("#remark_" + id).val( obj.data.addItem[i]['remark'] );
                            }
                            if( deduction ) {
                                $(".deduction").remove( );
                                $(".deduction1").removeClass("deduction1").addClass("deduction");
                            }
                        }
                        $("#processSummary").html( obj.summary );
                    }
                }
            }
        }
        Aurora.WebService.AJAX( "admin/payroll/reprocessPayroll/" + $("#userID").val( ), data );
    });

    $(document).on("click", "#savePayroll", function ( ) {
        var data = {
            bundle: {
                data: Aurora.WebService.serializePost("#processForm")
            },
            success: function( res ) {
                if( res ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool === 0 ) {
                        swal( "error", obj.errMsg );
                        return;
                    }
                    else {
                        swal({
                            title: "Payroll Saved",
                            text: "Note: This payroll is not finalised until confirmed and payment is made. You may still reprocess the payroll at anytime.",
                            type: 'success'
                        }, function( isConfirm ) {
                            $("#process" + obj.data.empInfo.userID).text("Saved");
                            $("#process" + obj.data.empInfo.userID).attr("data-saved", 1);
                            haveSaved = true;
                            $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", false);
                            $("#modalCalPayroll").modal('hide');
                        });
                    }
                }
            }
        }
        Aurora.WebService.AJAX( "admin/payroll/savePayroll/" + $("#userID").val( ) + "/" + $("#processDate").val( ), data );
    });

    $(document).on("click", "#reprocessPayroll", function ( ) {
        swal({
            title: "Are you sure you want to reprocess " + $("#userName").val( ) + "'s payroll?",
            text: "This action is irreversible and all item types will be reset!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirm Reprocess",
            closeOnConfirm: false
        }, function( isConfirm ) {
            if( !isConfirm ) return;

            var data = {
                bundle: {
                    data: Aurora.WebService.serializePost("#processForm")
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if( obj.bool === 0 ) {
                        alert(obj.errMsg);
                        return;
                    }
                    else {
                        $(document).find(".modal-body").load( Aurora.ROOT_URL + 'admin/payroll/processPayroll/' +
                            $("#userID").val( ) + "/" + $("#processDate").val( ), function() {
                            $(".itemType").select2( );

                            var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
                            var icon = iconWrapper.find(".icon")

                            icon.removeClass("icon-minus-circle2").addClass("icon-plus-circle2");
                            icon.parent().attr( "class", "addItem" );

                            var pu = $("#process" + $("#userID").val( ) );
                            pu.attr("data-saved", 0);
                            pu.text("Process");

                            var processBtn = $(".processBtn");
                            processBtn.attr("id", "savePayroll");
                            processBtn.text("Save Payroll");

                            if( obj.data.userProcessCount == 0 ) {
                                haveSaved = false;
                                $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", true);
                            }
                            swal.close()
                        });
                    }
                }
            };
            Aurora.WebService.AJAX("admin/payroll/deletePayroll/" + $("#userID").val( ), data);
        });
        return false;
    });

    function confirmFinalize( ) {
        swal({
            title: "Are you sure everything is finalized?",
            text: "Once confirmed, there will be no more changes to be made.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirm",
            closeOnConfirm: true,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm === false) return;

            var data = {
                bundle: {
                    processDate:  $("#processDate").val( )
                },
                success: function (res) {
                    var obj = $.parseJSON(res);

                    if( obj.bool === 0 ) {
                        alert(obj.errMsg);
                        return;
                    }
                    window.location.reload(true);
                }
            };
            Aurora.WebService.AJAX("admin/payroll/setCompleted", data);
        });
    }

    function addItem( deduction ) {
        var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
        var icon = iconWrapper.find(".icon")

        icon.removeClass("icon-plus-circle2").addClass("icon-minus-circle2");
        icon.parent().attr( "class", "removeItem" );

        var length = $(".itemRow").length;
        var item = $("#itemTemplate").html( );
        item = item.replace(/\{id\}/g, length );

        if( deduction ) {
            item = item.replace(/\{deduction\}/g, "deduction1" );
        }
        else {
            item = item.replace(/\{deduction\}/g, "" );
        }

        $("#itemWrapper").append( item );

        $("#itemRowWrapper_" + length).find(".select2").remove( );
        $("#itemType_" + length).select2( );

        var itemWrapper = $("#itemWrapper");
        itemWrapper.animate({ scrollTop: itemWrapper.prop("scrollHeight") - itemWrapper.height() }, 300);
        return length;
    }
});