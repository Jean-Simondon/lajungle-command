<?php

namespace YOUR_THEME_NAME\Controllers;

use Iquitheme\Core\Controllers\BaseClassicalPagecontroller;
use YOUR_THEME_NAME\Helpers\PostHelper;
use \WP_Query;

class PageController extends BaseClassicalPagecontroller
{

    public function search($post, $query)
    {

        if (isset($query->query['s'])) {
            $research_word = $query->query['s'];
        } else {
            wp_safe_redirect(home_url('/'));
        }

        $paged = intval(get_query_var('paged'));
        if ($paged < 1) {
            $paged = 1;
        }

        $posts = $query->posts;

        foreach($posts as $post) {

            $post_type = get_post_type($post->ID);

            if( $post_type == "page") { // Pages

                if( get_post_meta( $post->ID, '_wp_page_template', true ) == "default" ) {
                    // PostHelper::fillPostExcerpt( [ $post ], "texte-mis-en-avant", 120);
                    // $post->post_type = "page de contenu";
                } else if( get_post_meta( $post->ID, '_wp_page_template', true ) == "marques" ) {
                    // $post->post_type = "page marque";
                    // aucun champ pour l'extrait de page marques
                } else if (get_post_meta( $post->ID , '_wp_page_template', true ) == "contact") {
                    // $post->post_type = "page de contact";
                    // PostHelper::fillPostExcerpt( [ $post ] , "texte-mis-en-avant", 120);
                } else if (get_post_meta($post->ID, '_wp_page_template', true ) == "carrefour") {
                    // $post->post_type = "page carrefour";
                    // PostHelper::fillPostExcerpt( [ $post ], "texte-mis-en-avant", 120);
                }

            }  // Custom post type
            
            else if( $post_type == "example" ) {
                // $post->post_type = "example";
                // PostHelper::fillPostExcerpt( [ $post ], "texte-mis-en-avant", 120);
            }

        }

        $pagination = PostHelper::getPagination([
            'total'           => ceil($query->max_num_pages),
            'current'         => $paged,
        ], '&paged=%#%');


        return view('pages.search', [
            'nb_result' => $query->found_posts,
            'posts' => $posts,
            'query' => $query,
            'pagination' => $pagination,
            'research_word' => $research_word,
        ]);
    }


}
