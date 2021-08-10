<?php

namespace YOUR_THEME_NAME\Helpers;

class LangHelper
{

    public static function links()
    {
        $retour = '';
        if(function_exists('pll_the_languages')) {
            $translations = pll_the_languages(['raw' => 1]);
            $output = [];
            if (isset($translations) && is_array($translations) && count($translations) > 0) {
                foreach($translations as $key => $translation) {
                    $attributes = '';
                    if ($translation['current_lang'] === true) {
                        $attributes = ' class="is-active"';
                    }
                    $output[] =  <<<HTML
                        <a href="{$translation['url']}"{$attributes}>{$key}</a>
HTML;

                    // if ($translation['current_lang'] === true) {
                    //     $output[] = '<span class="lang-switcher active js-ajax-ignore">'.$key.'</span>';
                    // }else{
                    //     $output[] = '<a href="'.$translation['url'].'" class="lang-switcher js-ajax-ignore">'.$key.'</a>';
                    // }
                    
                }
                // $retour = implode('', $output);
            }
            // return $retour;
            return implode('', $output);
        }
    }

    public static function euro($value)
    {
        if (pll_current_language() == 'en') {
            return '<em>€</em>'.$value;
        }
        else {
            return $value.'<em>€</em>';
        }
    }

    public static function getHomeUrl()
    {
        if(function_exists('pll_home_url')){
            return esc_url(pll_home_url());
        }else{
            return esc_url(home_url('/'));
        }
    }

    /**
     * Les Options ACF ne sont pas traduisible, extrait donc le champs dans la bonne langue
     * Nommenclature : en version EN, on a un suffixe _en
     */
    public static function getAcfOption($fieldName)
    {
        $retour = '';
        if(pll_current_language('slug') == 'en'){
            $fieldName .= '_en';
        }
        return get_field($fieldName, 'options');
    }

}