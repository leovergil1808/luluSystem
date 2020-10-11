<?php

function set_css_by_status($status) {
    switch ($status) {
        case 0 : return "status-waiting";
        case 1 : return "status-approved";
        case 2 : return "status-trash";
    }
}

function set_css_by_tracking($tracking) {
    switch ($tracking) {
        case 1 : return "track-stocking";
        case 2 : return "track-outOfStock";
        case 3 : return "track-temporaryOut";
        case 4 : return "track-importingGoods";
    }
}
