<style>
    .tabWrapper {
        position:relative;
        margin:0 auto;
        overflow:hidden;
        padding:5px;
        height:90px;
    }
    .nav-pills {
        width:100%;
        white-space:nowrap;
        position:absolute;
        left:0px;
        top:0px;
        min-width:1324px;
        display: inherit;
    }
    .nav-pills>li>a {
        color : white;
    }

    .tab-pane .content {
        padding:12px 0px;
        padding-bottom:0px;
    }

    .exTab1 {
        position:relative;
    }

    #exTab1 .tab-content > [data-id='complete']  {
        border-top: 7px solid #3b8c41;
    }

    #exTab1 .tab-content > [data-id='pending']  {
        border-top: 7px solid #ddb557;
    }

    #exTab1 .tab-content > [data-id='current']  {
        border-top: 7px solid #0595d6;
    }

    #exTab1 .tab-content > [data-id='upcoming']  {
        border-top: 7px solid #b3b3b3;
    }

    #exTab1 .nav-pills > li > a {
        border-radius: 0;
        text-align: center;
        /*display: inline-block;*/
        width: 100%;
        height: 100%;
        padding: 0px;
        padding-top: 6px;
        vertical-align: text-top;
        text-transform:uppercase;
    }
    #exTab1 .nav-pills > li > .active {

    }
    #exTab1 .nav-pills > li {
        width: auto;
        float: none;
        direction: rtl;
        width:9.699%;
        color:#fff;
    }

    .nav-pills > li > a.complete-tab {
        background-color: #4caf50 !important;
    }
    .nav-pills > li > a.complete-tab > .status {
        background-color: #3b8c41;
    }
    .nav-pills > li > a.pending-tab {
        background-color: #FFD166 !important;
    }
    .nav-pills > li > a.pending-tab > .status {
        background-color: #ddb557;
    }
    .nav-pills > li > a.current-tab {
        background-color: #03a9f4 !important;
    }
    .nav-pills > li > a.current-tab > .status {
        background-color: #0595d6;
    }
    .nav-pills > li > a.upcoming-tab {
        background-color: #cccccc !important;
    }
    .nav-pills > li > a.upcoming-tab > .status {
        background-color: #b3b3b3;
    }
    .nav-pills .status {
        width:100%;
        display:block;
        margin-top:5px;
        padding: 3px;
        font-size:12px;
    }
    .nav-pills > li > .active > .status {
        margin-bottom: 5px;
        padding-bottom: 9px;
    }
    .row .col-lg-3 {
        border-right:1px solid #ccc;
        padding-left:30px;
        color: #666;
        height:60px;
    }
    .row .col-lg-3:last-child { border: none; }

    .scroller {
        text-align:center;
        cursor:pointer;
        display:none;
        padding:7px;
        padding-top:32px;
        white-space:no-wrap;
        vertical-align:middle;
        background-color:#fff;
        opacity: .4;
        position: absolute;
        top:0px;
        z-index:100;
        height:87px;
    }

    .scroller-right{
        right:0px;
    }

    .scroller-left {
        left:0px;
    }
