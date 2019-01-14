<style>
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
        // Rounded progress - single arc
        var _roundedProgressSingle = function(element, size, goal, color) {
            if (typeof d3 == 'undefined') {
                console.warn('Warning - d3.min.js is not loaded.');
                return;
            }

            // Initialize chart only if element exsists in the DOM
            if(element) {
                // Add random data
                var dataset = function () {
                    return [{percentage: Math.random() * 100}];
                };

                // Main variables
                var d3Container = d3.select(element),
                    padding = 2,
                    strokeWidth = 16,
                    width = size,
                    height = size,
                    twoPi = 2 * Math.PI;


                // Create chart
                // ------------------------------

                // Add svg element
                var container = d3Container.append("svg");

                // Add SVG group
                var svg = container
                    .attr("width", width)
                    .attr("height", height)
                    .append("g")
                    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");


                // Construct chart layout
                // ------------------------------

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


                //
                // Animate elements
                //

                // Add transition
                //d3.transition().duration(2500).each(update);
                d3.transition().duration(2500).each(update);


                // Animation
                function update() {
                    field = field.each(function (d) {
                            this._value = d.percentage;
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
                                this.textContent = Math.floor(d.percentage/100 * goal) + " days";
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
        _roundedProgressSingle("#rounded_progress_single", 150, 14, '#458AF2');
        _roundedProgressSingle("#rounded_progress_single1", 150, 14, '#EC407A');
        _roundedProgressSingle("#rounded_progress_single2", 150, 14, '#ffaf23');
        _roundedProgressSingle("#rounded_progress_single3", 150, 14, '#70b754');


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
                targets: 0,
                checkboxes: {
                    selectRow: true
                },
                width: '10px',
                orderable: false,
                searchable : false,
                className: "text-center",
                data: 'laID',
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="dt-checkboxes" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },{
                targets: [1],
                orderable: true,
                width: '250px',
                render: function (data, type, full, meta) {
                    return full["name"] + ' (' + full["code"] + ")";
                }
            },{
                targets: [2],
                orderable: true,
                width: '230px',
                render: function (data, type, full, meta) {
                    return full["startDate"] + '&nbsp; &mdash; &nbsp;' + full["endDate"];
                }
            },{
                targets: [3],
                orderable: true,
                width: '80px',
                className: "text-center",
                data: 'days'
            },{
                targets: [4],
                orderable: true,
                width: '280px',
                data: 'reason'
            },{
                targets: [5],
                orderable: true,
                width: '120px',
                data: 'approved'
            },{
                targets: [6],
                orderable: false,
                searchable : false,
                width: '180px',
                data: 'supervisors',
                render: function(data, type, full, meta) {
                    //var name   = full["name"];
                    //var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"
                    var length = data.length;
                    var supervisors = "";

                    for( var i=0; i<length; i++ ) {
                        if( data[i]["approved"] == 0 ) {
                            supervisors += '<i class="icon-watch2 text-grey-300 mr-3"></i>';
                        }
                        else if( data[i]["approved"] == 1 ) {
                            supervisors += '<i class="icon-checkmark4 text-green-800 mr-3"></i>';
                        }
                        else if( data[i]["approved"] == "-1" ) {
                            supervisors += '<i class="icon-cross2 text-warning-800 mr-3"></i>';
                        }
                        supervisors += data[i]["name"] + "<br />";
                    }
                    return supervisors;
                }
            },{
                targets: [7],
                orderable: false,
                searchable : false,
                width: '100px',
                className : "text-center",
                data: 'laID',
                render: function(data, type, full, meta) {
                    //var name   = full["name"];
                    //var statusText = full['suspended'] == 1 ? "Unsuspend Employee" : "Suspend Employee"

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
            }],
            select: {
                "style": "multi"
            },
            order: [],
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

<div class="row mt-10">

    <div class="col-md-9">
        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Annual Leave</h6>
                <div class="svg-center" id="rounded_progress_single"></div>

                <div class="row mt-20 mb-5 text-left">

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#458AF2;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Available</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#c3d8f8;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Consumed</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Acrued So Far</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>0 Days</div>
                    </div>

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Annual Quota</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>14 Days</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Sick Leave</h6>
                <div class="svg-center" id="rounded_progress_single1"></div>

                <div class="row mt-20 mb-5 text-left">

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#EC407A;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Available</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#fad0df;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Consumed</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Acrued So Far</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>0 Days</div>
                    </div>

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Annual Quota</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>14 Days</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Hospitalisation leave</h6>
                <div class="svg-center" id="rounded_progress_single2"></div>

                <div class="row mt-20 mb-5 text-left">

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ffaf23;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Available</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#fee8c8;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Consumed</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Acrued So Far</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>0 Days</div>
                    </div>

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Annual Quota</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>14 Days</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-body text-center">
                <h6 class="font-weight-semibold mb-0 mt-1 mb-10">Compassionate Leave</h6>
                <div class="svg-center" id="rounded_progress_single3"></div>

                <div class="row mt-20 mb-5 text-left">

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#70b754;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Available</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#d4f1c8;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Consumed</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>4.5 Days</div>
                    </div>


                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Acrued So Far</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>0 Days</div>
                    </div>

                    <div class="col-md-1">
                        <div style="width:10px;height:10px;margin-top: 5px;background-color:#ccc;"></div>
                    </div>
                    <div class="col-md-6">
                        <div>Annual Quota</div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div>14 Days</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 pl-0">
        <div class="col-md-12">
            <div class="card card-body" style="height:329px;">
                <h6 class="font-weight-semibold mb-0 mt-1">Leave Actions</h6>

                <a href="#" class="button-next btn btn-primary btn-next mt-20">Apply Leave Now</a>

                <h6 class="font-weight-semibold mb-10 mt-30">Useful Resources</h6>

                <a href="" target="_blank" class="mt-10 ml-10"><i class="icon-file-text2"></i> Leave Policy Document</a>
            </div>
        </div>
    </div>

</div>


<div class="panel panel-flat leave-history">
    <table class="table table-bordered leaveHistoryTable">
        <thead>
        <tr>
            <th></th>
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
</div>