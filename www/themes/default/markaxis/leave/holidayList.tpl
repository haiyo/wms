<script>
    $(document).ready(function( ) {
        var holidayTable = $(".holidayTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'leaveTypeTable-row' + aData['ltID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/leave/getHolidayResults",
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
                orderable: true,
                width: '900px',
                data: 'title'
            },{
                targets: [1],
                orderable: true,
                width: '200px',
                data: 'date',
            },{
                targets: [2],
                orderable: false,
                searchable: false,
                width: '10px',
                className: "text-center",
                data: 'hID',
                render: function( data, type, full, meta ) {
                    return '<div class="list-icons">' +
                        '<div class="list-icons-item dropdown">' +
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                        '<a href="<?TPLVAR_ROOT_URL?>admin/leave/editHoliday/' + data + '" class="dropdown-item editHoliday">' +
                        '<i class="icon-pencil5"></i> Edit Holiday</a>' +
                        '<div class="divider"></div>' +
                        '<a class="dropdown-item deleteHoliday" data-id="' + data + '">' +
                        '<i class="icon-bin"></i> Delete Holiday</a>' +
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
                $(".holidayTable [type=checkbox]").uniform();

                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                Popups.init();
            },
            preDrawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".holiday-list-action-btns").insertAfter("#holidayList .dataTables_filter");

        // Alternative pagination
        $('#holidayList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#holidayList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#holidayList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#holidayList .datatable tbody").on("mouseover", "td", function () {
            if( typeof holidayTable.cell(this).index() == "undefined" ) return;
            var colIdx = holidayTable.cell(this).index().column;

            if( colIdx !== lastIdx ) {
                $(holidayTable.cells().nodes()).removeClass('active');
                $(holidayTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function () {
            $(holidayTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#holidayList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });
    });
</script>

<div class="tab-pane fade" id="holidayList">
    <div class="list-action-btns holiday-list-action-btns">
        <ul class="icons-list">
            <li>
                <a href="<?TPLVAR_ROOT_URL?>admin/leave/addHoliday" type="button" class="btn bg-purple-400 btn-labeled">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_CUSTOM_HOLIDAY?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable holidayTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>