/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payrollEmployee.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayrollEmployee = (function( ) {

    /**
     * MarkaxisPayrollEmployee Constructor
     * @return void
     */
    MarkaxisPayrollEmployee = function( ) {
        this.table = null;
        this.itemAdded = false;
        this.haveSaved = false;
        this.detailRows = [];
        this.modalCalPayroll = $("#modalCalPayroll");
        this.init( );
    };

    MarkaxisPayrollEmployee.prototype = {
        constructor: MarkaxisPayrollEmployee,

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

            $.fn.stepy.defaults.legend = false;
            $.fn.stepy.defaults.transition = 'fade';
            $.fn.stepy.defaults.duration = 150;
            $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> ' + Aurora.i18n.GlobalRes.LANG_BACK;
            $.fn.stepy.defaults.nextLabel = Aurora.i18n.GlobalRes.LANG_NEXT + ' <i class="icon-arrow-right14 position-right"></i>';

            $(".stepy").stepy({
                titleClick: true,
                validate: false,
                block: true,
                back: function(index) {
                    if( index == 1 ) {
                        $("#officeFilter").insertAfter("#employeeForm-step-0 .dataTables_filter");
                    }
                },
                next: function(index) {
                    if( $("#completed").val( ) == 0 && !that.haveSaved ) {
                        return false;
                    }
                    else {
                        $("#officeFilter").insertAfter("#employeeForm-step-1 .dataTables_filter");
                    }
                    markaxisPayrollProcessed.table.ajax.reload( );
                },
                finish: function( index ) {
                    that.confirmFinalize();
                    return false;
                }
            });

            var stepy = $(".stepy-step");
            stepy.find(".button-next").addClass("btn btn-primary btn-next");
            stepy.find(".button-back").addClass("btn btn-default");

            $("#office").select2( );
            $(".select").select2({minimumResultsForSearch: -1});

            var processDate = $("#processDate").val( );
            var startDate = moment( processDate ).format("MMM Do YYYY");
            var endDate = moment( processDate ).endOf('month').format("MMM Do YYYY");
            $(".daterange").val( startDate + " - " + endDate );
            $(".payroll-range").insertAfter(".dataTables_filter");
            $("#employeeForm-step-0 .stepy-navigator").insertAfter("#employeeForm-step-0 .dataTables_filter");

            $(document).on("change", "#office", function(e) {
                that.table.ajax.url( Aurora.ROOT_URL + "admin/payroll/employee/" + $("#pID").val( ) + "/" + $("#office").val( ) ).load();
            });

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

            that.table.on("click", "tr", function (e) {
                if( e.target.type != "checkbox" ){
                    var cb = $(this).find("input[class=dt-checkboxes]");
                    cb.prop("checked", true).trigger("change");
                }
                e.preventDefault( );
            });

            $(document).on("click", ".addItem", function(e) {
                that.itemAdded = that.addItem( false );
                e.preventDefault( );
            });

            $(document).on("click", ".removeItem", function(e) {
                var href = $(this).attr("href");
                var id = $(this).attr("id");
                $("#itemRowWrapper_" + href).remove();
                $("#" + id).remove();
                e.preventDefault( );
            });

            $(document).on("blur", ".amountInput", function(e) {
                that.amountInput( $(this).val( ) );
                e.preventDefault( );
            });

            $(document).on("click", "#savePayroll", function(e) {
                that.savePayroll( );
                e.preventDefault( );
            });

            $(document).on("click", "#reprocessPayroll", function(e) {
                that.reprocessPayroll( );
                e.preventDefault( );
            });

            $(document).on("click", "#downloadCPF", function(e) {
                that.downloadCPF( );
                e.preventDefault( );
            });

            $(document).on("click", ".addRow", function () {
                var tr = $(this).closest("tr");
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr("id"), that.detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( "details" );
                    row.child.hide();

                    // Remove from the 'open' array
                    that.detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( "details" );
                    row.child( format( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        that.detailRows.push( tr.attr("id") );
                    }
                }
            });

            that.modalCalPayroll.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var dataSaved = $invoker.attr("data-saved");
                var path = dataSaved == 1 ? "viewSaved" : "processPayroll";

                $(document).find("#modalCalPayroll .modal-body").load( Aurora.ROOT_URL + 'admin/payroll/' + path + '/' +
                    $invoker.attr("data-id") + "/" + $("#pID").val( ), function() {

                    $(".itemType").select2( );

                    $('[data-popup="tooltip"]').tooltip();

                    if( dataSaved == 1 ) {
                        var iconWrapper = $("#itemWrapper").find(".itemRow").find(".iconWrapper");
                        var icon = iconWrapper.find(".icon");

                        icon.addClass("hide");

                        $(".processBtn").attr("id", "reprocessPayroll");
                        $(".processBtn").text( Markaxis.i18n.PayrollRes.LANG_REPROCESS_PAYROLL );
                    }
                    else {
                        var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
                        var icon = iconWrapper.find(".icon");

                        icon.removeClass("icon-minus-circle2").addClass("icon-plus-circle2");
                        icon.parent().attr( "class", "addItem" );

                        $(".processBtn").attr("id", "savePayroll");
                        $(".processBtn").text( Markaxis.i18n.PayrollRes.LANG_SAVE_PAYROLL );
                    }
                });
            });

            if( $("#completed").val( ) == 1 ) {
                $("#employeeForm-step-0 .stepy-navigator a")
                    .html( Markaxis.i18n.PayrollRes.LANG_ACCOUNT_AND_PAYSLIP + ' <i class="icon-arrow-right14 position-right"></i>');

                $('<button type="button" class="btn btn-primary" data-style="slide-right" ' +
                    'id="release">' + Markaxis.i18n.PayrollRes.LANG_RELEASE_PAYSLIPS + ' <i class="icon-check position-right"></i>').insertAfter(".stepy-finish");

                $('<button type="button" class="btn btn-primary" data-style="slide-right" ' +
                    'id="releaseAll">' + Markaxis.i18n.PayrollRes.LANG_RELEASE_ALL_PAYSLIPS + ' <i class="icon-check position-right"></i><i class="icon-check"></i></button>').insertAfter("#release");

                if( $("#officeFilter").attr("data-countrycode") == "SG" ) {
                    $('<button type="button" class="btn btn-primary" data-style="slide-right" ' +
                        'id="downloadCPF">' + Markaxis.i18n.PayrollRes.LANG_DOWNLOAD_CPF_FTP_FILE + ' <i class="icon-download position-right"></i>').insertAfter("#releaseAll");
                }

                $(".stepy-finish").remove( )
            }
            else {
                $("#employeeForm-step-0 .stepy-navigator a")
                    .attr("disabled", true)
                    .html(Markaxis.i18n.PayrollRes.LANG_COMPLETE_PROCESS + ' <i class="icon-arrow-right14 position-right"></i>');

                $(".stepy-finish")
                    .removeClass("bg-purple-400")
                    .addClass("bg-warning-400")
                    .attr("id", "confirm")
                    .html(Markaxis.i18n.PayrollRes.LANG_CONFIRM_FINALIZE + ' <i class="icon-check position-right"></i>');

                $(".stepy-finish").append( )
            }
        },


        amountInput: function( amount ) {
            var that = this;

            if( !that.itemAdded ) {
                return;
            }
            var data = {
                bundle: {
                    itemType: $("#itemType_" + that.itemAdded).val( ),
                    amountInput: amount,
                    data: Aurora.WebService.serializePost("#processForm")
                },
                success: function( res ) {
                    if( res ) {
                        var obj = $.parseJSON( res );

                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( obj.data.addItem && obj.data.addItem.length > 0 ) {
                                var deduction = false;

                                for( var i=0; i<obj.data.addItem.length; i++ ) {
                                    if( obj.data.addItem[i]['deduction'] === 1 ) {
                                        deduction = true;
                                    }

                                    var id = that.addItem( deduction );
                                    that.itemAdded--;

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
                            $("body").tooltip({
                                selector: '.icon-info22'
                            });
                        }
                    }
                }
            }
            Aurora.WebService.AJAX( "admin/payroll/reprocessPayroll/" + $("#userID").val( ) + "/" + $("#pID").val( ), data );
        },


        downloadCPF: function( ) {
            Aurora.WebService.download( "admin/payroll/downloadCPF/" + $("#pID").val( ) );
        },


        addItem: function( deduction ) {
            var that = this;
            var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
            var icon = iconWrapper.find(".icon");

            icon.removeClass("icon-plus-circle2").addClass("icon-minus-circle2");
            icon.parent().attr( "class", "removeItem" );

            var length = $(".itemRow").length;
            var item = $("#itemTemplate").html( );
            item = item.replace(/\{id\}/g, length );
            item = item.replace(/\{currency\}/g, $("#officeFilter").attr("data-currency") );

            if( deduction ) {
                item = item.replace(/\{deduction\}/g, "deduction1" );
            }
            else {
                item = item.replace(/\{deduction\}/g, "" );
            }

            $("#itemWrapper").append( item );

            $("#itemRowWrapper_" + length).find(".select2").remove( );
            $("#itemType_" + length).select2( );
            $("#itemType_" + length).val("").trigger("change");

            var itemWrapper = $("#itemWrapper");
            itemWrapper.animate({ scrollTop: itemWrapper.prop("scrollHeight") - itemWrapper.height() }, 300).promise().done(function () {
                $("#itemType_" + length).on("select2:select", function(e) {
                    var data = e.params.data;
                    var type = $(this).find('option[value="'+ data.element.value +'"]').attr("class");

                    if( type == "additional" ) {
                        var id =  $(this).attr("id");
                        id = id.replace("itemType_", "");

                        that.getAdditional( id );
                    }
                });
            });;
            return length;
        },


        getAdditional: function( id ) {
            var data = {
                bundle: {
                    data: Aurora.WebService.serializePost("#processForm")
                },
                success: function( res ) {
                    if( res ) {
                        var obj = $.parseJSON( res );

                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( obj.data.inputAmount ) {
                                $("#amount_" + id).val( obj.data.inputAmount );
                            }

                            if( obj.data.inputRemark ) {
                                $("#remark_" + id).val( obj.data.inputRemark );
                            }
                            $("#processSummary").html( obj.summary );
                            $("body").tooltip({
                                selector: '.icon-info22'
                            });
                        }
                    }
                }
            }
            Aurora.WebService.AJAX( "admin/payroll/reprocessPayroll/" + $("#userID").val( ) + "/" + $("#pID").val( ), data );
        },


        savePayroll: function( ) {
            var that = this;

            var data = {
                bundle: {
                    data: Aurora.WebService.serializePost("#processForm")
                },
                success: function( res ) {
                    if( res ) {
                        var obj = $.parseJSON( res );

                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            swal({
                                title: Markaxis.i18n.PayrollRes.LANG_PAYROLL_SAVED,
                                text: Markaxis.i18n.PayrollRes.LANG_PAYROLL_SAVED_DESCRIPT,
                                type: 'success'
                            }, function( isConfirm ) {
                                $("#process" + obj.data.empInfo.userID).text( Markaxis.i18n.PayrollRes.LANG_SAVED );
                                $("#process" + obj.data.empInfo.userID).attr("data-saved", 1);
                                $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", false);
                                $("#modalCalPayroll").modal('hide');

                                that.haveSaved = true;
                            });
                        }
                    }
                }
            }
            Aurora.WebService.AJAX( "admin/payroll/savePayroll/" + $("#userID").val( ) + "/" + $("#pID").val( ), data );
        },


        reprocessPayroll: function( ) {
            var that = this;

            swal({
                title: Markaxis.i18n.PayrollRes.LANG_REPROCESS_CONFIRMATION.replace('{username}', $("#userName").val( )),
                text: Markaxis.i18n.PayrollRes.LANG_REPROCESS_CONFIRMATION_DESCRIPT,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Markaxis.i18n.PayrollRes.LANG_CONFIRM_REPROCESS,
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
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(document).find("#modalCalPayroll .modal-body").load( Aurora.ROOT_URL + 'admin/payroll/processPayroll/' +
                                $("#userID").val( ) + "/" + $("#pID").val( ), function() {
                                $(".itemType").select2( );

                                var pu = $("#process" + $("#userID").val( ) );
                                pu.attr("data-saved", 0);
                                pu.text("Process");

                                var processBtn = $(".processBtn");
                                processBtn.attr("id", "savePayroll");
                                processBtn.text( Markaxis.i18n.PayrollRes.LANG_SAVE_PAYROLL );

                                if( obj.data.userProcessCount == 0 ) {
                                    that.haveSaved = false;
                                    $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", true);
                                }

                                var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
                                var icon = iconWrapper.find(".icon")

                                icon.removeClass("icon-minus-circle2").addClass("icon-plus-circle2");
                                icon.parent().attr( "class", "addItem" );

                                swal.close()
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/deletePayroll/" + $("#userID").val( ) + "/" + $("#pID").val( ), data);
            });
        },


        confirmFinalize: function( ) {
            swal({
                title: Markaxis.i18n.PayrollRes.LANG_FINALIZE_CONFIRM,
                text: Markaxis.i18n.PayrollRes.LANG_FINALIZE_CONFIRM_DESCRIPT,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Aurora.i18n.GlobalRes.LANG_CONFIRM,
                closeOnConfirm: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        processDate: $("#processDate").val( )
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
        },


        dateDiff: function( date ) {
            var dateSplit = date.split('-');
            var firstDate = new Date( );
            var secondDate = new Date( dateSplit[0], (dateSplit[1]-1), dateSplit[2] );
            return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".employeeTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/payroll/employee/" + $("#pID").val( ) + "/" + $("#office").val( ),
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    }
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
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
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
                            return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_SUSPENDED + '</span>';
                        }
                        else {
                            if( full['endDate'] ) {
                                if( that.dateDiff( full['endDate'] ) <= 30 ) {
                                    reason = ' title="" data-placement="bottom" data-original-title="Expire on ' + full['endDate'] + '"'
                                    return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_EXPIRED_SOON + '</span>';
                                }
                            }
                            return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>' + Markaxis.i18n.PayrollRes.LANG_ACTIVE + '</span>';
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
                            that.haveSaved = true;
                            $("#employeeForm-step-0 .stepy-navigator a").attr("disabled", false);

                            return '<a id="process' + full['userID'] + '" data-id="' + full['userID'] + '" data-saved="1" ' +
                                'data-toggle="modal" data-target="#modalCalPayroll">' + Markaxis.i18n.PayrollRes.LANG_SAVED + '</a>';
                        }
                        else {
                            return '<a id="process' + full['userID'] + '" data-id="' + full['userID'] + '" data-saved="0" ' +
                                'data-toggle="modal" data-target="#modalCalPayroll">' + Markaxis.i18n.PayrollRes.LANG_PROCESS + '</a>';
                        }
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });
        }
    }
    return MarkaxisPayrollEmployee;
})();
var markaxisPayrollEmployee = null;
$(document).ready( function( ) {
    markaxisPayrollEmployee = new MarkaxisPayrollEmployee( );
});