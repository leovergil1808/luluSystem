<?php
get_header();
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa media</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php
                    if (!empty($media)) {
                        ?>
                        <form method="POST" enctype="multipart/form-data">
                            <label for="title">Sửa media</label>
                            <input type="text" name="title" id="title" value="<?php echo $media['title'] ?>">
                            <p class="error"><?php echo form_error('title'); ?></p>

                            <label>Hình ảnh</label>
                            <div id="uploadFile">
                                <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                                <img id="upload-image" src="<?php echo $media['thumbnail']; ?>">
                            </div>
                            <p class="error"><?php echo form_error('upload_image'); ?></p>

                            <select name="media_type" id="">.
                                <option value="">Chọn kiểu</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="slider">Slider</option>
                            </select>

                            <button type="submit" name="btn-submit" id="btn-submit">Sửa media</button>
                        </form>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>