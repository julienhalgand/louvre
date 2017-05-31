$(document).foundation();

var $collectionHolder;

// setup an "add a ticket" link
var $addticketLink = $('<a href="#" class="add_ticket_link">Add a ticket</a>');
var $newLinkLi = $('<li></li>').append($addticketLink);

$(function() {
    var dateNow = new Date(),
        lang = $('html').attr("lang");
    //Date picker date of booking
    if (typeof holidays != "undefined") {
        $('#bill_step1_date_of_booking').fdatepicker({
            language: lang,
            format: 'dd/mm/yyyy',
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
    //Date picker date of birth
    var $tickets = $('[id*="_date_of_birth"]');
    console.log($tickets.length);
        for (i = 0; i < $tickets.length; i++) {
            $($tickets[i]).fdatepicker({
                language: lang,
                format: 'dd/mm/yyyy',
                startDate: "1900-01-01",
                endDate: dateNow,
                disableDblClickSelection: true,
                leftArrow: '<<',
                rightArrow: '>>',
                closeIcon: 'X',
                closeButton: true
            });
        }
    $('#scrollTop').on('click', function() {
        e.preventDefault();
    });
    cookieAdvisor();
    /*
    var $collectionHolder;

    // setup an "add a ticket" link
    var $newLinkLi = $('<a href="#" class="button" id="addTicket" ">Add a ticket</a>');

    // Get the ul that holds the collection of tickets
    $collectionHolder = $('#bill_step2_tickets');

    // add the "add a ticket" anchor and li to the tickets ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('#addTicket').on('click', function(e) {
        e.preventDefault();
        addticketForm($collectionHolder, $newLinkLi);
    });

    function addticketForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a ticket" link li
        var $newFormLi = $('#addTicket').append(newForm);
        $newLinkLi.before($newFormLi);
    }*/
});