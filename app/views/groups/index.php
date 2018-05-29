<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-9 groups">
    <div class="row">
        <div id="errors_container"></div>
        <div class="panel panel-default groups-list">
            <div class="panel-heading">
                <h3 class="panel-title">Your groups</h3>
                <a href="<?=ROOT_URI?>groups/list">View all groups</a>
                <button class="btn btn-primary" id="groups-list__new-group" data-toggle="modal" data-target="#create_group_modal">
                    Create new group
                </button>
            </div>
            <div class="panel-body row" id="groups-list__container">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create_group_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for creating a
group">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Create new group</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="create_group_form" method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="new_group_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="new_group_name" name="new_group_name"
                                   placeholder="Group name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_group_description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="new_group_description"
                                      placeholder="Group description..."
                                      name="new_group_description" maxlength="300"
                                      required
                            ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="group_image">Group avatar</label>
                        <div class="col-sm-10">
                            <input type="file" id="group_image" name="group_image" required>
                            <p class="help-block">Only jpeg,jpg and png formats supported</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="create_group">Create</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_group_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for creating a
group">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit group</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="edit_group_form" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="edit_group_id">
                    <div class="form-group">
                        <label for="edit_group_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit_group_name" name="edit_group_name"
                                   placeholder="Group name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_group_description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="edit_group_description"
                                      placeholder="Group description..."
                                      name="edit_group_description" required
                            ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="edit_group_image">Group avatar</label>
                        <div class="col-sm-10">
                            <input type="file" id="edit_group_image" name="edit_group_image" required>
                            <p class="help-block">Only jpeg,jpg and png formats supported</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="update_group">Update</button>
            </div>
        </div>
    </div>
</div>
<script src="<?=ROOT_URI;?>js/pages/groups.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
