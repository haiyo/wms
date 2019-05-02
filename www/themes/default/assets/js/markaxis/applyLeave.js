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

            $(".form-check-input-styled").uniform( );
            $("#startTime").pickatime({interval:60, min: [9,0], max: [18,0]});
            $("#endTime").pickatime({interval:60, min: [9,0], max: [18,0]});

            // Use Bloodhound engine
            var engine = new Bloodhound({
                remote: {
                    url: Aurora.ROOT_URL + 'admin/employee/getList/%QUERY',
                    wildcard: '%QUERY',
                    filter: function( response ) {
                        var tokens = $(".managerList").tokenfield("getTokens");

                        return $.map( response, function( d ) {
                            if( engine.valueCache.indexOf(d.name) === -1) {
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
                                return {
                                    id: d.userID,
                                    value: d.name,
                                    image: d.image,
                                    designation: d.designation
                                }
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
            $(".managerList").tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'value',
                    highlight: true,
                    source: engine.ttAdapter(),
                    templates: {
                        suggestion: Handlebars.compile([
                            '<div class="col-md-12">',
                            '<div class="col-md-3"><img src="{{image}}" width="40" height="40" ',
                            'style="padding:0;" class="rounded-circle" /></div>',
                            '<div class="col-md-9"><span class="typeahead-name">{{value}}</span>',
                            '<div class="typeahead-designation">{{designation}}</div></div>',
                            '</div>'
                        ].join(''))
                    }
                }]
            });

            $(".managerList").on("tokenfield:createtoken", function(e) {
                var exists = false;
                $.each( engine.valueCache, function(index, value) {
                    if( e.attrs.value === value ) {
                        exists = true;
                        $("#managerIDs").val( e.attrs.id + "," + $("#managerIDs").val( ) );
                    }
                });
                if( !exists ) {
                    e.preventDefault( );
                }
            }).on('tokenfield:createdtoken', function(e) {
                $(e.relatedTarget).attr( "data-id", e.attrs.id );
            });

            $(".managerList").on('tokenfield:removedtoken', function(e) {
                console.log(e.relatedTarget)
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

            $("#modalApplyLeave").on("show.bs.modal", function(e) {
                console.log("sdf")
                $('.managerList').tokenfield('createToken', 'Violet');
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
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        var ltID = $("#ltID").val( );
                        var count = parseInt( $("#ltID" + ltID).text( ) );
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