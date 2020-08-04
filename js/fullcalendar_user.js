$(document).ready(function () {

    //[FULLCALENDAR]
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'resourceTimeline', 'bootstrap'],
        themeSystem: 'bootstrap',
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

        resourceRender: function (renderInfo) {
            var resourceStatus = renderInfo.resource.extendedProps.printerStatus;
            if (resourceStatus == "Unavailable") {
                // renderInfo.el.style.backgroundColor = '#DCDCDC';  //change unavailable printer background to dark grey
                renderInfo.el.style.color = "red";
                var status = document.createElement('a');
                status.innerText = ' ( Unavailable ) ';
                renderInfo.el.querySelector('.fc-cell-text').appendChild(status);
            }
        },
        
        resourceLabelDidMount: function (info) {
           alert("hovered");
        },

        events: {
            url: 'calendar_event.php',
            method: 'POST'
        },
        eventTextColor: 'black', // change text color on event

        selectable: false, // cannot select times on the calendar
        editable: false,  // disable draggable events
        droppable: false, // does not allow things to be dropped onto the calendar
        eventOverlap: false, // disable overlap events - one printing object allowed at a time 

        
        // [EVENT CLICK - VIEW EVENT DETAIL]
        eventClick: function (info) {
            var jobStatus = info.event.extendedProps.jobStatus;
            var studentFirstName = info.event.extendedProps.studentFirstName;
            var studentLastName = info.event.extendedProps.studentLastName;
            var title = info.event.title;
            $('#eventDetailModal').modal('show');
            $('.modal-title').text(title);
            $('#viewStudentName').val(studentFirstName + " " + studentLastName);
            $('#viewStatus').val(jobStatus);
        },


    });

    calendar.render();

});
