<?php

namespace YOUR_THEME_NAME\Helpers;

use WPSEO_Breadcrumbs;

class BreadcrumbHelper
{
    public static function breadcrumb()
    {
        if (function_exists('yoast_breadcrumb')) {
            $links = collect(WPSEO_Breadcrumbs::get_instance()->get_links())->keyBy('url')->map->text->toArray();
            return self::create($links);
        }
    }

    public static function create(array $path)
    {
        $content = '';
        $i = 0;
        foreach ($path as $url => $name) {
            $name = $name == 'Home' ? 'Accueil' : $name; // on veut afficher Accueil et non pas Home
            if(strlen($name) > 15) {
                $name = substr($name, 0, 15) . '...';
            }            
            $content .= self::createItem($url, $name, $i++);
        }
        return '<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
          ' . $content . '
		</ol>';
    }

    /**
     * @param $url
     * @param string|\WP_Post $name
     * @param int $position
     * @return string
     */
    public static function createItem($url, $name, int $position)
    {
        if ($name instanceof  \WP_Post) {
            $url = get_permalink($name);
            $name = $name->post_title;
        }
        // $icon = IconHelper::get('right');
        $name = strip_tags($name);
        return <<<HTML
            <li itemprop="itemListElement" itemscope
                itemtype="https://schema.org/ListItem">
                <a itemtype="https://schema.org/Thing"
                   itemprop="item" href="{$url}">
                    <span itemprop="name">
                      {$name}
                    </span>
                </a>
                <meta itemprop="position" content="{$position}" />
            </li>
HTML;
    }
}
