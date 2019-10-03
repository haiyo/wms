
<script>
    $(function() {
        var naTable = $(".naTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['userID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/newsAnnouncement/results",
                type: "POST",
                data: function ( d ) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
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
                width: '270px',
                data: 'title'
            },{
                targets: [1],
                orderable: true,
                width: '260px',
                data: 'isNews',
                render: function(data, type, full, meta) {
                    if( data == 0 ) {
                        return Aurora.i18n.NewsAnnouncement.LANG_NEWS;
                    }
                    else {
                        return Aurora.i18n.NewsAnnouncement.LANG_ANNOUNCEMENT;
                    }
                }
            },{
                targets: [2],
                orderable: true,
                width: '260px',
                data: 'createdBy'
            },{
                targets: [3],
                orderable: true,
                width: '260px',
                data: 'created'
            },{
                targets: [4],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center p-0",
                data: 'naID',
                render: function(data, type, full, meta) {
                    return '<div class="list-icons">' +
                        '<div class="list-icons-item dropdown">' +
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                        '<i class="icon-menu9"></i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                        '<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/user/view/' + data + '">' +
                        '<i class="icon-user"></i> View Employee Info</a>' +
                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/user/edit/' + data + '">' +
                        '<i class="icon-pencil5"></i> Edit Employee Info</a>' +
                        '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '">' +
                        '<i class="icon-mail5"></i> Message Employee</a>' +
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
                Popups.init();
                $(".naTable [type=checkbox]").uniform();
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

        $(".dataTable tbody").on("mouseover", "td", function( ) {
            var colIdx = naTable.cell(this).index( ).column;

            if( colIdx !== lastIdx ) {
                $(naTable.cells().nodes()).removeClass("active");
                $(naTable.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(naTable.cells().nodes()).removeClass("active");
        });

        // External table additions
        // ------------------------------

        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        $(".list-action-btns").insertAfter(".dataTables_filter");
    });


    function setResign( userID, name ) {
        swal({
            title: "Set " + name + " as Resigned Employee?",
            text: name + "'s account will be move to the Alumni section.",
            type: "input",
            inputPlaceholder: "Provide reason(s) if any",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirm Delete",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm === false) return;

            var data = {
                bundle: {
                    userID: userID,
                    status: 1,
                    reason: isConfirm
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if (obj.bool == 0) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $("#row" + userID).fadeOut("slow");
                        swal("Done!", name + " has been successfully set to Resigned!", "success");
                        return;
                    }
                }
            };
            Aurora.WebService.AJAX("admin/employee/setResignStatus", data);
        });
        return false;
    }
</script>
<div class="tab-pane fade show" id="naList">
    <div class="list-action-btns">
        <ul class="icons-list">
            <li>
                <!-- BEGIN DYNAMIC BLOCK: addEmployeeBtn -->
                <a type="button" class="btn bg-purple-400 btn-labeled" href="<?TPLVAR_ROOT_URL?>admin/user/add">
                    <b><i class="mi-description"></i></b> <?LANG_ADD_NEW_CONTENT?></a>&nbsp;&nbsp;&nbsp;
                <!-- END DYNAMIC BLOCK: addEmployeeBtn -->
            </li>
        </ul>
    </div>

    <table class="table table-hover naTable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Content Type</th>
            <th>Created By</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="modalLoad" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title">Info header</h6>
                </div>

                <div class="modal-body"></div>

                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>
</div>