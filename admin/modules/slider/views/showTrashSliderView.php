<?php
get_header();
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách Slider rác</h3>
                    <!-- <a href="?mod=posts&controller=index&action=addPost" title="" id="add-new" class="fl-left">Thêm mới</a> -->
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=slider&action=index">Tất cả <span class="count">(<?php echo $num_rows; ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=slider&action=showApprovedSlider">Đã đăng <span class="count">(<?php echo $num_rows_approved; ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=slider&action=showWaitingSlider">Chờ xét duyệt<span class="count">(<?php echo $num_rows_waiting; ?>)</span> |</a></li>
                            <li class="pending"><a href="?mod=slider&action=showTrashSlider">Thùng rác<span class="count">(<?php echo $num_rows_trash; ?>)</span></a></li>
                        </ul>
                        <!-- <form method="GET" class="form-s fl-right">
                            <input type="text" name="s" id="s">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form> -->
                    </div>
                    <form method="POST" action="" class="form-actions">
                        <div class="actions">

                            <select name="actions">
                                <option value="0">Thao tác</option>
                                <option value="1">1. Khôi phục slider</option>
                                <option value="2">2. Xoá slider</option><br>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">

                        </div>
                        <div class="table-responsive">
                            <?php
                            if (!empty($list_slider)) {
                                ?>
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tên Slider</span></td>
                                            <td><span class="thead-text">Thao tác</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Ngày tạo</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $temp = 0;
                                        foreach ($list_slider as $item) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" value="<?php echo $item['id']; ?>" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp; ?></h3></span>

                                                <td class="clearfix">
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $item['title']; ?></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="<?php echo $item['url_restore'] ?>" style="color: #3860e6;">Khôi phục</a> | 
                                                    <a href="<?php echo $item['url_delete'] ?>" style="color: red;">Xoá bỏ</a>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $item['creator']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($item['created_date']); ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tên Slider</span></td>
                                            <td><span class="thead-text">Thao tác</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Ngày tạo</span></td>
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
                    <?php echo get_pagging($num_page, $page, "?mod=slider&action=showTrashSlider"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>