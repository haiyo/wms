/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: manager.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisManager = (function( ) {

    /**
     * MarkaxisManager Constructor
     * @return void
     */
    MarkaxisManager = function( includeOwn ) {
        this.managerElement = $(".managerList");

        if( includeOwn ) {
            this.includeOwn = "/includeOwn";
        }

        this.init( );
    };

    MarkaxisManager.prototype = {
        constructor: MarkaxisManager,

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

            // Use Bloodhound engine
            var engine = new Bloodhound({
                remote: {
                    url: Aurora.ROOT_URL + 'admin/employee/getList/%QUERY' + that.includeOwn,
                    wildcard: '%QUERY',
                    filter: function( response ) {
                        var tokens = that.managerElement.tokenfield("getTokens");

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
                                    value: d.userID,
                                    label: d.name,
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
            that.managerElement.tokenfield({
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
                            '<div class="col-md-9"><span class="typeahead-name">{{label}}</span>',
                            '<div class="typeahead-designation">{{designation}}</div></div>',
                            '</div>'
                        ].join(''))
                    }
                }]
            });

            that.managerElement.on("tokenfield:createtoken", function(e) {
                var exists = false;
                $.each( engine.valueCache, function(index, value) {
                    if( e.attrs.value === value ) {
                        exists = true;
                    }
                });
                if( !exists ) {
                    e.preventDefault( );
                }
            });
        },

        getManagerToken: function( url ) {
            var that = this;

            var data = {
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 0 && obj.errMsg ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    for( var i in obj.data ) {
                        var token = { id: obj.data[i]["managerID"],
                                      value: obj.data[i]["managerID"],
                                      label: obj.data[i]["name"] };

                        that.managerElement.tokenfield('createToken', token);
                    }
                }
            };
            Aurora.WebService.AJAX( url, data );
        },

        clearManagerToken: function( ) {
            this.managerElement.tokenfield('setTokens', []);
        }
    }
    return MarkaxisManager;
})();