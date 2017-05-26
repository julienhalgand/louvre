function cookieAdvisor() {
    if ($.cookie('cookieWarning') === undefined) {
        $('body').append('<div class="cookieWarningRow"><div class="panel cookieWarning" id="cookie">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de Cookies pour réaliser des statistiques de visites anonymes. <a class="cookiewarning" target="_blank" href="http://www.google.com/intl/fr/policies/technologies/cookies/" rel="noindex">En savoir +</a> <button class="tiny radius button">Ok</button></div></div>');
        $('div.cookieWarning').css({
            'width': '100%',
            'position': 'fixed',
            'margin-left': 'auto',
            'margin-right': 'auto',
            'text-align': 'center',
            'bottom': '0',
            'padding': '20px',
            'background': '#3fb6e3',
            'color': 'black',
            //'border-radius'      	: '40px',
            'opacity': '0.9',
            'z-index': '5'
        });
        $('a.cookiewarning').css({
            'color': 'white'
        });
    }

    $('button.cookieButton').click(function(e) {
        e.preventDefault();
        $.cookie('cookieWarning', 'viewed', { expires: 30 * 12 });
        $('div.cookieWarningRow').hide();
    });
}
