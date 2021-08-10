<?php

namespace YOUR_THEME_NAME\Controllers;

use Iquitheme\Core\Controllers\BaseClassicalPagecontroller;

class PageController extends BaseClassicalPagecontroller
{

    public function example($post, $query)
    {
        return View('pages.template.example');
    }

}
