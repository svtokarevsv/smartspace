<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
$current_user=$_SESSION['current_user'];
?>
    <!-- Begin page content -->
    <!--============= timeline posts-->
    <div class="container col-md-6 ">
        <div class="row">
            <div class="box profile-info">
                <!-- create posts-->
                <form class="form-horizontal" id="create_post_form" method="post" enctype="multipart/form-data">
                    <textarea class="form-control input-lg p-text-area" rows="3" name="new_post_message" placeholder="Whats in your mind today?"></textarea>

                    <div class="box-footer">
                        <button type="button"  id="create_post" class="btn posts-btn pull-right">Make a Post</button>
                        <ul class="nav nav-pills">
                            <li><label class="col-sm-2  control-label" for="post_image"><a><i
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
            </div>
            <!-- posts container-->
            <div class="posts-list">
                <div id="posts-list__container">
                </div>
            </div>
            <!-- loading icon-->
            <div class="loader" id="loader"></div>


        </div>
    </div>

    <!-- modal for update -->
    <div class="modal fade" id="edit_post_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for editing a
        post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="edit_post_form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="edit_post_id">
                        <div class="form-group">
                            <label for="edit_post_message" class="col-sm-2 control-label">Message</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_post_message" name="edit_post_message"
                                       placeholder="message.." required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2  control-label" for="edit_post_image">Image</label>
                            <div class="col-sm-8 edit-post-image">
                                <input type="file" id="edit_post_image" name="edit_post_image" required/>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-azure" id="update_post">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!--modal for delete-->
    <div class="modal fade" id="delete_post_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for deleting a
post">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete this Post?</h4>
                </div>
                <div class="modal-body">
                    <span>This post will be deleted and you won't be able to find it anymore. You can also edit this post, if you just want to change something.</span>
                    <form class="form-horizontal" id="delete_post_form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="delete_post_id">
                        <div class="form-group">
                            <label for="delete_post_message" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="delete_post_message"
                                       name="delete_post_message"
                                       placeholder="message.." required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-azure" id="delete_post">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- script-->
    <script src="<?= ROOT_URI; ?>js/pages/posts.js"></script>
    <script src="<?= ROOT_URI; ?>js/_shared/comments.js"></script>


<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>