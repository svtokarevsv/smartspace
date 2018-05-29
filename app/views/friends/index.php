
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>



<?php
$current_user=$_SESSION['current_user'];
?>

<!-- Begin page content -->

<div class="row col-md-9">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="m-t-xs btn-group pull-right mb2">
                    <a  href="" class="btn btn-md btn-white "><i class="fa fa-fw fa-users "></i> Friends</a>
                    <a  href="<?=ROOT_URI?>friends/requests" class="btn btn-md btn-white "><i class="fa fas fa-user-plus "></i> Friend Requests</a>
                    <a  href="<?=ROOT_URI?>friends/find" class="btn btn-md btn-white "><i class="fa fas fa-search-plus"></i>Find Friends</a>
                </div>
            </div>
        </div>
        <!-- friends list-->
        <div id="friend-list__container"></div>
    </div>
    <!-- modal for unfriend option -->
    <div class="modal fade" id="remove_frnd_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for deleting a
friend">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to Unfriend from friend list?</h4>
                </div>
                <div class="modal-body">
                    <span>This friend will be deleted from your friend list and you won't be able to communicate anymore.</span>
                    <form class="form-horizontal" id="remove_frnd_form" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="remove_frnd_id">

                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-azure" id="remove_frnd">UnFriend</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= ROOT_URI; ?>js/pages/friends.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>