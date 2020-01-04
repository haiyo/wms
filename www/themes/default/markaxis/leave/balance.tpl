<style>
    .balance-chart .col-md-9, .balance-chart .col-md-9 .col-md-3:first-child {
        padding-left:0px;
    }
    .balance-chart .pl-0, .balance-chart .pl-0 .col-md-12:last-child {
        padding-right:0
    }
    .balance-chart pl-0 {
        padding-right:0px;
    }
    .balance-chart .clear {
        clear:left;
    }
    .payroll-nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-top:20px;
        margin-bottom: 0;
        list-style: none;
    }
    .nav-tabs .nav-item {
        margin-bottom: -1px;
        min-width: 150px;
        text-align: center;
    }
    .nav-justified .nav-item {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        text-align: center;
    }
    .nav-link {
        display:block;
        padding: 9px 38px !important;
        position: relative;
        transition: all ease-in-out .15s;
        font-size:16px;
    }
    .nav-link.active {
        font-weight:500;
    }
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .1875em;
        border-top-right-radius: .1875em;
    }

    nav-tabs-bottom .nav-link, .nav-tabs-highlight .nav-link, .nav-tabs-top .nav-link {
        position: relative;
    }
    .nav-tabs-highlight .nav-link {
        border-top-color: transparent;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #333;
        background-color: #fff;
        border-color: #ddd #ddd #fff;
    }
    .nav-tabs-bottom .nav-link:before, .nav-tabs-highlight .nav-link:before, .nav-tabs-top .nav-link:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        transition: background-color ease-in-out .15s;
    }
    .nav-tabs-highlight .nav-link:before {
        height: 2px;
        top: -1px;
        left: -1px;
        right: -1px;
    }
    .nav-tabs-highlight .nav-link.active:before {
        background-color: #2196f3;
    }
    .justify-content-center {
        -ms-flex-pack: center!important;
        justify-content: center!important;
    }
