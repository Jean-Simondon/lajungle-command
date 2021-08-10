<?php

namespace YOUR_THEME_NAME\Helpers;

class PostHelper
{

    // utiliser $format = '&paged=%#%' en cas de pagination sur page search pour concaténer après le "?s=search_word"
    public static function getPagination($args, $format = '?paged=%#%')
	{

		$params = [
			'base'            => get_pagenum_link(1).'%_%',
			'format'          => $format,
			'total'           => 0,
			'current'         => 1,
			'show_all'        => false,
			'prev_next'       => true,
			'prev_text'       => __('Précédent'),
			'next_text'       => __('Suivant'),
			'type'            => 'plain',
			'add_args'        => false,
			'add_fragment'    => ''
		];

		$params = wp_parse_args($args, $params);
        return paginate_links($params);
	}

    public static function getCurrentUrl()
    {
        global $wp;
        return home_url($wp->request);
    }

    /**
     * D'un champ du post, on en fait un extrait en attribut de l'objet
     */
    public static function fillPostExcerpt($cpts, $field = "wysiwyg", $nbCaracter = 238)
    {
        foreach($cpts as $cpt) {
            // on prépare l'extrait à afficher de manière croppé;
            if( !empty( get_field($field, $cpt->ID ) )) {
                $cpt->extrait = get_field($field, $cpt->ID);
                $cpt->extrait = strip_tags( $cpt->extrait);
                $cpt->extrait = substr( $cpt->extrait, 0, $nbCaracter) . ' [...]';
            } else {
                $cpt->extrait = "";
            }
        }
    }

    /**
     * Ajoute le terme d'une taxo en attribut d'un post
     */
    public static function fillPostTaxo($cpts, $taxo)
    {
        foreach($cpts as $cpt) {
            if( is_object( get_the_terms($cpt->ID, $taxo)[0] ) ) {
                $cpt->taxo = get_the_terms($cpt->ID, $taxo)[0]->name;
            } else {
                $cpt->taxo = "";
            }
        }
    }

        /*
     * Requête permettant d'aller chercher les posts qui ont des tags en commun et les
     * tris par nombre de tags en commun et par la meta données score
     */
    public static function getRelatedPosts($post)
    {
		$container = \container();
        $actualiteSlug = $container[CptActualite::class]->getSlug();
        $evenementSlug = $container[CptEvenement::class]->getSlug();

		/**
		 * On récupère les tags du post principale
		 */
		$arrTags = [];
		if ($tags = get_the_tags($post->ID)) foreach ($tags as $tag) $arrTags[] = $tag->term_id;

		/**
		 * On récupère les posts qui ont au moins l'un de ces tag en commun
		 */
		$Allposts = get_posts([
			'numberposts'     => -1,
			'tag__in'         => $arrTags,
			'post__not_in'    => [ $post->ID ],
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'post_type'       => [ $actualiteSlug, $evenementSlug, 'page' ],
			'post_status'     => 'publish'
		]);

		/**
		 * Pour chacun de ces posts, on va compter combien de tag ils ont en commun avec le post initial, et leur attribuer un score
		 */
		 foreach($Allposts as $k => $postToScore) {
			$tmpTag = get_the_tags($postToScore->ID);
			$Allposts[$k]->score = 0;
			foreach($tmpTag as $t) {
				if( in_array($t->term_id, $arrTags)) {
					$Allposts[$k]->score++;
				}
			}
		 }

		 // On trie en fonction de ce nouvel attribut score
		 usort($Allposts, function($a, $b) {
			return $a->score < $b->score;
		 });

		 // on renvoi seulement les 3 premiers
        return array_slice($Allposts, 0, 3 );
	}

}