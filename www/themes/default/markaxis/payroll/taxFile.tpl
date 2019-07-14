
<script>
    $(document).ready(function( ) {
        var payItemTable = $(".payItemTable").DataTable({
            "processing": true,
            "serverSide": true,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', 'payItemTable-row' + aData['piID']);
            },
            ajax: {
                url: Aurora.ROOT_URL + "admin/payroll/getTaxFiledResults",
                type: "POST",
                data: function(d) {
                    d.ajaxCall = 1;
                    d.csrfToken = Aurora.CSRF_TOKEN;
                },
            },
            initComplete: function () {
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
                width: "60px",
                data: "title"
            }, {
                targets: [1],
                orderable: true,
                searchable: false,
                width: "150px",
                data: "basic",
                render: function( data, type, full, meta ) {
                    if( data == 0 ) {
                        return '<span class="label label-pending">No</span>';
                    }
                    else {
                        return '<span class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [2],
                orderable: true,
                searchable: false,
                width: "100px",
                data: "deduction",
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data == 0 ) {
                        return '<span id="deduction' + full['piID'] + '" class="label label-pending">No</span>';
                    }
                    else {
                        return '<span id="deduction' + full['piID'] + '" class="label label-success">Yes</span>';
                    }
                }
            },{
                targets: [3],
                orderable: true,
                searchable: false,
                width:"80px",
                data:"taxGroups",
                render: function( data, type, full, meta ) {
                    var groups = '<div class="group-item">';

                    for( var i=0; i<data.length; i++ ) {
                        groups += '<span class="badge badge-primary badge-criteria">' + data[i].title + '</span> ';
                    }
                    return groups + '</div>';
                }
            },{
                targets: [4],
                orderable: true,
                searchable: false,
                width:"200px",
                data:"taxGroups",
                render: function( data, type, full, meta ) {
                    var groups = '<div class="group-item">';

                    for( var i=0; i<data.length; i++ ) {
                        groups += '<span class="badge badge-primary badge-criteria">' + data[i].title + '</span> ';
                    }
                    return groups + '</div>';
                }
            },{
                targets: [5],
                orderable: false,
                searchable: false,
                width:"100px",
                className:"text-center",
                data:"piID",
                render: function( data, type, full, meta ) {
                    return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                            'data-toggle="modal" data-target="#modalPayItem">' +
                            '<i class="icon-pencil5"></i> Edit Pay Item</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item payItemDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Pay Item</a>' +
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
                searchPlaceholder: 'Search Pay Item',
                lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'},
                emptyTable: "No tax filing created yet."
            },
            drawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                $(".payItemTable [type=checkbox]").uniform();
            },
            preDrawCallback: function () {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            }
        });

        $(".payItems-list-action-btns").insertAfter("#payItems .dataTables_filter");

        var lastIdx = null;

        $('.payItemTable tbody').on('mouseover', 'td', function() {
            var colIdx = payItemTable.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(payItemTable.cells().nodes()).removeClass('active');
                $(payItemTable.column(colIdx).nodes()).addClass('active');
            }
        }).on('mouseleave', function( ) {
            $(payItemTable.cells( ).nodes( )).removeClass("active");
        });

        // Enable Select2 select for the length option
        $("#payItems .dataTables_length select").select2({
            minimumResultsForSearch: Infinity,
            width: "auto"
        });

        // Override defaults
        $.fn.stepy.defaults.legend = false;
        $.fn.stepy.defaults.transition = 'fade';
        $.fn.stepy.defaults.duration = 150;
        $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> Back';
        $.fn.stepy.defaults.nextLabel = 'Next <i class="icon-arrow-right14 position-right"></i>';

        $(".stepy").stepy({
            titleClick: true,
            validate: true,
            focusInput: true,
            //block: true,
            next: function(index) {
                $(".form-control").removeClass("border-danger");
                $(".error").remove( );
                $(".stepy").validate(validate)
            },
            finish: function( index ) {
                if( $(".stepy").valid() )  {
                    saveLeaveTypeForm();
                    return false;
                }
            }
        });

        // Apply "Back" and "Next" button styling
        $('.stepy-step').find('.button-next').addClass('btn btn-primary btn-next');
        $('.stepy-step').find('.button-back').addClass('btn btn-default');

        // Initialize validation
        var validate = {
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            successClass: 'validation-valid-label',
            highlight: function(element, errorClass) {
                $(element).addClass("border-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("border-danger");
            },
            // Different components require proper error label placement
            errorPlacement: function(error, element) {
                if( $(".error").length == 0 )
                    $(".stepy-navigator").prepend(error);
            },
            rules: {
                leaveTypeName : "required",
                leaveCode : "required"
            }
        };

        $("#savePayItem").validate({
            rules: {
                payItemTitle: { required: true }
            },
            messages: {
                payItemTitle: "Please enter a Pay Item Title."
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
                        data: Aurora.WebService.serializePost("#savePayItem")
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".payItemTable").DataTable().ajax.reload( );
                            $("#payItemTitle").val("");
                            selectPayItemType( "none" );
                            $("#itemTaxGroup").multiselect("deselectAll", false);
                            $("#itemTaxGroup").multiselect("refresh");

                            swal({
                                title: $("#payItemTitle").val( ) + " has been successfully created!",
                                text: "What do you want to do next?",
                                type: 'success',
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger',
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Create Another Pay Item",
                                cancelButtonText: "Close Window",
                                reverseButtons: true
                            }, function( isConfirm ) {
                                if( isConfirm === false ) {
                                    $("#modalPayItem").modal("hide");
                                }
                                else {
                                    setTimeout(function() {
                                        $("#payItemTitle").focus( );
                                    }, 500);
                                }
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/savePayItem", data );
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-6">
        <h4>IRAS AUTO-INCLUSION SCHEME (AIS)</h4>
        File tax and submit directly to IRAS through the AUTO-INCLUSION SCHEME (AIS).
        Click <a href="#" data-toggle="modal" data-target="#modalIrasInfo">HERE</a> to understand more.
    </div>
    <div class="col-md-6">
        <div class="list-action-btns payItems-list-action-btns">
            <ul class="icons-list">
                <li>
                    <a href="<?TPLVAR_ROOT_URL?>admin/payroll/newTaxFiling" type="button" class="btn bg-purple-400 btn-labeled">
                        <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_NEW_TAX_FILING?>
                    </a>&nbsp;&nbsp;&nbsp;
                    <a href="<?TPLVAR_ROOT_URL?>admin/payroll/newAmendment" type="button" class="btn bg-purple-400 btn-labeled">
                        <b><i class="icon-file-plus2"></i></b> <?LANG_CREATE_AMENDMENT?>
                    </a>

                </li>
            </ul>
        </div>
    </div>
</div>

    <table class="table table-hover datatable tableLayoutFixed payItemTable">
        <thead>
        <tr>
            <th>Year</th>
            <th>Authorized Person</th>
            <th>Submission Type</th>
            <th>No. of Employee</th>
            <th>A8A Required</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>
<div id="modalIrasInfo" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><?LANG_WHAT_IS_AIS?></h6>
            </div>

            <div class="modal-body modal-scroll">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            Under this scheme, employers submit the employment income information of their employees to IRAS electronically.
                            The submitted information will then be automatically included in the employees' income tax assessment.
                        </div>
                        <div class="row">
                            <h4>For Who</h4>
                            <div class="divider"></div>
                            From Year of Assessment (YA) 2020, participation in AIS is compulsory for employers with 7 or more employees or
                            who have received the "Notice to File Employment Income Of Employees Electronically under the Auto-Inclusion
                            Scheme (AIS)"
                            <a target="_blank" href="https://www.iras.gov.sg/IRASHome/uploadedFiles/IRASHome/Businesses/govt%20gazette%20(from%20egovt%20website).pdf">gazetted
                            under S68(2) of the Income Tax Act</a> (344 KB).</div>

                        <div class="row">
                            <h4>LEARN ABOUT AIS</h4>
                            <div class="divider"></div>
                            <div class="row">
                                <a target="_blank" href="https://elearn.iras.gov.sg/iraslearning/web/courseware/viewCourse.aspx?cid=introtoais">Introduction to AIS for Employment Income.</a><br />
                                <a target="_blank" href="https://mytax.iras.gov.sg/ESVWeb/default.aspx?target=ESubQueryEmployerSubStatusSearch">Check if an employer is in the AIS here.</a>
                            </div>
                        </div>

                        <div class="row">
                            <h4>THINGS TO DO BEFORE SUBMISSION</h4>
                            <div class="divider"></div>
                            <div class="row">
                                <ol>
                                    <li>
                                        <strong>Register for the AIS and Authorise Staff</strong><br />
                                        <a target="_blank" href="https://www.iras.gov.sg/irashome/Businesses/Employers/Auto-Inclusion-Scheme--AIS-/Join-the-Auto-Inclusion-Scheme--AIS--for-Employment-Income/">Join the AIS for Employment Income</a><br />
                                        <a target="_blank" href="https://www.iras.gov.sg/irashome/uploadedFiles/IRASHome/Businesses/Authorisation%20Guide.pdf">Authorise staff/third party to submit (759 KB)</a><br />
                                        <a target="_blank" href="https://www.iras.gov.sg/irashome/Businesses/Employers/Auto-Inclusion-Scheme--AIS-/Sign-up-for-CPF-Data-Link-up-Service/">Sign up for CPF Data Link-up Service</a><br /><br />
                                    </li>
                                    <li>
                                        <strong>Prepare Information for Submission</strong><br />
                                        <a target="_blank" href="https://www.iras.gov.sg/irashome/Businesses/Employers/Auto-Inclusion-Scheme--AIS-/Reporting-Employee-Earnings--IR8A--Appendix-8A--Appendix-8B--IR8S-/">What information to submit</a><br />
                                        <a target="_blank" href="https://www.iras.gov.sg/irashome/Businesses/Employers/Auto-Inclusion-Scheme--AIS-/Employees-to-be-Included-in-AIS-Submission/">Employees to be Included in AIS Submission</a><br /><br />
                                    </li>
                                    <li>
                                        <strong>Inform IRAS if the Organisation Status has Changed</strong><br />
                                        AIS Employers have to inform inform IRAS and submit all outstanding employment income information to IRAS electronically.
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <h4>THINGS TO DO AFTER SUBMISSION</h4>
                            <div class="divider"></div>
                            <div class="row">
                                <strong>Inform Employees</strong><br />
                                <a target="_blank" href="https://www.iras.gov.sg/irashome/Businesses/Employers/Auto-Inclusion-Scheme--AIS-/Inform-Employees-to-File-Tax-Returns/">Inform employees to file their tax returns</a><br /><br />
                            </div>
                        </div>

                        <div class="row">
                            <h4>IMPORTANT NOTES</h4>
                            <div class="divider"></div>
                            <div class="row">
                                The submission commences on 6th Jan and the <strong style="text-decoration:underline">due date is on 1st Mar every year.</strong>
                                Employers are encouraged to <strong style="text-decoration:underline">submit by 10th Feb</strong> to avoid rushing during the peak period.
                                <strong style="text-decoration:underline">Amendment files must be submitted by 31st Mar.</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>