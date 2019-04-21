<script>
    $(document).ready(function( ) {
        var contractTable = $(".contractTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/getContractResults",
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
                targets:[0],
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                data: 'cID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '160px',
                data: 'type'
            },{
                targets: [2],
                orderable: true,
                width: '400px',
                data: 'descript'
            },{
                targets: [3],
                orderable: true,
                width: '100px',
                data: 'empCount',
                className : "text-center",
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
                           '<a class="dropdown-item" data-backdrop="static" data-keyboard="false">' +
                           '<i class="icon-pencil5"></i> Edit Contract Type</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '">' +
                           '<i class="icon-bin"></i> Delete Contract Type</a>' +
                           '</div>' +
                           '</div>' +
                           '</div>';
                }
            }],
            select: {
                "style": "multi"
            },
            order: [],
            dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search: '',
                searchPlaceholder: 'Search Contract Type',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
            drawCallback: function () {
                $(".contractTable [type=checkbox]").uniform();

                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".contract-list-action-btns").insertAfter("#contractList .dataTables_filter");

        // Alternative pagination
        $('#contractList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#contractList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#contractList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#contractList .datatable tbody").on("mouseover", "td", function() {
            var colIdx = contractTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(contractTable.cells().nodes()).removeClass('active');
                $(contractTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(contractTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#contractList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });
    });
</script>

<div class="tab-pane fade" id="contractList">
    <div class="list-action-btns contract-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalContract">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_CONTRACT_TYPE?>
                </a>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn bg-purple-400 btn-labeled dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><i class="icon-stack3"></i></b> Bulk Action <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right dropdown-employee">
                    <li><a href="#" id="payItemBulkDelete"><i class="icon-bin"></i> Delete Selected Contracts</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed contractTable">
        <thead>
        <tr>
            <th></th>
            <th>Contract Type</th>
            <th>Description</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalContract" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Contract Type</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="savePayrun" name="savePayrun" method="post" action="">
                    <input type="hidden" id="cID" name="cID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contract Title:</label>
                                <input type="text" name="type" id="type" class="form-control" value=""
                                       placeholder="Enter Contract Title" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contract Description:</label>
                                <textarea id="descript" name="descript" rows="5" cols="4"
                                          placeholder="Enter Contract Description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>