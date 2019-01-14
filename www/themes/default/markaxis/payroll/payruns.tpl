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

        $(".payrunTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/payroll/getPayruns",
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
                targets: [0],
                orderable: true,
                width: '250px',
                data: 'name'
            },{
                targets: [1],
                orderable: true,
                width: '280px',
                data: 'payPeriod'
            },{
                targets: [2],
                orderable: true,
                width: '260px',
                data: 'position'
            },{
                targets: [3],
                orderable: true,
                width: '220px',
                data: 'type'
            },{
                targets: [4],
                orderable: true,
                width: '220px',
                data: 'type'
            },{
                targets: [5],
                orderable: true,
                width: '220px',
                data: 'type'
            },{
                targets: [6],
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

        $("#payPeriod").select2({minimumResultsForSearch: Infinity});

        $("#payPeriod option").filter(function() {
            return !this.value || $.trim(this.value).length == 0 || $.trim(this.text).length == 0;
        })
        .remove();

        $("#payPeriod option[value='month']").attr( "selected", true );

        $(".pickadate-start").pickadate({
            weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            showMonthsShort: true
        });

        $(".pickadate-start").change(function() {
            var data = {
                bundle: {
                    payPeriod: $("#payPeriod").val(),
                    start: $(this).val()
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        alert(obj.errMsg);
                        return;
                    }
                    else {
                        $(".startDateHelp").text( obj.data );
                    }
                }
            };
            Aurora.WebService.AJAX("admin/payroll/getEndDate", data);
        });

        $(".pickadate-firstPayment").pickadate({
            weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            showMonthsShort: true
        });

        $(".pickadate-firstPayment").change(function() {
            var data = {
                bundle: {
                    payPeriod : $("#payPeriod").val( ),
                    start: $(this).val( )
                },
                success: function( res ) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        alert(obj.errMsg);
                        return;
                    }
                    else {
                        $(".firstPaymentHelp").text( obj.data );
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/payroll/getPaymentRecur", data );
        });

        $("#savePayrun").validate({
            rules: {
                payrunName: { required: true },
                payPeriod: { required: true },
                startDate: { required: true },
                firstPayment: { required: true }
            },
            messages: {
                //username: Aurora.i18n.LoginRes.LANG_ENTER_VALID_EMAIL,
                //password: Aurora.i18n.LoginRes.LANG_ENTER_PASSWORD
                payrunName: "Please enter a Pay Run Name for this period.",
                payPeriod: "Please select Pay Period.",
                startDate: "Please select Start Date.",
                firstPayment: "Please select First Payment Date."
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        prID: $("#prID").val( ),
                        payrunName: $("#payrunName").val( ),
                        payPeriod: $("#payPeriod").val( ),
                        startDate: $("#startDate").val( ),
                        firstPayment: $("#firstPayment").val( )
                    },
                    success: function( res ) {
                        console.log(res)
                        $(".payrunTable").data.reload();
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/savePayrun", data );
            }
        });
    });
</script>

<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Employee List<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/employee/add"
                       data-toggle="modal" data-target="#modalAddPayrun">
                        <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_PAY_RUN?>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;
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

    <table class="table table-hover datatable payrunTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Pay Period</th>
            <th>Payment Date</th>
            <th>Salaries</th>
            <th>Tax</th>
            <th>Net Pay</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalAddPayrun" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Pay Run</h6>
            </div>

            <div class="modal-body">
                <form id="savePayrun" name="savePayrun" method="post" action="">
                    <input type="hidden" id="prID" name="prID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pay Run Name:</label>
                                <input type="text" name="payrunName" id="payrunName" class="form-control" value=""
                                       placeholder="For e.g: Monthly Full-time Employee, Weekly Part-time Employee" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pay Period:</label>
                                <?TPL_PAY_PERIOD_LIST?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>
                                    <input type="text" class="form-control pickadate-start" id="startDate" name="startDate" placeholder="" />
                                </div>
                                <span class="help-block startDateHelp"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label>First Payment Date:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="text" class="form-control pickadate-firstPayment" id="firstPayment" name="firstPayment" placeholder="" />
                            </div>
                            <span class="help-block firstPaymentHelp"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>