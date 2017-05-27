function cookieAdvisor() {
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
}
