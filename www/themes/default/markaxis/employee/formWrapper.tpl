
<script>
    $(function() {

        $("#addMoreContact").click(function (e) {
            $econtactRow = $(".econtact-row:last");
            $econtactRow.find("select").select2("destroy");

            var rowCount = $(".econtact-row").length;
            var $clone = $econtactRow.clone( )
                $clone.appendTo("#econtact").find(".econtact-count").text( rowCount+1 );

            $clone.find("input, select").each(function( ) {
                var attrName = $(this).attr("name");
                attrName = attrName.replace( /.$/, rowCount );

                $(this).attr( "id", attrName ).attr( "name", attrName );
                $(this).val("");
            });

            $("#econtact").find("select").select2( );
            $clone.find(":input:first").focus( );
            return false;
        });


        $("#addMoreEdu").click(function (e) {
            var added  = false;
            var index  = $("#eduEdit").val( ) != "" ? $("#eduEdit").val( ) : $(".education").length;
            var hidden = '<div id="education_' + index + '" class="education">';
            var school = "";
            var level = "";
            var fromMonth = "";
            var fromYear = "";
            var toMonth = "";
            var toYear = "";
            var certificate = "";

            $("#education").find(":input:not([type=hidden]):not([class=file-caption-name]), select").each(function( ) {
                if( $(this).attr("name") == "eduSchool" ) {
                    if( !$(this).val( ) ) return false;
                    school = $(this).val( );
                }
                if( $(this).attr("name") == "eduLevel" ) {
                    level = $(this).val( );
                }
                if( $(this).attr("name") == "eduFromMonth" ) {
                    fromMonth = $(this).find('option:selected').text();
                }
                if( $(this).attr("name") == "eduFromYear" ) {
                    fromYear = $(this).val( );
                }
                if( $(this).attr("name") == "eduToMonth" ) {
                    toMonth = $(this).find('option:selected').text();
                }
                if( $(this).attr("name") == "eduToYear" ) {
                    toYear = $(this).val( );
                }
                if( $(this).attr("name") == "eduCertificate" ) {
                    certificate = $(this).val( );
                }

                if( $(this).attr("name") != undefined ) {
                    var value = $(this).attr("name") == "eduCertificate" ? $("#eduUID").val( ) : $(this).val( );

                    hidden += '<input type="hidden" id="' + $(this).attr("name") + '_' + index + '" ' +
                              'name="' + $(this).attr("name") + '_' + index + '" value="' + value + '" />';
                }

                $(this).val("");

                if( $(this).hasClass("select") ) {
                    $(this).val("").trigger("change");
                }
                added = true;
            });

            if( added ) {
                hidden += '<input type="hidden" id="eduID_' + index + '" name="eduID_' + index + '" value="' + $("#eduID").val() + '" />';

                var showFile = 'none';

                if( $("#eduHashName").val( ) ) {
                    showFile = '';
                    hidden += '<input type="hidden" id="eduHashName_' + index + '" name="eduHashName_' + index + '" value="' + $("#eduHashName").val() + '" />';
                }

                hidden += '<div class="col-md-4">' +
                            '<div class="card">' +
                                '<div class="card-body">' +
                                    '<div class="media">' +
                                    '<div id="eduFileIcoWrapper_' + index + '" class="mr-3" style="color:inherit;display:' + showFile + '">' +
                                    '<a id="eduFileIco_' + index + '" href="' + Aurora.ROOT_URL + 'admin/file/view/' + $("#eduUID").val() + '/' + $("#eduHashName").val() + '" ' +
                                    'title="' + certificate + '" target="_blank">' +
                                    '<i class="icon-file-text2 text-success-400 icon-2x mt-1"></i></a>' +
                                '</div>' +
                            '<div class="media-body">' +
                            '<h6 class="media-title font-weight-semibold"><a href="#" class="text-default">' + school + '</a></h6>' + level +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="card-footer d-flex justify-content-between" style="display: flex!important;">' +
                            '<span class="text-muted">' + fromMonth + ' ' + fromYear + ' - ' + toMonth + ' ' + toYear +
                            '</span>' +
                            '<span class="text-muted ml-2">' +
                            '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item eduEdit" data-id="' + index + '"><i class="icon-pencil5"></i> Edit School</a>' +
                            '<a class="dropdown-item eduDelete" data-title="' + school + '" data-id="' + index + '" data-edu-id="' + $("#eduID").val() + '">' +
                            '<i class="icon-bin"></i> Delete School</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                if( $("#eduEdit").val( ) !== "" ) {
                    $( "#education_" + $("#eduEdit").val( ) ).replaceWith( hidden );
                    $("#addMoreEdu").html( 'Add Education <i class="icon-arrow-right14 ml-2">' );
                    $("#eduEdit").val("");
                    $("#eduIndex").val("");
                    $("#eduIDModal").val("");
                    $("#eduHashName").val("");
                }
                else {
                    $("#eduList").append( hidden );
                }
            }
            return false;
        });

        $(document).on( "click", ".needInfo", function ( ) {
            var id = $(this).attr("data-id");

            if( $(this).val( ) == 1 ) {
                $("#infoWrapper_" + id).removeClass("hide")
                $("#info_" + id).focus( );
            }
            else {
                $("#infoWrapper_" + id).addClass("hide");
            }
        });

        $(document).on( "click", ".eduEdit", function ( ) {
            var index = $(this).attr("data-id");

            $("#eduID").val( $("#eduID_" + index).val( ) );
            $("#eduIDModal").val( $("#eduID_" + index).val( ) );
            $("#eduSchool").val( $("#eduSchool_" + index).val( ) );
            $("#eduLevel").val( $("#eduLevel_" + index).val( ) );
            $("#eduCountry").val( $("#eduCountry_" + index).val( ) ).trigger("change");
            $("#eduFromMonth").val( $("#eduFromMonth_" + index).val( ) ).trigger("change");
            $("#eduFromYear").val( $("#eduFromYear_" + index).val( ) );
            $("#eduToMonth").val( $("#eduToMonth_" + index).val( ) ).trigger("change");
            $("#eduToYear").val( $("#eduToYear_" + index).val( ) );
            $("#eduSpecialize").val( $("#eduSpecialize_" + index).val( ) );
            $("#eduCertificate").val( $("#eduFileName_" + index).val( ) );
            $("#addMoreEdu").html( 'Update Education <i class="icon-arrow-right14 ml-2">' );
            $("#eduEdit").val( index );
            $("#eduIndex").val( index );
        });

        $(document).on( "click", ".eduDelete", function ( ) {
            var index = $(this).attr("data-id");
            var eduID = $(this).attr("data-edu-id");
            var school = $(this).attr("data-title");

            swal({
                title: "Delete " + school + " from Education?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                if( eduID == "" ) {
                    $("#education_" + index).fadeOut( "slow", function() {
                        $(this).remove( );

                        // If Editing mode for this Education but user Delete, then reset form.
                        if( index == $("#eduEdit").val( ) ) {
                            $("#eduEdit").val("");
                            $("#education").find(":input:not([type=hidden]), select").each(function( ) {
                                $(this).val("");

                                if( $(this).hasClass("select") ) {
                                    $(this).val("").trigger("change");
                                }
                            });
                        }
                    });
                }
                else {
                    var data = {
                        bundle: {
                            eduID: eduID
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                swal( school + " Deleted!", "", "success" );

                                $("#education_" + index).fadeOut( "slow", function() {
                                    $(this).remove( );

                                    // If Editing mode for this Education but user Delete, then reset form.
                                    if( index == $("#eduEdit").val( ) ) {
                                        $("#eduEdit").val("");
                                        $("#education").find(":input:not([type=hidden]), select").each(function( ) {
                                            $(this).val("");

                                            if( $(this).hasClass("select") ) {
                                                $(this).val("").trigger("change");
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/deleteEducation", data );
                }
            });
        });

        $("#addMoreExp").click(function (e) {
            var added   = false;
            var index   = $("#expEdit").val( ) != "" ? $("#expEdit").val( ) : $(".experience").length;
            var hidden  = '<div id="experience_' + index + '" class="experience">';
            var company = "";
            var designation = "";
            var description = "";
            var fromMonth = "";
            var fromYear = "";
            var toMonth = "";
            var toYear = "";
            var testimonial = "";

            $("#experience").find(":input:not([type=hidden]), select, textarea").each(function( ) {
                if( $(this).attr("name") == "expCompany" ) {
                    if( !$(this).val( ) ) return false;
                    company = $(this).val( );
                }
                if( $(this).attr("name") == "expDesignation" ) {
                    designation = $(this).val( );
                }
                if( $(this).attr("name") == "expDescription" ) {
                    description = $(this).val( );
                }
                if( $(this).attr("name") == "expFromMonth" ) {
                    fromMonth = $(this).find('option:selected').text();
                }
                if( $(this).attr("name") == "expFromYear" ) {
                    fromYear = $(this).val( );
                }
                if( $(this).attr("name") == "expToMonth" ) {
                    toMonth = $(this).find('option:selected').text();
                }
                if( $(this).attr("name") == "expToYear" ) {
                    toYear = $(this).val( );
                }

                if( $(this).attr("name") == "expTestimonial" ) {
                    testimonial = $(this).val( );
                }

                if( $(this).attr("name") != undefined ) {
                    var value = $(this).attr("name") == "expTestimonial" ? $("#expUID").val( ) : $(this).val( );

                    hidden += '<input type="hidden" id="' + $(this).attr("name") + '_' + index + '" ' +
                                'name="' + $(this).attr("name") + '_' + index + '" value="' + value + '" />';
                }

                $(this).val("");

                if( $(this).hasClass("select") ) {
                    $(this).val("").trigger("change");
                }
                added = true;
            });

            if( added ) {
                hidden += '<input type="hidden" id="expID_' + index + '" name="expID_' + index + '" value="' + $("#expID").val() + '" />';

                var showFile = 'none';

                if( $("#expHashName").val( ) ) {
                    showFile = '';
                    hidden += '<input type="hidden" id="expHashName_' + index + '" name="expHashName_' + index + '" value="' + $("#expHashName").val() + '" />';
                }

                hidden += '<div class="col-md-4">' +
                            '<div class="card">' +
                            '<div class="card-body">' +
                                '<div class="media">' +
                                    '<div id="expFileIcoWrapper_' + index + '" class="mr-3" style="color:inherit;display:' + showFile + '">' +
                                    '<a id="expFileIco_' + index + '" href="' + Aurora.ROOT_URL + 'admin/file/view/' + $("#expUID").val() + '/' + $("#expHashName").val() + '" ' +
                                    'title="' + testimonial + '" target="_blank">' +
                                    '<i class="icon-file-text2 text-success-400 icon-2x mt-1"></i></a>' +
                                '</div>' +
                            '<div class="media-body">' +
                            '<h6 class="media-title font-weight-semibold"><a href="#" class="text-default">' + company + '</a></h6>' + designation +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="card-footer d-flex justify-content-between" style="display: flex!important;">' +
                            '<span class="text-muted">' + fromMonth + ' ' + fromYear + ' - ' + toMonth + ' ' + toYear + '</span>' +
                            '<span class="text-muted ml-2">' +
                            '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item expEdit" data-id="' + index + '"><i class="icon-pencil5"></i> Edit Company</a>' +
                            '<a class="dropdown-item expDelete" data-title="' + company + '" data-id="' + index + '" data-exp-id="' + $("#expID").val() + '">' +
                            '<i class="icon-bin"></i> Delete Company</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                if( $("#expEdit").val( ) !== "" ) {
                    $( "#experience_" + $("#expEdit").val( ) ).replaceWith( hidden );
                    $("#addMoreExp").html( 'Add Experience <i class="icon-arrow-right14 ml-2">' );
                    $("#expEdit").val("");
                    $("#expIndex").val("");
                    $("#expIDModal").val("");
                    $("#expHashName").val("");
                }
                else {
                    $("#expList").append( hidden );
                }
            }
            return false;
        });

        $(document).on( "click", ".expEdit", function ( ) {
            var index = $(this).attr("data-id");

            $("#expID").val( $("#expID_" + index).val( ) );
            $("#expIDModal").val( $("#expID_" + index).val( ) );
            $("#expCompany").val( $("#expCompany_" + index).val( ) );
            $("#expPosition").val( $("#expPosition_" + index).val( ) );
            $("#expDescription").val( $("#expDescription_" + index).val( ) ).trigger("change");
            $("#expFromMonth").val( $("#expFromMonth_" + index).val( ) ).trigger("change");
            $("#expFromYear").val( $("#expFromYear_" + index).val( ) );
            $("#expToMonth").val( $("#expToMonth_" + index).val( ) ).trigger("change");
            $("#expToYear").val( $("#expToYear_" + index).val( ) );
            $("#expTestimonial").val( $("#expFileName_" + index).val( ) );
            $("#addMoreExp").html( 'Update Experience <i class="icon-arrow-right14 ml-2">' );
            $("#expEdit").val( index );
            $("#expIndex").val( index );
        });

        $(document).on( "click", ".expDelete", function ( ) {
            var index = $(this).attr("data-id");
            var expID = $(this).attr("data-exp-id");
            var company = $(this).attr("data-title");

            swal({
                title: "Delete " + company + " from Experience?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: true,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                if( expID == "" ) {
                    $("#experience_" + index).fadeOut( "slow", function() {
                        $(this).remove( );

                        // If Editing mode for this Experience but user Delete, then reset form.
                        if( index == $("#expEdit").val( ) ) {
                            $("#expEdit").val("");
                            $("#experience").find(":input:not([type=hidden]), select").each(function( ) {
                                $(this).val("");

                                if( $(this).hasClass("select") ) {
                                    $(this).val("").trigger("change");
                                }
                            });
                        }
                    });
                }
                else {
                    var data = {
                        bundle: {
                            expID: expID
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                swal( company + " Deleted!", "", "success" );

                                $("#experience_" + index).fadeOut( "slow", function() {
                                    $(this).remove( );

                                    // If Editing mode for this Experience but user Delete, then reset form.
                                    if( index == $("#expEdit").val( ) ) {
                                        $("#expEdit").val("");
                                        $("#experience").find(":input:not([type=hidden]), select").each(function( ) {
                                            $(this).val("");

                                            if( $(this).hasClass("select") ) {
                                                $(this).val("").trigger("change");
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/deleteExperience", data );
                }
            });
        });

        $(".form-check-input-styled").uniform();

        // Modal template
        var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
            '    </div>\n' +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>\n';

        // Buttons inside zoom modal
        var previewZoomButtonClasses = {
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        var previewZoomButtonIcons = {
            prev: '<i class="icon-arrow-left32"></i>',
            next: '<i class="icon-arrow-right32"></i>',
            toggleheader: '<i class="icon-menu-open"></i>',
            fullscreen: '<i class="icon-screen-full"></i>',
            borderless: '<i class="icon-alignment-unalign"></i>',
            close: '<i class="icon-cross2 font-size-base"></i>'
        };

        // File actions
        var fileActionSettings = {
            removeIcon: '<i class="icon-bin"></i>',
            uploadIcon: '<i class="icon-upload"></i>',
            uploadClass: '',
            zoomIcon: '<i class="icon-zoomin3"></i>',
            zoomClass: '',
            indicatorNew: '<i class="icon-file-plus text-success"></i>',
            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
            indicatorError: '<i class="icon-cross2 text-danger"></i>',
            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>',
        };

        var previewSettings = {
            pdf: {width: "400px", height: "290px"},
            image: {width: "400px", height: "290px"},
            object: {width: "400px", height: "290px"},
            other: {width: "400px", height: "290px"}
        };

        var uploadedFile = false;

        $(".eduFileInput").fileinput({
            browseLabel: 'Browse',
            uploadUrl: Aurora.ROOT_URL + "admin/employee/uploadCertificate",
            uploadAsync: false,
            maxFileCount: 1,
            initialPreview: [],
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            fileActionSettings: fileActionSettings,
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            initialCaption: 'No file selected',
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            allowedFileExtensions: ['pdf', 'doc', 'docx'],
            previewSettings: previewSettings
        }).on('fileuploaderror', function(event, data, msg) {
            console.log('File uploaded', data.previewId, data.index, data.fileId, msg);
        }).on('filebatchuploadsuccess', function(event, data) {
            console.log(data)
            uploadedFile = data.response;
        });

        $("#eduSaveUploaded").on("click", function( ) {
            if( uploadedFile ) {
                var index = $("#eduIndex").val( );

                // Upload via Menu
                if( index ) {
                    $("#eduCertificate_" + index).val( uploadedFile.uID );
                    $("#eduFileName_" + index).val( uploadedFile.name );
                    $("#eduHashName_" + index).val( uploadedFile.hashName );
                    $("#eduFileIcoWrapper_" + index).show( );
                    $("#eduFileIco_" + index).attr("title", uploadedFile.name);
                    $("#eduFileIco_" + index).attr("href", Aurora.ROOT_URL + 'admin/file/view/' + uploadedFile.uID + '/' + uploadedFile.hashName);
                    $("#eduUploadCert_" + index).hide( );
                    $("#eduDeleteCert_" + index).show( );
                    $("#eduDeleteCert_" + index).attr("data-uid", uploadedFile.uID)
                                                .attr("data-hashname", uploadedFile.hashName)
                                                .attr("data-filename", uploadedFile.name);

                    if( $("#eduIDModal").val( ) ) {
                        var data = {
                            bundle: {
                                eduID: $("#eduIDModal").val( ),
                                uID: uploadedFile.uID,
                                hashName: uploadedFile.hashName
                            },
                            success: function( res ) {
                                if( $("#eduEdit").val( ) ) {
                                    $("#eduCertificate").val( uploadedFile.name );
                                    $("#eduUID").val( uploadedFile.uID );
                                    $("#eduHashName").val( uploadedFile.hashName );
                                }

                                uploadedFile = false;
                                $(".fileinput-remove").click( );
                                $("#uploadEduModal").modal("hide");
                            }
                        };
                        Aurora.WebService.AJAX( "admin/employee/updateCertificate", data );
                    }
                }
                else {
                    // New Upload
                    $("#eduUID").val( uploadedFile.uID );
                    $("#eduCertificate").val( uploadedFile.name );
                    $("#eduHashName").val( uploadedFile.hashName );

                    uploadedFile = false;
                    $(".fileinput-remove").click( );
                    $("#uploadEduModal").modal("hide");
                }
            }
        });

        // Via Menu
        $(".eduUploadCert").on("click", function( ) {
            $("#eduIndex").val( $(this).attr("data-index") );
            $("#eduIDModal").val( $(this).attr("data-edu-id") );
        });

        $(".eduDeleteCert").on("click", function( ) {
            var index = $(this).attr("data-index");
            var eduID = $(this).attr("data-edu-id");
            var uID = $(this).attr("data-uid");
            var hashName = $(this).attr("data-hashname");
            var fileName = $(this).attr("data-filename");

            title = "Are you sure you want to delete " + fileName + "?";
            text  = "File(s) deleted will not be able to recover back.";
            confirmButtonText = "Confirm Delete";

            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        eduID : eduID,
                        uID : uID,
                        hashName: hashName
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#eduUploadCert_" + index).show( );
                            $("#eduDeleteCert_" + index).hide( );
                            $("#eduFileIcoWrapper_" + index).hide( );
                            swal("Done!", fileName + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/deleteCertificate", data );
            });
        });


        $(".expFileInput").fileinput({
            browseLabel: 'Browse',
            uploadUrl: Aurora.ROOT_URL + "admin/employee/uploadTestimonial",
            uploadAsync: false,
            maxFileCount: 1,
            initialPreview: [],
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            fileActionSettings: fileActionSettings,
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            initialCaption: 'No file selected',
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            allowedFileExtensions: ['pdf', 'doc', 'docx'],
            previewSettings: previewSettings
        }).on('filebatchuploadsuccess', function(event, data) {
            uploadedFile = data.response;
            $("#saveExpUpload").show( );
        });

        $("#expSaveUploaded").on("click", function( ) {
            if( uploadedFile ) {
                var index = $("#expIndex").val( );

                // Upload via Menu
                if( index ) {
                    $("#expTestimonial_" + index).val( uploadedFile.uID );
                    $("#expFileName_" + index).val( uploadedFile.name );
                    $("#expHashName_" + index).val( uploadedFile.hashName );
                    $("#expFileIcoWrapper_" + index).show( );
                    $("#expFileIco_" + index).attr("title", uploadedFile.name);
                    $("#expFileIco_" + index).attr("href", Aurora.ROOT_URL + 'admin/file/view/' + uploadedFile.uID + '/' + uploadedFile.hashName);
                    $("#expUploadTest_" + index).hide( );
                    $("#expDeleteTest_" + index).show( );
                    $("#expDeleteTest_" + index).attr("data-uid", uploadedFile.uID)
                                                .attr("data-hashname", uploadedFile.hashName)
                                                .attr("data-filename", uploadedFile.name);

                    if( $("#expIDModal").val( ) ) {
                        var data = {
                            bundle: {
                                expID: $("#expIDModal").val( ),
                                uID: uploadedFile.uID,
                                hashName: uploadedFile.hashName
                            },
                            success: function( res ) {
                                if( $("#expEdit").val( ) ) {
                                    $("#expTestimonial").val( uploadedFile.name );
                                    $("#expUID").val( uploadedFile.uID );
                                    $("#expHashName").val( uploadedFile.hashName );
                                }

                                uploadedFile = false;
                                $(".fileinput-remove").click( );
                                $("#uploadExpModal").modal("hide");
                                $("#saveExpUpload").hide( );
                            }
                        };
                        Aurora.WebService.AJAX( "admin/employee/updateTestimonial", data );
                    }
                }
                else {
                    // New Upload
                    $("#expUID").val( uploadedFile.uID );
                    $("#expTestimonial").val( uploadedFile.name );
                    $("#expHashName").val( uploadedFile.hashName );

                    uploadedFile = false;
                    $(".fileinput-remove").click( );
                    $("#uploadExpModal").modal("hide");
                    $("#saveExpUpload").hide( );
                }
            }
        });

        // Via Menu
        $(".expUploadTest").on("click", function( ) {
            $("#expIndex").val( $(this).attr("data-index") );
            $("#expIDModal").val( $(this).attr("data-exp-id") );
        });

        $(".expDeleteTest").on("click", function( ) {
            var index = $(this).attr("data-index");
            var expID = $(this).attr("data-exp-id");
            var uID = $(this).attr("data-uid");
            var hashName = $(this).attr("data-hashname");
            var fileName = $(this).attr("data-filename");

            title = "Are you sure you want to delete " + fileName + "?";
            text  = "File(s) deleted will not be able to recover back.";
            confirmButtonText = "Confirm Delete";

            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        expID : expID,
                        uID : uID,
                        hashName: hashName
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $("#expUploadTest_" + index).show( );
                            $("#expDeleteTest_" + index).hide( );
                            $("#expFileIcoWrapper_" + index).hide( );
                            swal("Done!", fileName + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/deleteTestimonial", data );
            });
        });

        $(".deletePhoto").on("click", function( ) {
            title = "Are you sure you want to delete " + $("#employeeName").text() + "'s photo?";
            text  = "Photo deleted will not be able to recover back.";
            confirmButtonText = "Confirm Delete";

            swal({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                $(".icon-bin").removeClass("icon-bin").addClass("icon-spinner2 spinner");

                var data = {
                    bundle: {
                        userID : $("#userID").val( )
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal("error", obj.errMsg);
                            return;
                        }
                        else {
                            $(".photo-wrap").remove( );
                            $(".defPhoto img").removeClass("hide");
                            swal("Done!", $("#employeeName").text() + "'s photo has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/employee/deletePhoto", data );
            });
        });

        /*$("#thumb").on("click", function( ev ) {
            $uploadCrop.croppie('result', {
                type: "canvas",
                size: "viewport"
            }).then(function (resp) {
                popupResult({
                    src: resp
                });
            });
        });*/

        $(".upload-cancel").on("click", function( ev ) {
            $(".upload-demo-wrap").removeClass('ready');
            $(".caption").removeClass("mt-30");
            $uploadCrop.croppie("destroy");

            $uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 290,
                    height: 290,
                    type: "circle"
                },
                enableExif: true
            });
            return false;
        });
    });
</script>

<div class="sidebar sidebar-secondary sidebar-default">
    <div class="sidebar-content profile-content">

        <!-- Sidebar search -->
        <div class="sidebar-category">

            <div class="thumbnail no-padding">
                <div id="thumb" class="thumb">
                    <div class="defPhoto">
                        <img src="<?TPLVAR_ROOT_URL?>themes/default/assets/images/silhouette.png" class="<?TPLVAR_DEF_PHOTO?>" />
                    </div>
                    <div class="caption-overflow">
                                <span>
                                    <a href="" class="btn bg-success-400 btn-icon btn-xs file-btn">
                                        <i class="icon-plus2"></i>
                                        <input type="file" id="upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </span>
                    </div>
                    <!-- BEGIN DYNAMIC BLOCK: photo -->
                    <div class="photo-wrap">
                        <div class="photo">
                            <a href="#" class="deletePhoto"><i class="icon-bin"></i></a>
                            <img src="<?TPLVAR_PHOTO?>" />
                        </div>
                    </div>
                    <!-- END DYNAMIC BLOCK: photo -->
                    <div class="upload-demo-wrap">
                        <a href="#" class="upload-cancel">&times;</a>
                        <div id="upload-demo">
                        </div>
                    </div>
                </div>

                <div class="caption text-center">
                    <h5 class="text-semibold no-margin">
                        <!-- BEGIN DYNAMIC BLOCK: name -->
                        <span id="employeeName"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></span>
                        <!-- END DYNAMIC BLOCK: name -->
                        <!-- BEGIN DYNAMIC BLOCK: designation -->
                        <small class="display-block"><?TPLVAR_DESIGNATION?></small></h5>
                    <!-- END DYNAMIC BLOCK: designation -->
                </div>

                <div class="text-center">
                    <!-- BEGIN DYNAMIC BLOCK: phone -->
                    <p><i class="icon-phone2"></i> <?TPLVAR_PHONE?></p>
                    <!-- END DYNAMIC BLOCK: phone -->
                    <!-- BEGIN DYNAMIC BLOCK: mobile -->
                    <p><i class="icon-mobile"></i> <?TPLVAR_MOBILE?></p>
                    <!-- END DYNAMIC BLOCK: mobile -->
                    <!-- BEGIN DYNAMIC BLOCK: email -->
                    <p><i class="icon-mail5"></i> <?TPLVAR_EMAIL?></p>
                    <!-- END DYNAMIC BLOCK: email -->
                </div>
            </div>

        </div>
        <!-- /sidebar search -->

    </div>
</div>


<div class="side-content-wrapper rp">
    <form id="employeeForm" class="stepy" action="#">
        <input type="hidden" id="userID" name="userID" value="<?TPLVAR_USERID?>" />
        <?TPL_FORM?>
        <button type="button" class="btn bg-purple-400 stepy-finish btn-ladda" data-style="slide-right">
            <span class="ladda-label">Submit <i class="icon-check position-right"></i></span>
        </button>
    </form>
</div>