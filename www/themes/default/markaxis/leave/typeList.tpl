<script>
    $(document).ready(function( ) {
        var leaveTypeTable = $(".leaveTypeTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'leaveTypeTable-row' + aData['ltID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/leave/getTypeResults",
                type: "POST",
                data: function (d) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
            },
            initComplete: function () {
                //
            },
            autoWidth: false,
            mark: true,
            columnDefs: [{
                targets: [0],
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable: false,
                data: 'ltID',
                render: function( data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes check-input" name="ltID[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '250px',
                data: 'name',
                render: function( data, type, full, meta ) {
                    return data + " (" + full['code'] + ")";
                }
            },{
                targets: [2],
                orderable: true,
                width: '120px',
                data: 'paidLeave',
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data == 0 ) {
                        return '<span class="label label-pending">No</span>';
                    }
                    else {
                        return '<span class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [3],
                orderable: true,
                width: '120px',
                data: 'allowHalfDay',
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data == 0 ) {
                        return '<span class="label label-pending">No</span>';
                    }
                    else {
                        return '<span class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [4],
                orderable: true,
                width: '100px',
                data: 'unused',
            },{
                targets: [5],
                orderable: false,
                searchable: false,
                width: '100px',
                className: "text-center",
                data: 'ltID',
                render: function( data, type, full, meta ) {
                    return '<div class="list-icons">' +
                        '<div class="list-icons-item dropdown">' +
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                        '<a href="<?TPLVAR_ROOT_URL?>admin/leave/editType/' + data + '" class="dropdown-item editLeaveType">' +
                        '<i class="icon-pencil5"></i> Edit Leave Type</a>' +
                        '<div class="divider"></div>' +
                        '<a class="dropdown-item deleteLeaveType" data-id="' + data + '">' +
                        '<i class="icon-bin"></i> Delete Leave Type</a>' +
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
                searchPlaceholder: 'Search Leave Type',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
            },
            drawCallback: function () {
                $(".leaveTypeTable [type=checkbox]").uniform();

                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".leaveType-list-action-btns").insertAfter("#leaveTypeList .dataTables_filter");

        // Alternative pagination
        $('#leaveTypeList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#leaveTypeList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#leaveTypeList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#leaveTypeList .datatable tbody").on("mouseover", "td", function () {
            if( typeof leaveTypeTable.cell(this).index() == "undefined" ) return;
            var colIdx = leaveTypeTable.cell(this).index().column;

            if( colIdx !== lastIdx ) {
                $(leaveTypeTable.cells().nodes()).removeClass('active');
                $(leaveTypeTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function () {
            $(leaveTypeTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#leaveTypeList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });
    });
</script>

<div class="tab-pane fade show active" id="leaveTypeList">
    <div class="list-action-btns leaveType-list-action-btns">
        <ul class="icons-list">
            <li>
                <a href="<?TPLVAR_ROOT_URL?>admin/leave/addType" type="button" class="btn bg-purple-400 btn-labeled">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_LEAVE_TYPE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable leaveTypeTable">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Paid Leave</th>
            <th>Allow Half Day</th>
            <th>Unused Leave</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>