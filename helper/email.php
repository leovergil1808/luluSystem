<?php

function form_email_cart() {
    $body = "";
    $total = currency_format($_SESSION['cart']['info']['total']);
    if (!empty($_SESSION)) {
        foreach ($_SESSION['cart']['buy'] as $item) {
            $url = $item['url'];
            $thumbnail = $item['thumbnail'];
            $title = $item['title'];
            $price = currency_format($item['price']);
            $quantity = $item['quantity'];
            $body .= "
            <tr>
                <td><a href='{$url}' title='' class='thumb'><img src='{$thumbnail}' alt=''></a></td>
                <td><a href='{$url}' title='' class='name-product'>{$title}</a></td>
                <td>{$price}</td>
                <td>{$quantity}</td>
            </tr>
            ";
        }
    }
    return "
    <table>
        <thead>
            <tr>
                <td>Ảnh sản phẩm</td>
                <td>Tên sản phẩm</td>
                <td>Giá sản phẩm</td>
                <td>Số lượng</td>
            </tr>
        </thead>
        <tbody>
            {$body}
        </tbody>
    </table>
    <p>Thành tiền : <strong>{$total}</strong></p> 
    ";
}
