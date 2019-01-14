<script>
    $(document).ready(function( ) {
        $(".payCalTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/payroll/getCalResults",
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
                data: 'calName'
            },{
                targets: [1],
                orderable: true,
                width: '280px',
                data: 'payPeriod'
            },{
                targets: [2],
                orderable: true,
                width: '260px',
                data: 'nextPayPeriod'
            },{
                targets: [3],
                orderable: true,
                width: '220px',
                data: 'nextPayment'
            },{
                targets: [4],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'pcID',
                render: function(data, type, full, meta) {
                    var name   = full["name"];
                    var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

                    return '<div class="list-icons">' +
                        '<div class="list-icons-item dropdown">' +
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view">' +
                        '<i class="icon-user"></i> View Employee Info</a>' +
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
            select: {
                "style": "multi"
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
        }).remove();

        $("#payPeriod option[value='monthly']").attr( "selected", true );

        $(".pickadate-start").pickadate({
            showMonthsShort: true
        });

        $(".pickadate-start").change(function() {
            var data = {
                bundle: {
                    payPeriod: $("#payPeriod").val(),
                    startDate: $(this).val()
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        //alert(obj.errMsg);
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
            showMonthsShort: true
        });

        $(".pickadate-firstPayment").change(function() {
            var data = {
                bundle: {
                    payPeriod : $("#payPeriod").val( ),
                    startDate: $(this).val( )
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
                        $(".payrunTable").data.reload();
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/savePayrun", data );
            }
        });
    });
</script>

<div class="tab-pane fade show active" id="calendars">
    <div class="panel-heading">
        <h5 class="panel-title">&nbsp;<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li>
                    <a type="button" class="btn bg-purple-400 btn-labeled"
                       data-toggle="modal" data-target="#modalAddPayrun">
                        <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_PAY_CALENDAR?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <table class="table table-hover datatable payCalTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Pay Period</th>
            <th>Next Pay Period</th>
            <th>Next Payment Date</th>
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

            <div class="modal-body overflow-y-visible">
                <form id="savePayrun" name="savePayrun" method="post" action="">
                    <input type="hidden" id="prID" name="prID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>How often will you pay your employees?</label>
                                <?TPL_PAY_PERIOD_LIST?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pay Run Name:</label>
                                <input type="text" name="payrunName" id="payrunName" class="form-control" value=""
                                       placeholder="For e.g: Monthly Full-time Employee, Weekly Part-time Employee" />
                            </div>
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
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