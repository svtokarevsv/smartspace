<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>


    <!-- Begin page content -->
    <!-- time line events-->
    <div class="col-md-6 mb2">
        <div class="row">
            <div class="container">

                <div id="events_details" class="col-md-6" style="background-color: white">
                    <div>
                        <img src="<?=ROOT_URI.$data['event']['imgpath'] ?>" style="display: block;
    margin: 0 auto;padding-top: 12px" />
                    </div>
                    <div class="text-center text-primary">
                        <p class="text-muted text-right mt2">Posted by:
                            <a href="<?=ROOT_URI?><?=$data['event']['role_id']===1?
                                'profile':'businessprofile' ?>/view/<?=$data['event']['userid']?>">
                                <?php echo $data['event']['user_name'] ?>
                            </a>
                        </p>
                    </div>
                    <div class="text-center text-primary">
                        <h3>
                            <span><?php echo $data['event']['event_name'] ?></span>
                        </h3>
                    </div>
                    <div class="text-center">
                        <h3>
                            <span class="text-primary">at </span>
                            <span><?php echo $data['event']['event_location'] ?></span>
                        </h3>
                    </div>
                    <div style="display: flex; justify-content: space-evenly">
                        <h5>
                            <span>From:</span>
                            <span><?php echo $data['event']['event_start'] ?></span>
                            <span class="text-muted" style="margin:0 5px"><?php echo 'at' ?></span>
                            <span><?php echo $data['event']['event_start_time'] ?></span>
                        </h5>
                        <h5>
                            <span>To:</span>
                            <span><?php echo $data['event']['event_end'] ?></span>
                            <span class="text-muted" style="margin:0 5px"><?php echo 'till' ?></span>
                            <span><?php echo $data['event']['event_end_time'] ?></span>
                        </h5>
                    </div>
                    <br />
                    <div class="text-left">
                        <p>
                            <span><?php echo $data['event']['event_description'] ?></span>
                        </p>
                    </div>
                    <span class="right"><a class="btn btn-azure" style="margin-bottom: 10px" id="details" href="<?php echo ROOT_URI.'events' ?>" >Back</a></span>
                </div>
            </div>
        </div>
    </div><!-- clo-md-6 -->
    <!-- end time line events-->


    <script src="<?= ROOT_URI; ?>js/pages/events.js"></script>


<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>