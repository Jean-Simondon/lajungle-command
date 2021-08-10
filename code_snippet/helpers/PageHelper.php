<?php

namespace YOUR_THEME_NAME\Helpers;

class PageHelper
{

    public static function getSitePages()
    {
        $dashboard = get_home_url();
        $lostPassword = get_home_url();
        $register = get_home_url();
        $login = get_home_url();
        $infosPersos = get_home_url();
        $contact = get_home_url();
        $sdc = get_home_url();
        
        $pages = get_pages();
        if (is_array($pages) && count($pages) > 0) {
            foreach($pages as $page){     
                if (get_page_template_slug($page->ID) == 'login') {
                    $login = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'dashboard') {
                    $dashboard = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'infos_personnelles') {
                    $infosPersos = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'password') {
                    $lostPassword = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'register') {
                    $register = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'contact') {
                    $contact = get_permalink($page->ID);
                }
                if (get_page_template_slug($page->ID) == 'sdc') {
                    $sdc = get_permalink($page->ID);
                }
            }
        }

        $pages = [
            'login' => $login,
            'dashboard' => $dashboard,
            'infosPersos' => $infosPersos,
            'lostPassword' => $lostPassword,
            'register' => $register,
            'contact' => $contact,
            'sdc' => $sdc
        ];
        
        return $pages;
    }

}