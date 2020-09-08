/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: user.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisUser = (function( ) {


    /**
     * MarkaxisUser Constructor
     * @return void
     */
    MarkaxisUser = function( ) {
        this.keyUpTime = 1200; // 1 sec
        this.keyUpTimeout = null;
        this.departmentClear = false;
        this.designationClear = false;
        this.init( );
    };

    MarkaxisUser.prototype = {
        constructor: MarkaxisUser,

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

            $("#department").select2({allowClear: true});
            $("#designation").select2({allowClear: true});

            $("#department").on("select2:unselecting", function (e) {
                $(this).select2("val", false);
                that.searchUser( );
                e.preventDefault();
            });

            $("#designation").on("select2:unselecting", function (e) {
                $(this).select2("val", false);
                that.searchUser( );
                e.preventDefault();
            });

            $("#department").on("change", function( ) {
                if( !this.departmentClear ) {
                    that.searchUser( );
                }
            });

            $("#designation").on("change", function( ) {
                if( !this.designationClear ) {
                    that.searchUser( );
                }
            });

            $("input[id=searchUser]").keyup( function(e) {
                if( $(this).val( ) == "" ) {
                    that.searchUser( );
                }
                else {
                    var regex = new RegExp("^[a-zA-Z0-9]+$");
                    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

                    if( regex.test( str ) ) {
                        clearTimeout( that.keyUpTimeout );
                        that.keyUpTimeout = setTimeout(function() { that.searchUser( ); }, that.keyUpTime);
                    }
                }
            });
        },


        /**
         * Save Employee Data
         * @return void
         */
        searchUser: function( ) {
            var data = {
                bundle: {
                    q: $("input[id=searchUser]").val( ),
                    department: $("#department").val( ),
                    designation: $("#designation").val( )
                },
                success: function( res, ladda ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        $("#userList").html( obj.html );
                        $('[data-toggle="tooltip"]').tooltip( );
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/user/search", data );
        }
    }
    return MarkaxisUser;
})();
var markaxisUser = null;
$(document).ready( function( ) {
    markaxisUser = new MarkaxisUser( );
});