</style>
<script>
    $(function() {
        var _roundedProgressSingle = function(element, size, color) {
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
                    .outerRadius((size / 2) - padding)
                    //.cornerRadius(20);

                // Background arc
                var background = d3.svg.arc()
                    .startAngle(0)
                    .endAngle(twoPi)
                    .innerRadius((size / 2) - strokeWidth)
                    .outerRadius((size / 2) - padding);

                // Group
                var field = svg.selectAll("g")
                    .data(dataset)
                    .enter().append("g");

                // Foreground arc
                field.append("path").attr("class", "arc-foreground").attr('fill', color);

                // Background arc
                field.append("path").attr("d", background).style({
                    "fill": color, "opacity": 0.2
                });

                // Goal
                field.append("text")
                    .text( "of " + goal + " Available" )
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
                //d3.transition().duration(2500).each(update);
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
                                this.textContent = days + " days";
                            };
                        });

                    // Update every 4 seconds (for demo)
                    //setTimeout(update, 4000);
                }

                // Arc animation
                function arcTween(d) {
                    var i = d3.interpolateNumber(d.previousValue, d.percentage);
                    return function (t) {
                        d.percentage = i(t);
                        return arc(d);
                    };
                }
            }
        };
        _roundedProgressSingle("#rounded_progress_single0", 150, '#458AF2');
        _roundedProgressSingle("#rounded_progress_single1", 150, '#EC407A');
        _roundedProgressSingle("#rounded_progress_single2", 150, '#ffaf23');
        _roundedProgressSingle("#rounded_progress_single3", 150, '#70b754');


        $(".leaveHistoryTable").DataTable({
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
            initComplete: function() {
                Popups.init();
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
                width: '230px',
                render: function(data, type, full, meta) {
                    return full["name"] + ' (' + full["code"] + ")";
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
                    if( data == "" ) {
                        return '&nbsp; &mdash; &nbsp;';
                    }
                }
            },{
                targets: [4],
                orderable: true,
                width: '120px',
                data: 'status',
                className : "text-center",
                render: function( data, type, full, meta ) {
                    if( data == 0 ) {
                        return '<span id="status' + full['piID'] + '" class="label label-pending">Pending Approval</span>';
                    }
                    else if( data == 1 ) {
                        return '<span id="status' + full['piID'] + '" class="label label-success">Approved</span>';
                    }
                    else {
                        return '<span id="status' + full['piID'] + '" class="label label-success">Unapproved</span>';
                    }
                }
            },{
                targets: [5],
                orderable: false,
                searchable : false,
                width: '180px',
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
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'laID',
                render: function(data, type, full, meta) {
                    //console.log(full)
                    if( full['cancelled'] == 0 && full['status'] != 1 ) {
                        return '<div class="list-icons">' +
                                '<div class="list-icons-item dropdown">' +
                                '<a href="#" class="list-icons-item dropdown-toggle caret-0" data-toggle="dropdown" aria-expanded="false">' +
                                '<i class="icon-menu9"></i></a>' +
                                '<div class="dropdown-menu dropdown-menu-right dropdown-menu-sm dropdown-employee" x-placement="bottom-end">' +
                                /*'<a class="dropdown-item" data-href="<?TPLVAR_ROOT_URL?>admin/employee/view">' +
                                '<i class="icon-user"></i> View Employee Info</a>' +
                                '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/edit/' + data + '">' +
                                '<i class="icon-pencil5"></i> Edit Employee Info</a>' +
                                '<a class="dropdown-item" href="<?TPLVAR_ROOT_URL?>admin/employee/email/' + data + '">' +
                                '<i class="icon-mail5"></i> Message Employee</a>' +
                                '<a class="dropdown-item" data-title="View ' + name + ' History Log" href="<?TPLVAR_ROOT_URL?>admin/employee/log/' + data + '">' +
                                '<i class="icon-history"></i> View History Log</a>' +
                                '<div class="divider"></div>' +
                                '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setSuspend(' + data + ', \'' + name + '\')">' +
                                '<i class="icon-user-block"></i> ' + statusText + '</a>' +
                                '<a class="dropdown-item" id="menuSetStatus' + full['userID'] + '" href="#" onclick="return setResign(' + data + ', \'' + name + '\')">' +
                                '<i class="icon-exit3"></i> Employee Resigned</a>' +*/
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
                searchPlaceholder: 'Search Leave History',
                lengthMenu: '<span>Show:</span> _MENU_',
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

        // Alternative pagination
        $('.datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
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

        // Highlighting rows and columns on mouseover
        var lastIdx = null;
        var table = $(".dataTable").DataTable( );

        $(".dataTable tbody").on("mouseover", "td", function( ) {
            if( typeof table.cell(this).index() == "undefined" ) return;
            var colIdx = table.cell(this).index( ).column;

            if( colIdx !== lastIdx ) {
                $(table.cells().nodes()).removeClass("active");
                $(table.column(colIdx).nodes()).addClass("active");
            }
        }).on("mouseleave", function() {
            $(table.cells().nodes()).removeClass("active");
        });

        // External table additions
        // ------------------------------

        // Enable Select2 select for the length option
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });
    });

</script>

<div class="row mt-10 balance-chart">

    <div class="col-md-9">

        <!-- BEGIN DYNAMIC BLOCK: balChart -->
        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10"><?TPLVAR_LEAVE_NAME?></h6>
                <div class="svg-center" data-goal="<?TPLVAR_TOTAL_LEAVES?>" data-balance="<?TPLVAR_BALANCE?>" id="rounded_progress_single<?TPLVAR_ID?>">

                </div>

                <div class="row mt-20 mb-5 text-left">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#<?TPLVAR_COLOR_1?>;"></div></td>
                            <td>Available</td>
                            <td class="text-right"><?TPLVAR_BALANCE?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#<?TPLVAR_COLOR_2?>;"></div></td>
                            <td>Consumed</td>
                            <td class="text-right"><?TPLVAR_TOTAL_APPLIED?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Pending</td>
                            <td class="text-right"><?TPLVAR_TOTAL_PENDING?> Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Entitled</td>
                            <td class="text-right"><?TPLVAR_TOTAL_LEAVES?> Days</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <!-- END DYNAMIC BLOCK: balChart -->

        <!--<div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Sick Leave</h6>
                <div class="svg-center" id="rounded_progress_single1"></div>

                <div class="row mt-20 mb-5 text-left">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#EC407A;"></div></td>
                            <td>Available</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#fad0df;"></div></td>
                            <td>Consumed</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Accrued</td>
                            <td class="text-right">0 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Entitled</td>
                            <td class="text-right">14 Days</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Hospitalisation leave</h6>
                <div class="svg-center" id="rounded_progress_single2"></div>

                <div class="row mt-20 mb-5 text-left">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ffaf23;"></div></td>
                            <td>Available</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#fee8c8;"></div></td>
                            <td>Consumed</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Accrued</td>
                            <td class="text-right">0 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Entitled</td>
                            <td class="text-right">14 Days</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Compassionate Leave</h6>
                <div class="svg-center" id="rounded_progress_single3"></div>

                <div class="row mt-20 mb-5 text-left">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#70b754;"></div></td>
                            <td>Available</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#d4f1c8;"></div></td>
                            <td>Consumed</td>
                            <td class="text-right">4.5 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Accrued</td>
                            <td class="text-right">0 Days</td>
                        </tr>
                        <tr>
                            <td><div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div></td>
                            <td>Entitled</td>
                            <td class="text-right">14 Days</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>-->
    </div>

    <div class="col-md-3 pl-0">
        <div class="col-md-12 pl-0">
            <div class="card card-body" style="height:330px;">
                <h6 class="font-weight-semibold mb-0 mt-1">Leave Actions</h6>

                <a href="#" class="button-next btn btn-primary btn-next mt-20">Apply Leave Now</a>

                <h6 class="font-weight-semibold mb-10 mt-30">Useful Resources</h6>

                <a href="" target="_blank" class="mt-10 ml-10"><i class="icon-file-text2"></i> Leave Policy Document</a>
            </div>
        </div>
    </div>

</div>


<table class="table table-bordered leaveHistoryTable">
    <thead>
    <tr>
        <th>Leave Type (Code)</th>
        <th>Period</th>
        <th>Days</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Approved By</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>