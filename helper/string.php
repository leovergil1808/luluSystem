<?php

function convert_status_to_string($status){
    switch ($status){
        case 0 : $status = "欠席";
            break;
        case 1 : $status = "出席";
            break;    
        case 2 : $status = "遅刻";
            break;
    }

    return $status;
}