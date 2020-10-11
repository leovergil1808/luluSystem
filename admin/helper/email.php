<?php

function form_email_cart() {
    $body = "";
    $total = currency_format($_SESSION['cart']['info']['total']);
    if (!empty($_SESSION)) {
        foreach ($_SESSION['cart']['buy'] as $item) {
            $product_url = $item['product_url'];
            $product_thumbnail = $item['product_thumbnail'];
            $product_title = $item['product_title'];
            $product_price = currency_format($item['product_price']);
            $product_quantity = $item['product_quantity'];
            $body .= "
            <tr>
                <td><a href='{$product_url}' title='' class='thumb'><img src='{$product_thumbnail}' alt=''></a></td>
                <td><a href='{$product_url}' title='' class='name-product'>{$product_title}</a></td>
                <td>{$product_price}</td>
                <td>{$product_quantity}</td>
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
