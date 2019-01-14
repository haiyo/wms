
<script>
    $(document).ready(function( ) {
        var start = moment().startOf('month');
        var end = moment().endOf('month');;

        $(".daterange").daterangepicker({
            //timePicker: true,
            startDate: start,
            endDate: end,
            opens: 'left',
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-light',
            locale: {
                format: 'MMMM DD, YYYY'
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

        $(".employeeTable").DataTable({
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
                Popups.init();
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
                targets: 0,
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                data: 'userID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '150px',
                data: 'idnumber'
            },{
                targets: [2],
                orderable: true,
                width: '280px',
                data: 'name'
            },{
                targets: [3],
                orderable: true,
                width: '260px',
                data: 'position'
            },{
                targets: [4],
                orderable: true,
                width: '220px',
                data: 'type'
            },{
                targets: [5],
                orderable: true,
                width: '150px',
                data: 'salary',
                render: function (data, type, full, meta) {
                    return $.fn.dataTable.render.number(',', '.', 2, full['currency']).display( full['salary'] );
                }
            },{
                targets: [6],
                searchable : false,
                data: 'status',
                width: '130px',
                className : "text-center",
                render: function(data, type, full, meta) {
                    var reason = full['suspendReason'] ? ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="' + full['suspendReason'] + '"' : "";

                    if( full['suspended'] == 1 ) {
                        return '<span id="status' + full['userID'] + '" class="label label-danger"' + reason + '>Suspended</span>';
                    }
                    else {
                        if( full['endDate'] ) {
                            if( dateDiff( full['endDate'] ) <= 30 ) {
                                reason = ' data-popup="tooltip" title="" data-placement="bottom" data-original-title="Expire on ' + full['endDate'] + '"'
                                return '<span id="status' + full['userID'] + '" class="label label-pending"' + reason + '>Expired Soon</span>';
                            }
                        }
                        return '<span id="status' + full['userID'] + '" class="label label-success"' + reason + '>Active</span>';
                    }
                }
            },{
                targets: [7],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'userID',
                render: function(data, type, full, meta) {
                    var name   = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<div class="list-icons">' +
                        '<div class="list-icons-item dropdown">' +
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view">' +
                        '<i class="icon-user"></i> View Employee Info</a>' +
                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/edit/' + data + '">' +
                        '<i class="icon-pencil5"></i> Edit Employee Info</a>' +
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

                    /*return '<ul class="action icons-list">\n' +
                        '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                        '<i class="icon-menu9"></i>\n' +
                        '</a>\n' +
                        '<ul class="dropdown-menu dropdown-menu-right">\n' +
                        '<li><a><i class="icon-user"></i> View Employee Info</a></li>\n' +

                        '<li><a href="<?TPLVAR_ROOT_URL?>admin/employee/edit/' + data + '"><i class="icon-pencil5"></i> Edit Employee Info</a></li>\n' +
                        '<li><a data-href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '"><i class="icon-mail5"></i> Message Employee</a></li>\n' +
                        '<li><a data-title="View ' + name + ' History Log" data-href="<?TPLVAR_ROOT_URL?>admin/employee/log/' + data + '" data-toggle="modal" data-target="#modalLoad"><i class="icon-history"></i> View History Log</a></li>\n' +
                        '<li class="divider"></li>\n' +
                        '<li><a id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setSuspend(' + data + ', \'' + name + '\')"><i class="icon-user-block"></i> ' + statusText + '</a></li>\n' +
                        '<li><a id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')"><i class="icon-exit3"></i> Employee Resigned</a></li>\n' +
                        '</ul>\n' +
                        '</li>\n' +
                        '</ul>'*/
                }
            }],
            select: {
                'style': 'multi'
            },
            order: [],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search Employee',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
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
            var colIdx = table.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(table.cells().nodes()).removeClass('active');
                $(table.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(table.cells().nodes()).removeClass("active");
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
    });
</script>
<style>
    .payroll-employee .stepy-step{padding:0;}
    .payroll-employee>.stepy-header{padding:15px;margin-bottom:0px;}
    .payroll-employee .payroll-range{width:65%;float:right;}
    .payroll-employee .payroll-range input{font-size:17px;}
    .payroll-employee .payroll-range .input-group-text{font-size:16px;padding:5px 14px;}
    .payroll-employee .payroll-range .input-group-text i{margin-right:10px;}
</style>
    <div class="panel panel-flat">
        <div class="panel panel-flat payroll-employee">

                <form id="employeeForm" class="stepy" action="#">
                    <fieldset>
                        <legend class="text-semibold">Select Employee to Pay</legend>
                        <div class="panel-heading">
                            <div class="col-md-6">
                                <h5 class="panel-title"></h5>
                            </div>
                            <div class="col-md-6 no-padding-right">
                                <div class="input-group payroll-range">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i> Process Period</span>
                                    </span>
                                    <input type="text" class="form-control daterange" >
                                </div>
                            </div>

                        </div>

                        <table class="table table-hover datatable employeeTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Contract Type</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </fieldset>

                    <fieldset>
                        <legend class="text-semibold">Select Pay Items</legend>




<style>
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
        font-size:16px;
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
</style>

                                <ul class="nav nav-tabs nav-tabs-highlight employee-nav justify-content-center">
                                    <li class="nav-item"><a href="#monthly" class="nav-link active" data-toggle="tab">Monthly Payment / Deduction</a></li>
                                    <li class="nav-item"><a href="#adhoc" class="nav-link" data-toggle="tab">Ad Hoc Payment / Deduction</a></li>
                                    <li class="nav-item"><a href="#hourly" class="nav-link" data-toggle="tab">Hourly / Daily Attendance</a></li>
                                </ul>

                                <div class="tab-content">

                                </div>





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

        </div>
    </div>