<?php

namespace YOUR_THEME_NAME\Helpers;

class PaginateHelper
{
    public static function pagination($total, $page, $ppp, $baseurl)
    {
        $totalPage = ceil($total / $ppp);

        $html = '';
        if ($totalPage > 1) {
            if ($page > 1) {
                $html .= '<a class="prev page-numbers" href="'.$baseurl.'page/'.($page - 1).'"><</a>';
            }
            for ($p = 1; $p <= $totalPage; $p++) {
                if ($page == $p) {
                    $html .= '<span aria-current="page" class="page-numbers current">'.$p.'</span>';
                }
                else {
                    $html .= '<a class="page-numbers" href="'.$baseurl.'page/'.$p.'">'.$p.'</a>';
                }
            }
            if ($page < $totalPage) {
                $html .= '<a class="next page-numbers" href="'.$baseurl.'page/'.($page + 1).'">></a>';
            }
            $html = '<div class="pagination">'.$html.'</div>';
        }

        return [
            'total' => $total,
            'page' => $page,
            'total_page' => $totalPage,
            'html' => $html,
        ];
    }
}
