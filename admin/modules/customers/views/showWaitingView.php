<?php
get_header();
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách đơn hàng chờ</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=customers&action=index">Tất cả <span class="count">(<?php echo $num_rows ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=customers&action=showDelivering">Đơn đang chuyển<span class="count">(<?php echo $num_rows_delivering ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=customers&action=showWaiting">Đơn đang chờ<span class="count">(<?php echo $num_rows_waiting ?>)</span> |</a></li>
                            <li class="pending"><a href="?mod=customers&action=showDelivered">Đơn đã chuyển<span class="count">(<?php echo $num_rows_delivered ?>)</span></a></li>
                        </ul>
                        <!-- <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form> -->
                    </div>
                    <form method="POST" action="" class="form-actions">
                        <div class="actions">
                            <select name="actions">
                                <option value="">Tác vụ</option>
                                <option value="1">1. Xác nhận đơn hàng</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">

                        </div>
                        <div class="table-responsive">
                            <?php
                            if (!empty($list_transaction)) {
                                ?>
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Mã đơn hàng</span></td>
                                            <td><span class="thead-text">Họ và tên</span></td>
                                            <td><span class="thead-text">Số sản phẩm</span></td>
                                            <td><span class="thead-text">Tổng giá</span></td>
                                            <td><span class="thead-text">Thanh toán</span></td>
                                            <td><span class="thead-text">Thời gian</span></td>
                                            <td><span class="thead-text">Chi tiết</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $temp = 0;
                                        foreach ($list_transaction as $transaction) {
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" value="<?php echo $transaction['id']; ?>" class="checkItem"></td>
                                                <td><span class="tbody-text">1</h3></span>
                                                <td><span class="tbody-text"><?php echo $transaction['transaction_code']; ?></h3></span>
                                                <td>
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $transaction['username']; ?></a>
                                                    </div>
                                                    <ul class="list-operation fl-right">
                                                        <li><a href="<?php echo $transaction['url_edit']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="<?php echo $transaction['url_delete']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $transaction['quantity']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo currency_format($transaction['total']); ?></span></td>
                                                <td><span class="tbody-text"><?php echo $transaction['payment_method']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($transaction['created_date']); ?></span></td>
                                                <td><a href="<?php echo $transaction['url_detail']; ?>" title="" class="tbody-text">Chi tiết</a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="tfoot-text">STT</span></td>
                                            <td><span class="tfoot-text">Mã đơn hàng</span></td>
                                            <td><span class="tfoot-text">Họ và tên</span></td>
                                            <td><span class="tfoot-text">Số sản phẩm</span></td>
                                            <td><span class="tfoot-text">Tổng giá</span></td>
                                            <td><span class="thead-text">Thanh toán</span></td>
                                            <td><span class="tfoot-text">Thời gian</span></td>
                                            <td><span class="tfoot-text">Chi tiết</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php
                            }
                            ?>

                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <!-- <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p> -->
                    <?php echo get_pagging($num_page, $page, "?mod=customers&action=showWaiting"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>