
<div class="card">
    <div class="card-header bg-transparent header-elements-inline">
                    <span class="dashboard-header text-uppercase font-size-sm font-weight-semibold">My Team Members (3) &nbsp;-&nbsp;
                        <a href="#" class="" data-toggle="modal" data-target="#modalNewTeam">Create New Team</a> &nbsp;|&nbsp;
                        <a href="">Join Existing Team</a>
                    </span>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="media-list">
                    <li class="media">
                        <a href="#" class="mr-3 position-relative" data-toggle="dropdown">
                            <img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face5.jpg" width="48" height="48" class="rounded-circle" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-force dropdown-menu-left">
                            <a href="#" class="dropdown-item modalChat"><i class="icon-bubbles4"></i> Chat with Sam</a>
                            <div class="divider"></div>
                            <a href="#" class="dropdown-item"><i class="icon-calendar"></i> View Sam's Calendar</a>
                            <a href="#" class="dropdown-item"><i class="icon-user"></i> View Sam's Profile</a>
                        </div>
                    </li>

                    <li class="media">
                        <a href="#" class="mr-3 position-relative" data-toggle="dropdown">
                            <img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face13.jpg" width="48" height="48" class="rounded-circle" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-force dropdown-menu-left">
                            <a href="#" class="dropdown-item modalChat"><i class="icon-bubbles4"></i> Chat with Sally</a>
                            <div class="divider"></div>
                            <a href="#" class="dropdown-item"><i class="icon-calendar"></i> View Sally's Calendar</a>
                            <a href="#" class="dropdown-item"><i class="icon-user"></i> View Sally's Profile</a>
                        </div>
                    </li>

                    <li class="media dropdown">
                        <a href="#" class="mr-3 dropdown-toggle position-relative" data-toggle="dropdown" aria-expanded="false">
                            <img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face25.jpg" width="48" height="48" class="rounded-circle" alt="">
                            <span class="badge badge-info badge-pill badge-float border-2 border-white">9</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-force dropdown-menu-left" x-placement="bottom-end">
                            <a href="#" class="dropdown-item modalChat" data-toggle="modal" id="34"><i class="icon-bubbles4"></i> Chat with David</a>
                            <div class="divider"></div>
                            <a href="#" class="dropdown-item"><i class="icon-calendar"></i> View David's Calendar</a>
                            <a href="#" class="dropdown-item"><i class="icon-user"></i> View David's Profile</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="modalNewTeam" class="modal fade">
    <div class="modal-dialog modal-med">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title">Create New Team</h6>
            </div>

            <form id="createTeamForm" name="createTeamForm" method="post" action="">
                <div class="modal-body overflow-y-visible">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name your team:</label>
                                <input type="text" name="teamName" id="teamName" class="form-control" value=""
                                       placeholder="Give your team a short and sweet name!" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Describe your team's objective:</label>
                                <textarea name="teamDescript" id="teamDescript" rows="6" cols="5"
                                          placeholder="We are the warriors of the company! Improving the quality of products, services, processes and communications!"
                                          class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label>Invite team members to join in the fun!</label>
                            <input type="text" name="teamMembers" class="form-control tokenfield-typeahead teamMemberList"
                                   placeholder="Enter team member's name" autocomplete="off" data-fouc />
                            <!--value="<?TPLVAR_TEAM_MEMBERS?>"-->

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer-btn">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Discard</button>
                        <button id="createTeam" type="submit" class="btn btn-primary">Create Team</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#modalNewTeam").on("shown.bs.modal", function(e) {
            $("#teamName").focus( );
        });

        var engine1 = new Bloodhound({
            remote: {
                url: Aurora.ROOT_URL + 'admin/employee/getList/%QUERY',
                wildcard: '%QUERY',
                filter: function( response ) {
                    var tokens = $(".teamMemberList").tokenfield("getTokens");

                    return $.map( response, function( d ) {
                        if( engine1.valueCache.indexOf(d.name) === -1) {
                            engine1.valueCache.push(d.name);
                        }
                        var exists = false;
                        for( var i=0; i<tokens.length; i++ ) {
                            if( d.name === tokens[i].label ) {
                                exists = true;
                                break;
                            }
                        }
                        if( !exists ) {
                            return {
                                id: d.userID,
                                value: d.name,
                                image: d.image,
                                designation: d.designation
                            }
                        }
                    });
                }
            },
            datumTokenizer: function(d) {
                return Bloodhound.tokenizers.whitespace(d.value);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        // Initialize engine
        engine1.valueCache = [];
        engine1.initialize();

        // Initialize tokenfield
        $(".teamMemberList").tokenfield({
            delimiter: ';',
            typeahead: [{
                minLength:1,
                highlight:true,
                hint:false
            },{
                displayKey: 'value',
                source: engine1.ttAdapter(),
                templates: {
                    suggestion: Handlebars.compile([
                        '<div class="col-md-12">',
                        '<div class="col-md-2"><img src="{{image}}" width="40" height="40" ',
                        'style="padding:0;" class="rounded-circle" /></div>',
                        '<div class="col-md-10"><span class="typeahead-name">{{value}}</span>',
                        '<div class="typeahead-designation">{{designation}}</div></div>',
                        '</div>'
                    ].join(''))
                }
            }]
        });

        $(".teamMemberList").on("tokenfield:createtoken", function( event ) {
            var exists = false;
            $.each( engine1.valueCache, function(index, value) {
                if( event.attrs.value === value ) {
                    exists = true;
                }
            });
            if( !exists ) {
                event.preventDefault( );
            }
        });

        $("#createTeam").on("click", function ( ) {
            var data = {
                bundle: {
                    data: Aurora.WebService.serializePost("#createTeamForm")
                },
                success: function( res, ladda ) {

                    //ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal("Error!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        //
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/team/create", data );
            return false;
        });
    });
</script>

<div id="modalChat" class="modal-dialog chat-dialog modal-xl ">
    <div class="modal-content">
        <div class="modal-header chat-header bg-info">
            <button type="button" class="close modalClose" data-dismiss="modal">&times;</button>
            <h6 class="modal-title">Chat with David</h6>
        </div>

        <div class="modal-body chat-body">

            <!-- contact list -->
            <div class="col-md-3 room-list">
                <div class="search">
                    <label>
                        <input type="search" class="" placeholder="Filter" />
                    </label>
                </div>
                <div class="no-history">
                    You have no chat history at the moment
                </div>

                <!--<a href="" class="room" data-user="0" data-room="">
                    <div class="col-md-3">
                        <img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face13.jpg" width="48" height="48" class="rounded-circle" alt="">
                    </div>
                    <div class="col-md-9 contact-name">
                        Sally Chan
                        <div class="contact-position">HR Manager</div>
                    </div>
                </a>
                <a href="" class="room read" data-user="" data-room="">
                    <div class="col-md-3">
                        <img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face25.jpg" width="48" height="48" class="rounded-circle" alt="">
                    </div>
                    <div class="col-md-9 contact-name">
                        David Seaman
                        <div class="contact-position">HR Manager</div>
                    </div>
                    <div class="badge badge-info badge-pill badge-float">9</div>
                </a>-->
            </div>
            <!-- contact list -->

            <script>
                $(document).ready( function( ) {
                    var crID = 0;
                    var users = [];

                    $("#message").keypress(function (e) {
                        var key = e.which;
                        if( key == 13 ) {
                            $("#sendMessage").click();
                            return false;
                        }
                    });

                    $("#sendMessage").on("click", function ( ) {
                        var selected = $(".selected");
                        var crID = selected.attr("data-room");
                        var users = selected.attr("data-user");

                        var data = {
                            bundle: {
                                crID: crID,
                                users: users,
                                message: $("#message").val( )
                            },
                            success: function (res) {
                                var obj = $.parseJSON(res);
                                //console.log(obj)
                                if( obj.bool == 0 ) {
                                    swal("error", obj.errMsg);
                                    return;
                                }
                                else {
                                    console.log(res)
                                    //what happen if some garbage sent to socket? will it terminate?
                                    socket.emit("notify", res );
                                }
                            }
                        }
                        Aurora.WebService.AJAX( "admin/chat/send", data );
                        return false;
                    });

                    $(".room").on("click", function ( ) {
                        crID = $(this).attr("data-room");

                        // load last 10/20 messages in window
                    });

                    $(".modalChat").on("click", function ( ) {
                        var found = false;
                        var userID = $(this).attr("id");
                        users.push( userID );

                        $(".no-history").hide( );

                        $(".room").each(function( i ) {
                            if( $(this).attr("data-user") == userID ) {
                                // highlight existing room tab
                                found = true;
                            }
                        });

                        if( !found ) {
                            // create new room tab
                            var html = '<a href="" class="room selected" data-user="' + users.join( ) + '" data-room="0">\n' +
                                '<div class="col-md-3">\n' +
                                '<img src="http://demo.interface.club/limitless/demo/bs4/Template/global_assets/images/demo/users/face25.jpg" width="48" height="48" class="rounded-circle" alt="">\n' +
                                '</div>\n' +
                                '<div class="col-md-9 contact-name">David Seaman\n' +
                                '<div class="contact-position">HR Manager</div>\n' +
                                '</div>\n' +
                                '<div class="badge badge-info badge-pill badge-float">9</div>\n' +
                                '</a>';

                            $(".room-list").append(html);
                        }

                        // load last 10/20 messages in window
                    });
                })
            </script>

            <div class="col-md-9 right-window">
                <div class="message-wrapper"></div>
                <div class="typing">Sally Chan is typing...</div>
                <div class="col-md-10 textfield-wrapper">
                    <div class="textfield">
                        <input type="textfield" id="message" name="message" class="form-control" placeholder="Type message here..." />
                    </div>
                    <div class="send">
                        <a href="#" class="btn bg-blue" id="sendMessage">Send <i class="icon-arrow-right14 ml-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>