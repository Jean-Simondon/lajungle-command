var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {

    //===========================================================================
    //===========================================================================
    //      ICONE DE PARTAGE RESEAUX SOCIAUX
    //===========================================================================
    //===========================================================================

    var sharingTools = $('#js-sharing_tools');

    if (sharingTools.length) {

        var icones = $('.js-section-share').data('iconePartage');
        icones += "";
        var shares = icones.split('-');

        // Customisation de l'objet email, et notamment de son contenu
        for(var key in shares) {
            if( shares[key] === "email") {
                const texte = window.location.href;
                shares[key] = {
                    share: "email",
                    url: $("#js-email-content").data("emailContent"),
                    showLabel: false,
                    showCount: false,
                };
            }
        }

        sharingTools.jsSocials({
            showLabel: false,
            showCount: false,
            shareIn: "popup",
            shares: shares,
        });

    }

});