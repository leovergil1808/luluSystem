<?php
get_header();
?>
<div id="main-content-wp" class="category-product-page">
    <div class="wp-inner clearfix">
        <div id="wp-form-reg">
            <form id="form-reg" action="" enctype="multipart/form-data" method="POST">

                <div class="widget clearfix">
                    <div class="fill-label fl-left">
                        <label for="fullname" >氏名: </label>
                    </div>

                    <div class="fill-info">
                        <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" placeholder="Fullname">
                        <p class="error" style="display: inline;"><?php echo form_error('fullname'); ?></p>
                    </div>
                </div>

                <div class="widget clearfix">
                    <div class="fill-label fl-left">
                        <label for="studentId" class="fl-left">学生記番号: </label>
                    </div>

                    <div class="fill-info">
                        <input type="text" name="studentId" id="username" value="<?php echo set_value('studentId') ?>" placeholder="学生記番号">
                        <p class="error"><?php echo form_error('studentId'); ?></p>
                    </div>
                </div>

                <div class="widget clearfix">
                    <div class="fill-label fl-left">
                        <label for="file" class="fl-left">写真: </label>
                    </div>

                    <div class="fill-info">
                        <div id="uploadFile">
                            <input type="file" name="file[]" id="upload-thumb" multiple="" onchange="show_upload_multi_image()">
                            <div id="slider-thumb" class="clearfix">

                            </div>
                        </div>
                    </div>
                    <p class="error"><?php echo form_error('upload'); ?></p>
                </div>

                <input type="submit" name="btn_reg" id="btn_reg" value="登録">
                <p class="error"><?php //echo form_error('account'); ?></p>
            </form>
        </div>

    </div>
</div>
<?php
get_footer();
?>