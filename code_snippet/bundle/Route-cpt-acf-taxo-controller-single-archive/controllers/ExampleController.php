<?php

namespace YOUR_THEME_NAME\Controllers;

use Iquitheme\Core\Controllers\BaseClassicalPagecontroller;
use YOUR_THEME_NAME\Features\cpt\CptExample;
// use YOUR_THEME_NAME\Helpers\PostHelper;
// use YOUR_THEME_NAME\Features\taxo\TaxoExample;
// use YOUR_THEME_NAME\Helpers\VarHelper;
// use YOUR_THEME_NAME\Helpers\CptHelper;
use YOUR_THEME_NAME\Models\ExampleModel;

class ExampleController extends BaseClassicalPagecontroller
{

    public function single($post, $query)
    {
        $container = \container();
        $exampleSlug = $container[CptExample::class]->getSlug();
        // $taxoExampleSlug = $container[TaxoExample::class]->getSlug();

        // Données pour la zone de rebond
        // $examples = get_posts([
        //     'post_type' => $exampleSlug,
        //     'order' => 'desc',
        //     'exclude' => [ $post->ID ],
        //     'posts_per_page' => 3,
        //     'post' => 3,
        // ]);

        // ajout d'attribut supplémentaire
        // CptHelper::processExample($examples);
        // CptHelper::processExample( [ $posts ] );

        return View('pages.single.single-example', [
            'post' => $post,
            // 'examples' => $examples,
        ]);
    }

    public function archive($post, $query)
    {
        $container = \container();
        $exampleSlug = $container[CptExample::class]->getSlug();
        // $taxoExampleSlug = $container[TaxoExample::class]->getSlug();

        $paged = intval(get_query_var('paged'));
        if ($paged < 1) {
            $paged = 1;
        }

        $ppp = 8;

        // Fetch
        $examples = ( new ExampleModel() )->findAll([
            'post_type' => $exampleSlug,
            'order' => 'DESC',
            'numberposts' => $ppp,
            'posts_per_page' => $ppp,
            'paged' => $paged,
        ]);

        // ajout d'attribut supplémentaire
        // CptHelper::processExample($examples);

        // Récupération du filtre par taxo
        // $example_filter = get_terms($taxoExampleSlug);

        // Pagination
        // $pagination = PostHelper::getPagination([
        //     'total'           => ceil($examples->max_num_pages),
        //     'current'         => $paged,
        // ]);

        return View('pages.archive.archive-example', [
            'examples' => $examples->posts,
            // 'example_filter' => $example_filter,
            // 'pagination' => $pagination,
            'ppp' => $ppp,
        ]);
    }

}
