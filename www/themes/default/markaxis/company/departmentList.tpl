<script>
    $(document).ready(function( ) {
        var departmentTable = $(".departmentTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/company/getDepartmentResults",
                type: "POST",
                data: function ( d ) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
            },
            initComplete: function() {
                //
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
                width: '320px',
                data: 'manager'
            },{
                targets: [2],
                orderable: true,
                width: '150px',
                data: 'empCount',
                className : "text-center",
            },{
                targets: [3],
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
                           '<i class="icon-pencil5"></i> Edit Department</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')">' +
                           '<i class="icon-bin"></i> Delete Department</a>' +
                           '</div>' +
                           '</div>' +
                           '</div>';
                }
            }],
            order: [],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search Department',
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

        $(".department-list-action-btns").insertAfter("#departmentList .dataTables_filter");

        // Alternative pagination
        $('#departmentList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#departmentList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#departmentList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#departmentList .datatable tbody").on("mouseover", "td", function() {
            var colIdx = departmentTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(departmentTable.cells().nodes()).removeClass('active');
                $(departmentTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(departmentTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#departmentList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });
    });
</script>

<div class="tab-pane fade" id="departmentList">
    <div class="list-action-btns department-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalAddPayrun">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_DEPARTMENT?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable departmentTable">
        <thead>
        <tr>
            <th>Department Name</th>
            <th>Manager</th>
            <th>No. of Employee</th>
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