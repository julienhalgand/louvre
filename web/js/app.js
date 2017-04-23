$(document).foundation();

$(function() {
    var dateNow = new Date(),
        lang = $('html').attr("lang");
    if (typeof holidays != "undefined") {
        $('#bill_step1_date_of_booking').fdatepicker({
            language: lang,
            initialDate: dateNow,
            startDate: dateNow,
            endDate: new Date(dateNow.getFullYear() + 1, dateNow.getMonth(), dateNow.getDate()),
            daysOfWeekDisabled: [0, 2],
            datesDisabled: holidays,
            disableDblClickSelection: true,
            leftArrow: '<<',
            rightArrow: '>>',
            closeIcon: 'X',
            closeButton: true
        });
    }
});