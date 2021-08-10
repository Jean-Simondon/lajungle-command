<?php

namespace YOUR_THEME_NAME\Helpers;

class MediaHelper
{

    public static function displaySvg($elt)
    {
        $svg = themosis_path('sub-theme') . 'resources/assets/images/svg/' . $elt . '.svg';
        $retour = '';
        if (file_exists($svg)) {
            $retour = file_get_contents($svg);
        } else {
            $retour = '';
        }
        return $retour;
    }

    // Ne marche que pour les images ayant un tableau comme retour
    public static function customSize($img, $sizename)
    {
      $img = wp_get_attachment_image_src($img['id'], $sizename);
      return $img[0];
    }

    public static function getLogo() {
        if(file_exists(get_stylesheet_directory() . 'resources/assets/images/logo/Sigle_QUADDRI.png')){
            return get_stylesheet_directory() . 'resources/assets/images/logo/logo_QUADDRI.png';
        } else {
            return false;
        }
    }

    public static function noImage() {
        if(file_exists( get_stylesheet_directory() . 'resources/assets/images/Sigle_QUADDRI.png')){
            return get_stylesheet_directory() . '/images/Sigle_QUADDRI.png';
        };
    }

    /**
     * Teste l'existence (réelle) d'une image
     */
    public static function imageExists($field, $size, $test = false)
    {
        if ($size === 'full') {
            return isset($field['url']);
        }
        $retour = isset($field) && is_array($field) && isset($field['sizes'], $field['sizes'][$size]);
        if($retour && $test){
            $url = home_url('content/uploads/');
            $path = dirname(themosis_path('theme'),2).'/uploads/';
            $retour = file_exists(str_replace($url, $path, $field['sizes'][$size]));
        }
        return $retour;
    }

    /**
     * Retourne l'image dans la taille souhaitée
     */
    public static function getImage($img, $size)
    {
        if ($size === 'full') {
            return $img['url'];
        }
        return $img['sizes'][$size];
    }

    public static function youtubeLink($url, $onlyId = false)
    {
        if(stripos($url, 'embed')){ // cas 1 : lien embed
            if($onlyId) {
                $return = substr($url, strrpos($url, 'embed/')+6); // retirer le html avant
                $return = substr($return, 0, strpos($return, '?')); // retirer le html après
            }
            else {
                $return = $url;
            }
        }else{
            if(strlen($url) < 18){ // cas 4 ID
                $id = $url;
            }else{
                if(stripos($url, 'watch')){ // cas 2 : lien watch
                    $exp = explode('v=', $url);
                }else{ // cas 3 : lien shorten
                    $exp = explode('/', $url);
                }
                $id = end($exp);
            }
            if($onlyId) {
                return $id;
            }
            //$return = 'https://www.youtube-nocookie.com/watch?v='.$id; // en 404 depuis juin
            $return = 'https://www.youtube-nocookie.com/embed/'.$id.'?rel=0';
            //$return = 'https://www.youtube.com/embed/'.$id.'?rel=0';
        }
        return $return;
    }

    /**
     * Afin de placer la vignette youtube avant qu'une vidéo ne démarre et que l'on a pas de vignette renseigné
     */
    public static function getYoutubeVignette($url)
    {
        $concat = MediaHelper::youtubeLink($url, true);
        if(stripos($concat, '?')) { // si ça vient d'une url avec des reste après l'id, comme un embed
            $concat = substr($concat, 0, stripos($concat, '?'));
        }
        return 'https://img.youtube.com/vi/' . $concat . '/0.jpg';
    }

}
