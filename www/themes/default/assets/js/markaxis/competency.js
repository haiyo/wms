/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: competency.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisCompetency = (function( ) {

    /**
     * MarkaxisCompetency Constructor
     * @return void
     */
    MarkaxisCompetency = function( ) {
        this.element = $(".competencyList");
        this.cache = [];
        this.init( );
    };

    MarkaxisCompetency.prototype = {
        constructor: MarkaxisCompetency,

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
                    url: Aurora.ROOT_URL + 'admin/competency/getCompetency/%QUERY',
                    wildcard: '%QUERY',
                    filter: function( response ) {
                        return $.map( response, function( d ) {
                            if( that.cache.indexOf( d.competency ) === -1 ) {
                                that.cache.push( d.cID );
                            }
                            var exists = that.isDuplicate( d.cID ) ? true : false;

                            if( !exists ) {
                                return {
                                    id: d.cID,
                                    value: d.cID,
                                    label: d.competency
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
            that.element.tokenfield({
                delimiter: ';',
                typeahead: [null, {
                    displayKey: 'label',
                    highlight: true,
                    source: engine.ttAdapter()
                }]
            });

            /*
            that.element.on("tokenfield:createtoken", function(e) {
                var exists = false;

                $.each( that.cache, function(index, value) {
                    if( e.attrs.value === value ) {
                        console.log(value)
                        exists = true;
                    }
                });
                if( !exists ) {
                    console.log("sda")
                    //e.preventDefault( );
                    //return false;
                }
            });*/
        },

        getCount: function( ) {
            var tokens = this.element.tokenfield("getTokens");
            return tokens.length;
        },

        isDuplicate: function( id ) {
            var tokens = this.element.tokenfield("getTokens");

            for( var i=0; i<tokens.length; i++ ) {
                if( id === tokens[i].id ) {
                    return true;
                }
            }
            return false;
        },

        setSuggestToken: function( data ) {
            for( var i in data ) {
                var token = { id: data[i]["cID"],
                              value: data[i]["cID"],
                              label: data[i]["competency"] };

                var exists = this.isDuplicate( token.id ) ? true : false;

                if( !exists ) {
                    this.cache.push( token.id );
                    this.element.tokenfield("createToken", token);
                }
            }
        },

        getSuggestToken: function( url ) {
            var that = this;

            var data = {
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool === 0 && obj.errMsg ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    that.setSuggestToken( obj.data );
                }
            };
            Aurora.WebService.AJAX( url, data );
        },

        clearToken: function( ) {
            this.element.tokenfield('setTokens', []);
            this.cache = [];
            $(".token-input").val("");
        }
    }
    return MarkaxisCompetency;
})();