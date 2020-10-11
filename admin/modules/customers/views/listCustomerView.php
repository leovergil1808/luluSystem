<?php
get_header();
?>

<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách khách hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Có tất cả <span class="count">(<?php echo $num_rows ?>)</span> khách hàng</a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form>
                    </div>
                    <div class="actions">
                        <!-- <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option value="1">Xóa</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form> -->
                    </div>
                    <div class="table-responsive">
                        <?php if (!empty($list_customer)) {
                            ?>
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <!-- <td><input type="checkbox" name="checkAll" id="checkAll"></td> -->
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Tên user</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Tạo ngày</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $temp = 0;
                                    foreach ($list_customer as $user) {
                                        $temp ++;
                                        ?>
                                        <tr>
                                    <!-- <td><input type="checkbox" name="checkItem" class="checkItem"></td> -->
                                            <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $user['fullname'] ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="<?php echo $user['url_edit']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="<?php echo $user['url_delete']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $user['username']; ?></span></td>
                                            <td><span class="tbody-text"><?php echo $user['tel']; ?></span></td>
                                            <td><span class="tbody-text"><?php echo $user['email']; ?></span></td>
                                            <td><span class="tbody-text"><?php echo $user['address']; ?></span></td>
                                            <td><span class="tbody-text"><?php echo time_format($user['registry_date']); ?></span></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <!-- <td><input type="checkbox" name="checkAll" id="checkAll"></td> -->
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Họ và tên</span></td>
                                        <td><span class="thead-text">Tên user</span></td>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Tạo ngày</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <!-- <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p> -->
                    <?php echo get_pagging($num_page, $page, "?mod=customers&action=listCustomer"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
