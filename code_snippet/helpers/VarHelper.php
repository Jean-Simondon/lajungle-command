<?php

namespace YOUR_THEME_NAME\Helpers;

class VarHelper
{

    /**
     * $array est un tableau non vide
     */
    public static function goodArray($array)
    {
        if ( !empty($array) && is_array($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }

    /**
     * $key est une clef existante du tableau $array
     */
    public static function goodKey($array, $key)
    {
        if( VarHelper::goodArray($array) ) {
            if( !empty($array[$key]) ) {
                return $array[$key];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Vérifie que toutes les clefs passsé dans $keys sont présente dans le tableau $array
     */
    public static function goodKeys($array, $keys)
    {
        if( VarHelper::goodArray($array)) {
            if( isset($keys) ) {
                foreach($keys as $key) {
                    if( !isset($array[$key])) {
                        return false; // une $key est !isset()
                    }
                }
                return true; // toutes les $key sont isset()
            } else {
                return false; // $keys est null
            }
        }
    }

    /**
     * Vérifie si l'image existe, et si non, appel un placeholder
     * Si pas de placeholder non plus, alors la balise est en display:none;
     * 
     *   <img {!! VarHelper::goodThumbnail( get_the_ID(), "full") !!}>
     */
    public static function goodImage($picture, $size)
    {
        if( MediaHelper::ImageExists($picture, $size)) {
            return ' src="' . MediaHelper::getImage($picture, $size) . '" ';
        } else {
            if( file_exists( themosis_path('sub-theme') . 'resources/assets/images/placeholder.png') ) {
                return ' src="' . iquitheme_assets() . '/images/placeholder.png" alt="placeholder" ';
            } else {
                return ' style="display:none"; src="" alt="no-image" ';
            }
        }
    }

    /**
     * Vérifie si l'image mis en avant existe, et si non, appel un placeholder,
     * si pas de placeholder non plus, alors la balise est en display:none;
     * 
     * @if( $picture = VarHelper::goodKey( ) )
     *      <img style="height:200px;" {!! VarHelper::goodImage( $picture, "full" ) !!}>
     * @endif
     */
    public static function goodThumbnail($post_id, $size)
    {
        if( has_post_thumbnail( $post_id, $size) ) {
            return ' src="' . get_the_post_thumbnail_url( $post_id, $size ) . '" ';
        } else {
            if( file_exists( themosis_path('sub-theme') . 'resources/assets/images/placeholder.png') ) {
                return ' src="' . iquitheme_assets() . '/images/placeholder.png" alt="placeholder" ';
            } else {
                return ' style="display:none"; src="" alt="no-image" ';
            }
        }
    }

}