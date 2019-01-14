<script>
$(function() {
    $(".logTable").DataTable({
        "processing": true,
        "serverSide": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            //$(nRow).attr('id', 'row' + aData['userID']);
        },
        ajax: {
            url: Aurora.ROOT_URL + "admin/employee/logResults/<?TPLVAR_USERID?>",
            type: "POST",
            data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
        },
        autoWidth: false,
        mark: true,
        columnDefs: [{
            targets: [0],
            orderable: true,
            width: '180px',
            data: 'eventType',
            render: function (data, type, full, meta) {
                return data.toUpperCase()
            }
        },{
            targets: [1],
            orderable: true,
            width: '180px',
            data: 'action',
            render: function (data, type, full, meta) {
                return data.toUpperCase()
            }
        },{
            targets: [2],
            orderable: true,
            data: 'descript'
        },{
            targets: [3],
            orderable: true,
            width: '200px',
            data: 'created'
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        aaSorting: [[3, 'desc']],
        language: {
            search: '',
            searchPlaceholder: 'Search History',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        }
    });
});
</script>

<div class="panel panel-flat">
        <table class="table table-hover datatable logTable">
            <thead>
            <tr>
                <th>Event Type</th>
                <th>Action</th>
                <th>Description</th>
                <th>Created</th>
            </tr>
            </thead>
        </table>
</div>