/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: notification.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var Notification = (function( ) {

    /**
     * Notification Constructor
     * @return void
     */
    Notification = function( ) {
        this.init( );
    };

    Notification.prototype = {
        constructor: Notification,

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
            $("#notification").on("click", function ( ) {
                var count = parseInt( $("#notificationCount").text( ) );

                if( count > 0 ) {
                    var data = {
                        success: function( res ) {
                            $("#notificationCount").text("");
                        }
                    };
                    Aurora.WebService.AJAX("admin/notification/markRead", data );
                }
            });
        },

        getCount: function( ) {
            var data = {
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool === 1 && obj.count > 0 ) {
                        $("#notificationCount").text( obj.count );
                    }
                }
            };
            Aurora.WebService.AJAX("admin/notification/getCount", data );
        }
    }
    return Notification;
})();
var notification = null;
$(document).ready( function( ) {
    notification = new Notification( );
    notification.getCount( );
});