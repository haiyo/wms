/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: taxFileDeclare.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisTaxFileDeclare = (function( ) {

    /**
     * MarkaxisTaxFileDeclare Constructor
     * @return void
     */
    MarkaxisTaxFileDeclare = function( ) {
        this.table = null;
        this.prepared = [];
        this.requireA8A = [];
        this.preparedA8A = [];
        this.modalIR8A = $("#modalIR8A");
        this.ir8aValidate = false;
        this.ira8aValidate = false;
        this.ir8aError = false;
        this.ira8aError = false;
        this.init( );
    };

    MarkaxisTaxFileDeclare.prototype = {
        constructor: MarkaxisTaxFileDeclare,

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

            $("#modalIR8A").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/taxfile/editIr8a/' + $("#tfID").val( ) + '/' + $invoker.attr("data-id"), function() {
                    $("#dobMonth").select2({minimumResultsForSearch: Infinity});
                    $("#dobDay").select2({minimumResultsForSearch: Infinity});
                    $("#startMonth").select2({minimumResultsForSearch: Infinity});
                    $("#startDay").select2({minimumResultsForSearch: Infinity});
                    $("#endMonth").select2({minimumResultsForSearch: Infinity});
                    $("#endDay").select2({minimumResultsForSearch: Infinity});
                    $("#nationality").select2({minimumResultsForSearch: Infinity});
                    $("#commFromMonth").select2({minimumResultsForSearch: Infinity});
                    $("#commFromDay").select2({minimumResultsForSearch: Infinity});
                    $("#commToMonth").select2({minimumResultsForSearch: Infinity});
                    $("#commToDay").select2({minimumResultsForSearch: Infinity});
                    $("#approvedMonth").select2({minimumResultsForSearch: Infinity});
                    $("#approvedDay").select2({minimumResultsForSearch: Infinity});
                    $("#exemptIndicator").select2({minimumResultsForSearch: Infinity});

                    $(".styled").uniform({
                        radioClass: 'choice'
                    });

                    if( $("#gender1").attr("checked") == "checked" ) {
                        $("#gender1").prop('checked',true);
                    }
                    else if( $("#gender2").attr("checked") == "checked" ) {
                        $("#gender2").prop('checked',true);
                    }

                    setTimeout( function( ) {
                        $("#saveIr8a").validate( that.ir8aValidate );
                        $("#saveIr8a").valid();
                    }, 100 );

                    setTimeout( function( ) {
                        $("#empRef").prop("disabled", true);
                        $("#empIDNo").prop("disabled", true);
                        $("#empName").prop("disabled", true);
                        $("#dobDay").prop("disabled", true);
                        $("#dobMonth").prop("disabled", true);
                        $("#dobYear").prop("disabled", true);
                        $("#nationality").prop("disabled", true);
                        $("#address").prop("disabled", true);
                        $("#designation").prop("disabled", true);
                        $("#bankName").prop("disabled", true);
                        $("#gender1").prop("disabled", true);
                        $("#gender2").prop("disabled", true);
                        $("#commPaymentType1").prop("disabled", true);
                        $("#commPaymentType2").prop("disabled", true);
                        $.uniform.update();
                    }, 200 );
                });
            });

            $("#modalA8A").on("show.bs.modal", function(e) {
                var $invoker = $(e.relatedTarget);

                $(this).find(".modal-body").load( Aurora.ROOT_URL + 'admin/taxfile/editA8a/' + $("#tfID").val( ) + '/' + $invoker.attr("data-id"), function() {
                    $("#fromMonth").select2({minimumResultsForSearch: Infinity});
                    $("#fromDay").select2({minimumResultsForSearch: Infinity});
                    $("#toMonth").select2({minimumResultsForSearch: Infinity});
                    $("#toDay").select2({minimumResultsForSearch: Infinity});

                    $(".styled").uniform({
                        radioClass: 'choice'
                    });

                    setTimeout( function( ) {
                        $("#saveIra8a").validate( that.ira8aValidate );
                        $("#saveIra8a").valid();
                    }, 100 );

                    setTimeout( function( ) {
                        $("#empIDNo8A").prop("disabled", true);
                        $("#empName8A").prop("disabled", true);
                    }, 200 );

                    $(document).on("blur", "#saveIra8a input", function(e) {
                        if( that.validatePeriod( ) ) {
                            that.computeTaxableValue( );
                            that.computeTotalTaxableValue( );
                            that.computeTotalUtilities( );
                            that.computeTaxableHotel( );
                        }
                    });
                });
            });


            that.ir8aValidate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.addClass("border-danger");
                    }
                    else {

                        $(element).addClass("border-danger");
                    }
                    if( $(element).attr("type") == "radio" ) {
                        $(element).parent().addClass("border-danger");
                    }
                    that.ir8aError = true;
                },
                unhighlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.removeClass("border-danger");
                    }
                    else {
                        $(element).removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    //$(".stepy-navigator .error").remove( );
                    //$(".stepy-navigator").prepend(error);
                },
                rules: {
                    empRef : "required",
                    empIDNo : "required",
                    empName : "required",
                    dobMonth: "required",
                    dobDay: "required",
                    dobYear: "required",
                    nationality: "required",
                    gender: "required",
                    address : "required",
                    designation: "required",
                    bankName: "required"
                }
            };

            that.ira8aValidate = {
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                successClass: 'validation-valid-label',
                highlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.addClass("border-danger");
                    }
                    else {

                        $(element).removeAttr("disabled").addClass("border-danger");
                    }
                },
                unhighlight: function( element, errorClass ) {
                    var selectEle = $(element).next().find(".select2-selection");
                    if( selectEle.length > 0 ) {
                        selectEle.removeClass("border-danger");
                    }
                    else {
                        $(element).removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function( error, element ) {
                    //$(".stepy-navigator .error").remove( );
                    //$(".stepy-navigator").prepend(error);
                },
                rules: {
                    empName : "required",
                    empIDNo : "required",
                    address : "required",
                    days: "required",
                    numberShare: "required",
                    fromMonth: "required",
                    fromDay: "required",
                    fromYear: "required",
                    toMonth: "required",
                    toDay: "required",
                    toYear: "required",
                }
            };

            $("#submitIr8a").on("click", function(e) {
                var data = {
                    bundle: {
                        data: Aurora.WebService.serializePost("#saveIr8a")
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            swal({
                                title: $("#empName").val() + "'s IR8A form has been successfully updated!",
                                type: "success"
                            }, function( isConfirm ) {
                                if( $.trim( $("#benefitsInKind").val( ) ) != "" ) {
                                    // Filter away first for column to load
                                    that.prepared = that.prepared.filter(e => e !== $("#userID").val( ));
                                    that.prepareUserDeclaration( $("#userID").val( ), false );
                                }
                                //that.table.ajax.reload( );
                                $("#modalIR8A").modal("hide");
                            });
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/saveIr8a", data);
                return false;
            });

            $("#submitIra8a").on("click", function(e) {
                if( that.computeTotalBenefits( ) ) {
                    var data = {
                        bundle: {
                            data: Aurora.WebService.serializePost("#saveIra8a")
                        },
                        success: function (res) {
                            var obj = $.parseJSON(res);
                            if( obj.bool === 0 ) {
                                swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                                return;
                            }
                            else {
                                swal({
                                    title: $("#empName8A").val() + "'s Appendix 8A form has been successfully updated!",
                                    type: "success"
                                }, function( isConfirm ) {
                                    $("#modalA8A").modal("hide");

                                    that.requireA8A = that.requireA8A.filter(e => e !== $("#userID").val( ));
                                    that.preparedA8A.push( $("#userID").val( ) );

                                    $("#a8a_" + $("#userID").val( )).removeClass("label-warning").addClass("label-success");
                                    $("#a8a_" + $("#userID").val( )).text('Prepared');
                                });
                            }
                        }
                    };
                    Aurora.WebService.AJAX("admin/taxfile/saveIra8a", data);
                }
                return false;
            });
        },


        validatePeriod: function( ) {
            if( $("#fromYear").val( ) == "" || $("#fromMonth").val( ) == "" || $("#fromDay").val( ) == "" ||
                $("#toYear").val( ) == "" || $("#toMonth").val( ) == "" || $("#toDay").val( ) == "" ) {
                $("#saveIra8a .select2-selection").addClass("border-danger");
                $("#fromYear").addClass("border-danger");
                $("#toYear").addClass("border-danger");
                return false;
            }

            var periodFrom = new Date( $("#fromYear").val( ), $("#fromMonth").val( ), $("#fromDay").val( ) );
            var periodTo = new Date( $("#toYear").val( ), $("#toMonth").val( ), $("#toDay").val( ) );

            if( periodFrom == "Invalid Date" || periodTo == "Invalid Date" ) {
                $("#saveIra8a .select2-selection").addClass("border-danger");
                $("#fromYear").addClass("border-danger");
                $("#toYear").addClass("border-danger");
                return false;
            }

            if( periodFrom > periodTo ) {
                $("#saveIra8a .select2-selection").addClass("border-danger");
                $("#fromYear").addClass("border-danger");
                $("#toYear").addClass("border-danger");

                $("#saveIra8a .modal-footer").append('<label class="error">Period From cannot be earlier than Period To.</label>');
                return false;
            }
            $(".modal-footer .error").remove( );
            $("#saveIra8a .select2-selection").removeClass("border-danger");
            $("#fromYear").removeClass("border-danger");
            $("#toYear").removeClass("border-danger");
            return true;
        },


        computeTaxableValue: function( ) {
            if( ($("#annualValue").val( ) != "" || $("#furnitureValue").val( ) != "") && $("#rentPaidEmployer").val( ) != "" ) {
                $("#annualValue").addClass("border-danger");
                $("#furnitureValue").addClass("border-danger");
                $("#rentPaidEmployer").addClass("border-danger");

                if( $(".modal-footer .error").length > 0 ) {
                    $(".modal-footer .error").remove( );
                }
                $("#saveIra8a .modal-footer").append('<label class="error">If you entered 2a and 2b, 2c must be blank. You may also enter 2c but leave blank for 2a and 2b.</label>');
                return false;
            }

            $("#annualValue").removeClass("border-danger");
            $("#furnitureValue").removeClass("border-danger");
            $("#rentPaidEmployer").removeClass("border-danger");
            $(".modal-footer .error").remove( );

            if( $("#annualValue").val( ) != "" || $("#furnitureValue").val( ) != "" ) {
                var annualValue = parseFloat( $("#annualValue").val( ) );
                var furnitureValue = parseFloat( $("#furnitureValue").val( ) );
                annualValue = isNaN( annualValue ) ? 0 : annualValue;
                furnitureValue = isNaN( furnitureValue ) ? 0 : furnitureValue;
                $("#taxableValue").val( (annualValue+furnitureValue) );
            }
            else if( $("#rentPaidEmployer").val( ) != "" ) {
                $("#taxableValue").val( $("#rentPaidEmployer").val( ) );
            }
        },


        computeTotalTaxableValue: function( ) {
            var taxableValue = parseFloat( $("#taxableValue").val( ) );
            var rentPaidEmployee = parseFloat( $("#rentPaidEmployee").val( ) );
            taxableValue = isNaN( taxableValue ) ? 0 : taxableValue;
            rentPaidEmployee = isNaN( rentPaidEmployee ) ? 0 : rentPaidEmployee;

            if( taxableValue > 0 ) {
                if( rentPaidEmployee > 0 && taxableValue < rentPaidEmployee ) {
                    $("#taxableValue").addClass("border-danger");
                    $("#rentPaidEmployee").addClass("border-danger");

                    $("#saveIra8a .modal-footer").append('<label class="error">Taxable value should not be less than Rent paid by Employee</label>');
                    return false;
                }

                $("#taxableValue").removeClass("border-danger");
                $("#rentPaidEmployee").removeClass("border-danger");
                $(".modal-footer .error").remove( );

                $("#totalTaxablePlace").val( (taxableValue-rentPaidEmployee) );
            }
        },


        computeTotalUtilities: function( ) {
            var utilities = parseFloat( $("#utilities").val( ) );
            var driver = parseFloat( $("#driver").val( ) );
            var upkeep = parseFloat( $("#upkeep").val( ) );

            utilities = isNaN( utilities ) ? 0 : utilities;
            driver = isNaN( driver ) ? 0 : driver;
            upkeep = isNaN( upkeep ) ? 0 : upkeep;

            var total = (utilities+driver+upkeep);

            if( total > 0 ) {
                $("#totalTaxableUtilities").val( total );
            }
        },


        computeTaxableHotel: function( ) {
            var hotel = parseFloat( $("#hotel").val( ) );
            var hotelPaidEmployee = parseFloat( $("#hotelPaidEmployee").val( ) );

            hotel = isNaN( hotel ) ? 0 : hotel;
            hotelPaidEmployee = isNaN( hotelPaidEmployee ) ? 0 : hotelPaidEmployee;

            if( hotel > 0 && hotel < hotelPaidEmployee ) {
                $("#hotel").addClass("border-danger");
                $("#hotelPaidEmployee").addClass("border-danger");

                $("#saveIra8a .modal-footer").append('<label class="error">Actual Cost of Hotel should not be less than Amount paid by Employee</label>');
                return false;
            }

            $("#hotel").removeClass("border-danger");
            $("#hotelPaidEmployee").removeClass("border-danger");
            $(".modal-footer .error").remove( );

            var total = (hotel-hotelPaidEmployee);

            if( total > 0 ) {
                $("#hotelTotal").val( total );
            }
        },


        computeTotalBenefits: function( ) {
            var totalTaxablePlace = parseFloat( $("#totalTaxablePlace").val( ) );
            var totalTaxableUtilities = parseFloat( $("#totalTaxableUtilities").val( ) );
            var hotelTotal = parseFloat( $("#hotelTotal").val( ) );
            var incidentalBenefits = parseFloat( $("#incidentalBenefits").val( ) );
            var interestPayment = parseFloat( $("#interestPayment").val( ) );
            var insurance = parseFloat( $("#insurance").val( ) );
            var holidays = parseFloat( $("#holidays").val( ) );
            var education = parseFloat( $("#education").val( ) );
            var recreation = parseFloat( $("#recreation").val( ) );
            var assetGain = parseFloat( $("#assetGain").val( ) );
            var vehicleGain = parseFloat( $("#vehicleGain").val( ) );
            var carBenefits = parseFloat( $("#carBenefits").val( ) );
            var otherBenefits = parseFloat( $("#otherBenefits").val( ) );

            totalTaxablePlace = isNaN( totalTaxablePlace ) ? 0 : totalTaxablePlace;
            totalTaxableUtilities = isNaN( totalTaxableUtilities ) ? 0 : totalTaxableUtilities;
            hotelTotal = isNaN( hotelTotal ) ? 0 : hotelTotal;
            incidentalBenefits = isNaN( incidentalBenefits ) ? 0 : incidentalBenefits;
            interestPayment = isNaN( interestPayment ) ? 0 : interestPayment;
            insurance = isNaN( insurance ) ? 0 : insurance;
            holidays = isNaN( holidays ) ? 0 : holidays;
            education = isNaN( education ) ? 0 : education;
            recreation = isNaN( recreation ) ? 0 : recreation;
            assetGain = isNaN( assetGain ) ? 0 : assetGain;
            vehicleGain = isNaN( vehicleGain ) ? 0 : vehicleGain;
            carBenefits = isNaN( carBenefits ) ? 0 : carBenefits;
            otherBenefits = isNaN( otherBenefits ) ? 0 : otherBenefits;

            var totalBenefits = (totalTaxablePlace+totalTaxableUtilities+hotelTotal+
                incidentalBenefits+interestPayment+insurance+holidays+education+recreation+
                assetGain+vehicleGain+carBenefits+otherBenefits);

            if( $("#totalBenefits").val( ) != totalBenefits ) {
                $("#totalBenefits").addClass("border-danger");

                $("#saveIra8a .modal-footer").append('<label class="error">Total benefits value does not compute to the Total Value of Benefits-In-Kind.</label>');
                return false;
            }
            $("#totalBenefits").removeClass("border-danger");
            $(".modal-footer .error").remove( );
            return true;
        },


        prepareUserDeclaration: function( i, firstLoad ) {
            var that = this;

            if( markaxisTaxFileEmployee.selected.length > 0 ) {
                if( firstLoad ) {
                    var userID = markaxisTaxFileEmployee.selected[i];
                }
                else {
                    userID = i;
                }

                var data = {
                    bundle: {
                        userID: userID,
                        tfID: $("#tfID").val( ),
                        year: $("#year").val( )
                    },
                    success: function (res) {
                        var obj = $.parseJSON(res);
                        if( obj.bool === 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            var ir8a = $("#ir8a_" + obj.data.ir8a.userID);

                            if( obj.data.ir8a.completed == 1 ) {
                                ir8a.removeClass("label-pending").addClass("label-success").text("Prepared");
                            }
                            else {
                                ir8a.removeClass("label-pending").addClass("label-warning").text("Action Required");
                            }

                            var a8a = $("#a8a_" + obj.data.ir8a.userID);
                            a8a.removeClass("label-pending");

                            if( obj.data.ira8a.completed != undefined ) {
                                if( obj.data.ira8a.completed == 0 ) {
                                    that.requireA8A.push( userID );
                                    a8a.removeClass("label-pending").addClass("label-warning").text("Action Required");
                                }
                                else {
                                    that.preparedA8A.push( obj.data.ir8a.userID );
                                    a8a.removeClass("label-pending").addClass("label-success").text("Prepared");
                                }
                            }
                            else {
                                a8a.removeClass("label-pending").addClass("label-default").text("Not Required");
                            }

                            that.prepared.push( userID );

                            if( firstLoad ) {
                                i++;
                                if( i != markaxisTaxFileEmployee.selected.length ) {
                                    that.prepareUserDeclaration( i, true );
                                }
                            }
                        }
                    }
                };
                Aurora.WebService.AJAX("admin/taxfile/prepareUserDeclaration", data);
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            if( that.table ) {
                that.table.destroy();
            }

            //$('table.dataTable').DataTable().clearPipeline().draw();
            that.table = $(".declareTable").DataTable({
                processing: true,
                serverSide: true,
                fnCreatedRow: function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: $.fn.dataTable.pipeline({
                    url: Aurora.ROOT_URL + "admin/taxfile/getDeclarationResults/",
                    pages: 9999,
                    data: function ( d ) {
                        d.ajaxCall = 1;
                        d.csrfToken = Aurora.CSRF_TOKEN;
                        d.selected = markaxisTaxFileEmployee.selected;
                        d.year = $("#year").val( );
                        d.tfID = $("#tfID").val( );
                        d.officeID = $("#office").val( );
                    }
                }),
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    width: '200px',
                    data: 'name',
                    render: function(data, type, full, meta) {
                        return '<img src="' + full['photo'] + '" class="user-table-photo" />' + data;
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        if( !that.prepared.includes( full['userID'] ) ) {
                            return '<span id="ir8a_' + full['userID'] + '" class="label label-pending">Preparing <div class="loader"></div></span>';
                        }
                        return '<span id="ir8a_' + full['userID'] + '" class="label label-success">Prepared</span>';
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        if( that.requireA8A.includes( full['userID'] ) ) {
                            return '<span id="a8a_' + full['userID'] + '" class="label label-warning">Action Required</span>';
                        }
                        else if( that.preparedA8A.includes( full['userID'] ) ) {
                            return '<span id="a8a_' + full['userID'] + '" class="label label-success">Prepared</span>';
                        }
                        return '<span id="a8a_' + full['userID'] + '" class="label label-default">Not Required</span>';
                    }
                },{
                    targets: [3],
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [4],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [5],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [6],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    render: function(data, type, full, meta) {
                        return '<span id="status' + full['userID'] + '" class="label label-striped">Not Supported</span>';
                    }
                },{
                    targets: [7],
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center p-0",
                    data: 'userID',
                    render: function(data, type, full, meta) {
                        return '<div class="list-icons">' +
                            '<div class="list-icons-item dropdown">' +
                            '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="icon-menu7"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalIR8A">' +
                            '<i class="icon-pencil5"></i> Edit IR8A</a>' +
                            '<a class="dropdown-item" data-id="' + data + '" data-toggle="modal" data-target="#modalA8A">' +
                            '<i class="icon-pencil5"></i> Edit A8A</a>' +
                            /*'<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit A8B</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR8S</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR21</a>' +
                            '<a class="dropdown-item" href="' + Aurora.ROOT_URL + 'admin/user/edit/' + data + '">' +
                            '<i class="icon-pencil5"></i> Edit IR21A</a>' +*/
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }],
                order: [],
                dom: '<"datatable-header"Bfr><"datatable-scroll"t><"datatable-footer"ilp>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.PayrollRes.LANG_SEARCH_EMPLOYEE,
                    lengthMenu: '<span>| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + Aurora.i18n.GlobalRes.LANG_NUMBER_ROWS + ':</span> _MENU_',
                    paginate: { 'first': Aurora.i18n.GlobalRes.LANG_FIRST, 'last': Aurora.i18n.GlobalRes.LANG_LAST, 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                },
                initComplete: function( settings, json ) {
                    that.prepareUserDeclaration( 0, true );
                }
            });

            // Datatable with saving state
            $('.declareTable .datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.declareTable .datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $(".declareTable tbody").on("mouseover", "td", function() {
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
            $(".dataTables_length select").select2({
                minimumResultsForSearch: Infinity,
                width: "auto"
            });
        }
    }
    return MarkaxisTaxFileDeclare;
})();
var markaxisTaxFileDeclare = null;
$(document).ready( function( ) {
    markaxisTaxFileDeclare = new MarkaxisTaxFileDeclare( );
});