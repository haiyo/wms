/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: claim.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisClaim = (function( ) {

    /**
     * MarkaxisClaim Constructor
     * @return void
     */
    MarkaxisClaim = function( ) {
        this.table = null;
        this.markaxisUSuggest = new MarkaxisUSuggest( );
        this.fileInput = null;
        this.fileSelected = false;
        this.validator = false;
        this.modalClaim = $("#modalClaim");
        this.init( );
    };

    MarkaxisClaim.prototype = {
        constructor: MarkaxisClaim,

        /**
         * Initialize first onload setup
         * @return void
         */
        init: function( ) {
            this.initTable( );
            this.initEvents( );
        },


        /**
         * Events Registration
         * @return void
         */
        initEvents: function( ) {
            var that = this;

            $(document).on("click", ".claimAction", function(e) {
                that.setClaimAction( $(this).attr("data-id"), $(this).hasClass("approve") ? 1 : "-1" );
                e.preventDefault( );
            });

            $(document).on("click", ".claimCancel", function(e) {
                that.claimCancel( $(this).attr("data-id") );
                e.preventDefault( );
            });

            $("#expense").select2( ).change(function( ) {
                $(this).valid( );
                $(this).removeAttr("aria-required");

                var data = {
                    bundle: {
                        eiID: $(this).val()
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 1 ) {
                            $("#maxAmount").html( obj.text );
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/expense/getMaxAmount/", data );
            });

            $("#currency").select2( ).change(function( ) {
                $(this).valid( );
                $(this).removeAttr("aria-required");
            });

            that.fileInput = $(".claimFileInput").fileinput({
                uploadUrl: Aurora.ROOT_URL + "admin/expense/upload/",
                uploadAsync: false,
                showUpload: false,
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'pdf', 'doc', 'docx'],
                showPreview: false,
                uploadExtraData: function(previewId, index) {
                    var data = {
                        ecID: $("#ecID").val( ),
                        csrfToken: Aurora.CSRF_TOKEN
                    };
                    return data;
                }
            }).on('fileuploaderror', function( event, data, msg ) {
                that.fileSelected = false;
            }).on('filebatchuploadsuccess', function(event, data) {
                that.updateAll( );
            });

            that.fileInput.change(function () {
                that.fileSelected = true;
            });

            that.modalClaim.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var ecID = $invoker.attr("data-id");

                if( ecID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalClaim .modal-title").text("Edit Claim");
                                $("#ecID").val( obj.data.ecID )
                                $("#expense").val( obj.data.eiID ).trigger("change");
                                $("#claimDescript").val( obj.data.descript );
                                $("#claimAmount").val( obj.data.amount );
                                $("#ecaUploadField").val( obj.data.uploadName );

                                that.markaxisUSuggest.setSuggestToken( obj.data.managers );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/expense/getClaim/" + ecID, data );
                }
                else {
                    $("#modalClaim .modal-title").text("Create New Claim");
                    $("#ecID").val(0);
                    $("#claimDescript").val("");
                    $("#claimAmount").val("");
                    $("#ecaUploadField").val("");

                    that.markaxisUSuggest.clearToken( );
                    that.markaxisUSuggest.getSuggestToken("admin/user/getSuggestToken" );
                }
            });

            that.validator = $("#saveClaim").validate({
                ignore: "",
                rules: {
                    expense: { required: true },
                    claimAmount: { required: true }
                },
                messages: {
                    expense: "Please provide all required fields."
                },
                highlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).addClass("border-danger");
                    }
                    else {
                        elem.addClass("border-danger");
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).removeClass("border-danger");
                    }
                    else {
                        elem.removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length == 0 )
                        $(".modal-footer").append(error);
                },
                submitHandler: function( ) {
                    $("#expense-error").remove( );

                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveClaim")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );

                            if( obj.bool == 0 ) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#ecID").val(obj.data.ecID);

                                if( that.fileSelected ) {
                                    that.fileInput.fileinput("upload");
                                }
                                else {
                                    that.updateAll( );
                                }

                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/expense/saveClaim", data );
                }
            });
        },


        setClaimAction: function( ecID, approved ) {
            var data = {
                bundle: {
                    ecID: ecID,
                    approved: approved
                },
                success: function( res   ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 1 ) {
                        $("#list-" + ecID).fadeOut("slow", function( ) {
                            $(this).remove( );

                            if( $(".requestList").length == 0 ) {
                                $("#tableRequest").remove( );
                                $("#noRequest").show( );
                            }
                            else if( $(".claimAction").length == 0 ) {
                                $("#group-claim").remove( );
                            }
                            return;
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/expense/setClaimAction", data );
        },


        claimCancel: function( ecID ) {
            var that = this;
            var title = $("#list-" + ecID + " > td:first-child > span").text( );

            swal({
                title: "Are you sure you want to cancel the claim " + title + "?",
                text: "This action cannot be undone once cancelled",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Cancel",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if( isConfirm === false ) return;

                var data = {
                    bundle: {
                        data: ecID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            if( $("#list-" + ecID).length > 0 ) {
                                $("#list-" + ecID).fadeOut("slow", function( ) {
                                    $(this).remove();

                                    if( $(".requestList").length == 0 ) {
                                        $("#tableRequest").remove( );
                                        $("#noRequest").show( );
                                    }
                                    else if( $(".claimAction").length == 0 ) {
                                        $("#group-claim").remove( );
                                    }
                                });
                            }
                            else {
                                that.table.ajax.reload();
                            }
                            swal("Done!", title + " has been successfully cancelled!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/expense/cancelClaim", data);
            });
        },


        updateAll: function( ) {
            var that = this;

            that.table.ajax.reload( );
            $("#expense").val("").trigger("change");
            $("#expense-error").remove( );
            $("#claimDescript").val("");
            $("#claimAmount").val("");
            that.fileSelected = false;
            that.validator.resetForm( );

            swal({
                title: "Claim has been successfully created!",
                text: "What do you want to do next?",
                type: 'success',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Create Another Claim",
                cancelButtonText: "Close Window",
                reverseButtons: true
            }, function( isConfirm ) {
                if( isConfirm === false ) {
                    that.modalClaim.modal("hide");
                }
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".claimTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', 'claimTable-row' + aData['ecID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/expense/getClaimResults",
                    type: "POST",
                    data: function(d) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function () {
                    /*var api = this.api();
                    var that = this;
                    $('input').on('keyup change', function() {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });*/
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    searchable: false,
                    width: "150px",
                    data: "title",
                    render: function( data, type, full, meta ) {
                        return '<span id="claim' + full['ecID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    searchable: false,
                    width: "180px",
                    data: "descript",
                    render: function( data, type, full, meta ) {
                        return '<span id="claimDescript' + full['ecID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "amount",
                    render: function( data, type, full, meta ) {
                        return Aurora.currency + data;
                    }
                },{
                    targets: [3],
                    orderable: true,
                    searchable: false,
                    width: "110px",
                    data: "uploadName",
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data ) {
                            return '<div class="text-ellipsis"><a target="_blank" href="' + Aurora.ROOT_URL +
                                'admin/file/view/claim/' + full['uID'] + '/' + full['hashName'] + '">' + data + '</a></div>';
                        }
                        else {
                            return '';
                        }
                    }
                },{
                    targets: [4],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "status",
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( full['cancelled'] == 1 ) {
                            return '<span id="status' + full['piID'] + '" class="label label-default">Cancelled</span>';
                        }
                        else {
                            if( data == 0 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-pending">Pending Approval</span>';
                            }
                            else if( data == 1 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-success">Approved</span>';
                            }
                            else if( data == 2 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-success">Paid</span>';
                            }
                            else {
                                return '<span id="status' + full['piID'] + '" class="label label-danger">Disapproved</span>';
                            }
                        }
                    }
                },{
                    targets: [5],
                    orderable: false,
                    searchable : false,
                    width: '140px',
                    data: 'managers',
                    render: function(data, type, full, meta) {
                        //var name   = full["name"];
                        //var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"
                        var length = data.length;
                        var managers = "";

                        for( var i=0; i<length; i++ ) {
                            if( data[i]["approved"] == 0 ) {
                                managers += '<i class="icon-watch2 text-grey-300 mr-3"></i>';
                            }
                            else if( data[i]["approved"] == 1 ) {
                                managers += '<i class="icon-checkmark4 text-green-800 mr-3"></i>';
                            }
                            else if( data[i]["approved"] == "-1" ) {
                                managers += '<i class="icon-cross2 text-warning-800 mr-3"></i>';
                            }
                            managers += data[i]["name"] + "<br />";
                        }
                        return managers;
                    }
                },{
                    targets: [6],
                    orderable: true,
                    searchable: false,
                    width: "100px",
                    data: "created"
                },{
                    targets: [7],
                    orderable: false,
                    searchable: false,
                    width:"100px",
                    className:"text-center",
                    data:"ecID",
                    render: function( data, type, full, meta ) {
                        if( full['cancelled'] != 1 && full['status'] != 1 && full['status'] != 2 ) {
                            return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="icon-menu7"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">' +
                                '<a class="dropdown-item" data-id="' + data + '" data-backdrop="static" data-keyboard="false" ' +
                                'data-toggle="modal" data-target="#modalClaim">' +
                                '<i class="icon-pencil5"></i> Edit Claim</a>' +
                                '<div class="divider"></div>' +
                                '<a class="dropdown-item claimCancel" data-id="' + data + '">' +
                                '<i class="icon-cross2"></i> Cancel Claim</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }
                        return '';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Claim',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    $(".payItemTable [type=checkbox]").uniform();
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".claim-list-action-btns").insertAfter("#claim .dataTables_filter");

            $('.claimTable tbody').on('mouseover', 'td', function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function( ) {
                $(that.table.cells( ).nodes( )).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#claim .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisClaim;
})();
var markaxisClaim = null;
$(document).ready( function( ) {
    markaxisClaim = new MarkaxisClaim( );
});