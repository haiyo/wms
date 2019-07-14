
<script>
    $(document).ready(function( ) {
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        $(".daterange").daterangepicker({
            //timePicker: true,
            startDate: start,
            endDate: end,
            opens: 'left',
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-light',
            locale: {
                format: 'MMM DD, YYYY'
            }
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
            validate: true,
            block: true,
            next: function(index) {
                $(".stepy").validate( validate );

                if( index == 2 ) {
                    if( ids.length > 0 ) {
                        var data = {
                            bundle: {
                                ids: ids
                            },
                            success: function( res ) {
                                var obj = $.parseJSON( res );
                                if( obj.bool == 0 ) {
                                    swal("Error!", obj.errMsg, "error");
                                    return;
                                }
                                else {
                                    $(".tab-content").html( obj.html );
                                    return true;
                                }
                            }
                        };
                        Aurora.WebService.AJAX( "admin/payroll/getAllByID", data );
                    }
                }
            },
            finish: function( index ) {
                if( $(".stepy").valid() )  {
                    //saveEmployeeForm();
                    return false;
                }
            }
        });

        var validate = {
            highlight: function(element, errorClass) {
                //
            },
            errorPlacement: function(error, element) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Please select one more more employees to continue.'
                });
            },
            rules: {
                "id[]" : {
                    required : true
                }
            }
        }

        var dt = $(".employeeTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/results",
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
                width: '150px',
                data: 'idnumber'
            },{
                targets: [1],
                orderable: true,
                width: '200px',
                data: 'name'
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
                    var name   = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<a data-id="' +  + full['userID'] + '" data-toggle="modal" data-target="#modalCalPayroll">Process</a>';

                    return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                    '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                        '<i class="icon-menu9"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view\' + data + \'">' +
                                            '<i class="icon-user"></i> Calculate Payroll</a>' +
                                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/edit/' + data + '">' +
                                            '<i class="icon-pencil5"></i> Unprocess Payroll</a>' +
                                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '">' +
                                            '<i class="icon-mail5"></i> Message Employee</a>' +
                                        '<a class="dropdown-item" data-title="View ' + name + ' History Log" href="<?TPLVAR_ROOT_URL?>admin/employee/log/' + data + '">' +
                                            '<i class="icon-history"></i> View History Log</a>' +
                                        '<div class="divider"></div>' +
                                        '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setSuspend(' + data + ', \'' + name + '\')">' +
                                        '<i class="icon-user-block"></i> ' + statusText + '</a>' +
                                        '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')">' +
                                        '<i class="icon-exit3"></i> Employee Resigned</a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
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

        $("#modalCalPayroll").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/payroll/processPayroll/' +
                                              $invoker.attr("data-id") + "/" + $("#processDate").val( ), function() {
                $(".itemType").select2( );

                var iconWrapper = $("#itemWrapper").find(".itemRow:last-child").find(".iconWrapper");
                var icon = iconWrapper.find(".icon")

                icon.removeClass("icon-minus-circle2").addClass("icon-plus-circle2");
                icon.parent().attr( "class", "addItem" );
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

        function dateDiff( date ) {
            var date = date.split('-');
            var firstDate = new Date( );
            var secondDate = new Date( date[0], (date[1]-1), date[2] );
            return Math.round( ( secondDate-firstDate ) / (1000*60*60*24 ) );
        }

        $(".payroll-range").insertAfter(".dataTables_filter");
        $(".officeFilter").insertAfter(".dataTables_filter");
        $("#office").select2( );
        $(".select").select2({minimumResultsForSearch: -1});

        var itemAdded = 0;

        $(document).on("click", ".addItem", function ( ) {
            itemAdded = addItem( false );
            return false;
        });

        $(document).on("click", ".removeItem", function ( ) {
            var id = $(this).attr("href");
            $("#childRowWrapper_" + id).addClass("childRow").html("").hide();

            if( $("#childWrapper .childRow").length == 0 ) {
                $("#children2").click( );
                $.uniform.update( );
            }
            return false;
        });

        $(document).on("blur", ".amountInput", function(e) {
            if( itemAdded ) {
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
            }
        });

        $("#savePayroll").click(function () {
            if( itemAdded ) {
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
                                //
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/payroll/savePayroll/", data );
            }
        });

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
</script>
<style>
    .payroll-employee .stepy-step{padding:0;}
    .payroll-employee>.stepy-header{padding:15px;margin-bottom:0px;}
    .payroll-employee .payroll-range{width:65%;float:right;}
    .payroll-employee .payroll-range input{font-size:17px;}
    .payroll-employee .payroll-range .input-group-text{font-size:16px;padding:5px 14px;}
    .payroll-employee .payroll-range .input-group-text i{margin-right:10px;}
    .payroll-range{float:right;width:355px;}

    .employee-nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-top:20px;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-tabs {
        border-bottom:1px solid #ddd;
    }
    .nav-tabs .nav-item {
        margin-bottom: -1px;
        min-width: 150px;
        text-align: center;
    }
    .nav-justified .nav-item {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        text-align: center;
    }
    .nav-link {
        display:block;
        padding: 9px 38px !important;
        position: relative;
        transition: all ease-in-out .15s;
    }
    .nav-link.active {
        font-weight:500;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .1875em;
        border-top-right-radius: .1875em;
    }

    nav-tabs-bottom .nav-link, .nav-tabs-highlight .nav-link, .nav-tabs-top .nav-link {
        position: relative;
    }
    .nav-tabs-highlight .nav-link {
        border-top-color: transparent;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #333;
        background-color: #fff;
        border-color: #ddd #ddd #fff;
    }
    .nav-tabs-bottom .nav-link:before, .nav-tabs-highlight .nav-link:before, .nav-tabs-top .nav-link:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        transition: background-color ease-in-out .15s;
    }
    .nav-tabs-highlight .nav-link:before {
        height: 2px;
        top: -1px;
        left: -1px;
        right: -1px;
    }
    .nav-tabs-highlight .nav-link.active:before {
        background-color: #2196f3;
    }
    .justify-content-center {
        -ms-flex-pack: center!important;
        justify-content: center!important;
    }
    .payItems .row {
        border-bottom:1px solid #ccc;
        padding-bottom:10px;
        margin-bottom: 10px;
    }
    .payItems .row:first-child {
        margin-top:20px;
        padding-bottom:10px;
    }
    .font-weight-semibold {
        font-weight:bold;
    }
    .payItems .text-height {
        line-height:30px;
    }
    #processForm .row {
        margin-top:12px;
        margin-bottom: 0px;
    }
    #processForm .sm-addrm {
        width:5%;
    }
    #processForm .modal-footer {
        margin-top: 20px;
    }
    #itemWrapper .row:last-child {
        border-bottom:none !important;
    }
    .prePopulateTxt {
        position:absolute;
        top:-118px;
    }
    .tipsIco{float: left;margin-right: 7px;color:orange}
    .tipsTxt{float: left;width: 90%;}
    .useTemplate{margin-left:23px;margin-top: 10px;}
