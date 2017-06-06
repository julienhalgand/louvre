$(document).foundation();

var $collectionHolder;

// setup an "add a ticket" link
var $addticketLink = $('<a href="#" class="add_ticket_link">Add a ticket</a>');
var $newLinkLi = $('<li></li>').append($addticketLink);

$(function() {
    var dateNowWithTime = new Date(),
        dateNow = new Date(dateNowWithTime.getFullYear(),dateNowWithTime.getMonth(),dateNowWithTime.getDate(),0,0,0),
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
        for (i = 0; i < $tickets.length; i++) {
            $($tickets[i]).fdatepicker({
                language: lang,
                format: 'dd/mm/yyyy',
                startDate: "01-01-1900",
                endDate: dateNow,
                disableDblClickSelection: true,
                leftArrow: '<<',
                rightArrow: '>>',
                closeIcon: 'X',
                closeButton: true
            });
        }
    //Reduced price
    var $checkbox = $('[id*="_reduced_price"]');
    $checkbox.click(function (e) {
      var key = e.target.attributes.getNamedItem('data-selector').nodeValue;
      if($("#identityCallout"+key).css('display') == 'none'){
          $("#identityCallout"+key).show();
      }else{
          $("#identityCallout"+key).hide();
      }
    })
    $('#scrollTop').on('click', function() {
        e.preventDefault();
    });
        if ($.cookie('cookieWarning') === undefined) {
            $('body').append('<div id="cookieWarningRow"><div class="panel" id="cookieWarning">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de Cookies pour réaliser des statistiques de visites anonymes. <a id="cookieWarningLink" target="_blank" href="http://www.google.com/intl/fr/policies/technologies/cookies/" rel="noindex">En savoir +</a> <button id="cookieConfirm" class="button">Ok</button></div></div>');
            $('#cookieWarning').css({
                'width': '100%',
                'position': 'fixed',
                'margin-left': 'auto',
                'margin-right': 'auto',
                'text-align': 'center',
                'bottom': '0',
                'padding': '20px',
                'background': '#222',
                'color': 'white',
                //'border-radius'      	: '40px',
                'opacity': '0.9',
                'z-index': '5'
            });
            $('#cookieWarningLink').css({
                'color': '#c82d00'
            });
        }

        $('#cookieConfirm').click(function(e) {
            e.preventDefault();
            $.cookie('cookieWarning', 'viewed', { expires: 30 * 12 });
            $('#cookieWarningRow').hide();
        });
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