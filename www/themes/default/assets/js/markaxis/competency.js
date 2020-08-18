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
        this.table = null;
        this.cache = [];
        this.element = $(".competencyList");
        this.modalCompetency = $("#modalCompetency");
        this.init( );
    };

    MarkaxisCompetency.prototype = {
        constructor: MarkaxisCompetency,

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

            $(document).on("click", ".competencyDelete", function(e) {
                that.competencyDelete( );
                e.preventDefault( );
            });

            $("#competencyBulkDelete").on("click", function(e) {
                that.competencyBulkDelete( );
                e.preventDefault( );
            });

            this.modalCompetency.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var cID = $invoker.attr("data-id");

                if( cID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if (obj.bool == 0) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#modalCompetency .modal-title").text("Edit Competency");
                                $("#competencyID").val( obj.data.cID );
                                $("#competency").val( obj.data.competency );
                                $("#competencyDescript").val( obj.data.descript );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/employee/getCompetency/" + cID, data );
                }
                else {
                    $("#modalCompetency .modal-title").text("Create New Competency");
                    $("#competencyID").val(0);
                    $("#competency").val("");
                    $("#competencyDescript").val("");
                }
            });

            this.modalCompetency.on("shown.bs.modal", function(e) {
                $("#competency").focus( );
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "competency" ) {
                    var cID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/competency/' + cID, function() {
                        $(".modal-title").text( $("#competency" + cID).text( ) );
                    });
                }
            });

            $("#saveCompetency").validate({
                rules: {
                    competency: { required: true }
                },
                messages: {
                    competency: "Please enter a Competency."
                },
                highlight: function(element, errorClass) {
                    $(element).addClass("border-danger");
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass("border-danger");
                    $(".modal-footer .error").remove();
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length == 0 )
                        $(".modal-footer").append(error);
                },
                submitHandler: function( ) {
                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveCompetency")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                that.table.ajax.reload();

                                swal({
                                    title: $("#competency").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Competency",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#competencyID").val(0);
                                    $("#competency").val("");
                                    $("#competencyDescript").val("");

                                    if( isConfirm === false ) {
                                        $("#modalCompetency").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#competency").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/employee/saveCompetency", data );
                }
            });

            if( typeof Bloodhound === "function" ) {
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
            }
        },

        /**
         * Delete
         * @return void
         */
        competencyDelete: function( ) {
            var that = this;
            var id = $(this).attr("data-id");
            var title = $("#competencyTable-row" + id).find("td").eq(1).text( );
            var cID = new Array( );
            cID.push( id );

            swal({
                title: "Are you sure you want to delete " + title + "?",
                text: "This action cannot be undone once deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Confirm Delete",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: cID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload();
                            swal("Done!", title + " has been successfully deleted!", "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/employee/deleteCompetency", data);
            });
        },


        /**
         * Delete Bulk
         * @return void
         */
        competencyBulkDelete: function( ) {
            var that = this;
            var cID = new Array( );
            $("input[name='cID[]']:checked").each(function(i) {
                cID.push( $(this).val( ) );
            });

            if( cID.length == 0 ) {
                swal({
                    title: "No Competency Selected",
                    type: "info"
                });
            }
            else {
                swal({
                    title: "Are you sure you want to delete the selected competencies?",
                    text: "This action cannot be undone once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Confirm Delete",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function( isConfirm ) {
                    if( isConfirm === false ) return;

                    var data = {
                        bundle: {
                            data: cID
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal("Error!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload( );
                                swal("Done!", obj.count + " items has been successfully deleted!", "success");
                                return;
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/employee/deleteCompetency", data);
                });
            }
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
        },

        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".competencyTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'competencyTable-row' + aData['cID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/employee/getCompetencyResults",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    },
                },
                initComplete: function() {
                    //
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets:[0],
                    checkboxes: {
                        selectRow: true
                    },
                    width: '10px',
                    orderable: false,
                    searchable : false,
                    data: 'cID',
                    render: function (data, type, full, meta) {
                        return '<input type="checkbox" class="dt-checkboxes check-input" name="cID[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '160px',
                    data: 'competency',
                    render: function (data, type, full, meta) {
                        return '<span id="competency' + full['cID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '400px',
                    data: 'descript'
                },{
                    targets: [3],
                    orderable: true,
                    width: '100px',
                    data: 'empCount',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data > 0 ) {
                            return '<a data-role="competency" data-id="' + full['cID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets: [4],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'cID',
                    render: function( data, type, full, meta ) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item competencyEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalCompetency" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> Edit Competency</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item competencyDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Competency</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                select: {
                    "style": "multi"
                },
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Competency',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(".competencyTable [type=checkbox]").uniform();

                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".competency-list-action-btns").insertAfter("#competencyList .dataTables_filter");

            // Alternative pagination
            $('#competencyList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('#competencyList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#competencyList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#competencyList .datatable tbody").on("mouseover", "td", function() {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index().column;

                if (colIdx !== null) {
                    $(that.table.cells().nodes()).removeClass('active');
                    $(that.table.column(colIdx).nodes()).addClass('active');
                }
            }).on('mouseleave', function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // Enable Select2 select for the length option
            $("#competencyList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisCompetency;
})();
var markaxisCompetency = null;
$(document).ready( function( ) {
    markaxisCompetency = new MarkaxisCompetency( );
});