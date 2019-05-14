<script>
    $(document).ready(function( ) {
        var rolePermTable = $(".rolePermTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'roleTable-row' + aData['roleID']);
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
                render: function (data, type, full, meta) {
                    if( data > 0 ) {
                        return '<a data-role="role" data-id="' + full['roleID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                    }
                    else {
                        return data;
                    }
                }
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
                           '<a class="dropdown-item roleDelete" data-id="' + data + '">' +
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
            if( typeof rolePermTable.cell(this).index() == "undefined" ) return;
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

        $(document).on("click", ".permGroup", function( ) {
            var id = $(this).attr("data-id");

            if( !$(this).hasClass("groupShow") ) {
                $(".permRow-" + id).removeClass("hide");
                $(this).addClass("groupShow");
                $(this).children( ).addClass("parentGroupLit");
                $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
                $(".permTable tbody").scrollTo( $(".permGroup-" + id), 500 );
            }
            else {
                $(".permRow-" + id).addClass("hide");
                $(this).removeClass("groupShow");
                $(this).children( ).removeClass("parentGroupLit");
                $("#groupIco-" + id).removeClass("").addClass("icon-shrink7");
            }
        });

        $("#modalRole").on("shown.bs.modal", function(e) {
            $("#roleTitle").focus( );
        });

        $("#modalRole").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            var roleID = $invoker.attr("data-id");

            if( roleID ) {
                var data = {
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#roleID").val( obj.data.roleID );
                            $("#roleTitle").val( obj.data.title );
                            $("#roleDescript").val( obj.data.descript );
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/role/getRole/" + roleID, data );
            }
            else {
                $("#roleID").val(0);
                $("#roleTitle").val("");
                $("#roleDescript").val("");
            }
        });

        $("#modalPermission").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getPermList/' + $invoker.attr("data-id"), function() {
                $(".switch").bootstrapSwitch('disabled',false);
                $(".switch").bootstrapSwitch('state', false);
                getPerms( $invoker.attr("data-id") );
            });
        });

        $("#modalEmployee").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            if( $invoker.attr("data-role") == "role" ) {
                var rID = $invoker.attr("data-id");

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/role/' + rID, function( ) {
                    $(".modal-title").text( $("#roleTitle" + rID).text( ) );
                });
            }
        });

        $("#savePerm").on("click", function ( ) {
            var checked = []
            $(".switch:checked").each(function( ) {
                checked.push(parseInt($(this).val()));
            });

            var data = {
                bundle: {
                    "roleID": $("#roleID").val( ),
                    "perms": checked
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 0 && obj.errMsg ) {
                        return;
                    }
                    swal("Done!", "Permissions saved!", "success");
                }
            };
            Aurora.WebService.AJAX( "admin/rolePerm/savePerms", data );
            return false;
        });

        function getPerms( roleID ) {
            var data = {
                bundle: {
                    "roleID": roleID
                },
                success: function( res ) {
                    $("#defineTitle").text( $("#roleTitle" + roleID).text( ) );

                    var perms = $.parseJSON( res );

                    $("#roleID").val( roleID );
                    $(".switch").bootstrapSwitch('disabled',false);
                    $(".switch").bootstrapSwitch('state', false);
                    $.each(perms, function(index, value) {
                        $("#perm_" + value['permID']).bootstrapSwitch('state', true);
                    });
                }
            };
            Aurora.WebService.AJAX( "admin/rolePerm/getPerms", data );
        }

        $("#saveRole").validate({
            rules: {
                roleTitle: { required: true }
            },
            messages: {
                roleTitle: "Please enter a Role Title."
            },
            highlight: function(element, errorClass) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("border-danger");
                $(".modal-footer .error").remove();
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".modal-footer .error").length == 0 )
                    $(".modal-footer").append(error);
            },
            submitHandler: function( ) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveRole")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".rolePermTable").DataTable().ajax.reload();

                            swal({
                                title: $("#roleTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Role",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                $("#roleID").val(0);
                                $("#roleTitle").val("");
                                $("#roleDescript").val("");

                                if( isConfirm === false ) {
                                    $("#modalRole").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#roleTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/role/saveRole", data );
            }
        });

        $(document).on("click", ".roleDelete", function ( ) {
            var roleID = $(this).attr("data-id");
            var title = $("#roleTitle" + roleID).text( );

            swal({
                title: "Are you sure you want to delete " + title + "?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: roleID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            $(".rolePermTable").DataTable().ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/role/deleteRole", data);
            });
            return false;
        });
    });
</script>

<div class="tab-pane fade show" id="rolePermList">
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

            <form id="saveRole" name="saveRole" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <input type="hidden" id="roleID" name="roleID" value="0" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Role Title:</label>
                                <input type="text" name="roleTitle" id="roleTitle" class="form-control" value="" placeholder="Enter Role Title" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Role Description:</label>
                                <textarea id="roleDescript" name="roleDescript" rows="5" cols="4"
                                          placeholder="Enter Role Description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
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
            <form id="permForm" name="permForm" method="post" action="">
                <input type="hidden" id="roleID" value="" />
                <div class="modal-body modal-perm"></div>

                <div class="modal-footer modal-perm-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                    <button id="savePerm" type="submit" class="btn btn-primary">Save Permissions</button>
                </div>
            </form>
        </div>
    </div>
</div>