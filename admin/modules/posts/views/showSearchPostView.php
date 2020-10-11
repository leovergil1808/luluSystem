<?php
get_header();
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Kết quả tìm kiếm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">

                <div class="section-detail">
                    <a href="?mod=posts&action=index">Trở về trang chính</a><br>
                    <div class="filter-wp clearfix">

                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tìm được <span class="count">(<?php echo $num_rows; ?>)</span> kết quả</a> </li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <div class="actions">
                                <input type="hidden" name="mod" value="posts">
                                <input type="hidden" name="action" value="index">
                                <select name="search_by">
                                    <option value="">Tìm theo :</option>
                                    <option value="post_title">Tiêu đề</option>
                                    <option value="creator">Người tạo</option>
                                </select>
                                <input type="text" name="s" id="s">
                                <input type="submit" name="sm_s" value="Tìm kiếm">
                            </div>
                        </form>
                    </div>
                    <form method="POST" action="" class="form-actions">
                        <div class="actions">

                            <select name="actions">
                                <option value="0">Danh sách tác vụ</option>
                                <option value="1">Gỡ, tạm chỉnh sửa</option>
                                <option value="2">Tạm xoá bài viết</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">

                        </div>
                        <div class="table-responsive">
                            <?php
                            if (!empty($list_post)) {
                                ?>
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
                                            <td><span class="thead-text">Danh mục</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Ngày tạo</span></td>
                                            <td><span class="thead-text">Người sửa</span></td>
                                            <td><span class="thead-text">Ngày sửa</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $temp = 0;
                                        foreach ($list_post as $item) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" value="<?php echo $item['id']; ?>"class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                                <td class="clearfix">
                                                    <div class="tb-title fl-left">
                                                        <a href="<?php echo $item['url_edit'] ?>" title=""><?php echo $item['post_title']; ?></a>
                                                    </div>
                                                    <ul class="list-operation fl-right">
                                                        <li><a href="<?php echo $item['url_edit'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="<?php echo $item['url_move_trash'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $item['cat_title']; ?></span></td>
                                                <td><span class="tbody-text <?php echo $item['status_css']; ?>"><?php echo $item['post_status']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo $item['creator']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($item['created_date']); ?></span></td>
                                                <td><span class="tbody-text"><?php echo $item['editor']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo time_format($item['edit_date']); ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="tfoot-text">STT</span></td>
                                            <td><span class="tfoot-text">Tiêu đề</span></td>
                                            <td><span class="tfoot-text">Danh mục</span></td>
                                            <td><span class="tfoot-text">Trạng thái</span></td>
                                            <td><span class="tfoot-text">Người tạo</span></td>
                                            <td><span class="tfoot-text">Ngày tạo</span></td>
                                            <td><span class="tfoot-text">Người sửa</span></td>
                                            <td><span class="tfoot-text">Ngày sửa</span></td>
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
                    <?php echo get_pagging($num_page, $page, "?mod=posts&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm") ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>