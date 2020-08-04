$(document).ready(function () {

    var months = ["Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"]; // x value for many charts

    var date = new Date();  // date object with current date, time
    // var date = new Date("September 21, 2020 01:15:00");   // test
    var currentYear = date.getFullYear();  // get current year
    var currentMonth = date.getMonth();   // get currentMonth.  0=Jan, 11=Dec

    // determine academic year based on current date
    for (var i = 0; i < 5; i++) {  // show 5 academic years including this year
        if (currentMonth < 8) { // 0-7 January to August 
            var year = currentYear;
            var previousYear = year - 1;
        } else if (currentMonth >= 8) {  // 8-11 September to December
            year = currentYear + 1;
            previousYear = currentYear;
        }
        year = year - i;
        previousYear = previousYear - i;
        // append year list to all dropdown whose id starts with yearList. (e.g. "#yearList_result" or "#yearList_reason")
        $('select[id^="yearList"]').append("<option class='dropdown-item' value='" + year + "'> " + previousYear + " - " + year + " </option>");
    }


    // [FILAMENT CONSUMED]
    getData_filament(); // draw chart based on defult (current) academic year

    $('#yearList_filament').change(function () {  // if user choose to view a different academic year
        getData_filament();   // draw a new chart based on selected year
        $(this).closest(".dropdown-menu").prev().dropdown("toggle");  // close dropdown after selection
    });

    function getData_filament() {
        var selectedYear = $('select[name=yearList_filament] option').filter(':selected').val();   // get selected year
        $.ajax({
            url: "statistics_fetch.php",
            method: "POST",
            dataType: "json",
            data: { yearList_filament: selectedYear },
            success: function (data) {
                draw_filament(data);
            }
        });
    }

    function draw_filament(data) {

        var filamentArray = [];
        var appointmentArray = [];
        for (var i = 0; i < data.length; i++) {  // loop through all json objects in the array 
            var object = data[i];       // get each object
            filamentArray.push(object.totalFilamentConsumed);  // store filament consumed of each object in an array
            appointmentArray.push(object.totalAppointments);  // store number of appointments per month in an array
        }

        var trace1 = {
            x: months,
            y: filamentArray,
            type: 'bar',
            name: 'Filament',
            text: filamentArray.map(String),
            textposition: 'auto',
            hoverinfo: 'none',
            marker: {
                color: 'rgb(158,202,225)',
                opacity: 0.6,
                line: {
                    color: 'rgb(8,48,107)',
                    width: 1.5
                }
            }
        };

        var trace2 = {
            x: months,
            y: appointmentArray,
            mode: 'markers+lines',
            name: 'Print Jobs',
            type: 'scatter'
        }

        var academicYear = $('select[name=yearList_filament] option').filter(':selected').text();

        var layout = {
            showlegend: true,
            title: 'Total Filament Consumed for' + academicYear,
        };

        var data = [trace1, trace2];

        var config = {
            responsive: true
        }

        Plotly.newPlot('filamentChart', data, layout, config);
    }


    // [PRINT REASON]
    getData_printReason();

    $('#yearList_reason').change(function () {  // if user choose to view a different academic year
        getData_printReason();   // draw a new chart based on selected year
        $(this).closest(".dropdown-menu").prev().dropdown("toggle");  // close dropdown after selection
    });

    function getData_printReason() {
        var selectedYear = $('select[name=yearList_reason] option').filter(':selected').val();   // get selected year
        $.ajax({
            url: "statistics_fetch.php",
            method: "POST",
            dataType: "json",
            data: { yearList_reason: selectedYear },
            success: function (data) {
                draw_printReason(data);
            }
        });
    }

    function draw_printReason(data) {
        var data = [{
            type: 'pie',
            values: [data.schoolCount, data.personalCount],
            textinfo: "label+percent",
            labels: ["School", "Personal"],
            textposition: "outside",
            automargin: true,
            marker: {
                'colors': ['#4e73df', ' #8cb0d9']
            },
        }]

        var academicYear = $('select[name=yearList_reason] option').filter(':selected').text();

        var layout = {
            title: '3D Print Reason for' + academicYear,
            showlegend: false,
        }

        var config = {
            responsive: true
        } //automatically resize when the browser window size changes

        Plotly.newPlot('reasonPieChart', data, layout, config);
    }


    // [TOTAL PRINT TIME]
    getData_printTime(); // draw chart based on defult (current) academic year

    $('#yearList_printTime').change(function () {  // if user choose to view a different academic year
        getData_printTime();   // draw a new chart based on selected year
        $(this).closest(".dropdown-menu").prev().dropdown("toggle");  // close dropdown after selection
    });

    function getData_printTime() {
        var selectedYear = $('select[name=yearList_printTime] option').filter(':selected').val();   // get selected year
        $.ajax({
            url: "statistics_fetch.php",
            method: "POST",
            dataType: "json",
            data: { yearList_printTime: selectedYear },
            success: function (data) {
                //alert(data);
                draw_printTime(data);
            }
        });
    }

    function draw_printTime(data) {
        var minuteArray = [];
        var hourArray = [];
        for (var i = 0; i < data.length; i++) {  // loop through all json objects in the array 
            var object = data[i];       // get each object
            minuteArray.push(object.totalDurationMinute);  // store duration minute of each object into an array
            hourArray.push(object.totalDurationHour);
        }

        var trace1 = {
            x: months,
            y: minuteArray,
            type: 'bar',
            name: 'Minutes',
            marker: {
                color: '#858796',
                opacity: 0.5
            }
        };

        var trace2 = {
            x: months,
            y: hourArray,
            type: 'bar',
            name: 'Hours',
            marker: {
                color: '#1cc88a',
                opacity: 0.7,
            }
        };

        var academicYear = $('select[name=yearList_printTime] option').filter(':selected').text();

        var layout = {
            showlegend: true,
            title: 'Total Print Time for' + academicYear,
        }

        var config = {
            responsive: true
        }

        var data = [trace1, trace2];

        Plotly.newPlot('printTimeChart', data, layout, config);
    }


    // [PRINT REASULT]
    getData_printResult(); // draw chart based on defult (current) academic year

    $('#yearList_result').change(function () {  // if user choose to view a different academic year
        getData_printResult();   // draw a new chart based on selected year
        $(this).closest(".dropdown-menu").prev().dropdown("toggle");  // close dropdown after selection
    });

    function getData_printResult() {
        var selectedYear = $('select[name=yearList_result] option').filter(':selected').val();   // get selected year
        $.ajax({
            url: "statistics_fetch.php",
            method: "POST",
            dataType: "json",
            data: { yearList_result: selectedYear },
            success: function (data) {
                draw_printResult(data);
            }
        });
    }

    function draw_printResult(data) {
        var data = [{
            type: 'pie',
            values: [data.successCount, data.failedCount],
            textinfo: "label+percent",
            labels: ['Success', 'Failed'],
            textposition: "outside",
            automargin: true,
            marker: {
                'colors': ['#8cd9b3', ' #387769']
            },
        }];

        var academicYear = $('select[name=yearList_result] option').filter(':selected').text();

        var layout = {
            title: '3D Print Results for' + academicYear,
            showlegend: false,
        }

        var config = {
            responsive: true
        } //automatically resize when the browser window size changes

        Plotly.newPlot('resultPieChart', data, layout, config);
    }


    // [NUMBER OF PRINTS]
    getData_printNumber(); // draw chart based on defult (current) academic year

    $('#yearList_printNumber').change(function () {  // if user choose to view a different academic year
        getData_printNumber();   // draw a new chart based on selected year
        $(this).closest(".dropdown-menu").prev().dropdown("toggle");  // close dropdown after selection
    });

    function getData_printNumber() {
        var selectedYear = $('select[name=yearList_printNumber] option').filter(':selected').val();   // get selected year

        $.ajax({
            url: "statistics_fetch.php",
            method: "POST",
            dataType: "json",
            data: { yearList_printNumber: selectedYear },
            success: function (data) {
                draw_printNumber(data);
            },
            error: function (xhr, thrownError) {
                alert(xhr.status);  // 200
                alert(thrownError);
            }
        });
    }

    function draw_printNumber(data) {

        var dataArray = []; // create an array to store data for drawing this chart

        for (var i = 0; i < data.length; i++) {  // loop through all json objects in the array 
            var object = data[i];       // get each object
            var yValue = object.totalPrints.split(", ");  // convert totalPrints from stirng to array
            dataArray.push({  // store each trace in the data array
                x: months,
                y: yValue,
                name: object.printerName,
                type: 'bar'
            });
        }

        var academicYear = $('select[name=yearList_printNumber] option').filter(':selected').text();

        var layout = {
            showlegend: true,
            barmode: 'stack',
            title: 'Total Number of Prints by Printer for' + academicYear,
            //set colors for each printer block
            colorway: ['#f3cec9', '#e7a4b6', '#cd7eaf', '#a262a9', '#6f4d96', '#3d3b72', '#182844', '#24478f', '#4169E1','#1E90FF', '#87CEFA','#ADD8E6']
        };

        var config = {
            responsive: true
        }
        Plotly.newPlot('numOfPrintsChart', dataArray, layout, config);
    }

});