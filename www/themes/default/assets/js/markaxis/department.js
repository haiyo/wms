/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: department.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisDepartment = (function( ) {

    /**
     * MarkaxisDepartment Constructor
     * @return void
     */
    MarkaxisDepartment = function( ) {
        this.table = null;
        this.markaxisUSuggest = new MarkaxisUSuggest({includeOwn:true});
        this.modalDepartment = $("#modalDepartment");
        this.init( );
    };

    MarkaxisDepartment.prototype = {
        constructor: MarkaxisDepartment,

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

            $(document).on("click", ".departmentDelete", function(e) {
                that.departmentDelete( $(this).attr("data-id") );
                e.preventDefault( );
            });

            that.modalDepartment.on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);
                var dID = $invoker.attr("data-id");
                that.markaxisUSuggest.clearToken( );

                if( dID ) {
                    var data = {
                        success: function(res) {
                            var obj = $.parseJSON(res);

                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                $("#modalDepartment .modal-title").text( Markaxis.i18n.DepartmentRes.LANG_EDIT_DEPARTMENT );
                                $("#departmentID").val( obj.data.dID );
                                $("#departmentName").val( obj.data.name );
                                that.markaxisUSuggest.getSuggestToken("admin/company/getSuggestToken/" + obj.data.dID);
                            }
                        }
                    }
                    Aurora.WebService.AJAX( "admin/company/getDepartment/" + dID, data );
                }
                else {
                    $("#modalDepartment .modal-title").text( Markaxis.i18n.DepartmentRes.LANG_CREATE_NEW_DEPARTMENT );
                    $("#departmentID").val(0);
                    $("#departmentName").val("");
                }
            });

            that.modalDepartment.on("shown.bs.modal", function(e) {
                $("#departmentName").focus( );
            });

            $("#modalEmployee").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                if( $invoker.attr("data-role") == "department" ) {
                    var dID = $invoker.attr("data-id");

                    $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/employee/getCountList/department/' + dID, function() {
                        $(".modal-title").text( $("#departName" + dID).text( ) );
                    });
                }
            });

            $("#saveDepartment").validate({
                rules: {
                    departmentName: { required: true }
                },
                messages: {
                    departmentName: Markaxis.i18n.DepartmentRes.LANG_ENTER_DEPARTMENT_NAME
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
                    if( $(".tt-input").val( ) != "" && that.markaxisUSuggest.getCount( ) == 0 ) {
                        $(".modal-footer").append('<label id="departmentName-error" class="error">' + Markaxis.i18n.DepartmentRes.LANG_ENTER_VALID_MANAGER + '</label>');
                        return;
                    }

                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveDepartment")
                        },
                        success: function( res ) {
                            var obj = $.parseJSON( res );
                            if( obj.bool == 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                that.table.ajax.reload();

                                swal({
                                    title: Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_CREATED.replace('{title}', $("#departmentName").val( )),
                                    text: Aurora.i18n.GlobalRes.LANG_WHAT_TO_DO_NEXT,
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-success',
                                    cancelButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                    showCancelButton: true,
                                    confirmButtonText: Markaxis.i18n.DepartmentRes.LANG_CREATE_ANOTHER_DEPARTMENT,
                                    cancelButtonText: Aurora.i18n.GlobalRes.LANG_CLOSE_WINDOW,
                                    reverseButtons: true
                                }, function( isConfirm ) {
                                    $("#departmentID").val(0);
                                    $("#departmentName").val("");
                                    that.markaxisUSuggest.clearToken( );

                                    if( isConfirm === false ) {
                                        $("#modalDepartment").modal("hide");
                                    }
                                    else {
                                        setTimeout(function() {
                                            $("#departmentName").focus( );
                                        }, 500);
                                    }
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX( "admin/company/saveDepartment", data );
                }
            });
        },


        departmentDelete: function( dID ) {
            var that = this;
            var title = $("#departName" + dID).text( );

            swal({
                title: Aurora.i18n.GlobalRes.LANG_ARE_YOU_SURE_DELETE.replace('{title}', title),
                text: Aurora.i18n.GlobalRes.LANG_CANNOT_UNDONE_DELETED,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function( isConfirm ) {
                if (isConfirm === false) return;

                var data = {
                    bundle: {
                        data: dID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.table.ajax.reload( );
                            swal( Aurora.i18n.GlobalRes.LANG_DONE + "!", Aurora.i18n.GlobalRes.LANG_SUCCESSFULLY_DELETE.replace('{title}', title), "success");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/company/deleteDepartment", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".departmentTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'departmentTable-row' + aData['dID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/company/getDepartmentResults",
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
                    width: '250px',
                    data: 'name',
                    render: function( data, type, full, meta ) {
                        return '<span id="departName' + full['dID'] + '">' + data + '</span>';
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '320px',
                    data: 'managers',
                    render: function( data, type, full, meta ) {
                        var groups = '<div class="group-item">';

                        for( var obj in data ) {
                            if( data[obj].name != null ) {
                                groups += '<span class="badge badge-primary badge-criteria">' + data[obj].name + '</span> ';
                            }
                        }
                        return groups + '</div>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '150px',
                    data: 'empCount',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( data > 0 ) {
                            return '<a data-role="department" data-id="' + full['dID'] + '" data-toggle="modal" data-target="#modalEmployee">' + data + '</a>';
                        }
                        else {
                            return data;
                        }
                    }
                },{
                    targets: [3],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'dID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                            '<a class="dropdown-item departmentEdit" data-id="' + data + '" data-toggle="modal" data-target="#modalDepartment" ' +
                            'data-backdrop="static" data-keyboard="false">' +
                            '<i class="icon-pencil5"></i> ' + Markaxis.i18n.DepartmentRes.LANG_EDIT_DEPARTMENT + '</a>' +
                            '<div class="divider"></div>' +
                            '<a class="dropdown-item departmentDelete" data-id="' + data + '">' +
                            '<i class="icon-bin"></i> ' + Markaxis.i18n.DepartmentRes.LANG_DELETE_DEPARTMENT + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"f><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.DepartmentRes.LANG_SEARCH_DEPARTMENT,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                    Popups.init();
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".department-list-action-btns").insertAfter("#departmentList .dataTables_filter");

            // Alternative pagination
            $('#departmentList .datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('#departmentList .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('#departmentList .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $("#departmentList .datatable tbody").on("mouseover", "td", function() {
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
            $("#departmentList .dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisDepartment;
})();
var markaxisDepartment = null;
$(document).ready( function( ) {
    markaxisDepartment = new MarkaxisDepartment( );
});