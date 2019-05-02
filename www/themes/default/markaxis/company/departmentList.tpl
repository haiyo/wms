<script>
    $(document).ready(function( ) {
        var departmentTable = $(".departmentTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'row' + aData['dID']);
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
                data: 'name',
                render: function( data, type, full, meta ) {
                    return '<span id="departName' + full['dID'] + '">' + data + '</span>';
                }
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
                render: function( data, type, full, meta ) {
                    if( data > 0 ) {
                        return '<a data-role="department" data-id="' + full['dID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                    }
                    else {
                        return data;
                    }
                }
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

        $("#modalDepartment").on("shown.bs.modal", function(e) {
            $("#departmentName").focus( );
        });

        $("#modalEmployee").on("show.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);

            if( $invoker.attr("data-role") == "department" ) {
                var dID = $invoker.attr("data-id");

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/company/getCountList/department/' + dID, function() {
                    $(".modal-title").text( $("#departName" + dID).text( ) );
                });
            }
        });

        // Use Bloodhound engine
        var engine = new Bloodhound({
            remote: {
                url: Aurora.ROOT_URL + 'admin/employee/getList/%QUERY/includeOwn',
                wildcard: '%QUERY',
                filter: function( response ) {
                    var tokens = $(".managerList").tokenfield("getTokens");

                    return $.map( response, function( d ) {
                        if( engine.valueCache.indexOf(d.name) === -1) {
                            engine.valueCache.push(d.name);
                        }
                        var exists = false;
                        for( var i=0; i<tokens.length; i++ ) {
                            if( d.name === tokens[i].label ) {
                                exists = true;
                                break;
                            }
                        }
                        if( !exists ) {
                            return {
                                id: d.userID,
                                value: d.name,
                                image: d.image,
                                designation: d.designation
                            }
                        }
                    });
                }
            },
            datumTokenizer: function(d) {
                return Bloodhound.tokenizers.whitespace(d.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        // Initialize engine
        engine.valueCache = [];
        engine.initialize();

        // Initialize tokenfield
        $(".managerList").tokenfield({
            delimiter: ';',
            typeahead: [{
                minLength:1,
                highlight:true,
                hint:false
            }, {
                displayKey: 'value',
                source: engine.ttAdapter(),
                templates: {
                    suggestion: Handlebars.compile([
                        '<div class="col-md-12">',
                        '<div class="col-md-2"><img src="{{image}}" width="40" height="40" ',
                        'style="padding:0;" class="rounded-circle" /></div>',
                        '<div class="col-md-10"><span class="typeahead-name">{{value}}</span>',
                        '<div class="typeahead-designation">{{designation}}</div></div>',
                        '</div>'
                    ].join(''))
                }
            }]
        });

        $(".managerList").on("tokenfield:createtoken", function( event ) {
            var exists = false;
            $.each( engine.valueCache, function(index, value) {
                if( event.attrs.value === value ) {
                    exists = true;
                    $("#managerIDs").val( event.attrs.id + "," + $("#managerIDs").val() );
                }
            });
            if( !exists ) {
                event.preventDefault( );
            }
        }).on('tokenfield:createdtoken', function(e) {
            $(e.relatedTarget).attr( "data-id", e.attrs.id );
        });;

        $("#saveDepartment").validate({
            rules: {
                departmentName: { required: true }
            },
            messages: {
                departmentName: "Please enter a Department Name."
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
                        data: Aurora.WebService.serializePost("#saveDepartment")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        console.log(obj)
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".officeTable").DataTable().ajax.reload();

                            swal({
                                title: $("#departmentName").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Office",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                $("#departmentID").val(0);
                                $("#departmentName").val("");
                                //$("#officeAddress").val("");

                                if( isConfirm === false ) {
                                    $("#modalDepartment").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#departmentName").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/company/saveDepartment", data );
            }
        });
    });
</script>

<div class="tab-pane fade" id="departmentList">
    <div class="list-action-btns department-list-action-btns">
        <ul class="icons-list">
            <li>
                <a type="button" class="btn bg-purple-400 btn-labeled"
                   data-toggle="modal" data-target="#modalDepartment">
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
<div id="modalDepartment" class="modal fade">
    <div class="modal-dialog modal-med2">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Department</h6>
            </div>

            <form id="saveDepartment" name="saveDepartment" method="post" action="">
                <input type="hidden" id="departmentID" name="departmentID" value="0" />
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Department Name:</label>
                                <input type="text" name="departmentName" id="departmentName" class="form-control" value=""
                                       placeholder="Enter Department Name" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Department Manager(s):</label>
                                <input type="text" name="managers" class="form-control tokenfield-typeahead managerList"
                                       placeholder="Enter Manager's Name" value=""
                                       autocomplete="off" data-fouc />
                                <input type="hidden" id="managerIDs" name="managerIDs" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveApplyLeave">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>