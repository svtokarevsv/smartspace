<?php include VIEWS_PATH . DS . '_shared' . DS . 'header.php' ?>
<?php include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php' ?>


<!-- Begin page content -->
<!--============= timeline/ News Feed posts[posts of user and friends]-->
<div class="col-md-6">
    <div class="row">
        <!-- display errors-->
        <div id="errors_container"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="box profile-info">
                        <!-- create a post using text message and picture and both-->
                        <form class="form-horizontal" id="create_post_form" method="post"
                              enctype="multipart/form-data">
                            <textarea class="form-control input-lg p-text-area" name="new_post_message" rows="3"
                                      placeholder="Whats in your mind today?" required></textarea>

                            <div class="box-footer box-form">
                                <button type="button" id="create_post" class="btn posts-btn pull-right">Make a Post
                                </button>
                                <ul class="nav nav-pills">
                                    <li><label class="col-sm-2  control-label" for="post_image"><a><i
                                                    style="pointer-events: none;"
                                                    class="fa fa-camera"></i></a></label>
                                    <li>
                                    <li><span id="show_image_path" style="color: #2dc3e8;"></span></li>
                                    <div class="col-sm-8 upload-image-label">
                                        <input type="file" id="post_image" name="post_image" required/>
                                    </div>
                                    </li>
                                </ul>

                            </div>
                        </form>
                    </div><!-- end post state form -->

                    <!--view all posts-->
                    <div class="feed-list">
                        <div id="feed-list__container">
                        </div>
                    </div>
                    <!-- loading icon-->
                    <div class="loader" id="loader"></div>
                </div>
            </div>
        </div><!--col-md-12-->
        <!--   posts -->
    </div><!--row div-->
</div><!-- col-md-6 -->
<!-- end timeline posts-->

<!-- script-->
<script src="<?= ROOT_URI; ?>js/pages/feed.js"></script>
<script src="<?= ROOT_URI; ?>js/_shared/comments.js"></script>

<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>

