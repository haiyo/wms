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

            $.fn.stepy.defaults.legend = false;
            $.fn.stepy.defaults.transition = 'fade';
            $.fn.stepy.defaults.duration = 150;
            $.fn.stepy.defaults.backLabel = '<i class="icon-arrow-left13 position-left"></i> ' + Aurora.i18n.GlobalRes.LANG_BACK;
            $.fn.stepy.defaults.nextLabel = Aurora.i18n.GlobalRes.LANG_NEXT + ' <i class="icon-arrow-right14 position-right"></i>';

            $(".stepy").stepy({
                titleClick: true,
                validate: false,
                block: true,
                back: function (index) {
                    if (index == 1) {
                        $("#officeFilter").insertAfter("#employeeForm-step-0 .dataTables_filter");
                    }
                },
                next: function (index) {
                    if ($("#completed").val() == 0 && !that.haveSaved) {
                        return false;
                    }
                    else {
                        $("#officeFilter").insertAfter("#employeeForm-step-1 .dataTables_filter");
                    }
                    markaxisPayrollProcessed.table.ajax.reload();
                },
                finish: function (index) {
                    that.confirmFinalize();
                    return false;
                }
            });

            var stepy = $(".stepy-step");
            stepy.find(".button-next").addClass("btn btn-primary btn-next");
            stepy.find(".button-back").addClass("btn btn-default");
        }
    }
    return MarkaxisTaxFile;
})();
var markaxisTaxFile = null;
$(document).ready( function( ) {
    markaxisTaxFile = new MarkaxisTaxFile( );
});