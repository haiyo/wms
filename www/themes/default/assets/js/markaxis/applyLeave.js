/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: applyLeave.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisApplyLeave = (function( ) {

    /**
     * MarkaxisApplyLeave Constructor
     * @return void
     */
    MarkaxisApplyLeave = function( ) {
        this.init( );
    };

    MarkaxisApplyLeave.prototype = {
        constructor: MarkaxisApplyLeave,

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

            $("#ltID").select2({minimumResultsForSearch: -1});
            //$("#applyFor").select2({minimumResultsForSearch: -1});

            var datesToDisable = [ [2019,1,5], [2019,1,6] ]

            $(".pickadate-start").pickadate({
                showMonthsShort: true,
                disable:datesToDisable,
                format:"dd mmm yyyy"
            });
            $(".pickadate-end").pickadate({
                showMonthsShort: true,
                ///disable:datesToDisable,
                format:"dd mmm yyyy"
            });
            $('.form-check-input-styled').uniform();
            $("#startTime").pickatime({interval:60, min: [9,0], max: [18,0]});
            $("#endTime").pickatime({interval:60, min: [9,0], max: [18,0]});

            // Use Bloodhound engine
            var engine = new Bloodhound({
                remote: {
                    url: Aurora.ROOT_URL + 'admin/employee/getList/%QUERY',
                    wildcard: '%QUERY',
                    filter: function( response ) {
                        var tokens = $(".supervisorList").tokenfield("getTokens");

                        return $.map( response, function( d ) {
                            if  ( engine.valueCache.indexOf(d.name) === -1) {
                                engine.valueCache.push(d.name);
                            }
                            var exists = false;
                            for( var i=0; i<tokens.length; i++ ) {
                                if( d.name === tokens[i].label ) {
                                    exists = true;
                                    break;
                                }
                            }
                            if( !exists )
                                return { value: d.name, id: d.userID }
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
            $(".supervisorList").tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'value',
                    highlight: true,
                    source: engine.ttAdapter()
                }]
            });

            $(".supervisorList").on("tokenfield:createtoken", function( event ) {
                var exists = false;
                $.each( engine.valueCache, function(index, value) {
                    if( event.attrs.value === value ) {
                        exists = true;
                        $("#supUserIDs").val( event.attrs.id + "," + $("#supUserIDs").val() );
                    }
                });
                if( !exists ) {
                    event.preventDefault( );
                }
            });

            $("#startDate").change(function() {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });

            $("#endDate").change(function() {
                if( $.trim( $("#startDate").val( ) ) != "" && $.trim( $("#endDate").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });

            $("#startTime").change(function() {
                if( $.trim( $("#startTime").val( ) ) != "" && $.trim( $("#endTime").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });

            $("#endTime").change(function() {
                if( $.trim( $("#startTime").val( ) ) != "" && $.trim( $("#endTime").val( ) ) != "" ) {
                    that.getDaysDiff( );
                }
            });

            $("#saveApplyLeave").on("click", function ( ) {
                that.saveApplyLeave();
                return false;
            });
        },

        getDaysDiff: function( ) {
            var startDate = new Date( $("#startDate").val( ) );
            var endDate = new Date( $("#endDate").val( ) );

            if( startDate > endDate ) {
                swal("Error!", "Invalid date range selected", "error");
                return false;
            }
            var data = {
                bundle: {
                    ltID: $("#ltID").val( ),
                    startDate: $("#startDate").val( ),
                    endDate: $("#endDate").val( ),
                    startTime: $("#startTime").val( ),
                    endTime: $("#endTime").val( )
                },
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 0 && obj.errMsg ) {
                        $("#daysHelp").text(obj.errMsg);
                        $("#dateHelpWrapper").removeClass("hide");
                        return;
                    }

                    if( obj.text ) {
                        $("#daysHelp").text(obj.text);
                        $("#dateHelpWrapper").removeClass("hide");
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/getDateDiff", data );
        },


        saveApplyLeave: function( ) {
            var formData = Aurora.WebService.serializePost("#applyLeaveForm");

            var data = {
                bundle: {
                    laddaClass: "#saveApplyLeave",
                    data: formData
                },
                success: function( res, ladda ) {
                    console.log(res)
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        var ltID = $("#ltID").val();
                        console.log(ltID)
                        var count = parseInt( $("#ltID" + ltID).text() );
                        $("#ltID" + ltID).text( count-obj.data.days );

                        if( obj.data.hasSup ) {
                            text = "Your leave application is not confirm yet and is subject to Supervisor(s) approval.";
                        }
                        else {
                            text = "";
                        }

                        swal({
                            title: "Leave Applied Successfully",
                            text: text,
                            type: 'success'
                        }, function( isConfirm ) {
                            $("#modalApplyLeave").modal('hide');
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/leave/apply", data );
        }
    }
    return MarkaxisApplyLeave;
})();
var markaxisApplyLeave = null;
$(document).ready( function( ) {
    markaxisApplyLeave = new MarkaxisApplyLeave( );
});