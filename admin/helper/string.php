<?php

function cat_id_convert_cat_title($cat_id) {
    $result;

    switch ($cat_id) {
        case 1 : $result = "Điện thoại";
            break;
        case 2 : $result = "Máy tính bảng";
            break;
        case 3 : $result = "Laptop";
            break;
        case 4 : $result = "Tai nghe";
            break;
        case 5 : $result = "Thời trang";
            break;
        case 6 : $result = "Đồ gia dụng";
            break;
        case 7 : $result = "Thiết bị văn phòng";
            break;
        default : $result = "None";
    }
    return $result;
}

function convert_status_to_string($status) {
    $result;

    switch ($status) {
        case 1 : $result = "Waiting";
            break;
        case 2 : $result = "Approved";
            break;
        case 3 : $result = "Trash";
            break;
    }
    return $result;
}

function convert_tracking_to_string($tracking) {
    $result;

    switch ($tracking) {
        case 1 : $result = "Stocking";
            break;
        case 2 : $result = "Out of Stock";
            break;
        case 3 : $result = "Temporary Out";
            break;
        case 4 : $result = "Importing goods";
            break;
        default: $result = "Checking";
    }
    return $result;
}
