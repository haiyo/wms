<script>
    $(function() {
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

        $("#applied").select2({minimumResultsForSearch:Infinity});
        $("#unused").select2({minimumResultsForSearch:Infinity});
        $("#pPeriodType").select2({minimumResultsForSearch:Infinity});
        $("#cPeriodType").select2({minimumResultsForSearch:Infinity});
        $("#usedType").select2({minimumResultsForSearch:Infinity});
        $("#childBorn").select2({allowClear:true});
        $("#childAge").select2({minimumResultsForSearch:Infinity,allowClear:true});

        $(".styled").uniform({radioClass:"choice"});
        $("#designation").multiselect({
            //enableFiltering: true,
            includeSelectAllOption: true,
            dropUp : false
        });

        $("#applied").change(function( ) {
            if( $(this).val( ) == "probation" ) {
                $("#pPeriodValue").removeAttr("disabled");
                $("#pPeriodType").removeAttr("disabled");
            }
            else {
                $("#pPeriodValue").prop("disabled", true);
                $("#pPeriodType").prop("disabled", true);
            }
        });

        $("#unused").change(function( ) {
            if( $(this).val( ) == "carry" ) {
                $("#cPeriodValue").removeAttr("disabled");
                $("#cPeriodType").removeAttr("disabled");
                $("#usedValue").removeAttr("disabled");
                $("#usedType").removeAttr("disabled");
            }
            else {
                $("#cPeriodValue").prop("disabled", true);
                $("#cPeriodType").prop("disabled", true);
                $("#usedValue").prop("disabled", true);
                $("#usedType").prop("disabled", true);
            }
        });

        $("#applied").trigger("change");
        $("#unused").trigger("change");

        $(document).on("click", ".addStructure", function( ) {
            addStructure( );
            return false;
        });

        $(document).on("click", ".removeStructure", function( ) {
            var id = $(this).attr("href");
            $("#structureRowWrapper_" + id).addClass("structureRow").html("").hide();
            return false;
        });

        function addStructure( list ) {
            var length = $("#structureWrapper .structureRow").length;
            var structure = $("#structureTemplate").html( );
            structure = structure.replace(/\{id\}/g, length );
            $("#structureWrapper").append( '<div id="structureRowWrapper_' + length + '">' + structure + "</div>" );

            if( list ) {
                $("#start_" + length).val( list["start"] );
                $("#end_" + length).val( list["end"] );
                $("#days_" + length).val( list["days"] );
            }

            var id = $("#structureWrapper .structureRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeStructure" );

            setTimeout(function() {
                var structureWrapper = $("#structureWrapper");
                structureWrapper.animate({ scrollTop: structureWrapper.prop("scrollHeight")-structureWrapper.height() }, 300);
            }, 200);
        }

        $("#saveLeaveGroup").on("click", function( ) {
            var groupTitle = $.trim( $("#groupTitle").val( ) );

            if( !groupTitle ) {
                //
            }
            else {
                var lgIndex;
                var editedGroups = [];
                var existingGroup = false;
                var existingSaved = false;
                var leaveGroupsInput = $("#leaveGroups");

                // Edit existing
                if( $("#lgIndex").val( ) != "" ) {
                    lgIndex = $("#lgIndex").val( );
                    existingGroup = true;
                }
                else {
                    // Create new
                    lgIndex = $("#groupWrapper .groupRow").length;
                }

                // If there are saved groups...
                if( leaveGroupsInput.val( ) != "" ) {
                    var existingGroups = JSON.parse( leaveGroupsInput.val( ) );

                    for( var i=0; i<existingGroups.length; i++ ) {
                        if( existingGroups[i].lgIndex == lgIndex ) {
                            existingGroups[i].groupTitle = groupTitle;
                            editedGroups.push( existingGroups[i] );
                            existingSaved = true;
                            continue;
                        }
                    }
                }
                if( !existingSaved ) {
                    var leaveGroups = {
                        "lgIndex": lgIndex,
                        "lgID": $("#lgID").val( ),
                        "groupTitle": groupTitle,
                        "designations": $("#designation").val( ),
                        "structures": []
                    };

                    $("#structureWrapper .structureRow").each(function() {
                        leaveGroups.structures.push({
                            "start": $(this).find(".start").val(),
                            "end": $(this).find(".end").val(),
                            "days": $(this).find(".days").val()
                        });
                    });

                    editedGroups.push( leaveGroups );
                }

                if( !existingGroup ) {
                    var group = $("#groupTemplate").html( );
                    group = group.replace(/\{index\}/g, lgIndex );
                    group = group.replace(/\{groupTitle\}/g, groupTitle );
                    $("#groupWrapper").append( '<div id="groupRowWrapper_' + length + '">' + group + "</div>" );
                }
                else {
                    $("#groupTitle_" + lgIndex).text( groupTitle );
                }

                leaveGroupsInput.val( JSON.stringify( editedGroups ) );
                swal("Done!", $("#groupTitle").val( ) + " has been successfully created! Remember to click on Submit to save changes!", "success");
                $("#modalLeaveGroup").modal('hide');
            }
            return false;
        });

        $("#modalLeaveGroup").on("hidden.bs.modal", function() {
            $("#lgID").val(0);
            $("#lgIndex").val("");
            $("#groupTitle").val("");

            var designation = $("#designation");
            designation.multiselect("clearSelection");
            designation.multiselect("refresh");
            $("#structureWrapper").html("");
        });

        $("#modalLeaveGroup").on("shown.bs.modal", function(e) {
            $("#groupTitle").focus( );
        });

        $("#modalLeaveGroup").on("show.bs.modal", function(e) {
            var editSaved = false;
            var $invoker = $(e.relatedTarget);
            var lgID = $invoker.attr("data-id");
            var lgIndex = $invoker.attr("data-index");
            $("#lgIndex").val( lgIndex );

            if( $("#leaveGroups").val( ) != "" ) {
                var leaveGroups = JSON.parse( $("#leaveGroups").val( ) );

                for( var i=0; i<leaveGroups.length; i++ ) {
                    if( leaveGroups[i].lgIndex == lgIndex ) {
                        editSaved = true;
                        $("#groupTitle").val( leaveGroups[i]["groupTitle"] );

                        var designation = $("#designation");

                        if( leaveGroups[i].designations.length > 0 ) {
                            for( var j=0; j<leaveGroups[i].designations.length; j++ ) {
                                designation.multiselect("select", leaveGroups[i].designations[j] );
                            }
                            designation.multiselect("refresh");
                        }
                        if( leaveGroups[i].structures.length > 0 ) {
                            for( var j=0; j<leaveGroups[i].structures.length; j++ ) {
                                if( leaveGroups[i].structures[j].start != "" ||
                                    leaveGroups[i].structures[j].end != "" ||
                                    leaveGroups[i].structures[j].days != "" ) {
                                    addStructure( leaveGroups[i].structures[j] );
                                }
                            }
                        }
                    }
                }
            }
            if( !editSaved && lgID > 0 ) {
                var data = {
                    bundle: {
                        lgID: lgID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#lgID").val( obj.data.group.lgID );
                            $("#groupTitle").val( obj.data.group.title );

                            var designation = $("#designation");

                            if( obj.data.designations.length > 0 ) {
                                for( var i=0; i<obj.data.designations.length; i++ ) {
                                    designation.multiselect("select", obj.data.designations[i]["dID"] );
                                }
                                designation.multiselect("refresh");
                            }

                            if( obj.data.structure.length > 0 ) {
                                for( var i=0; i<obj.data.structure.length; i++ ) {
                                    addStructure( obj.data.structure[i] );
                                }
                            }
                            else {
                                addStructure( );
                            }
                        }
                    }
                }
                Aurora.WebService.AJAX( "admin/leave/getGroup", data );
            }
            else {
                addStructure( );
            }
        });

        function saveLeaveTypeForm( ) {
            var formData = Aurora.WebService.serializePost("#leaveTypeForm");

            var data = {
                bundle: {
                    laddaClass: ".stepy-finish",
                    data: formData
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        if( $("#userID").val( ) == 0 ) {
                            title = "New Leave Type Added  Successfully";
                            goToURL = Aurora.ROOT_URL + "admin/leave/addType";
                            backToURL = Aurora.ROOT_URL + "admin/leave/settings";
                            confirmButtonText = "Add Another Leave Type";
                            cancelButtonText = "Go to Leave Settings";
                        }
                        else {
                            title = "Leave Type Updated Successfully";
                            cancelButtonText = "Continue Editing This Leave Type";
                            goToURL = Aurora.ROOT_URL + "admin/leave/settings";
                            backToURL = Aurora.ROOT_URL + "admin/leave/editType/" + $("#ltID").val( );
                            confirmButtonText = "Go to Leave Settings";
                        }
                        swal({
                            title: title,
                            text: "What do you want to do next?",
                            type: 'success',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false,
                            showCancelButton: true,
                            confirmButtonText: confirmButtonText,
                            cancelButtonText: cancelButtonText,
                            reverseButtons: true
                        }, function( isConfirm ) {
                            if( isConfirm === false ) {
                                window.location.href = backToURL;
                            }
                            else {
                                window.location.href = goToURL;
                            }
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/saveType", data );
        }

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
        }
    });
</script>


<div class="d-md-flex">
    <div class="sidebar sidebar-light sidebar-component sidebar-component-left sidebar-expand-md">
        <div class="sidebar-content">
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="text-uppercase font-size-sm font-weight-semibold">Annual Leave</span>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="media-list">
                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon">
                                    <i class="icon-git-pull-request"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                You are entitled to paid annual leave if you meet the following conditions:

                                You are covered under Part IV of the Employment Act.
                                You have worked for your employer for at least 3 months.
                                <div class="text-muted font-size-sm">4 minutes ago</div>
                            </div>
                        </li>

                        <li class="media">
                            <div class="mr-3">
                                <a href="#" class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon">
                                    <i class="icon-git-commit"></i>
                                </a>
                            </div>

                            <div class="media-body">
                                Your annual leave entitlement depends on how many years of service you have with your employer.
                                Your year of service begins from the day you start work with your employer.
                                <div class="text-muted font-size-sm">36 minutes ago</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-flat">
        <div class="panel-body">

            <div class="content-wrapper side-content-wrapper rp">
                <form id="leaveTypeForm" class="stepy" action="#">
                    <input type="hidden" id="ltID" name="ltID" value="<?TPLVAR_LEAVE_TYPE_ID?>" />
                    <?TPL_FORM?>
                    <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
                        <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>