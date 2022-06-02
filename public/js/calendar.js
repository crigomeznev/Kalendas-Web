$(document).ready(function () {
    // Set selected calendar on html select
    let curcalendar = $("input[name='_curcalendar']").val()
    $("#switchCalendar").val(curcalendar);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Quan canviem la selecció, es llença esdeveniment AJAX
    $("#switchCalendar").change(function (ev) {
        // AJAX
        // let token = $('input[name="_token"]').val();
        $.ajax({
            url: 'https://www.kalendas.com/calendars/switch',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                'id': $(this).val(),
                // '_token': token
            },
            type: 'POST',
            success: function (response) {
                // recarreguem la pàgina
                window.location.replace("https://www.kalendas.com/calendars");
            },
            statusCode: {
                404: function (response) {
                    alert('web not found' + JSON.message);
                }
            },
            error: function (x, xs, xt) {
                // window.open(JSON.stringify(x));
                alert(JSON.message);
            }
        });
    });




    // Powerful-calendar
    function selectDate(date) {
        $('#calendar-wrapper').updateCalendarOptions({
            date: date
        });

        if (date!=='' && date!==undefined){
            changeDate(date);
        }
    }

    // Unselect date
    $("#unselectDate").click(function(ev){
        changeDate(null);
    })

    function changeDate(date)
    {
        // let date = calendar.getSelectedDate();
        // AJAX per canviar data actual i mostrar activitats d'aquella data
        let dateObj = null;
        if (date!==null)
            dateObj = new Date(date).toLocaleDateString("en-CA", { year: "numeric", month: "2-digit", day: "2-digit" });
        $.ajax({
            url: 'https://www.kalendas.com/calendars/date',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                // data en format yyyy-MM-dd
                'date': dateObj
            },
            type: 'POST',
            success: function (response) {
                // recarreguem la pàgina
                window.location.replace("https://www.kalendas.com/calendars");
            },
            statusCode: {
                404: function (response) {
                    alert('web not found' + JSON.message);
                }
            },
            error: function (x, xs, xt) {
                // window.open(JSON.stringify(x));
                alert(JSON.message);
            }
        });

    }


    // Calendar config

    var defaultConfig = {
        weekDayLength: 1,
        onClickDate: selectDate,
        showYearDropdown: true,
        startOnMonday: true,

        prevButton: 'Prev',
        nextButton: 'Next',
        enableMonthChange: true,
        enableYearView: true,
        showTodayButton: true,
        highlightSelectedWeekday: true,
        highlightSelectedWeek: true,
        todayButtonContent: 'Today',
        showYearDropdown: true
    };
    
    let selectedDate = $("input[name='_selectedDate']");
    if (selectedDate!==undefined && selectedDate.val().length!=0){
        defaultConfig["date"] = new Date(selectedDate.val());
    }

    // var calendar = $('#calendar-wrapper').calendar(defaultConfig);
    var calendar = $('.calendar-wrapper').calendar(defaultConfig);

});
