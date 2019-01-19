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

            // Apply "Back" and "Next" button styling
            $(".stepy-step").find(".button-next").addClass("btn btn-primary btn-next");
            $(".stepy-step").find(".button-back").addClass("btn btn-default");

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
            $(".childSelect").select2( );

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
                if ($("#loginPassword").attr("type") == "text") {
                    $("#loginPassword").attr("type", "password");
                }
                else {
                    $("#loginPassword").attr("type", "text");
                }
            });

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

            $(document).on( "click", ".addChildren", function ( ) {
                that.addChildren( );
                return false;
            });

            $(document).on( "click", ".removeChildren", function ( ) {
                var id = $(this).attr("href");
                $("#childRowWrapper_" + id).addClass("childRow").html("").hide();

                if( $("#childWrapper .childRow").length == 0 ) {
                    $("#children2").click( );
                    $.uniform.update( );
                }
                return false;
            });
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
    }
    return MarkaxisEmployee;
})();
var markaxisEmployee = null;
$(document).ready( function( ) {
    markaxisEmployee = new MarkaxisEmployee( );
});