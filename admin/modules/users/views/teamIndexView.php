<?php
get_header();
// show_array($list_admin);
?>
<div id="main-content-wp" class="list-product-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=users&controller=team&action=addAdmin" title="" id="add-new" class="fl-left">Thêm quản trị viên</a>
            <h3 id="index" class="fl-left">Danh sách quản trị viên</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('users'); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách quản trị viên</h3>
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
                        if (!empty($data)) {
                            ?>
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Họ và tên</span></>
                                        <td><span class="thead-text">Số điện thoại</span></td>
                                        <td><span class="thead-text">Email</span></td>
                                        <td><span class="thead-text">Địa chỉ</span></td>
                                        <td><span class="thead-text">Khởi tạo</span></>
                                        <td><span class="thead-text">Phân quyền</span></>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($list_admin)) {
                                    ?>
                                    <tbody>
                                        <?php
                                        $temp = 0;
                                        foreach ($list_admin as $admin) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp ?></h3></span>
                                                <td>
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $admin['fullname'] ?></a>
                                                    </div>
                                                    <!-- <ul class="list-operation fl-right">
                                                        <li><a href="" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul> -->
                                                </td>
                                                <td><span class="tbody-text"><?php echo $admin['tel'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['email'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['address'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($admin['created_date']) ?></span></td>
                                                <td><span class="tbody-text"><?php echo $admin['role'] ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($list_editor)) {
                                    ?>
                                    <tbody>
                                        <?php
                                        foreach ($list_editor as $editor) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp ?></h3></span>
                                                <td>
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $editor['fullname'] ?></a>
                                                    </div>
                                                    <!-- <ul class="list-operation fl-right">
                                                        <li><a href="" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul> -->
                                                </td>
                                                <td><span class="tbody-text"><?php echo $editor['tel'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $editor['email'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $editor['address'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($editor['created_date']) ?></span></td>
                                                <td><span class="tbody-text"><?php echo $editor['role'] ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }
                                ?>
                                <?php
                                if (!empty($list_worker)) {
                                    ?>
                                    <tbody>
                                        <?php
                                        foreach ($list_worker as $worker) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp ?></h3></span>
                                                <td>
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $worker['fullname'] ?></a>
                                                    </div>
                                                    <!-- <ul class="list-operation fl-right">
                                                        <li><a href="" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul> -->
                                                </td>
                                                <td><span class="tbody-text"><?php echo $worker['tel'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $worker['email'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo $worker['address'] ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($worker['created_date']) ?></span></td>
                                                <td><span class="tbody-text"><?php echo $worker['role'] ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }
                                ?>


                                                    <!-- <tfoot> -->
                                                        <!-- <tr>
                                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                                            <td><span class="tfoot-body">STT</span></td>
                                                            <td><span class="tfoot-body">Họ và tên</span></td>
                                                            <td><span class="tfoot-body">Số điện thoại</span></td>
                                                            <td><span class="tfoot-body">Email</span></td>
                                                            <td><span class="tfoot-body">Địa chỉ</span></td>
                                                            <td><span class="tfoot-body">Khởi tạo</span></td>
                                                            <td><span class="tfoot-body">Cấp quyền</span></td>
                                                        </tr> -->
                                <br>
                                <!-- </tfoot> -->
                            </table>
                            <?php
                        }
                        ?>
                        <a href="?mod=users&controller=team&action=showPermissions">Cấp quyền cho user</a>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <!-- <div class="section-detail clearfix">
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
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>