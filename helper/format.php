<?php

function currency_format($number, $suffix = 'đ') {
    return number_format($number) . $suffix;
}

function time_format($timestamp) {
    if (!empty($timestamp)) {
        $format = "%d/%m/%y %H:%M:%S";
        return strftime($format, $timestamp);
    }
}