</style>
<script>
    $(document).ready(function( ) {
        var scrollBarWidths = 57;

        var widthOfList = function () {
            var itemsWidth = 0;
            $(".nav-pills li").each(function () {
                var itemWidth = $(this).outerWidth();
                itemsWidth += itemWidth;
            });
            return itemsWidth;
        };

        var widthOfHidden = function () {
            return $(".tabWrapper").outerWidth()-widthOfList()-getLeftPosi()-scrollBarWidths;
        };

        var getLeftPosi = function () {
            return $(".nav-pills").position().left;
        };

        var reAdjust = function () {
            if( widthOfHidden() < 0 ) {
                $(".scroller-right").fadeIn("slow");
            }
            else {
                $(".scroller-right").fadeOut("slow");
            }

            if (getLeftPosi() < 0) {
                $(".scroller-left").fadeIn("slow");
            }
            else {
                //$('.nav-pills').animate({left: "-=" + getLeftPosi( ) + "px"}, 'slow');
                $(".tabWrapper", this).scrollLeft -= getLeftPosi( );
                $(".scroller-left").fadeOut("slow");
            }
        }

        reAdjust();

        $(window).on("resize", function(e) {
            reAdjust();
        });

        $(".scroller-right").click(function () {
            $(".tabWrapper").animate({scrollLeft: "-=" + widthOfHidden()}, "slow", function () {
                $(".scroller-left").fadeIn("slow");
                $(".scroller-right").fadeOut("slow");
            });
        });
        $(".scroller-right").click().click();

        $(".scroller-left").click(function () {
            $(".tabWrapper").animate({scrollLeft: "+=" + getLeftPosi( )}, "slow", function () {
                $(".scroller-left").fadeOut("slow");
                $(".scroller-right").fadeIn("slow");
            });
        });

        $(".tabWrapper", this).mousewheel(function(event, delta) {
            this.scrollLeft -= (delta * 30);
            reAdjust();
            event.preventDefault();
        });
    });
</script>

<div id="exTab1" class="exTab1">
    <div class="scroller scroller-left"><i class="icon-arrow-left15"></i></div>
    <div class="scroller scroller-right"><i class="icon-arrow-right15"></i></div>
    <div class="tabWrapper">
        <ul class="nav nav-pills">
            <!-- BEGIN DYNAMIC BLOCK: tab -->
            <li>
                <a class="tab <?TPLVAR_STATUS_TAB?> <?TPLVAR_MONTH?>" href="#<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_MONTH?>" data-date="<?TPLVAR_DATA_DATE?>" data-toggle="tab">
                    <h4><?TPLVAR_MONTH?></h4>
                    <div><?TPLVAR_YEAR?></div>
                    <div class="status"><?TPLVAR_STATUS?></div>
                </a>
            </li>
            <!-- END DYNAMIC BLOCK: tab -->
        </ul>
    </div>

    <div class="tab-content clearfix">
        <!-- BEGIN DYNAMIC BLOCK: tab-pane -->
        <div class="tab-pane <?TPLVAR_STATUS_TAB?>" id="<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_DATA_ID?>">
            <div class="content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="daterange-custom daterange-custom2 d-flex align-items-center justify-content-center" style="margin-top:10px;">
                            <div class="daterange-custom-display daterange-custom2"><i>1</i>
                                <b><i><?TPLVAR_MONTH?></i> <i><?TPLVAR_YEAR?></i></b><em> –
                                </em><i><?TPLVAR_LAST_DAY?></i> <b><i><?TPLVAR_MONTH?></i> <i><?TPLVAR_YEAR?></i></b>
                            </div>
                            <span class="badge badge-primary ml-2"><?TPLVAR_WORK_DAYS?> Work Days</span>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="font-weight-semibold">ESTIMATED OVERHEAD / MONTH</div>
                        <h2>SGD$19,000</h2>
                    </div>

                    <div class="col-lg-3">
                        <div class="font-weight-semibold">TOTAL EMPLOYEES</div>
                        <h2><?TPLVAR_EMPLOYEE_COUNT?></h2>
                    </div>

                    <div class="col-lg-3">
                        <a type="button" class="btn btn-lg bg-purple-400 btn-labeled mt-10" data-date="<?TPLVAR_DATE?>"
                           data-toggle="modal" data-target="#modalEnterPassword">
                            <b><i class="icon-checkmark"></i></b> View Finalized Payroll</a>
                    </div>

                </div>
            </div>

            <div class="row" style="margin-top:10px">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="<?TPLVAR_MONTH?>Chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: tab-pane -->
        <!-- BEGIN DYNAMIC BLOCK: tab-pane-process -->
        <div class="tab-pane <?TPLVAR_STATUS_TAB?>" id="<?TPLVAR_MONTH?>Month" data-id="<?TPLVAR_DATA_ID?>">
            <div class="content">
                <div class="no-data">
                    <div class="row"><h2><?TPLVAR_LONG_MONTH?> <?TPLVAR_YEAR?> <?LANG_NOT_PROCESS_YET?></h2></div>
                    <a type="button" class="btn btn-lg bg-grey-400 btn-labeled" data-date="<?TPLVAR_DATE?>"
                       data-toggle="modal" data-target="#modalEnterPassword">
                    <b><i class="icon-calculator2"></i></b> <?LANG_LETS_DO_IT?></a>
                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: tab-pane-process -->
    </div>
