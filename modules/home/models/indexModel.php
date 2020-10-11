<?php

# Function for Product Category

function get_info_cat($cat_id) {
    $result = db_fetch_row("SELECT * FROM `tbl_product_cat` WHERE `cat_id` = {$cat_id}");
    if (!empty($result))
        return $result;
    return false;
}

# Function for Product

function get_list_product($cat_id, $start, $num_per_page) {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `cat_id` = {$cat_id} AND `status` = '1' AND `tracking` = '1' LIMIT {$start}, $num_per_page");

    if (!empty($result))
        foreach ($result as &$item) {
            $item['url_detail'] = "?mod=products&action=detail&id={$item['id']}&name={$item['slug']}";
            $item['url_add_cart'] = "?mod=cart&action=addCart&id={$item['id']}";
            $item['url_checkout'] = "?mod=cart&action=buyNow&id={$item['id']}";
        }
    return $result;
    return false;
}

function get_list_featured_product() {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `featured` = '1' AND `status` = '1' AND `tracking` = '1'");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_detail'] = "?mod=products&action=detail&id={$item['id']}&name={$item['slug']}";
            $item['url_add_cart'] = "?mod=cart&action=addCart&id={$item['id']}";
            $item['url_checkout'] = "?mod=cart&action=buyNow&id={$item['id']}";
        }
        return $result;
    }
}

function get_list_best_seller() {
    $result = db_fetch_array("SELECT * FROM `tbl_product` WHERE `best_seller` = '1' AND `status` = '1' AND `tracking` = '1' ");
    if (!empty($result)) {
        foreach ($result as &$item) {
            $item['url_detail'] = "?mod=products&action=detail&id={$item['id']}";
            $item['url_checkout'] = "?mod=cart&action=buyNow&id={$item['id']}";
        }
        return $result;
    }
}

# Function for Banner

function get_list_media($type = "") {
    if (!empty($type)) {
        $result = db_fetch_array("SELECT * FROM `tbl_media` WHERE `type` = '{$type}'");
        if (!empty($result))
            return $result;
    }
    return false;
}

# Function global for all

function get_num_rows($table, $where = '') {
    if (empty($where)) {
        $result = db_num_rows("SELECT * FROM `{$table}`");
        return $result;
    } else {
        $result = db_num_rows("SELECT * FROM `{$table}` WHERE {$where}");
        return $result;
    }
}

function get_url_upload_image($id) {
    $result = db_fetch_row("SELECT * FROM `tbl_page` WHERE `id` = {$id}");
    return $result['page_thumbnail'];
}

function search_item($table, $search_by = '', $s, $start, $num_per_page) {

    if (!empty($s)) {
        $result = db_fetch_array("SELECT * FROM `{$table}` WHERE {$search_by} LIKE '%{$s}%' LIMIT {$start} , {$num_per_page}");
        if (!empty($result)) {
            foreach ($result as &$item) {
                switch ($item['tracking']) {
                    case 1 : $item['tracking'] = "Stocking";
                        $item['tracking_css'] = 1;
                        break;
                    case 2 : $item['tracking'] = "Out of Stock";
                        $item['tracking_css'] = 2;
                        break;
                    case 3 : $item['tracking'] = "Temporary Out";
                        $item['tracking_css'] = 3;
                        break;
                    case 4 : $item['tracking'] = "Importing goods";
                        $item['tracking_css'] = 4;
                        break;
                    default : $item['tracking'] = "Checking";
                }
                switch ($item['status']) {
                    case 0 : $item['status'] = "Waiting";
                        $item['status_css'] = 0;
                        break;
                    case 1 : $item['status'] = "Approved";
                        $item['status_css'] = 1;
                        break;
                    case 2 : $item['status'] = "Trash";
                        $item['status_css'] = 2;
                        break;
                }
                switch ($item['cat_id']) {
                    case 1 : $item['cat_title'] = "?i�?n thoa?i";
                        break;
                    case 2 : $item['cat_title'] = "Ma?y ti?nh ba?ng";
                        break;
                    case 3 : $item['cat_title'] = "Laptop";
                        break;
                    case 4 : $item['cat_title'] = "Tai nghe";
                        break;
                    case 5 : $item['cat_title'] = "Th??i trang";
                        break;
                    case 6 : $item['cat_title'] = "?�? gia du?ng";
                        break;
                    case 7 : $item['cat_title'] = "Thi�?t bi? v?n pho?ng";
                        break;
                    default : $item['cat_title'] = "None";
                }

                $item['url_edit'] = "?mod=products&controller=index&action=editProduct&id={$item['id']}";
                $item['url_move_trash'] = "?mod=products&controller=index&action=moveTrash&id={$item['id']}";
                $item['status_css'] = set_css_by_status($item['status_css']);
                $item['tracking_css'] = set_css_by_tracking($item['tracking_css']);
                $item['url_approve'] = "?mod=products&controller=index&action=approveProduct&id={$item['id']}";
            }
            return $result;
        }
    }

    return false;
}
