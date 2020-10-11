<?php
get_header();
?>
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <?php get_sidebar(); ?>
        <div class="main-content fl-right">
            <div class="section">
                <div class="section-detail">
                    <div class="table-responsive">
                            <?php
                            if (!empty($list_student)) {
                                ?>
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">No.</span></td>
                                            <td><span class="thead-text">氏名</span></td>
                                            <td><span class="thead-text">学籍番号</span></td>
                                            <td><span class="thead-text">出席状態</span></td>
                                            <td><span class="thead-text">操作</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $temp = 0;
                                        foreach ($list_student as $item) {
                                            $temp ++;
                                            ?>
                                            <tr data-id="<?php echo $item['student_id'] ?>">
                                                <td><input type="checkbox" name="checkItem[]" value="<?php //echo $item['id']; ?>" class="checkItem"></td>
                                                <td><span class="tbody-text"><?php echo $temp; ?></h3></span>
                                                <td><span class="tbody-text"><?php echo $item['fullname']; ?></h3></span>
                                                <td><span class="tbody-text"><?php echo $item['student_id']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo convert_status_to_string($item['status']); ?></span></td>
                                                <td>
                                                    <select  name="changeStatusAjax">
                                                        <option value="">---</option>
                                                        <option value="0">欠席</option>
                                                        <option value="1">出席</option>
                                                        <option value="2">遅刻</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">No.</span></td>
                                            <td><span class="thead-text">氏名</span></td>
                                            <td><span class="thead-text">学籍番号</span></td>
                                            <td><span class="thead-text">出席状態</span></td>
                                            <td><span class="thead-text">操作</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php
                            }
                            ?>
                    </div> 
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>