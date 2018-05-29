<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>

<!-- Main Content-->
<div class="row col-md-6">
    <div class="col-md-12">
        <h2 class="widget-caption text-center" style="color:#5bc0de;"><?=$data['friend']['user_name'] ?>'s - Friends List</h2>
            <?php
            foreach ($data['friendlist'] as $friend) {?>

                <div class="col-md-4">
            <div class="contact-box center-version">
                <a href="<?=ROOT_URI?>profile/view/<?= $friend->frnd_id?>">
                    <img alt="image" class="img-circle" src="<?=ROOT_URI. $friend->frnd_image_path?>"/>

                    <h5 class="m-b-xs"><strong><?= $friend->frnd_name;?></strong></h5>

                    <div class="font-bold"><?= $friend->frnd_occupation;?></div>

                </a>

            </div>
        </div>
        <?php

            }
            ?>



    </div>
</div>

<!-- script -->
<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
