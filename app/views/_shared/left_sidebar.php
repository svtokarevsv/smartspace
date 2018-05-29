<!-- left links -->
<?php
$current_user=$_SESSION['current_user'];
$controller_name=strtolower(\App\lib\App::getRouter()->getControllerName());
?>
<div class="col-md-3">
    <div class="profile-nav left-sidebar">
        <div class="widget">
            <div class="widget-body">
                <div class="user-heading round">
                    <button type="button" class="btn btn-azure button-random-info" title="bored?">🤔</button>
                    <a href="<?= ROOT_URI ?>profile">
                        <img src="<?= ROOT_URI.$current_user['path'] ?>"
                             alt="<?=$current_user['first_name'] . ' ' .
                             $current_user['last_name'] ??'User' ?>">
                    </a>

                    <h1><a href="<?=ROOT_URI?>posts"><?=$current_user['first_name'] . " " .
                            $current_user['last_name'] ??'User' ?></a></h1>

                </div>
                <ul class="nav nav-pills nav-stacked">
                    <?php if($current_user['role_id'] === "2"): ?>
                        <li class="<?=$controller_name==='jobs'?'active':null ?>"><a href="<?= ROOT_URI ?>jobs"> <i class="fa fa-briefcase"></i> Job List </a></li>
                    <?php endif; ?>
                    <li class="<?=$controller_name==='feed'?'active':null ?>"><a href="<?= ROOT_URI ?>"> <i class="fa
                    fa-user"></i>News
                            feed</a></li>
                    <li class="<?=$controller_name==='messages'?'active':null ?>">
                        <a href="<?= ROOT_URI ?>messages">
                            <i class="fa fa-envelope"></i>Messages
                            <span class="label label-info pull-right r-activity new-message-notification"></span>
                        </a>
                    </li>
                    <li class="<?=$controller_name==='posts'?'active':null ?>"><a href="<?= ROOT_URI ?>posts"><i class="fa fa-newspaper-o"></i>My posts</a></li>
                    <li class="<?=$controller_name==='groups'?'active':null ?>"><a href="<?= ROOT_URI ?>groups"><i class="fa fa-users"></i>Groups</a></li>
                    <li class="<?=$controller_name==='events'?'active':null ?>"><a href="<?= ROOT_URI ?>events"><i class="fa fa-calendar"></i>Events</a></li>
                    <li class="<?=$controller_name==='photos'?'active':null ?>"><a href="<?= ROOT_URI ?>photos"><i class="fa fa-image"></i>Photos</a></li>
                    <li class="<?=$controller_name==='location'?'active':null ?>"><a href="<?= ROOT_URI ?>location">
                            <i class="fa fa-map-marker"></i>Location sharing</a></li>
                    <!--                    <li><a href="-->
                    <? //=ROOT_URI?><!--groups">> <i class="fa fa-share"></i> Browse</a></li>-->
                    <!--                    <li><a href="#"> <i class="fa fa-floppy-o"></i> Saved</a></li>-->
                    <li>
                        <a href="<?= ROOT_URI ?>logout"><i class="fa fa-sign-out"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><!-- end left links -->
<div class="modal fade" id="interesting_fact_modal" tabindex="-1" role="dialog" aria-labelledby="Modal with
interesting facts">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="interesting_fact__heading">Did you know that?</h4>
            </div>
            <div class="modal-body">
                <p class="interecting_fact__paragraph" id="interecting_fact__paragraph"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Good to know!</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= ROOT_URI; ?>js/_shared/left_sidebar.js"></script>
