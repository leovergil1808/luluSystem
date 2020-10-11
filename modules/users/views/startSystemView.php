<?php
get_header();
?>
<div id="main-content-wp" class="home-page clearfix">

    <div class="wp-inner">
    <?php get_sidebar('startSystem') ?>
        <div class="main-content fl-right">
            <div class="section" id="video-wp">
                <video id="video" width="720" height="560" autoplay muted></video>
                <div id="canvas"></div>
            </div>

            <div class="section">
                <?php 
                    if(!empty($list_student)){
                        ?>
                            <ul id="list-student" class="clearfix">
                            <?php 
                                foreach($list_student as $student){
                                    ?>
                                        <li data-id="<?php echo $student['student_id']; ?>">
                                            <span><?php echo $student['student_id']; ?></span><br>
                                            <span><?php echo $student['fullname'];?></span>
                                        </li>
                                    <?php
                                }
                            ?>
                            </ul>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer('rollCall');
?>

