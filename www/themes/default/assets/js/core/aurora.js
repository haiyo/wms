/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: aurora.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

$(document).ready( function( ) {

    var queue = [];
    var filesLoaded = [];
    var IS_NUMERIC = /^[0-9\.\,]+$/, defaultOptions = {
        thousands: ",",
        decimal: ".",
        zeroes: 2
    };


    /**
    * Aurora.Init Namespace
    */
    Aurora.Init = {
        start : function( ) {
            var parent = this;

            if( $(".nav-tabs").length > 0 ) {
                $(".nav-tabs li:first-child a").click( );
            }

            $(".check-input").uniform();

            $(document).on("focus", ".amountInput", function(e) {
                $(this).val( Aurora.String.unFormatMoney( $(this).val( ) ) );
            });
            $(document).on("blur", ".amountInput", function(e) {
                var amountInput = Aurora.String.formatMoney( $(this) );
                $(this).val( amountInput );
            });

            /*$(document).on("change", "#country", function(e) {
                if( $("#state").length > 0 ) {
                    $("#state").empty();

                    if( $("#city").length > 0 ) {
                        $("#city").empty();
                    }

                    var data = {
                        bundle: {
                            country: $(this).val( )
                        },
                        success: function( res ) {
                            var res = $.parseJSON( res );

                            var data = $.map( res, function( obj ) {
                                return {id: obj.id, text: obj.text};
                            });

                            $("#state").select2({allowClear: true, data: data});
                            $("#state").val("").trigger('change');
                        }
                    };
                    Aurora.WebService.AJAX( "admin/stateList", data );
                }
            });
            $(document).on("change", "#state", function(e) {
                if( $("#city").length > 0 ) {
                    $("#city").empty();

                    var data = {
                        bundle: {
                            state: $(this).val( )
                        },
                        success: function( res ) {
                            var res = $.parseJSON( res );

                            var data = $.map( res, function( obj ) {
                                return {id: obj.id, text: obj.text};
                            });

                            $("#city").select2({allowClear: true, data: data});
                            $("#city").val("").trigger('change');
                        }
                    };
                    Aurora.WebService.AJAX( "admin/cityList", data );
                }
            });*/
        }
    },


    /**
    * Aurora.TaskManager Namespace
    */
    Aurora.TaskManager = {

        running : false,

        /**
        * Add Task to Queue
        */
        add : function( task ) {
            if( task.length != undefined && task.length > 0 ) {
                for( var i=0; i<task.length; i++ ) {
                    queue.push(task[i]);
                }
            }
            else { queue.push(task); }
        },


        /**
        * Remove Task from Queue
        */
        remove : function( taskID ) {
            for( var i=0; i<queue.length; i++ ) {
                if( queue[i].taskID == taskID ) {
                    queue.splice(i,1);
                    break;
                }
            }
        },


        /**
        * Run Task
        */
        run : function( section ) {
            if( queue.length > 0 && this.running != true ) {
                for( var i=0; i<queue.length; i++ ) {
                    if( queue[i].section == section ) {
                        // If the task requires showBox...
                        if( queue[i].item == "showBox" ) {
                            var width  = (queue[i].width  == undefined) ? 560 : queue[i].width;
                            var height = (queue[i].height == undefined) ? 360 : queue[i].height;

                            Aurora.UI.showBox( queue[i].url, width, height );
                            this.running = true;
                        }
                        // Else if the task is a function callback...
                        else if( typeof queue[i].item === "function" ) {
                            queue[i].item( );
                        }
                        // Else we assume its an AJAX call.
                        else {
                            Aurora.WebService.AJAX( queue[i].url, queue[i].data );
                            this.running = true;
                        }
                        queue.splice(i, 1);
                    }
                }
            }
            if( queue.length == 0 ) {
                this.running = false;
            }
        }
    }


    /**
    * Aurora.WebService Namespace
    */
    Aurora.WebService = {

        /**
        * Serialize form post with square brackets ability
        */
        serializePost : function( form ) {
            var data = {};
            form = $(form).serializeArray( );
            for (var i = form.length; i--;) {
                var name = form[i].name;
                var value = form[i].value;
                var index = name.indexOf('[]');
                if (index > -1) {
                    name = name.substring(0, index);
                    if (!(name in data)) {
                        data[name] = [];
                    }
                    data[name].push( encodeURIComponent( value ) );
                }
                else
                    data[name] = encodeURIComponent( value );
            }
            return data;
        },


        /**
        * Create download prompt for a file
        */
        download : function( url ) {
            var iframe;
            iframe = document.getElementById("force");
            if( iframe == null ) {
                iframe = document.createElement('iframe');
                iframe.id = "force";
                iframe.style.visibility = 'hidden';
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
            }
            iframe.src = Aurora.ROOT_URL + url;
        },

        sendType : "POST",
        dataType : "html",
        external : false,
        cache: false,
        contentType: "application/x-www-form-urlencoded", //jquery default
        processData: true,

        /**
        * This AJAX call includes CSRF Guard token. Use this method for
        * all standard AJAX call.
        */
        AJAX : function( url, data ) {
            var parent = this;
            var ladda;

            if( data.bundle == undefined || data.bundle == "" ) {
                data.bundle = {};
            }
            if( !this.external ) {
                data.bundle.ajaxCall = "1";
                data.bundle.csrfToken = Aurora.CSRF_TOKEN;
                url = Aurora.ROOT_URL + url;
            }
            $.ajax({
                url: url,
                beforeSend: function( xhr, settings ) {
                    if( typeof data.beforeSend === "function" ) {
                        data.beforeSend( xhr, settings );
                    }
                    else if( data.bundle.laddaClass ) {
                        var laddaClass = data.bundle.laddaClass;
                        ladda = Ladda.create( document.querySelector( laddaClass ) );
                        ladda.start();
                    }
                },
                xhr: function( ) {
                    xhr = $.ajaxSettings.xhr( );
                    if( data.xhr != undefined && typeof data.xhr == "function" ) {
                        xhr = data.xhr( xhr );
                    }
                    return xhr;
                },
                cache: this.cache,
                contentType: this.contentType,
                processData: this.processData,
                type: this.sendType,
                dataType: this.dataType,
                data: data.bundle,
                complete: function( xhr, textStatus ) {
                    if( typeof data.complete === "function" ) {
                        data.complete( xhr, textStatus );
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR, textStatus, errorThrown );
                },
                success: function( res ) {
                    if( res == "login" ) {
                        location.reload(true);
                        return;
                    }
                    else if( data.notification ) {
                        parent.notify( data.notification );
                    }
                    else if( typeof data.success == "function" ) {
                        data.success( res, ladda );
                    }
                    else if( ladda ) {
                        ladda.stop( );
                    }
                }
            });
        },
        

        notify: function( message ) {
            parent.$(".notification").html( message );
            parent.$(".notification").fadeIn( ).delay(3000).fadeOut( );
        },


        /**
        * Permission Selector
        */
        permission : function( url ) {
            $("#perm1").click(function( ) {$("#roleList").hide( );});
            $("#perm2").click(function( ) {$("#roleList").hide( );});
            $("#perm3").click(function( ) {
                $("#roleList").show( );
                if( $("#roleList").html( ) == "" ) {
                    $("#roleList").html( Aurora.UI.showSpinner("Retrieving Roles...") );
                    var data = {
                        beforeSend:false,
                        success: function( res ) {
                            $("#roleList").html( res );
                        }
                    };
                    Aurora.WebService.AJAX( url, data );
                }
            });
        },


        /*
        * Get URL with variables defined
        */
        GET: function( key ) {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for( var i=0; i<hashes.length; i++ ) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            if( key != undefined ) {
                return vars[key];
            }
            return vars;
        },


        /*
        * Dynamically load JS and CSS file
        
        require: function( files, callBack ) {
            for( var file in files ) {
                
            }
        },*/


        /*
        * Dynamically load JS and CSS file
        */
        require: function( files, callBack ) {
            var totalFiles  = Aurora.Object.assocLength( files );
            
            if( totalFiles == 0 ) {
                callBack( );
                return;
            }
            var loaded = false;
            for( var file in files ) {
                for( var j=0; j<filesLoaded.length; j++ ) {
                    if( filesLoaded[j] == file ) {
                        loaded = true;
                        break;
                    }
                }
                if( !loaded ) {
                    var hash = Math.floor( Math.random( )*11 );
                    var fileRef  = false;
                    var fileType = file.split('.').pop( );

                    if( fileType == "js" ) {
                        fileRef = document.createElement("script");
                        fileRef.setAttribute( "type", "text/javascript" );
                        fileRef.setAttribute( "src", file );
                        document.getElementsByTagName("head")[0].appendChild( fileRef );
                    }
                    else if( fileType == "css" ) {
                        fileRef = document.createElement("link");
                        fileRef.setAttribute( "rel",  "stylesheet" );
                        fileRef.setAttribute( "type", "text/css" );
                        fileRef.setAttribute( "href", file + "?" + hash );
                        document.getElementsByTagName("head")[0].appendChild( fileRef );
                    }
                    filesLoaded.push( file );
                }
            }
            this.__loadFiles( files, callBack );
        },
                
        /*
        * Dynamically load JS and CSS file
        */
        __loadFiles: function( files, callBack ) {
            var filesCount  = 0;
            var totalFiles  = Aurora.Object.assocLength( files );

            for( var file in files ) {
                var fileType = file.split('.').pop( );

                if( fileType == "js" ) {
                    if( typeof callBack == 'function' ) {
                        this.__functionIsLoaded( files[file], function( ) {
                            filesCount++;
                            if( filesCount == totalFiles ) {
                                callBack( );
                            }
                        });
                    }
                }
                else if( fileType == "css" ) {                    
                    if( typeof callBack == 'function' ) {
                        this.__styleIsLoaded( files[file], function( ) {
                            filesCount++;
                            if( filesCount == totalFiles ) {
                                callBack( );
                            }
                        });
                    }
                }
            }
        },
                
        funcTimer : [],
        __functionIsLoaded: function( functionString, callBack ) {
            if( typeof window[functionString] != 'function' ) {
                this.funcTimer[functionString] = setTimeout( function( ) {
                    Aurora.WebService.__functionIsLoaded( functionString, callBack )
                }, 1000 );
            }
            else {
                /*
                clearTimeout(this.funcTimer[functionString]);*/
                window[functionString]( );
                callBack( );
            }
        },

        styleTimer : [],
        __styleIsLoaded: function( styleName, callBack ) {
            var div = document.getElementById( styleName );
            if( div == null) {
                div = document.createElement("div");
                div.id = styleName;
                document.body.appendChild(div);
            }
            if( window.getComputedStyle( div, null ).display !== "none" ) {
                this.styleTimer[styleName] = setTimeout( function( ){
                    Aurora.WebService.__styleIsLoaded( styleName, callBack )
                }, 1000 );
            }
            else {
                $("#" + styleName).remove( );
                //clearTimeout(this.styleTimer[styleName]);
                callBack( );
            }
        }
    }


    /**
    * Aurora.UI Namespace
    */
    Aurora.UI = {
        

        /**
        * Fade in/out element
        */
        blink: function( selector ) {
            $(selector).fadeOut( "slow", function( ) {
                $(this).fadeIn( "slow", function( ) {
                    Aurora.UI.blink(this);
                }).delay(800);
           });
        },


        /**
        * Disable Element Selection Based On Browser
        */
        disableSelection : function( elementID ) {
            if( $.browser.mozilla ) {
                $(elementID).css("MozUserSelect", "none");
            }
            else if( $.browser.msie ) {
                $(elementID).live("selectstart", function(e) {
                    e.preventDefault();
                });
            }
            else{//Opera, etc.
               $(elementID).mousedown(function( ){return false;} );
            }
        },


        /**
        * Text box focus
        */
        inputFocus : function( elementID ) {
            $(elementID).live("focus", function( ) {
                if( $(this).val( ) == $(this).attr("title") ) {
                    $(this).val("");
                    $(this).removeClass("textFade");
                }
            }).live("blur", function( ) {
                if( $(this).val( ) == "" ) {
                    $(this).val( $(this).attr("title") );
                    $(this).addClass("textFade");
                }
            });
        },


        /**
        * Show Element
        * @Usage: Aurora.UI.show( ".element" ); or Aurora.UI.show( "#element" );
        */
        show : function( elementID ) {
            $(elementID).show( );
            return false;
        },


        /**
        * Hide Element
        * @Usage: Aurora.UI.hide( ".element" ); or Aurora.UI.hide( "#element" );
        */
        hide : function( elementID ) {
            $(elementID).hide( );
            return false;
        },


        /**
        * Show if element is hidden, hide if element is visible
        * @Usage: Aurora.UI.showHide( ".element" ); or Aurora.UI.showHide( "#element" );
        */
        showHide : function( elementID ) {
            if( $(elementID).show( ) ) {
                $(elementID).hide( );
                return false;
            }
            $(elementID).show( );
            return false;
        },


        /**
        * Scroll to anchor
        * @param compensate - Don't scroll directly to anchor but compensate a few more pixel above.
        */
        showAndScrollTo : function( container, anchor, compensate ) {
            // Note: jQuery $(anchor).offset().top seems to change the offset position
            // calculation after a scrolling takes place IN IFRAME.
            // To fix this issue, we use document.getElementById(anchor).offsetTop
            var offset = $(anchor).offset( );
                offset = offset != null ? offset.top : document.getElementById(anchor).offsetTop;
                if( compensate ) {offset = offset-compensate}
            var pos = ($(container).prop("scrollHeight")-offset);
            $(container).animate({scrollTop: ($(container).prop("scrollHeight")-pos)}, 1000);
            return false;
        },


        /**
        * Show Loading Spinner
        * @Usage: $("div").html( Aurora.UI.showSpinner( "loading" ) );
        */
        showSpinner : function( text, className, image ) {
            className = className == undefined ? 'spinnerTxt' : className;
            image = image == undefined ? 'spinner16.gif' : image;
            text = text != undefined ? ' <span class="' + className + '">' + text + '</span>' : "";
            return '<images src="' + Aurora.ROOT_URL + 'www/themes/admin/aurora/core/images/' + Aurora.THEME + '/' + Aurora.LANG + '/' + image + '" width="16" height="16" align="absMiddle" border="0" />' + text;
        },


        modalInstance : null,

        /**
        * Show lightBox
        */
        showBox : function( modalID, href, width, height, openOnce ) {
            var open = openOnce == undefined ? true : false;
            this.modalInstance = new AuroraModal({
                modalID: modalID,
                href: href,
                width : width,
                height : height,
                openOnce : open
            });
        },


        /**
        * lightBox Loaded
        */
        boxLoaded : function( modalID ) {
            this.modalInstance.loaded( modalID );
        },


        /**
        * Close lightBox
        */
        closeBox : function( id ) {
            this.modalInstance.close( id );
        }
    },


    /**
    * Aurora.String Namespace
    */
    Aurora.String = {


        /**
        * Returns plural or non
        */
        getPlural : function( text, length ) {
            var str   = "";
            var split = text.split(" ");
            for( var i=0; i<split.length; i++ ) {
                if( split[i] == "{n}" ) {
                    str += length + " ";
                }
                else if( split[i].indexOf("|") > 0 ) {
                    var plural = split[i].split("|");
                    str += length == 1 ? plural[0] : plural[1];
                    str += " ";
                }
                else str += split[i] + " ";
            }
            return str;
        },

        /**
        * Truncate a text to length
        */
        truncate : function( text, length, trail ) {
            trail = trail == undefined ? '...' : trail;
            if( text.length > length ) {
                return text.substr( 0, length ) + trail;
            }
            return text;
        },

        truncateWithLink : function( element, length, trail ) {
            var text = element.html( );
            trail = trail == undefined ? '...' : trail;
            
            if( text.length > length ) {
                text = text.substring(0, length);
                text = text.replace(/\w+$/, '');
                text += '... <a href="#" class="extendText" onclick="this.parentNode.innerHTML=' +
                        'unescape(\''+escape( element.html( ) )+'\');return false;">See More</a>';
            }
            return element.html( text );
        },


        /**
        * Truncate a filename to length
        */
        truncateFileName : function( text, length, trail ) {
            trail = trail == undefined ? '...' : trail;
            if( text.length > length ) {
                ext = text.substr(-4);
                return text.substr( 0, (length-4) ) + trail + ext;
            }
            return text;
        },

        /**
        * Extract domain hostname from a URL
        */
        extractHostname : function( url ) {
            var result = url.match('^(?:f|ht)tp(?:s)?\://([^/]+)', 'im');
            if( result === null ) {
                return false;
            }
            return result[0];
        },

        /**
        * Scan text and return if URL detected
        */
        foundURL : function( text ) {
            var array = new Array( );
            var regex = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
            var match = text.match( regex );

            if( match !== null ) {
                text = text.replace( regex, "");
                for( var i=0; i<match.length; i++ ) {
                    array.push( $.trim( match[i] ) );
                }
            }
            //URLs starting with www. (without // before it, or it'd re-link the ones done above)
            match = text.match( /^([^\/\/])([a-z0-9_\-#?%&~+]+\.+){2,}([a-z0-9_\-\/#?%&~+|]+\.*)/gim );
            if( match !== null ) {
                for( var i=0; i<match.length; i++ ) {
                    array.push( $.trim( match[i] ) );
                }
            }
            if( array.length == 0 ) {
                return false;
            }
            return array;
        },


        /**
        * Number format function equivalent to PHP
        */
        numberFormat: function( number, decimals, decPoint, thousandsSep ) {
            var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
            var d = decPoint == undefined ? "," : decPoint;
            var t = thousandsSep == undefined ? "." : thousandsSep, s = n < 0 ? "-" : "";
            var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        },


        /**
        * Format file size
        */
        formatFileSize : function( bytes ) {
            if( bytes >= 1073741824 ) {
                bytes = this.numberFormat( bytes / 1073741824, 1, '.', '') + 'GB';
            }
            else if( bytes >= 1048576 ) {
                    bytes = this.numberFormat( bytes / 1048576, 1, '.', '') + 'MB';
            }
            else if( bytes >= 1024 ) {
                bytes = this.numberFormat(bytes / 1024, 0) + 'KB';
            }
            else {
                bytes = Math.round( this.numberFormat(bytes, 0) ) + ' B';
			}
            return bytes;
        },
        

        /**
        * Escape id attribute with . (period) when using with jQuery.
        */
        updateCounter : function( count ) {
            var title = document.title.toString( );
            if( count == 0 ) {
                $(".pmTag").hide( );
                $("#inboxCounter").html("");
                document.title = title.replace( "(1)", "" );
            }
            else {
                $(".pmTag").html( count );
                $("#inboxCount").html(count);
                document.title = title.replace( "(" + parseInt( count+1 ) + ")", "(" + count + ")" );
            }
        },


        /**
        * Escape id attribute with . (period) when using with jQuery.
        */
        cleanChars : function( str ) {
            var el = document.createElement("div");
                el.innerText = el.textContent = str;
                str = el.innerHTML;
                delete el;
            return $.trim( str.replace(/"/g, "&quot;") );
        },
        

        /**
        * Escape id attribute with . (period) when using with jQuery.
        */
        escID : function( id ) {
            return id.replace(/(:|\.)/g,'\\$1');
        },

        formatMoney: function( element, currency ) {
            t = defaultOptions;
            n = !isNaN(element) ? element : element.val( );
            n = n.replace(/[^0-9.-]+/g,"");
            n = this.toFixed(n);

            var i = [],
                u = [],
                r = n;
            n = (n = String(n.replace(/\,/g, "")).split("."), n.length > 2) ?
                r : t.zeroes === 0 && n.length === 2 ? r : t.zeroes !== 0 &&
                n[1] != null && n[1].length > t.zeroes ? r : (n[0] !== 0 &&
                (n[0] = n[0].replace(/^0*/, "")), (n[0] === "" || n[0] === 0) &&
                (n[0] = 0), i = this.formatThousands(n[0], t.thousands), u = this.formatDecimal(n[1], t.zeroes),
                    t.zeroes === 0 ? i : i + t.decimal + u);

            n = n.replace(/\.00$/,'');

            if( currency != undefined ) {
                return currency + n;
            }
            else if( !isNaN(element) ) {
                return element.attr("data-currency") + n;
            }
            return Aurora.currency + n;
        },

        formatThousands: function(n, t) {
            var r = [], i;
            for (n = String(n).split("").reverse(), i = 0; i < n.length; i++) i % 3 === 0 && i !== 0 && r.push(t), r.push(n[i]);
            return r.reverse().join("")
        },

        formatDecimal: function(n, t) {
            for (n = n || 0, n = String(n).substr(0, t), t = t - n.length, t; t > 0; t--) n = n + "0";
            return n
        },

        toFixed: function(n) {
            if( Math.abs(n) < 1 ) {
                var t = parseInt(n.toString().split("E-")[1]);
                t && (n *= Math.pow(10, t - 1), n = "0." + new Array(t).join("0") + n.toString().substring(2))
            }
            return n
        },

        unFormatMoney: function( n ) {
            return n.replace(/[^0-9.-]+/g,"");
        }
    },


    /**
    * Aurora.Object Namespace
    */
    Aurora.Object = {

        /**
        * Get an object Greatest Common Divisor GCD
        */
        getGCD : function( w, h ) {
            return (h == 0) ? w : Aurora.Object.getGCD(h, w%h);
        },


        /**
        * Check if a given array has duplicates
        */
        arrayHasDuplicate : function( arr ) {
            var i = arr.length, j, val;
            while(i--) {
                val = arr[i];
                j = i;
                while(j--) {
                    if( arr[j] === val ) {
                        return true;
                    }
                }
            }
            return false;
        },


        /**
        * Remove a value from an array
        */
        rmValue: function( array, item ) {
            for( var i in array ) {
                if( array[i] == item ) {
                    array.splice(i,1);
                    break;
                }
            }
            return array;
        },


        /**
        * Get total length for an associative array object
        */
        assocLength : function( array ) {
            var size = 0, key;
            for( key in array ) {
                if( array.hasOwnProperty(key)) size++;
            }
            return size;
        },


        /**
        * Dump object for debugging
        */
        dump : function( arr, level ) {
            var dumped_text = "";
            if(!level) level = 0;

            //The padding given at the beginning of the line.
            var level_padding = "";
            for(var j=0;j<level+1;j++) level_padding += "    ";

            if(typeof(arr) == 'object') { //Array/Hashes/Objects
                for(var item in arr) {
                    var value = arr[item];
                    if(typeof(value) == 'object') { //If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += dump(value,level+1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Stings/Chars/Numbers etc.
                dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
            }
            return dumped_text;
        }
    },
    

    /**
    * Aurora.Date Namespace
    */
    Aurora.Date = {

        /**
        * Return microtime
        */
        microtime: function( getFloat ) {
            var unixtime_ms = new Date( ).getTime( );
            var sec = parseInt(unixtime_ms / 1000);
            return getFloat ? (unixtime_ms/1000) : (unixtime_ms - (sec * 1000))/1000 + ' ' + sec;
        },
        

        /**
        * Calculates the age
        */
        getAge : function( month, day, year ) {
            var date = new Date( );
            tYear  = date.getYear( );
            tMonth = date.getMonth( );
            tDay   = date.getDate( );
            age    = (tYear+1900)-year;

            if( tMonth < (month-1 ) ) age--;
            if( ((month-1) == tMonth) && (tDay < day) ) age--;
            if( age > 1900 ) age -= 1900;
            return age;
        },


        /**
        * Calculates a date suffix
        */
        daySuffix : function( day ) {
            day = String( day );
            return day.substr(-(Math.min(day.length, 2))) > 3 &&
                   day.substr(-(Math.min(day.length, 2))) < 21 ?
                   "th" : ["th", "st", "nd", "rd", "th"][Math.min(Number(day)%10, 4)];
        }
    }
    Aurora.Init.start( );
});