$(document).ready(function () {

    //[FULLCALENDAR]
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'resourceTimeline', 'bootstrap'],
        themeSystem: 'bootstrap',
        aspectRatio: 1.35,  // default
        timeZone: 'local',
        nowIndicator: true, //show current time
        firsrHour: 6,    // set first visible hour to 6:00am

        height: 'auto', //allow for Fullcalender to determine best fit size
        header: {
            left: 'today prev,next',
            center: 'title',
            right: 'resourceTimelineDay,resourceTimelineThreeDays,timeGridWeek,dayGridMonth'
        },
        defaultView: 'resourceTimelineDay',
        views: {
            resourceTimelineThreeDays: {
                type: 'resourceTimeline',
                duration: { days: 3 },
                buttonText: '3 days'
            }
        },

        businessHours: [{
            daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday
            startTime: '9:00',
            endTime: '18:00',
        }, {
            daysOfWeek: [0, 6], // Sunday, Saturday
            startTime: '11:00',
            endTime: '17:00',
        }],

        resourceAreaWidth: '20%',
        resourceAreaHeight: '100%',
        resourceLabelText: '3D Printer',
        resources: {
            url: 'calendar_resource.php',
            method: 'POST'
        },


        // [SHOW PRINTER STATUS]
        resourceRender: function (renderInfo) {
            var resourceStatus = renderInfo.resource.extendedProps.printerStatus;
            if (resourceStatus == "Unavailable") {
                // renderInfo.el.style.backgroundColor = '#DCDCDC';  //change unavailable printer background to dark grey
                renderInfo.el.style.color = "red";
                var status = document.createElement('a');
                status.innerText = ' ( Unavailable ) ';  // show 'Unavailable' if the printer is Unavailable
                renderInfo.el.querySelector('.fc-cell-text').appendChild(status);
            }
        },

        events: {
            url: 'calendar_event.php',
            method: 'POST'
        },
        eventTextColor: 'black', // change text color on event

        selectable: true, // can select times on the calendar
        selectHelper: true,  // draw a “placeholder” event while the user is dragging 
        snapDuration: '00:15:00', // set time select duration 
        editable: true,  // enable draggable events
        droppable: true, // allows things to be dropped onto the calendar
        eventOverlap: false, // disable overlap events - one printing object allowed at a time 


        // [SELECT TIME - ADD]
        select: function (info) {
            var printerId = info.resource.id; // get resourceId (printerId)
            var startTime = moment(info.startStr).format('YYYY-MM-DD HH:mm'); // get user selected time 
            var endTime = moment(info.endStr).format('YYYY-MM-DD HH:mm');
            var ms = moment(endTime).diff(moment(startTime));   // calculate time difference (duration)
            var selectedDuration = moment.duration(ms, "milliseconds").format("HH:mm", {   //format duration to hh:mm
                trim: false
            });
            var resourceStatus = info.resource.extendedProps.printerStatus;
            if (resourceStatus == "Unavailable") {
                alert("WARNNING: This printer is currently unavailable!");
            }
            // set values in inputs
            $('#eventModal').find('input[name=startTime]').val(startTime); // user selected start time
            $('#eventModal').find('input[name=endTime]').val(endTime);  // user selected end time, for initial duration calculation only
            $('#eventModal').find('input[name=printDuration]').val(selectedDuration); // initial duration
            $('#eventModal').find('input[name=printerId]').val(printerId); // resourceId
            $('#eventModalLabel').text("Add Event");
            $('#action').val("Add");
            $('#operation').val("Add");
            $('#eventModal').modal('show');  // Show modal to create event
            $('#delete_btn_event').hide();   // hide delete btn when adding new events
            document.getElementById('studentEmail').readOnly = false;
            validate(); // validate duration
        },


        // [EVENT CLICK - UPDATE]
        eventClick: function (info) {
            $('#eventModal').modal('show');
            $('#eventModalLabel').text("Update Event");
            $('#action').val("Update");
            $('#operation').val("Update");
            $('#delete_btn_event').show();
            var appointmentId = info.event.id;
            $.ajax({
                url: "calendar_fetch.php",
                method: "POST",
                data: { appointmentId: appointmentId },
                dataType: "json",
                success: function (data) {
                    $('#title').val(data.title);
                    $('#datetimepicker1').val(data.startTime);
                    $('#datetimepicker3').val(data.printDuration);
                    $('#studentEmail').val(data.studentEmail);
                    $('#studentFirstName').val(data.studentFirstName);
                    $('#studentLastName').val(data.studentLastName);
                    $('#objectName').val(data.objectName);
                    $('#filamentConsumed').val(data.filamentConsumed);
                    $('#printReason').val(data.printReason);
                    $('#comment').val(data.comment);
                    $('#jobStatus').val(data.jobStatus);
                    $('#statusNote').val(data.statusNote);
                    $('#endTime').val(data.endTime);         // hidden field
                    $('#appointmentId').val(appointmentId);  // hidden field
                    $('#objectId').val(data.objectId);       // hidden field
                    $('#printerId').val(data.printerId);     // hidden field
					$('#validation_duration').empty();  //clear event overlay error message
					$("#datetimepicker3").removeClass('is-invalid'); // clear red frame for error message
                    document.getElementById('studentEmail').readOnly = true;  // make studentEmail not editable on update page because it's primary key on student table
					
                }
            })
        },


        // [UPDATE EVENT TIME - RESIZE WINDOW]
        eventResize: function (info) {
            var startTime = moment(info.event.start).format('YYYY-MM-DD HH:mm'); // get user selected time 
            var endTime = moment(info.event.end).format('YYYY-MM-DD HH:mm');
            var appointmentId = info.event.id;
            var printerId = info.event.extendedProps.printerId;
            if (confirm("Are you sure about this change?")) {
                $.ajax({
                    url: "calendar_drop&resize.php",
                    type: "POST",
                    data: {
                        startTime: startTime,
                        endTime: endTime,
                        appointmentId: appointmentId,
                        printerId: printerId
                    },
                    success: function (data) {
                        alert(data);
                        calendar.refetchEvents(); // refetch event/ update calendar
                    }
                })
            } else {
                info.revert();
            }
        },


        // [UPDATE EVENT RESOURCE (PRINTER) - DRAG AND DROP]
        eventDrop: function (info) {
            // get user selected time and event's appointmentId
            var startTime = moment(info.event.start).format('YYYY-MM-DD HH:mm');
            var endTime = moment(info.event.end).format('YYYY-MM-DD HH:mm');
            var appointmentId = info.event.id;

            //If the resource (printer) has not changed, newResource will be undefined. 
            if (typeof info.newResource === 'undefined' || info.newResource === null) {   // same printer
                var printerId = info.oldEvent.extendedProps.printerId;
            } else {   // different printer         
                var printerId = info.newResource.id;  // get new printerId
                var resourceStatus = info.newResource.extendedProps.printerStatus;  // get resourceStatus
                if (resourceStatus == "Unavailable") {
                    alert("WARNNING: This printer is currently unavailable!");
                }

            }

            // confirm. if yes, update event. if no, revert changes.
            if (confirm("Are you sure about this change?")) {
                $.ajax({
                    url: "calendar_drop&resize.php",
                    type: "POST",
                    data: {
                        startTime: startTime,
                        endTime: endTime,
                        appointmentId: appointmentId,
                        printerId: printerId
                    },
                    success: function (data) {
                        alert(data);
                        calendar.refetchEvents();
                    }
                })
            } else {
                info.revert();
            }
        },

    });

    calendar.render();


    // [ADD/UPDATE EVENT]
    $('#eventForm').on("submit", function (event) {
        event.preventDefault();    // restrict page refreshing
        $.ajax({
            url: "calendar_insert.php",
            type: "POST",
            data: $('#eventForm').serialize(),
            success: function (data) {
                alert(data);
                $('#eventForm')[0].reset();
                $('#eventModal').modal('hide');
                calendar.refetchEvents();
            }
        })
    });


    // [RESET MODAL]
    $(".modal").on("hidden.bs.modal", function () {
        // fired when the modal has finished being hidden from the user 
        $('#eventForm')[0].reset();
    });


    // [DELETE EVENT]
    $('#delete_btn_event').on('click', function () {
        var appointmentId = document.getElementById("appointmentId").value;
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                url: "calendar_delete.php",
                method: "POST",
                data: { appointmentId: appointmentId },
                success: function (data) {
                    alert(data);
                    $('#eventModal').modal('hide');
                    calendar.refetchEvents();
                }
            });
        }
        else {
            // if click on cancel button - no action
            return false;
        }
    });


    // [AUTOFILL - STUDENT INFO]
    $("#studentEmail").change(function () {
        var studentEmail = $(this).val();
        // check if input is in the datalist
        match = $('#studentEmailList option').filter(function () {
            var emailOption = $(this).val();
            return (studentEmail === emailOption);
        });
        if (match.length > 0) {  // if user input matches the list or was selected from the list
            $.ajax({
                url: 'calendar_object.php',
                type: 'post',
                data: { studentEmail: studentEmail },
                dataType: 'json',
                success: function (data) {
                    // get object list based on student email
                    var len = data.length;
                    $("#objectList").empty();
                    for (var i = 0; i < len; i++) {
                        var objectName = data[i]['objectName'];
                        var objectId = data[i]['objectId'];
                        $("#objectList").append("<option value='" + objectName + "' id='" + objectId + "'></option>");
                    }
                    // auto fill student first name and last name
                    $.ajax({
                        url: 'calendar_fetch.php',
                        type: 'post',
                        data: { studentEmail: studentEmail },
                        dataType: 'json',
                        success: function (data) {
                            $('#studentFirstName').val(data.studentFirstName);
                            $('#studentLastName').val(data.studentLastName);
                        }
                    });
                }
            });
        }
    });


    // [AUTOFILL - OBJECT INFO]
    $('#objectName').on('input', function () {
        var objectName = $('#objectName').val();
        // check if input is in the datalist
        match = $('#objectList option').filter(function () {
            var objectOption = $(this).val();
            return (objectOption === objectName);
        });
        if (match.length > 0) {  // if user input matches the list or was selected from the list
            // get objectId associated with the selected object
            var objectId = $('#eventModal').find('option[value="' + objectName + '"]').attr('id');
            $('#eventModal').find('input[name=objectId]').val(objectId);
            // auto fill object information
            $.ajax({
                url: 'calendar_fetch.php',
                type: 'post',
                data: { objectId: objectId },
                dataType: 'json',
                success: function (data) {
                    $('#filamentConsumed').val(data.filamentConsumed);
                    $('#printReason').val(data.printReason);
                    $('#comment').val(data.comment);
                    $('#datetimepicker3').val(data.printDuration);
                }
            });
        }
    });


    // [DATE TIME PICKER FORMAT]
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });


    // [TIME PICKER FORMAT - DURATION]
    $('#datetimepicker3').datetimepicker({
        format: 'HH:mm'
    });


    // [DURATION VALIDATION]
    function validate() {
        // get selected time and printer
        var startTime = $('#eventModal').find('input[name=startTime]').val();
        var endTime = $('#eventModal').find('input[name=endTime]').val();
        var printerId = $('#printerId').val();
        $.ajax({
            type: "POST",
            url: "calendar_validate.php",
            data: {
                startTime: startTime,
                endTime: endTime,
                printerId: printerId
            },
            success: function (data) {
                if (!$.trim(data)) { // returns null means time slot is available 
                    $("#datetimepicker3").removeClass('is-invalid'); // remove red frame for input
                } else {
                    $("#datetimepicker3").addClass('is-invalid');  // show red frame for input 
                    $('#validate_duration').html(data).css('color', 'red');  // display validation message
                }
            }
        });
    };

});
