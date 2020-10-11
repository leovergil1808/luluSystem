<?php
get_header();
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <?php
        if (!empty($transaction_info)) {
            ?>
            <div id="content" class="detail-exhibition fl-right">
                <div class="section" id="info">
                    <div class="section-head">
                        <h3 class="section-title">Thông tin đơn hàng</h3>
                    </div>
                    <ul class="list-item">
                        <li>
                            <h3 class="title">Mã đơn hàng</h3>
                            <span class="detail"><?php echo $transaction_info['transaction_code']; ?></span>
                        </li>
                        <li>
                            <h3 class="title">Địa chỉ nhận hàng</h3>
                            <span class="detail"><?php echo $transaction_info['address']; ?></span>
                        </li>
                        <li>
                            <h3 class="title">Số điện thoại</h3>
                            <span class="detail"> +84 <?php echo $transaction_info['phone']; ?></span>
                        </li>
                        <li>
                            <h3 class="title">Thông tin vận chuyển</h3>
                            <span class="detail"><?php echo $transaction_info['payment_method']; ?></span>
                        </li>
                        <form method="POST" action="">
                            <li>
                                <h3 class="title">Tình trạng đơn hàng</h3>
                                <select name="status">
                                    <option value="none" selected='selected'><?php echo $transaction_info['status']; ?></option>
                                    <option value="none">-------------------------------</option>
                                    <option  value="0">Đang chờ</option>
                                    <option  value='1'>Đang vận chuyển</option>
                                    <option  value='2'>Đã chuyển</option>                           
                                </select>
                                <input type="submit" name="sm_status" value="Cập nhật đơn hàng">
                            </li>
                        </form><br>
                        <li>
                            <a href="?mod=customers&action=index">Trở về danh sách hợp đồng</a>
                        </li>
                    </ul>
                </div>
                <div class="section">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm đơn hàng</h3>
                    </div>
                    <div class="table-responsive">
                        <?php
                        if (!empty($list_order_product)) {
                            ?>
                            <table class="table info-exhibition">
                                <thead>
                                    <tr>
                                        <td class="thead-text">STT</td>
                                        <td class="thead-text">Ảnh sản phẩm</td>
                                        <td class="thead-text">Tên sản phẩm</td>
                                        <td class="thead-text">Đơn giá</td>
                                        <td class="thead-text">Số lượng</td>
                                        <td class="thead-text">Thành tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $temp = 0;
                                    foreach ($list_order_product as $item) {
                                        $temp ++;
                                        ?>
                                        <tr>
                                            <td class="thead-text"><?php echo $temp; ?></td>
                                            <td class="thead-text">
                                                <div class="thumb">
                                                    <img src="<?php echo $item['detail']['thumbnail']; ?>" alt="">
                                                </div>
                                            </td>
                                            <td class="thead-text"><?php echo $item['detail']['title']; ?></td>
                                            <td class="thead-text"><?php echo currency_format($item['detail']['price']); ?></td>
                                            <td class="thead-text"><?php echo $item['quantity']; ?></td>
                                            <td class="thead-text"><?php echo currency_format($item['sub_total']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="section">
                    <h3 class="section-title">Giá trị đơn hàng</h3>
                    <div class="section-detail">
                        <?php
                        if (!empty($transaction_info)) {
                            ?>
                            <ul class="list-item clearfix">
                                <li>
                                    <span class="total-fee">Tổng số lượng</span>
                                    <span class="total">Tổng đơn hàng</span>
                                </li>
                                <li>
                                    <span class="total-fee"><?php echo $transaction_info['quantity']; ?> sản phẩm</span>
                                    <span class="total"><?php echo currency_format($transaction_info['total']); ?></span>
                                </li>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</div>
<?php
get_footer();
?>