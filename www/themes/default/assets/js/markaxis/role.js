/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: role.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisRole = (function( ) {

    /**
     * MarkaxisRole Constructor
     * @return void
     */
    MarkaxisRole = function( ) {
        this.table = null;
        this.modalRole = $("#modalRole");
        this.init( );
    };

    MarkaxisRole.prototype = {
        constructor: MarkaxisRole,

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

            $("#dID").select2( );

            $(document).on("click", ".permGroup", function(e) {
                that.permGroup( $(this) );
                e.preventDefault( );
            });

            $("#savePerm").on("click", function (e) {
                that.savePerm( );
                e.preventDefault( );
            });

            $(document).on("click", ".roleDelete", function (e) {
                that.roleDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.modalRole.on("shown.bs.modal", function(e) {
                $("#roleTitle").focus( );
            });

            that.modalRole.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var roleID = $invoker.attr("data-id");

                if( roleID ) {
                    var data = {
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool == 0 ) {
                                swal("error", obj.errMsg);
                                return;
                            }
                            else {
                                $("#roleID").val( obj.data.roleID );
                                $("#roleTitle").val( obj.data.title );
                                $("#roleDescript").val( obj.data.descript );
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/role/getRole/" + roleID, data );
                }
                else {
                    $("#roleID").val(0);
                    $("#roleTitle").val("");
                    $("#roleDescript").val("");
                }
            });

            $("#modalPermission").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/user/getPermList/' + $invoker.attr("data-id"), function() {
                    $(".switch").bootstrapSwitch('disabled',false);
                    $(".switch").bootstrapSwitch('state', false);
                    that.getPerms( $invoker.attr("data-id") );
                });
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "role" ) {
                    var rID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/role/' + rID, function( ) {
                        $(".modal-title").text( $("#roleTitle" + rID).text( ) );
                    });
                }
            });

            $("#saveRole").validate({
                rules: {
                    roleTitle: { required: true }
                },
                messages: {
                    roleTitle: "Please enter a Role Title."
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
                            data: Aurora.WebService.serializePost("#saveRole")
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
                                    title: $("#roleTitle").val( ) + " has been successfully created!",
                                    text: "What do you want to do next?",
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: "Create Another Role",
                                    cancelButtonText: "Close Window",
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#roleID").val(0);
                                    $("#roleTitle").val("");
                                    $("#roleDescript").val("");

                                    if( isConfirm === false ) {
                                        $("#modalRole").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#roleTitle").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/role/saveRole", data );
                }
            });
        },


        /**
         * Get Permissions
         * @return void
         */
        permGroup: function( ele ) {
            var id = ele.attr("data-id");

            if( !ele.hasClass("groupShow") ) {
                $(".permRow-" + id).removeClass("hide");
                ele.addClass("groupShow");
                ele.children( ).addClass("parentGroupLit");
                $("#groupIco-" + id).removeClass("icon-shrink7").addClass("icon-enlarge7");
                $(".permTable tbody").scrollTo( $(".permGroup-" + id), 500 );
            }
            else {
                $(".permRow-" + id).addClass("hide");
                ele.removeClass("groupShow");
                ele.children( ).removeClass("parentGroupLit");
                $("#groupIco-" + id).removeClass("").addClass("icon-shrink7");
            }
        },


        /**
         * Get Permissions
         * @return void
         */
        getPerms: function( roleID ) {
            var data = {
                bundle: {
                    "roleID": roleID
                },
                success: function( res ) {
                    $("#defineTitle").text( $("#roleTitle" + roleID).text( ) );

                    var perms = $.parseJSON( res );

                    $("#roleID").val( roleID );
                    $(".switch").bootstrapSwitch('disabled',false);
                    $(".switch").bootstrapSwitch('state', false);
                    $.each(perms, function(index, value) {
                        $("#perm_" + value['permID']).bootstrapSwitch('state', true);
                    });
                }
            };
            Aurora.WebService.AJAX( "admin/rolePerm/getPerms", data );
        },


        /**
         * Save Permissions
         * @return void
         */
        savePerm: function( ) {
            var checked = []
            $(".switch:checked").each(function( ) {
                checked.push( parseInt( $(this).val( ) ) );
            });

            var data = {
                bundle: {
                    "roleID": $("#roleID").val( ),
                    "perms": checked
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );

                    if( obj.bool == 0 && obj.errMsg ) {
                        return;
                    }
                    swal("Done!", "Permissions saved!", "success");
                }
            };
            Aurora.WebService.AJAX( "admin/rolePerm/savePerms", data );
        },


        /**
         * Delete
         * @return void
         */
        roleDelete: function( roleID ) {
            var title = $("#roleTitle" + roleID).text( );

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
                        data: roleID
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
                Aurora.WebService.AJAX("admin/role/deleteRole", data);
            });
        },

        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".rolePermTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'roleTable-row' + aData['roleID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/employee/getRolePermResults",
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
                    targets: [0],
                    orderable: true,
                    width: '160px',
                    data: 'title',
                    render: function(data, type, full, meta) {
                        return '<span id="roleTitle' + full['roleID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '400px',
                    data: 'descript'
                },{
                    targets: [2],
                    orderable: true,
                    width: '100px',
                    data: 'empCount',
                    className : "text-center",
                    render: function (data, type, full, meta) {
                        if( data > 0 ) {
                            return '<a data-role="role" data-id="' + full['roleID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets: [3],
                    orderable: false,
                    searchable : false,
                    width: '80px',
                    className : "text-center",
                    data: 'roleID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalRole">' +
                            '<i class="icon-pencil5"></i> Edit Role</a>' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-backdrop="static" ' +
                            'data-keyboard="false" data-target="#modalPermission">' +
                            '<i class="icon-lock2"></i> Define Permissions</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item roleDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> Delete Role</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search Role Name',
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of Rows:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".rolePerm-list-action-btns").insertAfter("#rolePermList .dataTables_filter");

            // Alternative pagination
            $('#rolePermList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('#rolePermList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#rolePermList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#rolePermList .datatable tbody").on("mouseover", "td", function() {
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
            $("#rolePermList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisRole;
})();
var markaxisRole = null;
$(document).ready( function( ) {
    markaxisRole = new MarkaxisRole( );
});