<?php

/* $Id: pager.php 98 2012-04-25 05:04:25Z qiao $ */

// require_once 'url.php';

class util_pager {

    private static $PT = '_PAGE_';

    public static function gethtml($page, $total_page, $url_format = true, $els = array('prev','next','first','moreprev','pages','morenext','last'), $sider = 4){

        if($url_format === true){
            // auto url 
            $url_format = util_url::add_param($_SERVER['REQUEST_URI'], 'page', self::$PT, false);
        }

        $pages = self::getpage($page, $total_page, $sider);

        $html = '';

        $_quote = array(
            'first'     => '|&lt;',
            'moreprev'  => '&lt;&lt',
            'prev'      => '上一页',
            'next'      => '下一页',
            'morenext'  => '&gt;&gt;',
            'last'      => '&gt;|',
        );

        foreach($els as $k){
            if($k == 'pages'){
                if($pages['pages'][0] > 1){
                    $html .= '<span class="p_sep">...</span>'."\n";
                }
                foreach($pages['pages'] as $p){
                    if($p == $page){
                        $html .= '<span class="p_current">'.$p.'</span>'."\n";
                    } else {
                        $html .= '<a class="p_'.$k.'" href="'.htmlspecialchars(str_replace(self::$PT, $p, $url_format)).'">'.$p.'</a>'."\n";
                    }
                }
                $len_pages = count($pages['pages']);
                if($pages['pages'][$len_pages - 1] < $total_page){
                    $html .= '<span class="p_sep">...</span>'."\n";
                }
            } else {

                if($pages[$k]){
                    $html .= '<a class="p_'.$k.'" href="'.htmlspecialchars(str_replace(self::$PT, $pages[$k], $url_format)).'">'.$_quote[$k].'</a>'."\n";
                } else {
                    $html .= '<span class="p_'.$k.'">'.$_quote[$k].'</span>'."\n";
                }
            }

        }


        return $html;
    }

    public static function getpage($page, $total_page, $sider = 4){
        $sider_num = $sider * 2 + 1;

        $pages = array(
            'first' => false,
            'last'  => false,
            'prev'  => false,
            'next'  => false,
            'moreprev' => false,
            'morenext' => false,
            'pages' => array(),
        );

        if($total_page < 2){
            $pages['pages'][] = 1;
            return $pages;
        }
        if($page < 1 or $page > $total_page){
            $page = 1;
        }



        if($page > 1){
            $pages['first'] = 1;
            $pages['prev'] = $page - 1;
            $pages['moreprev'] = $page - $sider_num;
            if($pages['moreprev'] < 1){
                $pages['moreprev'] = 1;
            }
        }
        if($page < $total_page){
            $pages['last'] = $total_page;
            $pages['next'] = $page + 1;
            $pages['morenext'] = $page + $sider_num;
            if($pages['morenext'] > $total_page){
                $pages['morenext'] = $total_page;
            }
        }

        $pages['pages'][] = $page;

        // prev five page

        for($p = $page - 1, $i = 0; $p > 0 and $i < $sider; $p--, $i++){
            $pages['pages'][] = $p;
        }

        // next five page
        for($p = $page + 1, $i = 0; $p <= $total_page and $i < $sider; $p++, $i++){
            $pages['pages'][] = $p;
        }

        $pages['pages'] = array_unique($pages['pages']);
        sort($pages['pages']);

        return $pages;
    }
}

/*
$s = q_pager::getpage(0, 100);
print_r($s);

$s = q_pager::getpage(1, 100);
print_r($s);

$s = q_pager::getpage(2, 100);
print_r($s);

$s = q_pager::getpage(10, 100);
print_r($s);

$s = q_pager::getpage(99, 100);
print_r($s);

$s = q_pager::getpage(100, 100);
print_r($s);
 */

/*
$s = q_pager::gethtml('?page=%s', 10, 100);
print_r($s);
 */