</style>
<div id="modalCalPayroll" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Process Payroll</h6>
            </div>

            <div class="modal-body overflow-y-visible">

            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button id="createTeam" type="submit" class="btn btn-primary">Save Payroll</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="employeeForm" class="stepy" action="#">
    <input type="hidden" id="processDate" value="<?TPLVAR_PROCESS_DATE?>" />
    <fieldset>
        <legend class="text-semibold">Select Employee to Pay</legend>

        <div class="col-md-3 officeFilter"><?TPL_OFFICE_LIST?></div>

        <div class="input-group payroll-range">
            <span class="input-group-prepend">
                <span class="input-group-text">
                    <i class="icon-calendar22"></i> &nbsp;&nbsp;Process Period
                </span>
            </span>
            <input type="text" class="form-control daterange" >
        </div>

        <table class="table table-hover datatable employeeTable">
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Contract Type</th>
                <th>Employment Status</th>
                <th>Actions</th>
            </tr>
            </thead>
        </table>
    </fieldset>

    <fieldset>
        <legend class="text-semibold">View Summary</legend>

        <div class="panel-body">
            <div class="panel-heading">
                <h5 class="panel-title">Employee List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li>
                            <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/employee/add">
                                <b><i class="icon-user-plus"></i></b> Add New Employee</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <b><i class="icon-reading"></i></b> Bulk Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                                <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-user-plus"></i> Import Employee (CSV/Excel)</a></li>
                                <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/upload"><i class="icon-cloud-download2"></i> Export All Employees</a></li>
                                <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/email"><i class="icon-mail5"></i> Message Selected Employees</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon-user-block"></i> Suspend Selected Employees</a></li>
                                <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/delete"><i class="icon-user-minus"></i> Delete Selected Employees</a></li>
                                <li class="divider"></li>
                                <li><a href="<?TPLVAR_ROOT_URL?>admin/employee/settings"><i class="icon-gear"></i> Employee Settings</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </fieldset>
    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
    </button>
</form>