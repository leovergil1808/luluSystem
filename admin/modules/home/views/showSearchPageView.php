<?php
get_header();
// show_array($data)
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
                    <div class="filter-wp clearfix">
                        <a href="?mod=pages&action=index">Trở về trang chính</a><br>
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=pages&action=index">Tìm được <span class="count">(<?php echo $num_rows; ?>)</span> kết quả</a> </li>

                        </ul>
                        <div class="actions">
                            <form method="GET" class="form-s fl-right">
                                <input type="hidden" name="mod" value="pages">
                                <input type="hidden" name="action" value="index">
                                <select name="search_by">
                                    <option value="">Tìm theo</option>
                                    <option value="1">Tiêu đề</option>
                                    <option value="2">Người tạo</option>
                                    <option value="3">Ngày tạo</option>
                                </select>
                                <input type="text" name="s" id="s">
                                <input type="submit" name="sm_s" value="Tìm kiếm">
                            </form>
                        </div>
                    </div>
                    <form method="POST" action="" class="form-actions">
                        <div class="actions">
                            <select name="actions">
                                <option value="">Danh sách tác vụ</option>
                                <option value="1">Gỡ, tạm chỉnh sửa</option>
                                <option value="2">Tạm xoá trang</option>
                                <option value="3">Duyệt trang</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </div>
                        <div class="table-responsive">
                            <?php
                            if (!empty($list_page)) {
                                ?>
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
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
                                        foreach ($list_page as $item) {
                                            $temp ++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" value="<?php echo $item['id']; ?>" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                                <td class="clearfix">
                                                    <div class="tb-title fl-left">
                                                        <a href="" title=""><?php echo $item['page_title']; ?></a>
                                                    </div>
                                                    <ul class="list-operation fl-right">
                                                        <li><a href="<?php echo $item['url_edit'] ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                        <li><a href="<?php echo $item['url_move_trash'] ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </td>
                                                <td><span class="tbody-text <?php echo $item['status_css']; ?>"><?php echo $item['page_status']; ?></span></td>
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
                    <?php echo get_pagging($num_page, $page, "?mod=pages&action=index&search_by={$search_by}&s={$s}&sm_s=Tìm+kiếm"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>