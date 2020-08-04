/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: pickerExtend.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPickerExtend = (function( ) {

    /**
     * MarkaxisPickerExtend Constructor
     * @return void
     */
    MarkaxisPickerExtend = function( ) {
        this.pickerHolidays = [];
        this.pickerPayroll = [];
        this.init( );
    };

    MarkaxisPickerExtend.prototype = {
        constructor: MarkaxisPickerExtend,

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
        },


        clearCache: function( ) {
            this.pickerHolidays = [];
        },


        setPickerHolidays: function( id, element, context=false ) {
            var that = this;
            var firstDate = new Date( $(".picker__table .picker__day:first-child").data("pick") );
            var lastDate;
            var date = new Date( );

            if( !context || context.highlight == undefined ) {
                lastDate =  new Date( date.getFullYear( ), (date.getMonth( )+1), 0 );
            }
            else {
                var current = new Date( context.highlight.obj );
                lastDate = new Date( current.getFullYear( ), (current.getMonth( )+2), 0 );
            }

            var start = firstDate.getDate( ) + "-" + (firstDate.getMonth( )+1) + "-" + firstDate.getFullYear( );
            var end = lastDate.getDate( ) + "-" + (lastDate.getMonth( )+1) + "-" + lastDate.getFullYear( );
            var cache = firstDate.getTime( ) + lastDate.getTime( );


            if( that.pickerHolidays.hasOwnProperty( cache ) ) {
                $(id + " .picker__day").each(function() {
                    var ts = new Date( $(this).data("pick") );
                    var date = ts.getFullYear( ) + "-" +  (ts.getMonth( )+1) + "-" + ts.getDate( );

                    if( that.pickerHolidays[cache].hasOwnProperty( date ) ) {
                        $(this).addClass("holiday");
                        //$(this).attr("aria-disabled", true);
                        $(this).attr("data-toggle", "tooltip");
                        $(this).attr("data-placement", "top");
                        $(this).attr("title", that.pickerHolidays[cache][date]);
                    }
                });
                $('[data-toggle="tooltip"]').tooltip( );
            }
            else {
                var data = {
                    bundle: {
                        type: "holiday",
                        start: start,
                        end: end,
                    },
                    success: function( res ) {
                        that.pickerHolidays[cache] = [];

                        if( res ) {
                            var obj = $.parseJSON( res );

                            if( obj.length > 0 ) {
                                for( var i=0; i<obj.length; i++ ) {
                                    var holiday = new Date( obj[i].date );
                                    that.pickerHolidays[cache][holiday.getFullYear() + "-" +  (holiday.getMonth()+1) + "-" +  holiday.getDate()] = obj[i].title;
                                }

                                $(id + " .picker__day").each(function() {
                                    var ts = new Date( $(this).data("pick") );
                                    var date = ts.getFullYear( ) + "-" +  (ts.getMonth( )+1) + "-" + ts.getDate( );

                                    if( that.pickerHolidays[cache].hasOwnProperty( date ) ) {
                                        $(this).addClass("holiday");
                                        //$(this).attr("aria-disabled", true);
                                        $(this).attr("data-toggle", "tooltip");
                                        $(this).attr("data-placement", "top");
                                        $(this).attr("title", that.pickerHolidays[cache][date]);
                                    }
                                });
                                $('[data-toggle="tooltip"]').tooltip( );
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/calendar/getEvents", data );
            }
        },


        setPickerPayroll: function( id, element, context=false ) {
            var that = this;
            var firstDate = new Date( $(".picker__table .picker__day:first-child").data("pick") );
            var lastDate;
            var date = new Date( );

            if( !context || context.highlight == undefined ) {
                lastDate =  new Date( date.getFullYear( ), (date.getMonth( )+1), 0 );
            }
            else {
                var current = new Date( context.highlight.obj );
                lastDate = new Date( current.getFullYear( ), (current.getMonth( )+2), 0 );
            }

            var start = firstDate.getDate( ) + "-" + (firstDate.getMonth( )+1) + "-" + firstDate.getFullYear( );
            var end = lastDate.getDate( ) + "-" + (lastDate.getMonth( )+1) + "-" + lastDate.getFullYear( );
            var cache = firstDate.getTime( ) + lastDate.getTime( );


            if( that.pickerPayroll.hasOwnProperty( cache ) ) {
                $(" .picker__day").each(function() {
                    var ts = new Date( $(this).data("pick") );
                    var date = ts.getFullYear( ) + "-" +  (ts.getMonth( )+1) + "-" + ts.getDate( );

                    if( that.pickerPayroll[cache].hasOwnProperty( date ) ) {
                        $(this).removeClass("picker__day--disabled");
                        $(this).attr("aria-disabled", false);
                        $(this).addClass("holiday");
                        $(this).attr("data-toggle", "tooltip");
                        $(this).attr("data-placement", "top");
                        $(this).attr("title", that.pickerPayroll[cache][date]);
                    }
                });
                $('[data-toggle="tooltip"]').tooltip( );
            }
            else {
                var data = {
                    bundle: {
                        start: start,
                        end: end,
                    },
                    success: function( res ) {
                        that.pickerPayroll[cache] = [];

                        if( res ) {
                            var obj = $.parseJSON( res );

                            if( obj.events.length > 0 ) {
                                for( var i=0; i<obj.events.length; i++ ) {
                                    var payroll = new Date( obj.events[i].startDate );
                                    var title = "";
                                    that.pickerPayroll[cache][payroll.getFullYear() + "-" +  (payroll.getMonth()+1) + "-" +  payroll.getDate()] = ""; // obj[i].title;
                                }

                                $(" .picker__day").each(function() {
                                    var ts = new Date( $(this).data("pick") );
                                    var date = ts.getFullYear( ) + "-" +  (ts.getMonth( )+1) + "-" + ts.getDate( );

                                    if( that.pickerPayroll[cache].hasOwnProperty( date ) ) {
                                        $(this).removeClass("picker__day--disabled");
                                        $(this).attr("aria-disabled", false);
                                        $(this).addClass("holiday");
                                        $(this).attr("data-toggle", "tooltip");
                                        $(this).attr("data-placement", "top");
                                        $(this).attr("title", that.pickerPayroll[cache][date]);
                                    }
                                });
                                $('[data-toggle="tooltip"]').tooltip( );
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/payroll/getPayrollEvents", data );
            }
        }
    }
    return MarkaxisPickerExtend;
})();
var markaxisPickerExtend = null;
$(document).ready( function( ) {
    markaxisPickerExtend = new MarkaxisPickerExtend( );
});