<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-6 photos">
    <div class="row">
        <div id="errors_container"></div>
        <div class="panel panel-default photos-list">
            <div class="panel-heading">
                <h3 class="panel-title"><?=$data['user']['user_name']?>'s gallery</h3>
            </div>
            <div class="panel-body row" id="photos-list__container">
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
<script src="<?= ROOT_URI; ?>js/pages/photos-view.js"></script>
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
