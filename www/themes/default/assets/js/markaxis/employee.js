/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: employee.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisEmployee = (function( ) {


    /**
     * MarkaxisEmployee Constructor
     * @return void
     */
    MarkaxisEmployee = function( ) {
        this.uploadCrop = false;
        this.init( );
    };

    MarkaxisEmployee.prototype = {
        constructor: MarkaxisEmployee,

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
                        that.saveEmployeeForm( );
                        return false;
                    }
                }
            });

            $.validator.addMethod("validEmail", function(value, element) {
                if( value == '' ) return true;

                var ind  = value.indexOf('@');
                var str2 = value.substr(ind+1);
                var str3 = str2.substr(0,str2.indexOf('.'));
                if( str3.lastIndexOf('-') == (str3.length-1) ||
                    (str3.indexOf('-') != str3.lastIndexOf('-')) )
                    return false;

                var str1 = value.substr(0,ind );
                if( (str1.lastIndexOf('_') == (str1.length-1)) ||
                    (str1.lastIndexOf('.') == (str1.length-1)) ||
                    (str1.lastIndexOf('-') == (str1.length-1)) )
                    return false;
                str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
                temp1 = str.test(value);
                return temp1;
            }, "Please enter valid email address.");

            // Initialize validation
            var validate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    $(element).addClass("border-danger");
                },
                unhighlight: function( element, errorClass ) {
                    $(element).removeClass("border-danger");
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    // Styled checkboxes, radios, bootstrap switch
                    if( element.parents('div').hasClass("checker") ||
                        element.parents('div').hasClass("choice") ||
                        element.parent().hasClass('bootstrap-switch-container') ) {

                        if( element.parents('label').hasClass('checkbox-inline') ||
                            element.parents('label').hasClass('radio-inline')) {
                            error.appendTo( element.parent().parent().parent().parent() );
                        }
                        else {
                            error.appendTo( element.parent().parent().parent().parent().parent() );
                        }
                    }
                    // Unstyled checkboxes, radios
                    else if( element.parents('div').hasClass('checkbox') ||
                             element.parents('div').hasClass('radio') ) {
                        error.appendTo( element.parent().parent().parent() );
                    }
                    // Input with icons and Select2
                    else if( element.parents('div').hasClass('has-feedback') ||
                             element.hasClass('select2-hidden-accessible') ) {
                        //error.appendTo( element.parent() );
                        element.next().find(".select2-selection").addClass("border-danger");
                    }
                    // Inline checkboxes, radios
                    else if( element.parents('label').hasClass('checkbox-inline') ||
                             element.parents('label').hasClass('radio-inline') ) {
                        error.appendTo( element.parent().parent() );
                    }
                    // Input group, styled file input
                    else if( element.parent().hasClass('uploader') ||
                             element.parents().hasClass('input-group') ) {
                        error.appendTo( element.parent().parent() );
                    }
                    else {
                        if( $(".error").length == 0 )
                            $(".stepy-navigator").prepend(error);
                    }
                },
                rules: {
                    fname : "required",
                    lname : "required",
                    idnumber : "required",
                    email1: {
                        validEmail: true,
                        required: true
                    }
                }
            };

            // Apply "Back" and "Next" button styling
            var stepy = $(".stepy-step");
            stepy.find(".button-next").addClass("btn btn-primary btn-next");
            stepy.find(".button-back").addClass("btn btn-default");

            $("#dobMonth").select2({minimumResultsForSearch: -1});
            $("#dobDay").select2({minimumResultsForSearch: -1});
            $("#country").select2( );
            $("#state").select2( );
            $("#city").select2( );
            $("#designation").select2( );
            $("#department").select2( );
            $("#currency").select2( );
            $("#confirmMonth").select2( );
            $("#confirmDay").select2( );
            $("#startMonth").select2( );
            $("#startDay").select2( );
            $("#endMonth").select2( );
            $("#endDay").select2( );
            $("#passType").select2( );
            $("#passExpiryMonth").select2( );
            $("#passExpiryDay").select2( );
            $("#eduCountry").select2( );
            $("#eduFromMonth").select2( );
            $("#eduToMonth").select2( );
            $("#expFromMonth").select2( );
            $("#expToMonth").select2( );
            $("#recruitSource").select2( );
            $(".relationship").select2( );
            $(".raceList").select2({minimumResultsForSearch: -1});
            $(".maritalList").select2({minimumResultsForSearch: -1});
            $(".salaryTypeList").select2({minimumResultsForSearch: -1});
            $(".paymentMethodList").select2({minimumResultsForSearch: -1});

            $("#pcID").select2();
            $("#tgID").multiselect({includeSelectAllOption: true});
            $("#ltID").multiselect({includeSelectAllOption: true});

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

            $(".childSelect").select2( );
            $(".childSelect").select2("destroy");

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
                that.addChildren();
            }

            $(document).on("click", ".addChildren", function ( ) {
                that.addChildren( );
                return false;
            });

            $(document).on("click", ".removeChildren", function ( ) {
                var id = $(this).attr("href");
                $("#childRowWrapper_" + id).addClass("childRow").html("").hide();

                if( $("#childWrapper .childRow").length == 0 ) {
                    $("#children2").click( );
                    $.uniform.update( );
                }
                return false;
            });

            this.uploadCrop = $("#upload-demo").croppie({
                viewport: {
                    width: 290,
                    height: 290,
                    type: "circle"
                },
                enableExif: true
            });
            $("#upload").on("change", function( ) { that.readFile(this); });
        },

        addChildren: function( ) {
            var length = $("#childWrapper .childRow").length;
            var child = $("#childTemplate").html( );
            child = child.replace(/\{id\}/g, length );
            $("#childWrapper").append( '<div id="childRowWrapper_' + length + '">' + child + "</div>" );
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
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
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
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( $("#userID").val( ) == 0 ) {
                                title = "New Employee Added  Successfully";
                                goToURL = Aurora.ROOT_URL + "admin/employee/add";
                                backToURL = Aurora.ROOT_URL + "admin/employee/list";
                                confirmButtonText = "Add Another Employee";
                                cancelButtonText = "Go to Employee Listing";
                            }
                            else {
                                title = "Employee Updated Successfully";
                                cancelButtonText = "Continue Editing This Employee";
                                goToURL = Aurora.ROOT_URL + "admin/employee/list";
                                backToURL = Aurora.ROOT_URL + "admin/employee/edit/" + $("#userID").val( );
                                confirmButtonText = "Go to Employee Listing";
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
                Aurora.WebService.AJAX( "admin/employee/save", data );
            });
        }
    }
    return MarkaxisEmployee;
})();
var markaxisEmployee = null;
$(document).ready( function( ) {
    markaxisEmployee = new MarkaxisEmployee( );
});