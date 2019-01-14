/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, June 4th, 2012
 * @version $Id: aurora.uploader.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

var AuroraUploader = (function( ) {

    AuroraUploader = function( options ) {
        this.settings = $.extend({
            fileInputId: "file-input",
            fileDragId: "", 
            fileDataName: "file",
            queueSizeLimit: 50,
            bytesPerChunk: 1048576, // 1MB
            handler: "",
            mimeTypes: "" // "image/jpeg,image/gif"
        }, options );

        this.filesQueue = [];
        this.xhrObj = null;
        this.currentUploadedFileId = 0;
        this.mimeTypes = "";
        this.totalSize = 0;
        this.itemsInQueue = 0;
        this.blob = "";
        this.fileSize = 0;
        this.numChunks = 0;
        this.uploaders = [];
        this.loadedBytes = 0;
        this.formData = "";

        // run init function
        this.init( );

    };

    AuroraUploader.prototype = {
        constructor: AuroraUploader,

        init: function( ) {
            if( this.settings.handler == "" ) {
                console.log("Upload path handler not set!")
            }
            var fileInput = $("#" + this.settings.fileInputId );
            
            if( fileInput.length == 0 ) {
                console.log("Unable to find fileInput with ID: " + this.settings.fileInputId);
            }
            
            if( this.settings.mimeTypes != "" ) {
                fileInput.attr( "accept", this.settings.mimeTypes );
                this.mimeTypes = this.settings.mimeTypes.split(",");
            }
            fileInput.bind( "click",  function( ) {$("#file").val("");});
            fileInput.bind( "change", this.bind( this.fileSelected, this ) );

            if( this.settings.fileDragId != "" ) {
                var dragID = this.settings.fileDragId != "body" ? "#" + this.settings.fileDragId : "body";
                $(dragID)
                .bind( "dragenter", this.bind( this.fileDragHover, this ) )
                .bind( "dragover", this.bind( this.fileDragHover, this ) )
                .bind( "drop", this.bind( this.fileSelectHandler, this ) );
            }
        },

        fileDragHover: function( e ) {
            e.originalEvent.stopPropagation( );
            e.originalEvent.preventDefault( );
        },

        fileSelectHandler: function( e ) {
            e.originalEvent.stopPropagation( );
            e.originalEvent.preventDefault( );
            this.fileSelected( e, true );
        },

        browse: function( ) {
            var fileInput = $("#" + this.settings.fileInputId);
            fileInput.trigger("click");
        },

        /* general functions */
        bind: function( fn, bind ) {
            return function( ) {
                fn.apply(bind, arguments);
            };
        },

        /* removes whitespaces */
        trimString: function( inputString ) {
            return inputString.replace(/^\s+|\s+$/g, "");
        },

        /*
        * enforceQueueLimits function :
        * verify queue limit,
        * verify file size
        * verify max queue size
        * verify file is not already added - avoid duplicates
        * maybe file type rule here ?
        */
        enforceQueueLimits: function( file ) {
            // verify queue length
            var errObj = new Object( );
            errObj.file = file;
            if( this.filesQueue.length >= this.settings.queueSizeLimit ) {
                if( this.settings.queueSizeLimit == 1 ) {
                    // performs overwrite
                    this.clearQueue( );
                }
                else {
                    errObj.reason = "Queue is Full";
                    $(this).trigger("onErrorAddingFile", errObj);
                    return false;
                }
            }
            // verify mime types
            if( this.mimeTypes.length != 0 ) {
                var mimeTypeFound = false;
                var fileMimeType = file.type;
                for( var i=0; i<this.mimeTypes.length; i++ ) {
                    if( this.trimString( this.mimeTypes[i] ) == fileMimeType ) {
                        mimeTypeFound = true;
                        break;
                    }
                }
                if( !mimeTypeFound ) {
                    errObj.reason = "File type not allowed (" + fileMimeType + ")";
                    $(this).trigger("onErrorAddingFile", errObj);
                    return false;
                }
            }

            // verify file size
            if ( $("#uploadBytes")[0] && $("#uploadBytes").val( ) > 0 ) {
                if( file.size > $("#uploadBytes").val( ) ) {
                    errObj.reason = "Sorry, the file " + file.name + " has exceeded the upload size limit of " + $("#uploadBytesTxt").val( ) + ".";
                    $(this).trigger("onErrorAddingFile", errObj);
                    return false;
                }
            }

            // verify total size
            if ( $("#totalBytes")[0] && $("#totalBytes").val( ) > 0 ) {
                if( this.totalSize + file.size > $("#totalBytes").val( ) ) {
                    errObj.reason = "Sorry, the total number of files has exceeded the upload size limit of " + $("#totalBytesTxt").val( ) + ".";
                    $(this).trigger("onErrorAddingFile", errObj);
                    return false;
                }
            }

            // verify file was not added before
            if( this.filesQueue.length > 0 ) {
                for( var i=0; i<this.filesQueue.length; i++ ) {
                    if( this.filesQueue[i].file.size == file.size &&
                        this.filesQueue[i].file.name == file.name ) {
                        errObj.reason = "The file " + this.filesQueue[i].file.name + " has already been added to queue";
                        $(this).trigger("onErrorAddingFile", errObj);
                        return false;
                    }
                }
            }
            return true;
        },

        /* goes over the queue and calculates total size */
        calculateQueueFileSizes: function( ) {
            this.totalSize = 0;
            for( var i=0; i<this.filesQueue.length; i++ ) {
                this.totalSize += this.filesQueue[i].file.size;
            }
            this.itemsInQueue = this.filesQueue.length;
        },

        /* canceles the file if currently uploaded and removes from queue  */
        cancel: function( fileId ) {
            // if currently uploaded file is canceled cancel request
            if( this.currentUploadedFileId == fileId ) {
                this.currentUploadedFileId = "";
                xhrObj.abort( );
            }
            var fileObj = this.getFileObjById(fileId);
            if( fileObj != null ) {
                var newfilesQueue = [];
                for( var i in this.filesQueue ) {
                    if( this.filesQueue[i].id != fileId ) {
                        newfilesQueue.push( this.filesQueue[i] );
                    }
                }
                this.filesQueue = newfilesQueue;
                this.calculateQueueFileSizes( );
                 // for ie.... zzzz
                $("#" + this.settings.fileInputId).replaceWith( $("#" + this.settings.fileInputId).clone(true) );
                $("#" + this.settings.fileInputId).val(""); // for other browsers
                $(this).trigger("onCancel", fileObj);
            }
        },

        /* empties the queue, and canceles current upload if any */
        clearQueue: function( ) {
            while( this.filesQueue.length != 0 ) {
                this.cancel( this.filesQueue[0].id );
            }
        },

        getNextFileFromQueue: function( ) {
            for( var i in this.filesQueue ) {
                if( this.filesQueue[i].status == 0 ) {
                    return this.filesQueue[i];
                }
            }
            return null;
        },

        getFileObjById: function( fileId ) {
            for( var i in this.filesQueue ) {
                if( this.filesQueue[i].id == fileId ) {
                    return this.filesQueue[i];
                }
            }
            return null;
        },

        fileSelected: function( e, drag ) {
            var input = drag ? e.originalEvent.dataTransfer : e.target;
            if( typeof input === "undefined" ) {
                return false;
            }
            for( var i=0; i<input.files.length; i++ ) {
                var selectedFile = input.files[i];
                if( this.enforceQueueLimits( selectedFile ) ) {
                    var fileObj = new Object( );
                    fileObj.id = Math.floor( Math.random( ) * 100000000 ); // generate random file id
                    fileObj.file = selectedFile;
                    fileObj.status = 0;
                    this.filesQueue.push( fileObj );
                    this.calculateQueueFileSizes( );
                    $(this).trigger( "onAddedToQueue", fileObj );
                }
            }
            return;
        },

        uploadFiles: function( formData ) {
            this.formData = formData;
            if( this.currentUploadedFileId == 0 ) {
                this.uploadNextFile( );
            }
        },

        uploadNextFile: function( ) {
            var fileToUpload = this.getNextFileFromQueue( );

            if( fileToUpload != null ) {
                fileToUpload = this.normalizeFile( fileToUpload );
                $(this).trigger( "onUploadStarted", fileToUpload );
                
                var fd = new FormData( );
                //fd.append( "action", "upload" );
                //fd.append( "fileId", fileToUpload.id );
                //fd.append( "files", fileToUpload.file );
                fd.append( "csrfToken", Aurora.CSRF_TOKEN );
                for( var i in this.formData ) {
                    fd.append( i, this.formData[i] );
                }

                this.blob = fileToUpload.file;
                this.fileSize = this.blob.size;
                this.currentUploadedFileId = fileToUpload.id;
                
                // Not in use
                //this.numChunks = Math.max( Math.floor( size / this.settings.bytesPerChunk ), 1 );
                var start = 0;
                var end   = this.settings.bytesPerChunk;
                var chunk = 0;

                while( start < this.fileSize ) {
                    // Note: blob.slice has changed semantics and been prefixed.
                    // See http://groups.google.com/a/chromium.org/group/chromium-apps/browse_thread/thread/5bd921ad25449471/40a69d12b69072ec
                    if( "mozSlice" in this.blob ) {
                        chunk = this.blob.mozSlice( start, end );
                    }
                    else {
                        chunk = this.blob.slice( start, end );
                    }
                    //console.log( end );
                    start = end;
                    end   = start + this.settings.bytesPerChunk;
                    fd.append( "file", chunk );
                    this.upload( fd );
                }
            }
            else {
                this.currentUploadedFileId = 0;
                //this.clearQueue( );
                $(this).trigger("onAllComplete");
            }
        },
        
        upload: function( formData ) {
            var xhr = new XMLHttpRequest( );
            xhr.upload.addEventListener( "progress", this.bind( this.uploadProgress, this ), false );
            xhr.addEventListener( "load",  this.bind( this.uploadComplete, this ), false );
            xhr.addEventListener( "error", this.bind( this.uploadFailed,   this ), false );
            xhr.addEventListener( "abort", this.bind( this.uploadCanceled, this ), false );
            xhr.open( "POST", this.settings.handler, true );
            xhr.setRequestHeader( "X-File-Name", this.blob.name );
            xhr.setRequestHeader( "X-File-Size", this.fileSize );
            this.uploaders.push( xhr );
            xhr.send( formData );

        },

        uploadProgress: function( e ) {console.log(e.target.response)
            var progressObj = new Object( );
            progressObj.fileId = this.currentUploadedFileId;
            progressObj.lengthComputable = e.lengthComputable;
            progressObj.loaded = e.loaded;
            progressObj.totalLoaded = this.loadedBytes;
            progressObj.position = e.position;
            progressObj.total = e.total;
            progressObj.totalSize = this.fileSize;
            $(this).trigger( "onProgress", progressObj );
        },

        uploadComplete: function( e ) {
            this.uploaders.pop( );
            console.log(e.target.response)
            var obj = $.parseJSON( e.target.response );
            this.loadedBytes += obj.chunkSize;

            if( !this.uploaders.length ) {
                var fileObj = this.getFileObjById( this.currentUploadedFileId );
                if( fileObj != null ) {
                    fileObj.fileId = this.currentUploadedFileId;
                    fileObj.status = 2;
                    $(this).trigger( "onComplete", {fileObj:fileObj, response:obj});
                    this.loadedBytes = 0;
                }
                this.uploadNextFile( );
            }
        },

        uploadFailed: function( e ) {
            var fileObj = this.getFileObjById(this.currentUploadedFileId);
            if( fileObj ) {
                fileObj.status = 3;
                $(this).trigger("onError", {fileObj: fileObj, response:e});
            }
            this.uploadNextFile( );
        },

        uploadCanceled: function( e ) {
            var fileObj = this.getFileObjById(this.currentUploadedFileId);
            if( fileObj ) {
                fileObj.status = 4;
                $(this).trigger("onError", fileObj, e);
            }
            this.uploadNextFile( );
        },

        // File Normalization for Gecko 1.9.1 (Firefox 3.5) support:
        normalizeFile: function ( file ) {
            if( file.name === undefined && file.size === undefined ) {
                file.name = file.fileName;
                file.size = file.fileSize;
            }
            return file;
        }
    };
    return AuroraUploader;
})();
function auroraUploaderLoader( ) {}