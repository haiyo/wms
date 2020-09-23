/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: leave.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisLeave = (function( ) {

    /**
     * MarkaxisLeave Constructor
     * @return void
     */
    MarkaxisLeave = function( ) {
        this.table = null;

        this.init( );
    };

    MarkaxisLeave.prototype = {
        constructor: MarkaxisLeave,

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

            that.progress( "#progress_0", 150, "#458AF2" );
            that.progress( "#progress_1", 150, "#EC407A" );
            that.progress( "#progress_2", 150, "#ffaf23" );
            that.progress( "#progress_3", 150, "#70b754" );
        },


        progress: function( element, size, color ) {
            if( typeof d3 == 'undefined' ) {
                console.warn('Warning - d3.min.js is not loaded.');
                return;
            }

            // Initialize chart only if element exists in the DOM
            if( element ) {
                var d3Container = d3.select(element),
                    padding = 2,
                    strokeWidth = 16,
                    width = size,
                    height = size,
                    twoPi = 2 * Math.PI;

                var container = d3Container.append("svg");
                var goal = $(element).attr("data-goal");
                var balance = $(element).attr("data-balance");

                var dataset = [
                    { totalLeaves: goal, balance: balance, percentage: balance*100/goal }
                ];

                // Add SVG group
                var svg = container
                    .attr("width", width)
                    .attr("height", height)
                    .append("g")
                    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

                // Foreground arc
                var arc = d3.svg.arc()
                    .startAngle(0)
                    .endAngle(function (d) {
                        return d.percentage / 100 * twoPi;
                    })
                    .innerRadius((size / 2) - strokeWidth)
                    .outerRadius((size / 2) - padding);
                //.cornerRadius(20);

                // Background arc
                var background = d3.svg.arc()
                    .startAngle(0)
                    .endAngle(twoPi)
                    .innerRadius((size / 2) - strokeWidth)
                    .outerRadius((size / 2) - padding);

                // Group
                var field = svg.selectAll("g").data(dataset).enter().append("g");

                // Foreground arc
                field.append("path").attr("class", "arc-foreground").attr("fill", color);

                // Background arc
                field.append("path").attr("d", background).style({
                    "fill": color, "opacity": 0.2
                });

                // Goal
                field.append("text")
                    .text( Markaxis.i18n.LeaveRes.LANG_OF + " " + goal + " " + Markaxis.i18n.LeaveRes.LANG_AVAILABLE )
                    .attr("transform", "translate(0,20)")
                    .style({
                        'font-size': 11,
                        'fill': '#999',
                        'font-weight': 500,
                        'text-transform': 'uppercase',
                        'text-anchor': 'middle'
                    });

                // Count
                field.append("text").attr('class', 'arc-goal-completed')
                    .attr("transform", "translate(0,0)")
                    .style({
                        'font-size': 23,
                        'font-weight': 500,
                        'text-anchor': 'middle'
                    });

                // Add transition
                d3.transition().duration(2500).each(update);

                // Animation
                function update() {
                    field = field.each(function (d) {
                        this._value = d.balance;
                    })
                        .data(dataset)
                        .each(function (d) {
                            d.previousValue = this._value;
                        });

                    // Foreground arc
                    field.select(".arc-foreground")
                        .transition()
                        .duration(600)
                        .ease("easeInOut")
                        .attrTween("d", arcTween);

                    // Update count text
                    field.select(".arc-goal-completed").text(function (d) {
                        return Math.round(d.percentage /100 * goal);
                    });

                    // Animate count text
                    svg.select('.arc-goal-completed')
                        .transition()
                        .duration(600)
                        .tween("text", function(d) {
                            var i = d3.interpolate(this.textContent, d.percentage);
                            return function(t) {
                                var days = Math.floor(d.percentage/100 * goal);
                                days = isNaN( days ) ? 0 : days;
                                this.textContent = days + " " + Aurora.i18n.CalendarRes.LANG_DAYS;
                            };
                        });

                    // Update every 4 seconds (for demo)
                    //setTimeout(update, 4000);
                }

                // Arc animation
                function arcTween(d) {
                    if( isNaN( d.percentage ) ) {
                        return false;
                    }

                    var i = d3.interpolateNumber(d.previousValue, d.percentage);
                    return function (t) {
                        d.percentage = i(t);
                        return arc(d);
                    };
                }
            }
        },


        /**
         * Table Initialize
         * @return void
         */
        initTable: function( ) {
            var that = this;

            this.table = $(".leaveHistoryTable").DataTable({
                "processing": true,
                "serverSide": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', 'row' + aData['userID']);
                },
                ajax: {
                    url: Aurora.ROOT_URL + "admin/leave/getHistory",
                    type: "POST",
                    data: function ( d ) { d.ajaxCall = 1; d.csrfToken = Aurora.CSRF_TOKEN; },
                },
                autoWidth: false,
                mark: true,
                columnDefs: [{
                    targets: [0],
                    orderable: true,
                    width: '230px',
                    render: function(data, type, full, meta) {
                        return full["name"] + ' (' + full["code"] + ")<br />" + full['created'];
                    }
                },{
                    targets: [1],
                    orderable: true,
                    width: '230px',
                    render: function (data, type, full, meta) {
                        return full["startDate"] + '&nbsp; &mdash; &nbsp;' + full["endDate"];
                    }
                },{
                    targets: [2],
                    orderable: true,
                    width: '80px',
                    className: "text-center",
                    data: 'days'
                },{
                    targets: [3],
                    orderable: true,
                    width: '260px',
                    data: 'reason',
                    render: function (data, type, full, meta) {
                        var text = "";

                        if( data == "" ) {
                            text += '&nbsp; &mdash; &nbsp;';
                        }
                        else {
                            text += data;
                        }
                        if( full['uploadName'] ) {
                            text += '<div class="text-ellipsis"><a target="_blank" href="' + Aurora.ROOT_URL +
                                'admin/file/view/leave/' + full['uID'] + '/' + full['hashName'] + '">' + full['uploadName'] + '</a></div>';
                        }
                        return text;
                    }
                },{
                    targets: [4],
                    orderable: true,
                    width: '120px',
                    data: 'status',
                    className : "text-center",
                    render: function( data, type, full, meta ) {
                        if( full['cancelled'] == 1 ) {
                            return '<span id="status' + full['piID'] + '" class="label label-default">' + Aurora.i18n.GlobalRes.LANG_CANCELLED + '</span>';
                        }
                        else {
                            if( data == 0 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-pending">' + Aurora.i18n.GlobalRes.LANG_PENDING + '</span>';
                            }
                            else if( data == 1 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-success">' + Aurora.i18n.GlobalRes.LANG_APPROVED + '</span>';
                            }
                            else if( data == 2 ) {
                                return '<span id="status' + full['piID'] + '" class="label label-success">' + Aurora.i18n.GlobalRes.LANG_APPROVED + '</span>';
                            }
                            else {
                                return '<span id="status' + full['piID'] + '" class="label label-danger">' + Aurora.i18n.GlobalRes.LANG_UNAPPROVED + '</span>';
                            }
                        }
                    }
                },{
                    targets: [5],
                    orderable: false,
                    searchable : false,
                    width: '180px',
                    data: 'managers',
                    render: function(data, type, full, meta) {
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
                    orderable: false,
                    searchable : false,
                    width: '100px',
                    className : "text-center",
                    data: 'laID',
                    render: function(data, type, full, meta) {
                        if( full['cancelled'] == 0 && full['status'] == 0 ) {
                            return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="icon-menu7"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm" x-placement="bottom-end">' +
                                '<a class="dropdown-item cancelApplyLeave" data-id="' + full['laID'] + '">' +
                                '<i class="icon-cross2"></i> ' + Markaxis.i18n.LeaveRes.LANG_CANCEL_APPLY + '</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }
                        return '';
                    }
                }],
                order: [0,"desc"],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '',
                    info: Aurora.i18n.GlobalRes.LANG_TABLE_ENTRIES,
                    searchPlaceholder: Markaxis.i18n.LeaveRes.LANG_SEARCH_LEAVE_HISTORY,
                    lengthMenu: '<span>' + Aurora.i18n.GlobalRes.LANG_SHOW + ':</span> _MENU_',
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

            // Alternative pagination
            $('.datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': Aurora.i18n.GlobalRes.LANG_NEXT + ' &rarr;', 'previous': '&larr; ' + Aurora.i18n.GlobalRes.LANG_PREV}
                }
            });

            // Datatable with saving state
            $('.datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            $(".dataTable tbody").on("mouseover", "td", function( ) {
                if( typeof that.table.cell(this).index() == "undefined" ) return;
                var colIdx = that.table.cell(this).index( ).column;

                if( colIdx !== null ) {
                    $(that.table.cells().nodes()).removeClass("active");
                    $(that.table.column(colIdx).nodes()).addClass("active");
                }
            }).on("mouseleave", function() {
                $(that.table.cells().nodes()).removeClass("active");
            });

            // External table additions
            // ------------------------------

            // Enable Select2 select for the length option
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        }
    }
    return MarkaxisLeave;
})();
var markaxisLeave = null;
$(document).ready( function( ) {
    markaxisLeave = new MarkaxisLeave( );
});