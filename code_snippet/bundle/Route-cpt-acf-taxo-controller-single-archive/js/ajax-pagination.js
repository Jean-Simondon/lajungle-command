var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {

    //===========================================================================
    //===========================================================================
    //      PAGINATION EN AJAX AVEC FILTRE
    //===========================================================================
    //===========================================================================

    /**
     * Si la page contient des filtres dont on veut voir le contenu s'actualisé à chaque fois que l'on change la valeur d'un sélect
     */
    if( $(".js-static-filter").length < 1 ) {

        // Changement de valeur du select de secteur
        if( $('.js-example-filter').length > 0) {
            $('.js-example-filter').on('change', function () {
                sendAjaxPagination("onChange");
            });
        }

    }

    /**
     * Bouton pour charger plus de post à la suite
     */
    if( $('.js-load-more-button').length > 0) {
        $('.js-load-more-button').on('click', function (event) {
            event.preventDefault();
            sendAjaxPagination("loadMore");
        });
    }

    /**
     * S'il y a un bouton pour valider les filtres et refresh le contenu de la page
     */
    if( $('.js-validator-filter').length > 0) {
        $('.js-validator-filter').on('click', function (event) {
            event.preventDefault();
            sendAjaxPagination("onValidate");
        });
    }

    /**
     * Désactive le refresh de la page au clic sur la pagination et place sur écoute les éléments afin de recharger le contenu en ajax
     */
     function ajaxOnPagination() {
		$('.js-pagination-container *').each(function(index, element) {
			if($(element).hasClass('page-numbers') !== undefined && !$(element).hasClass('current')) {
				$(element).click(function(event) {
					event.preventDefault();
					var current = $('.js-pagination-container .current')[0].innerHTML * 1;
					var target = element.innerHTML;
					if( $(element).hasClass('next') ) {
						target = current * 1 + 1;
					} else if ( $(element).hasClass('prev') ) {
						target = current * 1 - 1;
					} else {
						target = target * 1;
					}
					sendAjaxPagination("onPagination", target);
				})
			}
		});
    }
    if( $('.js-pagination-container').length > 0) {
        ajaxOnPagination();
    }

    /**
     * Si on recherche en fonction de mots-clefs seulement, on branche l'écoute sur l'input texte
     */
    if( $(".js-validator-keyword").length > 0 ) {
        $(".js-validator-keyword").click(function (event) {
            // Ne fonctionne que si le champ n'est pas vide
            if ( $('.js-keyword-filter').val().length > 0 ) { 
                // on reset les filtres
                $(".js-example-filter").prop("selectedIndex", 0);
                // puis requête ajax sur le nom
                sendAjaxPagination("onSearchByKeyword");
            }
        });
    }

    /**
     * S'il y a un bouton pour effacer le contenu des filtres
     */
    if( $('.js-reset-filter').length > 0 ) {
        $('.js-reset-filter').on('click', function() {
            $(".js-example-filter").prop("selectedIndex", 0);
            $(".js-keyword-filter").val("");
            sendAjaxPagination("onReset");
        })
    }

    /** 
     * Constuire un filtre avec les données présente sur la page
     */
    function getFilterValue(action, targetPagination = undefined) {
        // le type d'action, qui veut que l'on reparte de 0 ou que l'on ajoute à la suite
        let offset;
        if( action == "OnChange" || action == "onSearchByKeyword" || action == "onReset" || action == "onValidate" || action == "onPagination" ) {
            offset = 0;
        } else if( action == "onLoadMore") {
            offset =  1 * $('.js-ajax-anchor').data("offset");
        }
        // Dans le filtre, on récupère le nombre de post actuellement affiché, le pays, le secteur sélectionné
        var filter = {
            "ppp": $(".js-ajax-anchor").data("ppp"),
            "offset": offset,
            // "example": $('.js-example-filter-item.active').data("example"), // si inté nécessite champ select custom plus tard
            "example": $('.js-example-filter').val(),
            "keyword": $('.js-keyword-filter').val(),
            "action": action,
        }

        if( action == "onPagination" && targetPagination !== undefined) {
            filter.targetPagination = targetPagination;
        }

        return filter;
    }

    /**
     * On envoi le filtrage par tag et pagination
     */
    function sendAjaxPagination(action, targetPagination = undefined) {
        var data = {
            filter: getFilterValue(action, targetPagination), // la fonction getFilterValue va construire tout le filtre de valeur
            action: $('.js-ajax-anchor').data("action"), // vise le controller AjaxListeController
            method: $('.js-ajax-anchor').data("method"), // vise la fonction getAnnuaireAction
        }
        $.ajax({
                url: my_theme_name.ajaxurl,
                dataType: 'json',
                data: data,
            })
            .done(function (data) {

                if (action == "onLoadMore") { // si on veut simplement les posts suivant avec le même filtre

                    $('.js-list-container')[0].innerHTML += data.html; // on injecte le contenu à la fin

                    // on met data-offset au nombre de post que l'on a récupéré + le nombre précédent
                    var offset = $('.js-ajax-anchor').data("offset");
                    $('.js-ajax-anchor').data("offset", 1 * ( offset + (1 * data.size) )); 

                    // Si jamais on a récupéré moins de post que ppp, alors on cache le bouton load More
                    if (data.size < $(".js-ajax-anchor").data("ppp")) { 
                        $('.js-load-more-button').fadeOut();
                    }

                } else if (action == "onChange" || action == "onValidate" || action == "onReset" || action == "onPagination" || action == "onSearchByKeyword" ) { // si on change le filtre ou la méhode de recherche

                    if (data.size < $(".js-ajax-anchor").data("ppp")) {
                        // Si jamais on a récupéré moins de post, alors on cache le bouton load More
                        $('.js-load-more-button').fadeOut();
                    } else {
                        // On fait réapparaitre le bouton si jamais il était caché
                        $('.js-load-more-button').fadeIn();
                    }

                    // on remplace tout par les x nouveaux
                    $('.js-list-container')[0].innerHTML = data.html;
                    // on remplace toutes les nouvelles popin par les x nouveaux
                    
                    if( data.htmlPopin !== undefined) {
                        $('.js-popin-container')[0].innerHTML = data.htmlPopin;
                    }
                    // on met data-offset au nombre de post que l'on a récupéré
                    $('.js-ajax-anchor').data("offset", 1 * data.size);

                    if( data.pagination !== undefined ) {
                        $(".js-pagination-container")[0].innerHTML = data.pagination;
                        ajaxOnPagination();
                    }

                }

            });
    }

});