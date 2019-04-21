<script>
    $(document).ready(function( ) {
        var rolePermTable = $(".rolePermTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['roleID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/employee/getRolePermResults",
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
                width: '160px',
                data: 'title',
                render: function(data, type, full, meta) {
                    return '<span id="roleTitle' + full['roleID'] + '">' + data + '</span>';
                }
            },{
                targets: [1],
                orderable: true,
                width: '400px',
                data: 'descript'
            },{
                targets: [2],
                orderable: true,
                width: '100px',
                data: 'empCount',
                className : "text-center",
            },{
                targets: [3],
                orderable: false,
                searchable : false,
                width: '80px',
                className : "text-center",
                data: 'roleID',
                render: function(data, type, full, meta) {
                    return '<div class="list-icons">' +
                           '<div class="list-icons-item dropdown">' +
                           '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                           '<i class="icon-menu9"></i></a>' +
                           '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                           '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalRole">' +
                           '<i class="icon-pencil5"></i> Edit Role</a>' +
                           '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-backdrop="static" ' +
                           'data-keyboard="false" data-target="#modalPermission">' +
                           '<i class="icon-lock2"></i> Define Permissions</a>' +
                           '<div class="divider"></div>' +
                           '<a class="dropdown-item" id="">' +
                           '<i class="icon-bin"></i> Delete Role</a>' +
                           '</div>' +
                           '</div>' +
                           '</div>';
                }
            }],
            order: [],
            dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
            language: {
                search: '',
                searchPlaceholder: 'Search Role Name',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
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

        $(".rolePerm-list-action-btns").insertAfter("#rolePermList .dataTables_filter");

        // Alternative pagination
        $('#rolePermList .datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
            }
        });

        // Datatable with saving state
        $('#rolePermList .datatable-save-state').DataTable({
            stateSave: true
        });

        // Scrollable datatable
        $('#rolePermList .datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollY: 300
        });

        $("#dID").select2( );

        // Highlighting rows and columns on mouseover
        var lastIdx = null;

        $("#rolePermList .datatable tbody").on("mouseover", "td", function() {
            var colIdx = rolePermTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(rolePermTable.cells().nodes()).removeClass('active');
                $(rolePermTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function() {
            $(rolePermTable.cells().nodes()).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#rolePermList .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        $("#modalPermission").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getPermList/' + $invoker.attr("data-id"), function() {
                $(".switch").bootstrapSwitch('disabled',false);
                $(".switch").bootstrapSwitch('state', false);
                getPerms( $invoker.attr("data-id") );
            });
        });

        function getPerms( roleID ) {
            var data = {
                bundle: {
                    "roleID": roleID
                },
                success: function( res ) {
                    $("#defineTitle").text( $("#roleTitle" + roleID).text( ) );

                    var perms = $.parseJSON( res );

                    $(".switch").bootstrapSwitch('disabled',false);
                    $(".switch").bootstrapSwitch('state', false);
                    $.each(perms, function(index, value) {
                        $("#perm_" + value['permID']).bootstrapSwitch('state', true);
                    });

                    if( roleID == 1 ) {
                        $(".switch").bootstrapSwitch('disabled',true);
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/rolePerm/getPerms", data );
        }
    });
</script>

<div class="tab-pane fade show active" id="rolePermList">
    <div class="list-action-btns rolePerm-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled" data-backdrop="static" data-keyboard="false"
                   data-toggle="modal" data-target="#modalRole">
                    <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_ROLE?>
                </a>
            </li>
        </ul>
    </div>

    <table class="table table-hover datatable tableLayoutFixed rolePermTable">
        <thead>
        <tr>
            <th>Role Name</th>
            <th>Description</th>
            <th>No. of Employee</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalRole" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Role</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="savePayrun" name="savePayrun" method="post" action="">
                    <input type="hidden" id="rID" name="rID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Role Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="" placeholder="Enter Role Name" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Role Description:</label>
                                <textarea id="description" name="description" rows="5" cols="4"
                                          placeholder="Enter Role Description" class="form-control"></textarea>
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
<div id="modalPermission" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Define Permissions (<strong id="defineTitle"></strong>)</h6>
            </div>

            <div class="modal-body modal-perm">

            </div>
            <div class="modal-footer modal-perm-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                <button id="createTeam" type="submit" class="btn btn-primary">Save Permissions</button>
            </div>
        </div>
    </div>
</div>