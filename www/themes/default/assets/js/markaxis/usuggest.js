/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: uSuggest.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisUSuggest = (function( ) {

    /**
     * MarkaxisUSuggest Constructor
     * @return void
     */
    MarkaxisUSuggest = function( includeOwn ) {
        this.suggestElement = $(".suggestList");
        this.includeOwn = includeOwn === undefined ? "" : "/includeOwn";
        this.cache = [];
        this.init( );
    };

    MarkaxisUSuggest.prototype = {
        constructor: MarkaxisUSuggest,

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
                        return $.map( response, function( d ) {
                            if( that.cache.indexOf( d.name ) === -1) {
                                that.cache.push( d.userID );
                            }
                            var exists = that.isDuplicate( d.userID ) ? true : false;

                            if( !exists ) {
                                return {
                                    id: d.userID,
                                    value: d.userID,
                                    label: d.name,
                                    image: d.image,
                                    designation: d.designation
                                }
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
            engine.initialize();

            // Initialize tokenfield
            that.suggestElement.tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'label',
                    highlight: true,
                    source: engine.ttAdapter(),
                    templates: {
                        suggestion: Handlebars.compile([
                            '<div class="col-md-12">',
                            '<div class="col-md-2"><img src="{{image}}" width="40" height="40" ',
                            'style="padding:0;" class="rounded-circle" /></div>',
                            '<div class="col-md-10"><span class="typeahead-name">{{label}}</span>',
                            '<div class="typeahead-designation">{{designation}}</div></div>',
                            '</div>'
                        ].join(''))
                    }
                }]
            });

            that.suggestElement.on("tokenfield:createtoken", function(e) {
                var exists = false;
                $.each( that.cache, function(index, value) {
                    if( e.attrs.value === value ) {
                        exists = true;
                    }
                });
                if( !exists ) {
                    e.preventDefault( );
                    return false;
                }
            });
        },

        isDuplicate: function( id ) {
            var tokens = this.suggestElement.tokenfield("getTokens");

            for( var i=0; i<tokens.length; i++ ) {
                if( id === tokens[i].id ) {
                    return true;
                }
            }
            return false;
        },

        getSuggestToken: function( url ) {
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

                        var exists = that.isDuplicate( token.id ) ? true : false;

                        if( !exists ) {
                            that.cache.push( token.id );
                            that.suggestElement.tokenfield("createToken", token);
                        }
                    }
                }
            };
            Aurora.WebService.AJAX( url, data );
        },

        clearToken: function( ) {
            this.suggestElement.tokenfield('setTokens', []);
            this.cache = [];
            $(".token-input").val("");
        }
    }
    return MarkaxisUSuggest;
})();