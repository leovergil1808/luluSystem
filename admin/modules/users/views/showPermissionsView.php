<?php
get_header();
// show_array($list_admin);
?>
<div id="main-content-wp" class="list-product-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=users&controller=team&action=addAdmin" title="" id="add-new" class="fl-left">Thêm quản trị viên</a>
            <h3 id="index" class="fl-left">Cấp quyền cho quản trị viên</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?Php get_sidebar('users'); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cấp quyền quản trị</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả có <span class="count">(<?php echo $num_rows ?>)</span> quản trị viên</a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form>
                    </div>

                    <div class="table-responsive">
                        <?php
                        if (!empty($list_admin)) {
                            ?>
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <!-- <td><input type="checkbox" name="checkAll" id="checkAll"></td> -->
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">ID</span></>
                                        <td><span class="thead-text">Họ và tên</span></>
                                        <td><span class="thead-text">Phân quyền</span></>
                                        <td><span class="thead-text">Đối tượng</span></>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $temp = 0;
                                    foreach ($list_admin as $admin) {
                                        $temp ++;
                                        ?>
                                        <tr>
                                            <!-- <td><input type="checkbox" name="checkItem" class="checkItem"></td> -->
                                            <td><span class="tbody-text"><?php echo $temp ?></h3></span>
                                            <td><span class="tbody-text"><?php echo $admin['id']; ?></h3></span>
                                            <td>
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo $admin['fullname'] ?></a>
                                                </div>
                                                <!-- <ul class="list-operation fl-right">
                                                    <li><a href="" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul> -->
                                            </td>
                                            <td><span class="tbody-text"><?php echo $admin['role'] ?></span></td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" name="username" id="" readonly="readonly" style="cursor : not-allowed; background-color: #f3f3f3;" value="<?php echo $admin['username'] ?>">
                                                    <select name="update_role" id="">
                                                        <option value="">----------</option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">Editor</option>
                                                        <option value="3">Worker</option>
                                                    </select>
                                                    <button type="submit" name="btn-submit" id="btn-submit">Cấp quyền</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="tfoot-body">STT</span></td>
                                        <td><span class="tfoot-body">Họ và tên</span></td>
                                        <td><span class="tfoot-body">Số điện thoại</span></td>
                                        <td><span class="tfoot-body">Email</span></td>
                                        <td><span class="tfoot-body">Địa chỉ</span></td>
                                        <td><span class="tfoot-body">Khởi tạo</span></td>
                                        <td><span class="tfoot-body">Cấp quyền</span></td>
                                    </tr>
                                </tfoot> -->
                            </table>
                            <?php
                        }
                        ?>
                        <a href="?mod=users&controller=team&action=index">Xem danh sách quản trị viên</a>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <ul id="list-paging" class="fl-right">
                        <li>
                            <a href="" title=""><</a>
                        </li>
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                        <li>
                            <a href="" title="">></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>