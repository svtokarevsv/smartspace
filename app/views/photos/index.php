<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-9 photos">
    <div class="row">
        <div id="errors_container"></div>
        <div class="panel panel-default photos-list">
            <div class="panel-heading">
                <h3 class="panel-title">Your gallery</h3>
                <button class="btn btn-primary" id="photos-list__new-group" data-toggle="modal"
                        data-target="#create_image_modal">
                    + Add new image
                </button>
            </div>
            <div class="panel-body row" id="photos-list__container">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create_image_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for adding an image">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add new image to the gallery</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="add_image_form" method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image_title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="image_title" name="image_title"
                                   placeholder="Image title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="gallery_image">Image</label>
                        <div class="col-sm-10">
                            <input type="file" id="gallery_image" name="gallery_image" required>
                            <p class="help-block">Only jpeg,jpg and png formats supported</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add_image">Add</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view_image_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for viewing an image">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="view_image__title"></h4>
            </div>
            <div class="">
                <img id="view_image__photo" src="" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_image_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for deleting an
image">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Are you sure you want to delete this image?</h4>
            </div>
            <div class="modal-body">
                <span>This image will be deleted from your gallery</span>
                <form class="form-horizontal" id="delete_image_form" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="delete_image_id" id="delete_image_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-azure" id="delete_image">Delete</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= ROOT_URI; ?>js/pages/photos.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
