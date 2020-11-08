/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: employeeForm.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisEmployeeForm = (function( ) {


    /**
     * MarkaxisEmployeeForm Constructor
     * @return void
     */
    MarkaxisEmployeeForm = function( ) {
        this.markaxisUSuggest   = new MarkaxisUSuggest({includeOwn:true});
        this.markaxisCompetency = new MarkaxisCompetency({includeOwn:true});
        this.uploadCrop = false;
        this.init( );
    };

    MarkaxisEmployeeForm.prototype = {
        constructor: MarkaxisEmployeeForm,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            // Override defaults
            $.fn.stepy.defaults.legend = false;
            $.fn.stepy.defaults.transition = 'fade';
            $.fn.stepy.defaults.duration = 150;
            $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> ' + Aurora.i18n.GlobalRes.LANG_BACK;
            $.fn.stepy.defaults.nextLabel = Aurora.i18n.GlobalRes.LANG_NEXT + ' <i class="icon-arrow-right14 position-right"></i>';

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
                        that.saveEmployeeForm( );
                        return false;
                    }
                }
            });

            $.validator.addMethod("validChildren", function(value, element) {
                if( $("#children1").is(":checked") ) {
                    var error = false;

                    if( $("#haveChildren .childName").length > 0 ) {
                        $("#haveChildren .childRow").each(function( ) {
                            if( $.trim( $(this).find(".childName").val( ) ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childCountry").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childDobDay").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $(this).find(".childDobMonth").val( ) == "" ) {
                                error = true;
                                return false;
                            }
                            if( $.trim( $(this).find(".childDobYear").val( ) ) == "" ) {
                                error = true;
                                return false;
                            }
                        });
                    }
                    if( !error )
                    return true;
                }
                else
                return true;

            }, Markaxis.i18n.EmployeeRes.LANG_ENTER_VALID_CHILD);


            $.validator.addMethod("validEmail", function(value, element) {
                if( value == '' ) return true;

                var ind  = value.indexOf('@');
                var str2 = value.substr(ind+1);
                var str3 = str2.substr(0,str2.indexOf('.'));
                if( str3.lastIndexOf('-') === (str3.length-1) ||
                    (str3.indexOf('-') !== str3.lastIndexOf('-')) )
                    return false;

                var str1 = value.substr(0,ind );
                if( (str1.lastIndexOf('_') === (str1.length-1)) ||
                    (str1.lastIndexOf('.') === (str1.length-1)) ||
                    (str1.lastIndexOf('-') === (str1.length-1)) )
                    return false;
                str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
                temp1 = str.test(value);
                return temp1;
            }, Markaxis.i18n.EmployeeRes.LANG_ENTER_VALID_EMAIL);

            // Initialize validation
            var validate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.addClass("border-danger");
                    }
                    else {
                        $(element).addClass("border-danger");
                    }
                    if( $(element).attr("type") == "radio" ) {
                        $(element).parent().addClass("border-danger");
                    }
                },
                unhighlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.removeClass("border-danger");
                    }
                    else {
                        $(element).removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    $(".stepy-navigator .error").remove( );
                    $(".stepy-navigator").prepend(error);
                },
                rules: {
                    fname : "required",
                    lname : "required",
                    gender : "required",
                    dobMonth: "required",
                    dobDay: "required",
                    dobYear: "required",
                    race: "required",
                    idnumber : "required",
                    office: "required",
                    pcID: "required",
                    email: {
                        validEmail: true,
                        required: true
                    },
                    children: {
                        validChildren: true
                    },
                    startMonth: "required",
                    startDay: "required",
                    startYear: "required",
                }
            };

            // Apply "Back" and "Next" button styling
            var stepy = $(".stepy-step");
            stepy.find(".button-next").addClass("btn btn-primary btn-next");
            stepy.find(".button-back").addClass("btn btn-default");

            $("#dobMonth").select2({minimumResultsForSearch: -1});
            $("#dobDay").select2({minimumResultsForSearch: -1});
            $("#idType").select2({minimumResultsForSearch: -1});
            $("#nationality").select2( );
            $("#country").select2( );
            $("#state").select2( );
            $("#city").select2( );
            $("#designation").select2( );
            $("#currency").select2( );
            $("#confirmMonth").select2( );
            $("#confirmDay").select2( );
            $("#startMonth").select2( );
            $("#startDay").select2( );
            $("#endMonth").select2( );
            $("#endDay").select2( );
            $("#passType").select2({allowClear:true});
            $("#passExpiryMonth").select2( );
            $("#passExpiryDay").select2( );
            $("#eduCountry").select2( );
            $("#eduFromMonth").select2( );
            $("#eduToMonth").select2( );
            $("#expFromMonth").select2( );
            $("#expToMonth").select2( );
            $("#recruitSource").select2( );
            $(".relationship").select2( );
            $("#language").select2({minimumResultsForSearch: -1});
            $(".raceList").select2({minimumResultsForSearch: -1});
            $(".maritalList").select2({minimumResultsForSearch: -1});
            $(".salaryTypeList").select2({minimumResultsForSearch: -1});
            $(".paymentMethodList").select2({minimumResultsForSearch: -1});
            $("#pcID").select2({minimumResultsForSearch: -1});
            $("#department").multiselect({includeSelectAllOption: true});
            $("#tgID").multiselect({includeSelectAllOption: true});
            $("#ltID").multiselect({includeSelectAllOption: true});

            if( $("#userID").val( ) != 0 ) {
                this.getUserManager( );
                this.getCompetency( );
            }

            $("#office").on("change", function( ) {
                that.setOfficePreference( $(this).val( ) );
            });

            $("#department").on("change", function( ) {
                that.suggestDeptManager( );
            });

            $(".styled").uniform({
                radioClass: 'choice'
            });

            $(".file-styled").uniform({
                fileButtonClass: 'action btn bg-blue'
            });

            $("#autoGenPwd").on("click", function ( ) {
                that.autoGenPwd();
                return false;
            });

            $("#showPwd").on("click", function() {
                if( $("#loginPassword").attr("type") == "text" ) {
                    $("#loginPassword").attr("type", "password");
                }
                else {
                    $("#loginPassword").attr("type", "text");
                }
            });

            // Editing with existing children
            if( $("#children1").is(":checked") ) {
                $("#haveChildren").removeClass("hide");
            }

            $('input:radio[name="children"]').change(function( ) {
                if( $(this).val( ) == 1 ) {
                    $("#haveChildren").removeClass("hide");

                    if( $("#childWrapper .childRow").length == 0 ) {
                        that.addChildren();
                    }
                }
                else {
                    if( !$("#haveChildren").hasClass("hide") ) {
                        $("#haveChildren").addClass("hide");
                    }
                }
            });

            if( $(".childRow").length > 0 ) {
                $(".childSelect").select2( );
                //that.addChildren( );
            }

            $(document).on("click", ".addChildren", function ( ) {
                that.addChildren( );
                return false;
            });

            $(document).on("click", ".removeChildren", function ( ) {
                var id = $(this).attr("href");
                $("#childRowWrapper_" + id).html("").hide();

                if( $("#childWrapper .childRow").length == 0 ) {
                    $("#children2").click( );
                    $.uniform.update( );
                }
                return false;
            });

            $("#loginPassword").keypress(function(e) {
                var s = String.fromCharCode( e.which );

                if((s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey) ||
                    (s.toUpperCase() !== s && s.toLowerCase() === s && e.shiftKey)) {
                    $("#capsLockWarn").removeClass("hide");
                }
                else {
                    $("#capsLockWarn").addClass("hide");
                }
            });

            this.uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 306,
                    height: 306,
                    //type: "circle"
                },
                enableExif: true
            });
            $("#upload").on("change", function( ) { that.readFile(this); });

            /*==============================================================*/

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
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>' +
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
                        '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>' +
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
                                    swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
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
                browseLabel: Aurora.i18n.GlobalRes.LANG_BROWSE,
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
                initialCaption: Aurora.i18n.GlobalRes.LANG_NO_FILE_SELECTED,
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

                title = Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', fileName);
                text  = Aurora.i18n.GlobalRes.LANG_FILE_DELETED_UNDONE;
                confirmButtonText = Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE;

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
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', fileName), "success");
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

                title = Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', fileName);
                text  = Aurora.i18n.GlobalRes.LANG_FILE_DELETED_UNDONE;
                confirmButtonText = Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE;

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
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#expUploadTest_" + index).show( );
                                $("#expDeleteTest_" + index).hide( );
                                $("#expFileIcoWrapper_" + index).hide( );
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', fileName), "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/deleteTestimonial", data );
                });
            });

            $(".deletePhoto").on("click", function( ) {
                title = Markaxis.i18n.EmployeeRes.LANG_CONFIRM_DELETE_PHOTO.replace('{name}', $("#employeeName").text());
                text  = Markaxis.i18n.EmployeeRes.LANG_PHOTO_DELETED_UNDONE;
                confirmButtonText = Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE;

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
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $(".photo-wrap").remove( );
                                $(".defPhoto").removeClass("hide");
                                swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Markaxis.i18n.EmployeeRes.LANG_PHOTO_SUCCESSFULLY_DELETED.replace('{name}', $("#employeeName").text()), "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/user/deletePhoto", data );
                });
            });

            $(".upload-cancel").on("click", function( ev ) {
                $(".upload-demo-wrap").removeClass('ready');
                $(".caption").removeClass("mt-30");
                $("#upload").val("");

                that.uploadCrop.croppie('bind', {
                    url : ''
                }).then(function () {
                    console.log('reset complete');
                });
                return false;
            });
        },

        addChildren: function( ) {
            var length = $("#childWrapper .childRow").length;
            var child = $("#childTemplate").html( );
            child = child.replace(/\{id\}/g, length );
            $("#addChildren").append( '<div id="childRowWrapper_' + length + '">' + child + "</div>" );

            $("#childRowWrapper_" + length).find(".select2").remove( );

            $("#childCountry_" + length).select2( );
            $("#childDobMonth_" + length).select2( );
            $("#childDobDay_" + length).select2( );

            var id = $("#childWrapper .childRow").length-2;
            $("#plus_" + id).attr( "class", "icon-minus-circle2" );
            $("#plus_" + id).parent().attr( "class", "removeChildren" );
        },

        /**
         * Auto Generate Random Password
         * @return void
         */
        autoGenPwd: function( ) {
            let low = "abcdefghjkmnpqrstuvwxyz";
            let mid = "@#$%&_";
            let hig = "ABCDEFGHJKLMNPQRSTUVWXYZ";
            let num = "123456789";
            let pass = "";

            for( var x=0; x<2; x++ ) {
                let i = Math.floor( Math.random( ) * low.length );
                pass += low.charAt( i );

                i = Math.floor( Math.random( ) * mid.length );
                pass += mid.charAt( i );

                i = Math.floor( Math.random( ) * hig.length );
                pass += hig.charAt( i );

                i = Math.floor( Math.random( ) * num.length );
                pass += num.charAt( i );
            }
            $("#loginPassword").val( pass );
        },

        readFile: function( input ) {
            var that = this;

            if( input.files && input.files[0] ) {
                var reader = new FileReader( );
                reader.onload = function (e) {
                    $(".upload-demo-wrap").addClass('ready');
                    $(".caption").addClass("mt-30");

                    that.uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - your browser doesn't support the FileReader API");
            }
        },

        suggestDeptManager: function( ) {
            if( this.markaxisUSuggest.getCount( ) === 0 ) {
                //this.markaxisUSuggest.clearToken( );
                var departments = $("#department").val( );

                if( departments.length > 0 ) {
                    for( var dID in departments ) {
                        this.markaxisUSuggest.getSuggestToken("admin/company/getSuggestToken/" + departments[dID]);
                    }
                }
            }
        },

        setOfficePreference: function( oID ) {
            var data = {
                success: function( res ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $(".amountInput").attr("data-currency", obj.data.currencyCode + obj.data.currencySymbol);
                        $(".amountInput").focus( ).blur( );
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/employee/getOffice/" + oID, data );

            var data = {
                bundle: {
                    oID : oID
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $("#taxGroupList").html( obj.html );
                        $("#tgID").multiselect({includeSelectAllOption: true});
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/employee/getTaxGroupListByOffice/" + $("#userID").val( ) + "/" + oID, data );
        },

        getUserManager: function( ) {
            this.markaxisUSuggest.getSuggestToken("admin/user/getSuggestToken/" + $("#userID").val( ));
        },


        getCompetency: function( ) {
            this.markaxisCompetency.getSuggestToken("admin/employee/getCompetencyToken/" + $("#userID").val( ));
        },

        /**
         * Save Employee Data
         * @return void
         */
        saveEmployeeForm: function( ) {
            this.uploadCrop.croppie("result", {
                type: "canvas",
                size: "viewport"
            }).then(function( resp ) {
                var formData = Aurora.WebService.serializePost("#employeeForm");

                var data = {
                    bundle: {
                        laddaClass: ".stepy-finish",
                        data: formData,
                        image: encodeURIComponent( resp )
                    },
                    success: function( res, ladda ) {
                        ladda.stop( );

                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( $("#userID").val( ) === 0 ) {
                                title = Markaxis.i18n.EmployeeRes.LANG_EMPLOYEE_ADDED_SUCCESSFULLY;
                                goToURL = Aurora.ROOT_URL + "admin/user/add";
                                backToURL = Aurora.ROOT_URL + "admin/employee/settings";
                                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_ADD_ANOTHER_EMPLOYEE;
                                cancelButtonText = Markaxis.i18n.EmployeeRes.LANG_GO_EMPLOYEE_LISTING;
                            }
                            else {
                                title = Markaxis.i18n.EmployeeRes.LANG_EMPLOYEE_UPDATED_SUCCESSFULLY;
                                cancelButtonText = Markaxis.i18n.EmployeeRes.LANG_CONTINUE_EDIT_EMPLOYEE;
                                goToURL = Aurora.ROOT_URL + "admin/employee/settings";
                                backToURL = Aurora.ROOT_URL + "admin/user/edit/" + $("#userID").val( );
                                confirmButtonText = Markaxis.i18n.EmployeeRes.LANG_GO_EMPLOYEE_LISTING;
                            }
                            swal({
                                title: title,
                                text: Aurora.i18n.GlobalRes.LANG_WHAT_TO_DO_NEXT,
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
                Aurora.WebService.AJAX( "admin/user/saveUser", data );
            });
        }
    }
    return MarkaxisEmployeeForm;
})();
var markaxisEmployeeForm = null;
$(document).ready( function( ) {
    markaxisEmployeeForm = new MarkaxisEmployeeForm( );
});