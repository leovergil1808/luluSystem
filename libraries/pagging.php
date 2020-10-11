<?php

function get_pagging($num_page, $page, $base_url = "", $friendly_url = "") {

    if(empty($friendly_url)){
        $str_pagging = "<ul class='list-item clearfix'>";
        if ($page > 1) {
            $page_prev = $page - 1;
            $str_pagging .= "<li data-page='{$page_prev}'><a href='{$base_url}&page={$page_prev}'><</a></li>";
        }
        for ($i = 1; $i <= $num_page; $i++) {
            // $active = "";
            // if($i == $page){
            //     $active = "class ='active'";
            // }
            $str_pagging .= "<li data-page='{$i}'><a href='{$base_url}&page={$i}'>{$i}</a></li>";
        }
        if ($page < $num_page) {
            $page_next = $page + 1;
            $str_pagging .= "<li data-page='{$page_next}'><a href='{$base_url}&page={$page_next}'>></a></li>";
        }
        $str_pagging .= "</ul>";
        return $str_pagging;
    }else{
        $str_pagging = "<ul class='list-item clearfix'>";
        if ($page > 1) {
            $page_prev = $page - 1;
            $str_pagging .= "<li data-page='{$page_prev}'><a href='{$friendly_url}/page-{$page_prev}'><</a></li>";
        }
        for ($i = 1; $i <= $num_page; $i++) {
            // $active = "";
            // if($i == $page){
            //     $active = "class ='active'";
            // }
            $str_pagging .= "<li data-page='{$i}'><a href='{$friendly_url}/page-{$i}'>{$i}</a></li>";
        }
        if ($page < $num_page) {
            $page_next = $page + 1;
            $str_pagging .= "<li data-page='{$page_next}'><a href='{$friendly_url}/page-{$page_next}'>></a></li>";
        }
        $str_pagging .= "</ul>";
        return $str_pagging;
    }
    
}

function get_pagging_custom($num_page, $page, $base_url = "") {

    $str_pagging = "<ul class='list-pagging fl-right clearfix'>";
    if ($page > 1) {
        $page_prev = $page - 1;
        $str_pagging .= "<li data-page='{$page_prev}'><a href='{$base_url}&page={$page_prev}'><</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        // $active = "";
        // if($i == $page){
        //     $active = "class ='active'";
        // }
        $str_pagging .= "<li data-page='{$i}'><a href='{$base_url}&page={$i}'>{$i}</a></li>";
    }
    if ($page < $num_page) {
        $page_next = $page + 1;
        $str_pagging .= "<li data-page='{$page_next}'><a href='{$base_url}&page={$page_next}'>></a></li>";
    }
    $str_pagging .= "</ul>";
    return $str_pagging;
}

function render_list_product($list_product) {

    if (!empty($list_product)) {
        $str = "";

        foreach ($list_product as $item) {
            $price = currency_format($item['price']);
            $old_price = currency_format($item['old_price']);
            ;

            $str .= "<li>
                        <a href='product/{$item['slug']}' title='' class='thumb'><img src='{$item['thumbnail']}'></a>
                        <a href='product/{$item['slug']}' title='' class='product-name'>{$item['title']}</a>
                        <div class='price'>
                            <span class='new'>{$price}</span>
                            <span class='old'>{$old_price}</span>
                        </div>
                        <div class='action clearfix'>
                            <a href='{$item['url_add_cart']}' title='Add Cart' class='add-cart fl-left'>Add Cart</a>
                            <a href='{$item['url_checkout']}' title='Buy Now' class='buy-now fl-right'>Buy Now</a>
                        </div>
                    </li>";
        }
        return $str;
    }
}

function render_pagging($num_page, $page, $base_url = "") {
    $str_pagging = "<ul class='list-pagging fl-right clearfix'>";

    if ($page > 1) {
        $page_prev = $page - 1;
        $str_pagging .= "<li data-page='{$page_prev}'><a href='{$base_url}&page={$page_prev}'><</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        // $active = "";
        // if($i == $page){
        //     $active = "class ='active'";
        // }
        $str_pagging .= "<li data-page='{$i}'><a href='mod=home&action=index&page={$i}'>{$i}</a></li>";
    }
    if ($page < $num_page) {
        $page_next = $page + 1;
        $str_pagging .= "<li data-page='{$page_next}'><a href='{$base_url}&page={$page_next}'>></a></li>";
    }
    $str_pagging .= "</ul>";
    return $str_pagging;
}
