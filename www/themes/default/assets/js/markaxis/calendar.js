/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July 9th, 2012
 * @version $Id: calendar.js, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
var MarkaxisCalendar = (function( ) {

    /**
     * MarkaxisCalendar Constructor
     * @return void
     */
    MarkaxisCalendar = function( ) {
        this.startPicker = false;
        this.endPicker = false;
        this.tooltip = false;
        this.calendar = false;
        this.validator = false;
        this.rules = false;

        this.myEvents = true;
        this.colleagues = true;
        this.includeBirthday = true;
        this.includeHoliday = true;

        this.evenSources = {
            birthdays: {
                id: "birthdays",
                url: Aurora.ROOT_URL + "admin/calendar/getEvents",
                method: "POST",
                className: "birthday",
                extraParams: {
                    type: "birthday",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            holidays: {
                id: "holidays",
                url: Aurora.ROOT_URL + "admin/calendar/getEvents",
                method: "POST",
                className: "holiday",
                extraParams: {
                    type: "holiday",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerEvents: {
                id: "ownerEvents",
                url: Aurora.ROOT_URL + "admin/calendar/getEvents",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerDayRecur: {
                id: "ownerDayRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "day",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerWeekRecur: {
                id: "ownerWeekRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "week",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerBiWeeklyRecur: {
                id: "ownerBiWeeklyRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "biweekly",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerWeekdayRecur: {
                id: "ownerWeekdayRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "weekday",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerMonWedFriRecur: {
                id: "ownerMonWedFriRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "monWedFri",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerTueThurRecur: {
                id: "ownerTueThurRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "tueThur",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerMonthRecur: {
                id: "ownerMonthRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "month",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            ownerYearRecur: {
                id: "ownerYearRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                editable: true,
                extraParams: {
                    user: "owner",
                    type: "year",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            colleagueEvents: {
                id: "colleagueEvents",
                url: Aurora.ROOT_URL + "admin/calendar/getEvents",
                method: "POST",
                extraParams: {
                    user: "colleague",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            },
            colleagueMonthRecur: {
                id: "colleagueMonthRecur",
                url: Aurora.ROOT_URL + "admin/calendar/getRecurs",
                method: "POST",
                extraParams: {
                    user: "colleague",
                    type: "month",
                    ajaxCall: 1,
                    csrfToken: Aurora.CSRF_TOKEN
                }
            }
        }
        this.init( );
    };

    MarkaxisCalendar.prototype = {
        constructor: MarkaxisCalendar,

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

            $("#recurType").select2({minimumResultsForSearch: -1, allowClear: true});
            $("#reminder").select2({minimumResultsForSearch: -1, allowClear: true});
            $("#startTime").select2({minimumResultsForSearch: -1});
            $("#endTime").select2({minimumResultsForSearch: -1});

            $("#startTime").prop("disabled", true);
            $("#endTime").prop("disabled", true);

            $("#allDay").change(function () {
                if( $(this).is(':checked') ) {
                    $("#startTime").prop("disabled", true);
                    $("#endTime").prop("disabled", true);
                }
                else {
                    $("#startTime").prop("disabled", false);
                    $("#endTime").prop("disabled", false);
                }
            });

            var label = $("#label");
            label.select2({minimumResultsForSearch: -1});
            label.val("blue").trigger("change");
            label.next().find(".select2-selection").addClass( "blue" );

            label.on("select2:select", function(e) {
                var data = e.params.data;
                var select = label.next().find(".select2-selection");
                select.removeClass( "blue red gold green purple peach orange grey turquoise cyan yellow" );
                select.addClass( data.element.value );
            });

            this.startPicker = $(".pickadate-start").pickadate({
                showMonthsShort: true,
                //disable:datesToDisable,
                format:"dd mmm yyyy"
            });

            this.endPicker = $(".pickadate-end").pickadate({
                showMonthsShort: true,
                ///disable:datesToDisable,
                format:"dd mmm yyyy"
            });

            $("#deleteEvent").on("click", function ( ) {
                that.deleteEvent( );
                return false;
            });

            $("#saveEvent").on("click", function ( ) {
                $("#eventForm").validate( rules );

                if( $("#eventForm").valid( ) ) {
                    that.saveEvent( );
                    return false;
                }
            });

            $("#myEvents").bootstrapSwitch({
                size: 'mini',
                onSwitchChange: function (event, state) {
                    event.preventDefault()
                    if( that.myEvents ) {
                        that.calendar.getEventSourceById("ownerEvents").remove( );
                        that.calendar.getEventSourceById("ownerDayRecur").remove( );
                        that.calendar.getEventSourceById("ownerWeekRecur").remove( );
                        that.calendar.getEventSourceById("ownerBiWeeklyRecur").remove( );
                        that.calendar.getEventSourceById("ownerWeekdayRecur").remove( );
                        that.calendar.getEventSourceById("ownerMonWedFriRecur").remove( );
                        that.calendar.getEventSourceById("ownerTueThurRecur").remove( );
                        that.calendar.getEventSourceById("ownerMonthRecur").remove( );
                        that.calendar.getEventSourceById("ownerYearRecur").remove( );
                        that.myEvents = false;
                    }
                    else {
                        that.calendar.addEventSource( that.evenSources.ownerEvents );
                        that.calendar.addEventSource( that.evenSources.ownerDayRecur );
                        that.calendar.addEventSource( that.evenSources.ownerWeekRecur );
                        that.calendar.addEventSource( that.evenSources.ownerBiWeeklyRecur );
                        that.calendar.addEventSource( that.evenSources.ownerWeekdayRecur );
                        that.calendar.addEventSource( that.evenSources.ownerMonWedFriRecur );
                        that.calendar.addEventSource( that.evenSources.ownerTueThurRecur );
                        that.calendar.addEventSource( that.evenSources.ownerMonthRecur );
                        that.calendar.addEventSource( that.evenSources.ownerYearRecur );
                        that.myEvents = true;
                    }
                }
            });

            $("#colleagues").bootstrapSwitch({
                size: 'mini',
                onSwitchChange: function (event, state) {
                    event.preventDefault()
                    if( that.colleagues ) {
                        that.calendar.getEventSourceById("colleagueEvents").remove( );
                        that.calendar.getEventSourceById("colleagueMonthRecur").remove( );
                        that.colleagues = false;
                    }
                    else {
                        that.calendar.addEventSource( that.evenSources.colleagueEvents );
                        that.calendar.addEventSource( that.evenSources.colleagueMonthRecur );
                        that.colleagues = true;
                    }
                }
            });

            $("#includeBirthday").bootstrapSwitch({
                size: 'mini',
                onSwitchChange: function (event, state) {
                    event.preventDefault()
                    if( that.includeBirthday ) {
                        that.calendar.getEventSourceById("birthdays").remove( );
                        that.includeBirthday = false;
                    }
                    else {
                        that.calendar.addEventSource( that.evenSources.birthdays );
                        that.includeBirthday = true;
                    }
                }
            });

            $("#includeHoliday").bootstrapSwitch({
                size: 'mini',
                onSwitchChange: function (event, state) {
                    event.preventDefault()
                    if( that.includeHoliday ) {
                        that.calendar.getEventSourceById("holidays").remove( );
                        that.includeHoliday = false;
                    }
                    else {
                        that.calendar.addEventSource( that.evenSources.holidays );
                        that.includeHoliday = true;
                    }
                }
            });

            $("#eventModal").on('hidden.bs.modal', function (e) {
                that.resetForm( );
            });

            $.validator.addMethod("validDateRange", function(value, element, params) {
                return that.getDaysDiff();
            }, Aurora.i18n.GlobalRes.LANG_INVALID_DATE_RANGE );

            var rules = {
                ignore: "",
                rules: {
                    ltID: { required: true },
                    startDate: { required: true },
                    endDate: { required: true,
                               validDateRange: true
                    }
                },
                messages: {
                    ltID: Aurora.i18n.GlobalRes.LANG_PROVIDE_ALL_REQUIRED
                },
                highlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).addClass("border-danger");
                    }
                    else {
                        elem.addClass("border-danger");
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    var elem = $(element);
                    if( elem.hasClass("select2-hidden-accessible") ) {
                        $("#select2-" + elem.attr("id") + "-container").parent( ).removeClass("border-danger");
                    }
                    else {
                        elem.removeClass("border-danger");
                    }
                },
                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    if( $(".modal-footer .error").length > 0 ) {
                        $(".modal-footer .error").remove( );
                    }
                    $(".modal-footer").append( error );
                }
            };

            that.calendar = new FullCalendar.Calendar( document.getElementById("calendar"), {
                plugins: ['interaction', 'dayGrid', 'timeGrid'],
                defaultView: 'dayGridMonth',
                selectable: true,
                eventLimit: true,
                nextDayThreshold:'00:00',
                minTime: "08:00:00",
                maxTime: "32:00:00",
                eventTimeFormat: { hour: 'numeric', minute: '2-digit', omitZeroMinute: true },
                eventDataTransform: function(event) {
                    if( event.allDay ) {
                        event.end = moment(event.end).add(1, 'days').format();
                    }
                    return event;
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventClick: function( eventObj ) {
                    var event = eventObj.event;

                    if( event.classNames.includes("birthday") ||
                        event.classNames.includes("holiday") ||
                        event.classNames.includes("colleagues") ) {
                        return false;
                    }

                    $("#eID").val( event.extendedProps.eID );
                    $("#title").val( event.title );
                    $("#descript").val( event.extendedProps.descript );
                    $("#recurType").val( event.extendedProps.recurType ).trigger("change");
                    $("#reminder").val( event.extendedProps.reminder ).trigger("change");

                    that.labelChange( event.extendedProps.label );

                    if( event.extendedProps.public == "1" ) {
                        if( !$("#public").is(':checked') ) {
                            $("#public").click( );
                        }
                    }
                    else {
                        if( $("#public").is(':checked') ) {
                            $("#public").click( );
                        }
                    }

                    var startDay   = moment(event.start).format("DD");
                    var startMonth = moment(event.start).format("MM");
                    var startYear  = moment(event.start).format("YYYY");

                    var startPicker = that.startPicker.pickadate("picker");
                    startPicker.set("select", new Date( startYear, parseInt(startMonth)-1, startDay ) );

                    var endDay   = moment(event.end).format("DD");
                    var endMonth = moment(event.end).format("MM");
                    var endYear  = moment(event.end).format("YYYY");

                    if( event.allDay ) {
                        endDay -= 1;
                        $("#startTime").val( "0800" ).trigger("change");
                        $("#endTime").val( "0800" ).trigger("change");

                        if( !$("#allDay").is(':checked') ) {
                            $("#allDay").click( );
                        }
                    }
                    else {
                        $("#startTime").val( moment(event.extendedProps.startDateTime).format("HHmm") ).trigger("change");
                        $("#endTime").val( moment(event.extendedProps.endDateTime).format("HHmm") ).trigger("change");

                        if( $("#allDay").is(':checked') ) {
                            $("#allDay").click( );
                        }
                        $("#startTime").prop("disabled", false);
                        $("#endTime").prop("disabled", false);
                    }

                    var endPicker = that.endPicker.pickadate("picker");
                    endPicker.set("select", new Date( endYear, parseInt(endMonth)-1, parseInt(endDay) ) );

                    if( event.extendedProps.recurType != null ) {
                        $("#modalNote").removeClass("hide");
                    }
                    $("#deleteEvent").removeClass("hide");
                    $("#eventModal .modal-title").text( Markaxis.i18n.EventRes.LANG_EDIT_EVENT );
                    $("#eventModal").modal( );
                },
                select: function( info ) {
                    that.setDateTime( "start", info, info.startStr );
                    that.setDateTime( "end", info, info.endStr );
                    $("#eventModal").modal( );
                },
                eventRender: function( eventObj ) {
                    if( !that.myEvents && eventObj.event.classNames.includes("myEvents") ) {
                        $(eventObj.el).addClass("hide");
                    }

                    if( !that.colleagues && eventObj.event.classNames.includes("colleagues") ) {
                        $(eventObj.el).addClass("hide");
                    }

                    if( !that.includeBirthday && eventObj.event.classNames.includes("birthday") ) {
                        $(eventObj.el).addClass("hide");
                    }

                    if( !that.includeHoliday && eventObj.event.classNames.includes("holiday") ) {
                        $(eventObj.el).addClass("hide");
                    }

                    if( this.tooltip ) {
                        this.tooltip.tooltip("dispose");
                    }
                },
                eventMouseEnter: function( info ) {
                    var descript = "";
                    var start = "";
                    var end = "";

                    if( info.event.extendedProps.descript ) {
                        descript = "<br />" + info.event.extendedProps.descript;
                    }

                    if( !info.event.allDay ) {
                        start = "<br />" + moment(info.event.extendedProps.startDateTime).format("h:mma");
                        end = " &mdash; " + moment(info.event.extendedProps.endDateTime).format("h:mma");
                    }

                    this.tooltip = $(info.el).tooltip({
                        title: info.event.title + descript + start + end,
                        html: true,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body',
                        show: true
                    });
                    this.tooltip.tooltip("show");
                },
                eventDrop: function(info) {
                    that.updateEvent( info );

                },
                eventResize: function(info) {
                    that.updateEvent( info );
                },
                eventSources: [ that.evenSources.birthdays, that.evenSources.holidays, that.evenSources.ownerEvents,
                                that.evenSources.ownerDayRecur, that.evenSources.ownerWeekRecur,
                                that.evenSources.ownerBiWeeklyRecur,
                                that.evenSources.ownerWeekdayRecur, that.evenSources.ownerMonWedFriRecur,
                                that.evenSources.ownerTueThurRecur, that.evenSources.ownerMonthRecur,
                                that.evenSources.ownerYearRecur, that.evenSources.colleagueEvents,
                                that.evenSources.colleagueMonthRecur ],
            });
            that.calendar.render( );
        },


        labelChange: function( value ) {
            $("#label").val( value ).trigger("change");
            $("#label").trigger({
                type: 'select2:select',
                params: {
                    data: {
                        element: {
                            value: value
                        }
                    }
                }
            });
        },


        setDateTime: function( element, info, str ) {
            var year  = moment(str).format("YYYY");
            var month = moment(str).format("MM");
            var day   = moment(str).format("DD");

            if( !info.allDay ) {
                var hour = moment(str).format("HH");
                var min  = moment(str).format("mm");
                $("#" + element + "Time").val( hour + min ).trigger("change");

                if( $("#allDay").is(':checked') ) {
                    $("#allDay").click( );
                }
            }
            else {
                if( element == "end" ) {
                    day -= 1;
                }
                if( !$("#allDay").is(':checked') ) {
                    $("#allDay").click( );
                }
                $("#" + element + "Time").val( "0800" ).trigger("change");
            }

            if( element == "start" ) {
                var startPicker = this.startPicker.pickadate("picker");
                startPicker.set( "select", new Date( year, parseInt(month)-1, day ) );
            }
            else {
                var endPicker = this.endPicker.pickadate("picker");
                endPicker.set( "select", new Date( year, parseInt(month)-1, day ) );
            }
        },


        getDaysDiff: function( ) {
            var startDate = new Date( $("#startDate").val( ) );
            var endDate = new Date( $("#endDate").val( ) );

            if( startDate == "Invalid Date" || endDate == "Invalid Date" ) {
                return;
            }
            if( startDate > endDate ) {
                return false;
            }
            return true;
        },


        saveEvent: function( ) {
            var that = this;
            var formData = Aurora.WebService.serializePost("#eventForm");

            var data = {
                bundle: {
                    laddaClass: "#saveEvent",
                    data: formData
                },
                success: function( res, ladda ) {
                    ladda.stop( );

                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    else {
                        that.resetForm( );

                        if( $("#eID").val( ) == 0 ) {
                            var title = Markaxis.i18n.EventRes.LANG_EVENT_CREATED;
                            var text = Markaxis.i18n.EventRes.LANG_EVENT_CREATED_DESCRIPT;
                        }
                        else {
                            var title = Markaxis.i18n.EventRes.LANG_EVENT_UPDATED;
                            var text = Markaxis.i18n.EventRes.LANG_EVENT_UPDATED_DESCRIPT;
                        }
                        swal({
                            title: title,
                            text: text,
                            type: "success"
                        }, function( isConfirm ) {
                            that.calendar.removeAllEvents( );
                            that.calendar.refetchEvents( );
                            $("#eventModal").modal("hide");
                        });
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/calendar/saveEvent", data );
        },


        deleteEvent: function( ) {
            var that = this;
            var title = $("#title").val();
            titleTxt = Markaxis.i18n.EventRes.LANG_CONFIRM_DELETE_EVENT.replace('{title}', title);
            text  = Markaxis.i18n.EventRes.LANG_CONFIRM_DELETE_EVENT_DESCRIPT;
            confirmButtonText = Aurora.i18n.GlobalRes.LANG_CONFIRM_DELETE;

            swal({
                title: titleTxt,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmButtonText,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm === false) return;

                $(".icon-bin").removeClass("icon-bin").addClass("icon-spinner2 spinner");

                var data = {
                    bundle: {
                        eID : $("#eID").val( )
                    },
                    success: function( res ) {
                        var obj = $.parseJSON( res );
                        if( obj.bool == 0 ) {
                            swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                            return;
                        }
                        else {
                            that.calendar.removeAllEvents( );
                            that.calendar.refetchEvents( );
                            swal( LANG_DONE + "!", Markaxis.i18n.EventRes.LANG_EVENT_DELETED_SUCCESSFULLY.replace('{title}', title), "success");
                            $("#eventModal").modal("hide");
                            return;
                        }
                    }
                };
                Aurora.WebService.AJAX( "admin/calendar/deleteEvent", data );
            });
        },


        updateEvent: function( info ) {
            var that = this;

            var startDay   = moment(info.event.start).format("DD");
            var startMonth = moment(info.event.start).format("MM");
            var startYear  = moment(info.event.start).format("YYYY");
            var startHour  = moment(info.event.start).format("HH");
            var startMin   = moment(info.event.start).format("mm");
            var startSec   = moment(info.event.start).format("ss");

            var fullEnd = "0000-00-00 00:00:00";

            if( info.event.end != null ) {
                var endDay = moment(info.event.end);

                if( info.event.allDay ) {
                    endDay.subtract(1, "days");
                }
                endDate = endDay.format("DD");
                endMonth = endDay.format("MM");

                var endYear  = moment(info.event.end).format("YYYY");
                var endHour  = moment(info.event.end).format("HH");
                var endMin   = moment(info.event.end).format("mm");
                var endSec   = moment(info.event.end).format("ss");

                fullEnd = endYear + "-" + endMonth + "-" + endDate + " " + endHour + ":" + endMin + ":" + endSec;
            }
            else if( info.oldEvent.allDay && !info.event.allDay ) {
                var updateHour = moment(info.event.start).add(1, "hours");
                fullEnd = startYear + "-" + startMonth + "-" + startDay + " " + updateHour.format("HH") + ":" + startMin + ":" + startSec;
            }

            var data = {
                bundle: {
                    data: {
                        eID: info.event.id,
                        start: startYear + "-" + startMonth + "-" + startDay + " " + startHour + ":" + startMin + ":" + startSec,
                        end: fullEnd,
                        allDay: info.event.allDay ? 1 : 0
                    }
                },
                success: function( res, ladda ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        swal( Aurora.i18n.GlobalRes.LANG_ERROR + "!", obj.errMsg, "error");
                        return;
                    }
                    that.calendar.removeAllEvents( );
                    that.calendar.refetchEvents( );
                }
            };
            Aurora.WebService.AJAX( "admin/calendar/updateEventDropDrag", data );
        },


        resetForm: function( ) {
            $("#eID").val(0);
            $("#title").val("");
            $("#descript").val("");
            $("#allDay").prop("checked", false).parent( ).removeClass("checked");
            $("#public").prop("checked", false).parent( ).removeClass("checked");
            $("#recurType").val("").trigger("change");
            $("#reminder").val("").trigger("change");
            this.labelChange( "blue" );

            $("#deleteEvent").addClass("hide");
            $("#modalNote").addClass("hide");
            $("#eventModal .modal-title").text( Markaxis.i18n.EventRes.LANG_CREATE_NEW_EVENT );
            $(".modal-footer .error").remove( );
        }
    }
    return MarkaxisCalendar;
})();
var markaxisCalendar = null;
$(document).ready( function( ) {
    markaxisCalendar = new MarkaxisCalendar( );
});