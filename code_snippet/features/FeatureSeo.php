<?php
namespace YOUR_THEME_NAME\Features;

use Iquitheme\Core\Features\FeatureManager;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class FeatureSeo extends FeatureManager
{
    protected function _initHooks()
	{
        //add_filter('init', [$this, 'redirectLocaleBrowser'], 10, 1);
        add_filter('wpseo_breadcrumb_links', [$this, 'yoastLinks'], 10, 1);
        add_filter('wpseo_metadesc', [$this, 'yoastMetaDesc'], 10, 1);
    }

    public function redirectLocaleBrowser()
    {
        if((new CrawlerDetect())->isCrawler()){
            return;
        }

        if (isset($_COOKIE['_wp_first_time']) || is_user_logged_in()) {
            return;
        }
        $domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
        setcookie('_wp_first_time', '1', time() + 86400, '/', $domain);
        $link = null;
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && defined('ICL_LANGUAGE_CODE')){
            $locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if($locale != ICL_LANGUAGE_CODE){
                if($locale == 'en'){
                    $tr = 'fr';
                }elseif($locale == 'fr'){
                    $tr = 'en';
                }
                $url = get_the_permalink();
                $url2 = get_the_permalink(get_the_ID());
                if($url != false){
                    $link = apply_filters( 'wpml_permalink', $url ,$locale );
                }elseif(isset($_SERVER['REQUEST_URI']) && in_array($_SERVER['REQUEST_URI'], ['/', '/'.$tr.'/'])){
                    $link = str_replace('/'.$tr.'/', '/'.$locale.'/', home_url());
                }else{
                    $id = intval(url_to_postid($_SERVER['REQUEST_URI'] ));
                    if($id > 0){
                        $link = apply_filters( 'wpml_permalink', get_the_permalink($id) , $locale);
                    }
                }
            }
            if(!is_null($link)){
                wp_redirect($link);
                exit;
            }
        }
    }

    public function yoastLinks($links)
    {
        if(is_array($links) && count($links)>0){
            foreach($links as $k => $link){
                if(isset($link['ptarchive'])){
                    if (defined( 'ICL_LANGUAGE_CODE' )) {
                        if($link['ptarchive'] == 'essentiels'){
                            if( ICL_LANGUAGE_CODE=='en'){
                                $links[$k]['text'] = 'Essentials';
                            }elseif( ICL_LANGUAGE_CODE=='de'){
                                $links[$k]['text'] = 'Wissenswertes';
                            }else{
                                $links[$k]['text'] = 'Essentiels';
                            }
                            unset($links[$k]['ptarchive']);
                        } elseif($link['ptarchive'] == 'glossaire'){
                            if( ICL_LANGUAGE_CODE=='en'){
                                $links[$k]['text'] = 'Glossary';
                            }elseif( ICL_LANGUAGE_CODE=='de'){
                                $links[$k]['text'] = 'Glossar';
                            }else{
                                $links[$k]['text'] = 'Glossaire';
                            }
                            unset($links[$k]['ptarchive']);
                        }else{
                            $links[$k]['ptarchive'] = __($link['ptarchive'], THEME_TEXTDOMAIN);
                        }
                    }
                }
            }
        }
        return $links;
    }

    public function yoastMetaDesc($vars)
    {
        $len = 230;
        $displayBloc =  get_field('afficher_le_bloc');
        if(is_single()){
            if(strlen($vars) == 0 && get_field('introduction')){
                $vars = substr(get_field('introduction'), 0, $len);
            }
            elseif(strlen($vars) == 0 && get_field('texte_introduction')){
                $vars = substr(get_field('texte_introduction'), 0, $len);
            }
//        }elseif (isset($displayBloc) && $displayBloc == true ){
//            if(strlen($vars) == 0 && get_field('texte_introduction')){
//                $vars = substr(get_field('texte_introduction'), 0, $len);
//            }
        }else{
            $obj = get_queried_object();
            if(is_object($obj) && isset($obj->term_id)){
                $term_id        = $obj->term_id;
                if(strlen($vars) == 0 && get_field('texte_introduction', "category_$term_id")){
                    $vars = substr(get_field('texte_introduction', "category_$term_id"), 0, $len);
                }
            }
        }
        return $vars;
    }
}