</div>
<div id="modalEnterPassword" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-lock"></i>&nbsp; Verify Credential</h6>
            </div>

            <div class="modal-body overflow-y-visible">
                <form id="verifyPwd" name="verifyPwd" method="post" action="">
                    <input type="hidden" name="processDate" id="processDate" value="" />
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Enter your password to continue:</label>
                            <input type="password" name="password" id="password" class="form-control" value=""
                                   placeholder="" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-btn">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button id="unlock" type="submit" class="btn btn-primary">Unlock</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function( ){
        $("#modalEnterPassword").on("shown.bs.modal", function(e) {
            var $invoker = $(e.relatedTarget);
            $("#processDate").val( $invoker.attr("data-date") );
            $("#password").focus( );
        });

        $("#password").keypress( function( e ) {
            if( e.which === 13 ) {
                $("#unlock").click( );
                return false;
            }
        });

        $("#unlock").on("click", function( ) {
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
            return false;
        });

        $(".tab").on("click", function( ) {
            var dataID = $(this).attr("data-id");
            var dataDate = $(this).attr("data-date");

            setTimeout(function( ) {
                getChartData( dataID, dataDate )
                //initEChart( dataID, [] );
            }, 100);
        });

        $(".nav-pills li:last-child a").click( );
    });

    /*initEChart( 'MayChart' );
    setTimeout(function( ) {
        $(".may").trigger( "click" );
    }, 1500);*/

    function getChartData( dataID, date ) {
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
                    initEChart( dataID, obj.data );
                }
            }
        };
        Aurora.WebService.AJAX( "admin/payroll/getChart", data );
        return false;
    }

    function initEChart( dataID, data ) {
        var chart = document.getElementById( dataID + "Chart" );
        var columns_basic = echarts.init( chart );
        var dataLength = data.length;
        var salaries = claims = levies = contri = [];

        if( dataLength > 0 ) {
            for( var i=0; i<dataLength; i++ ) {
                if( !data[i].salaries ) {
                    salaries.push( 0 );
                }
                else {
                    salaries.push( parseInt( data[i].salaries ) );
                }

                if( !data[i].claims.length > 0 ) {
                    claims.push( 0 );
                }
                else {
                    claims.push( parseInt( data[i].claim ) );
                }

                if( !data[i].levies.length > 0 ) {
                    levies.push( 0 );
                }
                else {
                    levies.push( parseInt( data[i].levy ) );
                }

                if( !data[i].contributions.length > 0 ) {
                    contri.push( 0 );
                }
                else {
                    contri.push( parseInt( data[i].contribution ) );
                }
            }
        }

        columns_basic.setOption({

            // Define colors
            color: ['#E67F7F','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

            // Global text styles
            textStyle: {
                fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                fontSize: 13
            },

            // Chart animation duration
            animationDuration: 750,

            // Setup grid
            grid: {
                left: 0,
                right: 40,
                top: 35,
                bottom: 0,
                containLabel: true
            },

            // Add legend
            legend: {
                data: ['Total Salaries', 'Total Claims', 'Total Levies', 'Total CPF Contributions'],
                itemHeight: 8,
                itemGap: 20,
                textStyle: {
                    padding: [0, 5]
                }
            },

            // Add tooltip
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
                    data += params[0].seriesName + ": " + "SGD$" + salaries + "<br />";
                    data += params[1].seriesName + ": " + "SGD$" + claims + "<br />";
                    data += params[2].seriesName + ": " + "SGD$" + levies + "<br />";
                    data += params[3].seriesName + ": " + "SGD$" + contri + "<br />";
                    return data;
                }
            },

            // Horizontal axis
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

            // Vertical axis
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

            // Add series
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
</script>