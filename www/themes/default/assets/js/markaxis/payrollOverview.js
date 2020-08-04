/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: payrollOverview.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisPayrollOverview = (function( ) {

    /**
     * MarkaxisPayrollOverview Constructor
     * @return void
     */
    MarkaxisPayrollOverview = function( ) {
        this.scrollBarWidths = 57;
        this.init( );
    };

    MarkaxisPayrollOverview.prototype = {
        constructor: MarkaxisPayrollOverview,

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

            $(".payroll-archive").pickadate({
                showMonthsShort: true,
                disable: [true],
                format:"dd mmm yyyy",
                today: false,
                clear: false,
                close: false,
                max: new Date(),
                onSet: function( context ) {
                    if( context.select != undefined ) {
                        $("#processDate").val( this.get("select", "yyyy-mm-dd") );
                        $("#modalEnterPassword").modal("show");
                        $("#password").focus( );
                    }
                    markaxisPickerExtend.setPickerPayroll( ".picker__table", that.pickerStart, context );
                    $("div[role=tooltip]").remove();
                },
                onOpen: function ( ) {
                    markaxisPickerExtend.setPickerPayroll( ".picker__table", that.pickerStart );
                }
            });

            $("#modalEnterPassword").on("shown.bs.modal", function(e) {
                var date = $(e.relatedTarget).attr("data-date");

                if( date ) {
                    $("#processDate").val( date );
                }
                $("#password").focus( );
            });

            $("#password").keypress( function(e) {
                if( e.which === 13 ) {
                    $("#unlock").click( );
                    e.preventDefault( );
                }
            });

            $("#unlock").on("click", function(e) {
                var processDate = $("#processDate").val( );

                var data = {
                    bundle: {
                        laddaClass : ".btn",
                        processDate: processDate,
                        password: $("#password").val( )
                    },
                    success: function( res, ladda ) {
                        ladda.stop( );

                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            $("#password").focus( );
                            swal("Error!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            window.location = Aurora.ROOT_URL + 'admin/payroll/process/' + processDate;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/payroll/getProcessPass", data );
                e.preventDefault( );
            });

            $(".tab").on("click", function(e) {
                var dataID = $(this).attr("data-id");
                var dataDate = $(this).attr("data-date");

                setTimeout(function( ) {
                    that.getChartData( dataID, dataDate )
                    //initEChart( dataID, [] );
                }, 100);
                e.preventDefault( );
            });

            $(".nav-pills li:last-child a").click( );

            that.reAdjust( );

            $(window).on("resize", function(e) {
                that.reAdjust( );
            });

            $(".scroller-right").click(function () {
                $(".tabWrapper").animate({scrollLeft: "-=" + that.widthOfHidden()}, "slow", function () {
                    $(".scroller-left").fadeIn("slow");
                    $(".scroller-right").fadeOut("slow");
                });
            });
            $(".scroller-right").click().click();

            $(".scroller-left").click(function () {
                $(".tabWrapper").animate({scrollLeft: "+=" + that.getLeftPos( )}, "slow", function () {
                    $(".scroller-left").fadeOut("slow");
                    $(".scroller-right").fadeIn("slow");
                });
            });

            $(document).on("mousewheel", ".tabWrapper", function(e, delta) {
                this.scrollLeft -= (delta * 30);
                that.reAdjust();
            });
        },


        widthOfList: function( ) {
            var itemsWidth = 0;
            $(".nav-pills li").each(function () {
                var itemWidth = $(this).outerWidth();
                itemsWidth += itemWidth;
            });
            return itemsWidth;
        },


        widthOfHidden: function( ) {
            return $(".tabWrapper").outerWidth()-this.widthOfList( )-this.getLeftPos( )-this.scrollBarWidths;
        },


        getLeftPos: function( ) {
            return $(".nav-pills").position().left;
        },


        reAdjust: function( ) {
            if( this.widthOfHidden() < 0 ) {
                $(".scroller-right").fadeIn("slow");
            }
            else {
                $(".scroller-right").fadeOut("slow");
            }

            if( this.getLeftPos( ) < 0 ) {
                $(".scroller-left").fadeIn("slow");
            }
            else {
                $(".tabWrapper", this).scrollLeft -= this.getLeftPos( );
                $(".scroller-left").fadeOut("slow");
            }
        },


        getChartData: function( dataID, date ) {
            var that = this;

            var data = {
                bundle: {
                    date: date
                },
                success: function( res ) {
                    //console.log(res)
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        return;
                    }
                    else {
                        $("#" + dataID +  "empCount").text( obj.data.empCount );
                        that.initEChart( dataID, obj.data );
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/payroll/getChart", data );
        },


        getAvg: function( data ) {
            var total = 0;
            var count = 0;
            var length = data.length;

            for( var i=0; i<length; i++ ) {
                total += data[i];

                if( data[i] ) {
                    count++;
                }
            }
            return Aurora.currency +  Math.round( total/count ).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');
        },


        getTotal: function( data ) {
            var total = 0;
            var length = data.length;

            for( var i=0; i<length; i++ ) {
                total += data[i];
            }
            return Aurora.currency +  Math.round( total ).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');
        },


        initEChart: function( dataID, data ) {
            if( !document.getElementById( dataID + "Chart" ) ) {
                return;
            }
            var chart = document.getElementById( dataID + "Chart" );
            var columns_basic = echarts.init( chart );

            var total = 0;
            var count = 0;
            var length = data.salaries.length;

            for( var i=0; i<length; i++ ) {
                total += data.salaries[i];

                if( data.salaries[i] ) {
                    count++;
                }
            }

            $("#" + dataID +  "totalSalaries").text( this.getTotal( data.salaries ) );
            $("#" + dataID +  "totalClaims").text( this.getTotal( data.claims ) );
            $("#" + dataID +  "totalLevies").text( this.getTotal( data.levies ) );
            $("#" + dataID +  "avgSalary").text( this.getAvg( data.salaries ) );
            $("#" + dataID +  "avgContri").text( this.getAvg( data.contributions ) );

            columns_basic.setOption({
                color: ['#E67F7F','#b6a2de','#5ab1ef','#ffb980','#d87a80'],
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },
                animationDuration: 750,
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },
                legend: {
                    data: ['Total Salaries', 'Total Claims', 'Total Levies', 'Total CPF Contributions'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter : function(params) {
                        var salaries = params[0].data.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');
                        var claims = params[1].data.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');
                        var levies = params[2].data.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');
                        var contri = params[3].data.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").replace(/\.00/g, '');

                        var data  = params[0].axisValueLabel + "<br />";
                        data += params[0].seriesName + ": " + Aurora.currency + salaries + "<br />";
                        data += params[1].seriesName + ": " + Aurora.currency + claims + "<br />";
                        data += params[2].seriesName + ": " + Aurora.currency + levies + "<br />";
                        data += params[3].seriesName + ": " + Aurora.currency + contri + "<br />";
                        return data;
                    }
                },
                xAxis: [{
                    type: 'category',
                    data: data.range,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],
                series: [
                    {
                        name: 'Total Salaries',
                        type: 'bar',
                        data: data.salaries,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        }
                    },
                    {
                        name: 'Total Claims',
                        type: 'bar',
                        data: data.claims,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        }
                    },
                    {
                        name: 'Total Levies',
                        type: 'bar',
                        data: data.levies,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        }
                    },
                    {
                        name: 'Total CPF Contributions',
                        type: 'bar',
                        data: data.contributions,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        }
                    }
                ]
            });
        }
    }
    return MarkaxisPayrollOverview;
})();
var markaxisPayrollOverview = null;
$(document).ready( function( ) {
    markaxisPayrollOverview = new MarkaxisPayrollOverview( );
});