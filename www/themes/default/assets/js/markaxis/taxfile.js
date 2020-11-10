/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: taxfile.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisTaxFile = (function( ) {

    /**
     * MarkaxisTaxFile Constructor
     * @return void
     */
    MarkaxisTaxFile = function( ) {
        this.table = null;
        this.itemAdded = false;
        this.haveSaved = false;
        this.detailRows = [];
        this.modalCalPayroll = $("#modalCalPayroll");
        this.init( );
    };

    MarkaxisTaxFile.prototype = {
        constructor: MarkaxisTaxFile,

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

            $(document).on("click", ".authIRAS", function (e) {
                that.authIRAS( $(this).attr("data-id") );
                e.preventDefault( );
            });

            $("#year").select2({minimumResultsForSearch: Infinity});
            $("#office").select2({minimumResultsForSearch: Infinity});
            $("#sourceType").select2({minimumResultsForSearch: Infinity});
            $("#paymentType").select2({minimumResultsForSearch: Infinity});
            $("#orgIDType").select2({minimumResultsForSearch: Infinity});

            $(".styled").uniform({
                radioClass: 'choice'
            });

            $.fn.stepy.defaults.legend = false;
            $.fn.stepy.defaults.transition = 'fade';
            $.fn.stepy.defaults.duration = 150;
            $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> ' + Aurora.i18n.GlobalRes.LANG_BACK;
            $.fn.stepy.defaults.nextLabel = Aurora.i18n.GlobalRes.LANG_NEXT + ' <i class="icon-arrow-right14 position-right"></i>';

            $(".stepy").stepy({
                titleClick: false,
                validate: false,
                block: true,
                back: function (index) {

                },
                next: function (index) {
                    if( index == 2 ) {
                        that.createForm( );
                    }
                    else if( index == 3 ) {
                        if( markaxisTaxFileEmployee.selected.length == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", "Please select employee", "error");
                        }
                        else {
                            markaxisTaxFileDeclare.initTable( );
                            $(".stepy").stepy("step", 3);
                        }
                    }
                    return false;
                },
                finish: function(index) {
                    //that.confirmFinalize();
                    return false;
                }
            });

            var stepy = $(".stepy-step");
            stepy.find(".button-next").addClass("btn btn-primary btn-next");
            stepy.find(".button-back").addClass("btn btn-default");
        },


        createForm: function( ) {
            var data = {
                bundle: {
                    data: Aurora.WebService.serializePost("#irasForm")
                },
                success: function (res) {
                    var obj = $.parseJSON(res);
                    if( obj.bool === 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        if( obj.data != "update" ) {
                            $("#ir8aID").val( obj.data );
                        }
                        $(".stepy").stepy("step", 2);
                    }
                }
            };
            Aurora.WebService.AJAX("admin/taxfile/createForm", data);
        },


        authIRAS: function( tfID ) {
            swal({
                title: "Confirm submit to IRAS?",
                text: "You will be redirected to CorpPass website for authentication. Please have your CorpPass login information ready.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Proceed to CorpPass",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                $(".icon-bin").removeClass("icon-bin").addClass("icon-spinner2 spinner");

                var data = {
                    bundle: {
                        tfID: tfID
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            location.href = obj.url;
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/authIRAS", data);
            });
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            that.table = $(".taxfileTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/taxfile/getTaxFileResults/",
                    type: "POST",
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                    }
                },
                initComplete: function() {
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
                    width: '150px',
                    data: 'fileYear'
                },{
                    targets: [1],
                    orderable: true,
                    width: '250px',
                    data: 'authName',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '180px',
                    data: 'batch',
                    className : "text-center"
                },{
                    targets: [3],
                    orderable: true,
                    width: '150px',
                    data: 'empCount',
                    className : "text-center"
                },{
                    targets: [4],
                    orderable: true,
                    width: '200px',
                    data: 'completed',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        if( data == 0 ) {
                            return '<span id="ir8a_' + full['userID'] + '" class="label label-warning">Action Required</span>';
                        }
                        return '<span id="ir8a_' + full['userID'] + '" class="label label-success">Completed</span>';
                    }
                },{
                    targets: [5],
                    orderable: true,
                    width: '200px',
                    data: 'submitted',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        if( data == 0 ) {
                            return '<span id="ir8a_' + full['userID'] + '" class="label label-pending">Not Submitted</span>';
                        }
                        else{
                            return '<span id="ir8a_' + full['userID'] + '" class="label label-success">Submitted</span>';
                        }
                    }
                },{
                    targets: [6],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center p-0",
                    data: 'tfID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/taxfile/taxFiling/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit Batch</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/taxfile/downloadIR8A/' + data + '">' +
                            '<i class="icon-pencil5"></i> Download IRAS XML</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/taxfile/downloadA8A/' + data + '">' +
                            '<i class="icon-pencil5"></i> Download Appendix 8A XML</a>' +
                            '<a class="dropdown-item authIRAS" data-id="' + data + '">' +
                            '<i class="icon-pencil5"></i> Submit To IRAS</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: "",// Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

            $(".dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisTaxFile;
})();
var markaxisTaxFile = null;
$(document).ready( function( ) {
    markaxisTaxFile  = new MarkaxisTaxFile( );
});