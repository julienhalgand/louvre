$(document).foundation();

$(function() {
    var dateNow = new Date(),
        lang = $('html').attr("lang");
    $('#form_date_of_booking').fdatepicker({
        language: lang,
        initialDate: dateNow,
        startDate: dateNow,
        daysOfWeekDisabled: [0, 2],
        datesDisabled: ["2017-04-16"],
        disableDblClickSelection: true,
        leftArrow: '<<',
        rightArrow: '>>',
        closeIcon: 'X',
        closeButton: true
    });
    var dateOfBooking = new Date($('#form_date_of_booking').attr('value'));
    console.log(dateOfBooking);
    //Disable half journey if dateNow > 14h
    if (dateNow.getHours() < 14) {

        console.log(dateNow.getHours())
    }
});