<?php

namespace YOUR_THEME_NAME\Controllers;

use Iquitheme\Core\Controllers\BaseClassicalPagecontroller;
use Iquitheme\Core\Controllers\BaseAjaxController;
use Themosis\Foundation\Request;

// use YOUR_THEME_NAME\Features\cpt\CptExample;
// use YOUR_THEME_NAME\Models\ExampleModel;
// use YOUR_THEME_NAME\Features\taxo\TaxoExample;
// use YOUR_THEME_NAME\Helpers\PostHelper;

class AjaxListeController extends BaseClassicalPagecontroller
{
    /**
     * Refresh de la liste de example de la page d'archive ressource
     */
    public function getExampleAction()
    {
        $container = \container();
        $exampleSlug = $container[CptExample::class]->getSlug();
        $taxoExampleSlug = $container[TaxoExample::class]->getSlug();

        $request = Request::createFromGlobals();
        $filter = $request->query->get('filter');

        $filter = $filter !== null ? $filter : [];
        $ppp = ( !empty($filter["ppp"]) && $filter["ppp"] > 0 ) ? $filter["ppp"] : 8;
        $action = !empty($filter["action"]) ? $filter["action"] : "";

        //===========================================================================
        //===========================================================================
        //      PARAMETRE GENERAL
        //===========================================================================
        //===========================================================================

        /**
         * Paramètre générale pour récupérer tous les annuaires
         */
        $params = [
            // 'post_type' => $exampleSlug,
            'order' => 'desc',
            'tax_query' => [],
            'posts_per_page' => $ppp,
            'numberposts' => $ppp
        ];

        //===========================================================================
        //===========================================================================
        //      FILTRAGE PAGINATION 1/2
        //===========================================================================
        //===========================================================================

        /**
         * Si on arrive du clic sur la pagination, ou bien que l'on précise le service dans le filtre
         * Alors on réduira à ppp post plus tard
         */
        if( $action == "onPagination" ) {
            $params['posts_per_page'] = -1;
            $params['numberposts'] = -1;
        }

        //===========================================================================
        //===========================================================================
        //      FILTRAGE
        //===========================================================================
        //===========================================================================

        /**
         * Si on recherche par nom d'entreprise seulement :
         */
        if( $action == "onSearchByKeyword" ) {

            $params['s'] = $filter['keyword'] ? $filter['keyword'] : "";
            $params['order'] = 'ASC'; 
            $params['orderby'] = 'title';

        } else if( in_array( $action, [ "onChange", "onLoadMore", "onValidate", "onReset", "onPagination" ] )) {

            $tax_query = [];
            /**
             * Si on filtre en fonction d'une taxo
             */
            if( !empty( $filter['example_1'] && $filter['example_1'] !== "all")) {
                $tax_query = [
                    'taxonomy' => $taxoExampleSlug,
                    'field' => 'slug',
                    'terms' => $filter['example_1'],
                ];
            }

            /**
             * Si on filtre en fonction d'une seconde taxo
             */
            if( !empty( $filter['example_2'] && $filter['example_2'] !== "all")) {
                $tax_query = [
                    'taxonomy' => $taxoExampleSlug,
                    'field' => 'slug',
                    'terms' => $filter['example_2'],
                ];
            }

            /**
             * On rassemble les tax_query en veillant à gérer les cas avec une seule tax_query ou avec plusieurs (ajout de "AND")
             */
            if( count($tax_query) == 1 ) {
                $params["tax_query"][] = $tax_query[0];
            } else if( count($tax_query) > 1 ) {
                $params["tax_query"]["relation"] = "AND"; // ou OR
                foreach($tax_query as $query) {
                    $params["tax_query"][] = $query;
                }
            }

            /**
             * Si on filtre en fonction d'une année particulière
             */ 
            if( !empty( $filter['year'] && $filter['year'] !== "all") ) {
                $params['date_query'] = [
                    'column' => 'post_date',
                    'before'  => ( 1 + (int)$filter['year']) . "-00-00",
                    'after' => $filter['year'] . "-00-00",
                ];
            }

            /**
             * Si on filtre avant ou après aujourd'hui
             */
            if( !empty( $filter['date'] && $filter['date'] !== "all") ) {
                $params["meta_key"] = 'date-debut';
                $params["meta_value"] = date('Ymd'). ' 00:00:00';
                if( $filter["date"] == "before") {
                    $params["meta_compare"] = "<";
                    $params["order"] = "desc";
                } elseif( $filter["date"] == "after" ) {
                    $params["meta_compare"] = ">=";
                    $params["order"] = "asc";
                }
            }
        }

        //===========================================================================
        //===========================================================================
        //    FILTRAGE POUR RECUPERER UNE QUANTITE SUPPLEMENTAIRE A AJOUTER A LA FIN
        //===========================================================================
        //===========================================================================

        /**
         * Si on arrive depuis le bouton LoadMore, alors on veut les ppp examples suivant avec le même filtre
         */
        if( $action == "loadMore" && !empty($filter['offset']) ) {
            $params['offset'] = (int)$filter["offset"];
        }

        //===========================================================================
        //===========================================================================
        //      FETCH
        //===========================================================================
        //===========================================================================

        /**
         * Fetch avec ces paramètres
         */
        $examples = ( new ExampleModel() )->findAll($params);

        //===========================================================================
        //===========================================================================
        //      FILTRAGE SUPPLEMENTAIRE
        //===========================================================================
        //===========================================================================

        /**
         * Filtrage supplémentaire sur des élément que l'on ne peut pas mettre dans les query wordpress
         */
        if( !empty($filter["specific_val"]) && $filter["specific_val"] !== "all" ) {
            $countUnset = 0;
            foreach($examples->posts as $k => $v) {
                $keep = false;
                $specific_vals = get_field("specific_val", $v->ID);
                if( is_array($specific_vals)) {
                    foreach($specific_vals as $specific_val) {
                        if( $specific_val['value'] == $filter["specific_val"] ) {
                            $keep = true;
                        }
                    }
                }
                if($keep == false) {
                    $countUnset++;
                    unset($examples->posts[$k]);
                }
            }
            // On actualite les donnée suivante pour servir à la construction de la pagination
            $examples->found_posts -= $countUnset;
            $examples->max_num_pages = ceil( $examples->found_posts / $ppp ); // le nombre total de page avec le filtre final
            if( $action == "onLoadMore") {
                $examples->posts = array_slice( $examples->posts, $filter["offset"], $ppp ); // la première page faite de ppp post                
            }
            $examples->posts = array_slice( $examples->posts, 0, $ppp ); // la première page faire de ppp post
        }

        //===========================================================================
        //===========================================================================
        //      PAGINATION 2/2
        //===========================================================================
        //===========================================================================

        /**
         * Si on arrive depuis la pagination
         */
        if( $action == "onPagination" && isset($filter["targetPagination"]) ) {

            $paged = $filter['targetPagination']; // le numéro de la page demandé
            $paged = $paged < 1 ? 1 : $paged; // pas de numéro négatif autorisé

            // Réduction à une page
            $examples->max_num_pages = ceil( $examples->found_posts / $ppp );
            $examples->posts = array_slice( $examples->posts, ( $ppp * ( $paged - 1) ), $ppp );

        } else {
            /**
             * Sinon, comme il faut quand même constuire la pagination, on fait comme si c'était la première page qui était demandée
             */
            $paged = 1;
        }

        $pagination = PostHelper::getPagination([
            'total'           => $examples->max_num_pages,
            'current'         => $paged,
        ]);

        //===========================================================================
        //===========================================================================
        //      AJOUT D'ATTRIBUT SUR LES EVENEMENT
        //===========================================================================
        //===========================================================================

        PostHelper::processExample( $examples->posts );

        //===========================================================================
        //===========================================================================
        //      TRANSFORMATION EN HTML
        //===========================================================================
        //===========================================================================

        // On injecte les perturbations dans leurs templates respectifs vu que l'on est en Ajax
        $html = "";
        $htmlPopin = "";
        $loopIndex = 0;
        foreach ($examples->posts as $example) {
            $html .= strval(view('elements.card-example', ['example' => $example, 'loopIndex' => $loopIndex ]));
            $htmlPopin .= strval(view('elements.popin-example', ['example' => $example, 'loopIndex' => $loopIndex ]));
            $loopIndex++;
        }

        //===========================================================================
        //===========================================================================
        //      ENVOI DE LA REPONSE
        //===========================================================================
        //===========================================================================        

       // Envoie de la réponse
        return wp_json_encode([
            'html' => $html,
            'htmlPopin' => $htmlPopin,
            'pagination' => $pagination,
            'size' => count($examples->posts),
        ]);
    }

}
