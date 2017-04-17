$(document).foundation();

$(function() {
    var dateNow = new Date();
    $('#dp1').fdatepicker({
        language: 'fr',
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
});