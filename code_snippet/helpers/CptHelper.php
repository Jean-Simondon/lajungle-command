<?php
namespace YOUR_THEME_NAME\Helpers;

use YOUR_THEME_NAME\Features\cpt\CptActus;

class CptHelper
{

    public static function recursiveFind(array $haystack, $needle, $contains = false)
    {
        $iterator  = new \RecursiveArrayIterator($haystack);
        $recursive = new \RecursiveIteratorIterator(
            $iterator,
            \RecursiveIteratorIterator::SELF_FIRST
        );
        if (isset($recursive)) {
            foreach ($recursive as $key => $value) {
                if ($contains) {
                    if (str_contains($key, $needle) && !is_array($value)) {
                        return $value;
                    }
                } else {
                    if ($key === $needle) {
                        return $value;
                    }
                }
            }
        }
    }

	public static function getResults($cptClass, $number = -1, $order = 'DESC', $query = [])
    {
        $container = \container();
        $cptSlug = $container[$cptClass]->getSlug();

        if (count($query) > 0) {
            $args = $query;
        }
        
        $args['post_type'] = $cptSlug;
        $args['numberposts'] = $number;
        $args['orderBy'] = 'date';
        $args['order'] = $order;
        $args['post_type'] = $cptSlug;

        $cpts = get_posts($args);

        $args['numberposts'] = -1;

        $allCpts = get_posts($args);
        
        return [
            'cpts' => $cpts,
            'allCpts' => $allCpts,
        ];
    }

    public static function getPagedResults($cptClass, $query, $show_on = '', $metaQuery = [], $numberPosts = 6, $urlPagination = '', $isEvent = '')
    {
        $args = [];
        $container = \container();
        $cptSlug = $container[$cptClass]->getSlug();

        // if ($urlPagination == '') {
        //     $urlPagination = get_home_url() . "/$cptSlug/";
        // }        

        $args['post_type'] = $cptSlug;
        $args['numberposts'] = -1;

        $allCpts = get_posts($args);

        if (count($query) > 0) {
            $args = $query;
        }

        $args['meta_query'] = [
            'relation' => 'AND'
        ];

        if ($show_on != '') {
            $args['meta_query'] = array_merge($metaQuery, [
                [
                    'key' => 'show_on',
                    'value' => $show_on,
                    'compare' => 'LIKE'
                ]
            ]);
        }

        if ($cptSlug == \container()[CptActus::class]->getSlug()) {
            if ($isEvent == '') {
                $args['meta_query'] = array_merge($metaQuery, [
                    'relation' => 'OR',
                    [
                        'key' => 'actu_event',
                        'value' => $isEvent,
                        'compare' => 'LIKE'
                    ],
                    [
                        'key' => 'actu_event',
                        'value' => $isEvent,
                        'compare' => 'NOT EXISTS'
                    ],
                ]);
            } else {
                $args['meta_query'] = array_merge($metaQuery, [
                    [
                        'key' => 'actu_event',
                        'value' => $isEvent,
                        'compare' => 'LIKE'
                    ]
                ]);
            }            
        }

        // echo '<pre>';var_dump($args);echo '</pre>';die();
        $allCptsFilters = get_posts($args);
        
        if (isset($args['meta_query'])) {
            $baseMetaQuery = $args['meta_query'];
        }

        if (count($query) > 0) {
            $args = $query;
            
            if ($cptSlug == \container()[CptActus::class]->getSlug()) {
                if ($isEvent == '') {
                    $args['meta_query'] = array_merge($metaQuery, [
                        'relation' => 'OR',
                        [
                            'key' => 'actu_event',
                            'value' => $isEvent,
                            'compare' => 'LIKE'
                        ],
                        [
                            'key' => 'actu_event',
                            'value' => $isEvent,
                            'compare' => 'NOT EXISTS'
                        ],
                    ]);
                } else {
                    $args['meta_query'] = array_merge($metaQuery, [
                        [
                            'key' => 'actu_event',
                            'value' => $isEvent,
                            'compare' => 'LIKE'
                        ]
                    ]);
                }            
            }
        }

        if (isset($query['paged'])) {
            set_query_var('paged', (int) $query['paged']);
        }

        $pageNumber = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $pageOffset = ($pageNumber - 1) * $numberPosts;

        $args['numberposts'] = $numberPosts;
        $args['paged'] = $pageNumber;
        $args['offset'] = $pageOffset;
        $args['posts_per_page'] = $numberPosts;
        $args['orderby'] = 'date';

        if (isset($baseMetaQuery)) {
            $args['meta_query'] = $baseMetaQuery;
        }

        $cpts = get_posts($args);

        $numberPages = ceil(count($allCptsFilters) / $numberPosts);
        $paginationLinks = [];

        for ($i = 1; $i <= $numberPages; $i++) {
            $paginationLinks[] = $i;
        }

        return [
            'cpts' => $cpts,
            'allCpts' => $allCpts,
            'allCptsFilters' => $allCptsFilters,
            'urlPagination' => $urlPagination,
            'pagination' => $paginationLinks,
            'currentPage' => $pageNumber
        ];
    }

}
