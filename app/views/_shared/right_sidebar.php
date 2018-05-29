<!-- right posts -->
<div class="col-md-3 right-sidebar">

    <?php
    if ($_SESSION['current_user']['role_id'] === "1") {
        ?>
        <!-- Friends activity -->
        <div class="widget">
            <div class="widget-header">
                <h3 class="widget-caption">Friends activity</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <div class="card">
                    <div class="content">
                        <ul class="list-unstyled team-members" id="friends_posts">
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- End Friends activity -->
        <?php
    } else if ($_SESSION['current_user']['role_id'] === "2") {
        ?>
        <div class="widget">
            <div class="widget-header">
                <h3 class="widget-caption">Search student</h3>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <form id="search_by_tag_form" class="form-inline text-center">
                    <div class="form-group">
                        <label for="search_by_tag"><span class="hidden">Search</span></label>
                        <input type="text" class="form-control" id="search_by_tag" name="search_by_tag"
                               value="<?=$_GET['search_term']??'' ?>"
                               placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-azure fa fa-search"><span class="hidden">Go</span></button>
                </form>
                <div id="search_by_tag_result">
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- People You May Know -->
 <!--   <div class="widget">
        <div class="widget-header">
            <h3 class="widget-caption">People You May Know</h3>
        </div>
        <div class="widget-body bordered-top bordered-sky">
            <div class="card">
                <div class="content">
                    <ul class="list-unstyled team-members">
                        <li>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="avatar">
                                        <img src="img/Friends/bird.jpg" alt="Circle Image"
                                             class="img-circle img-no-padding img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    Carlos marthur
                                </div>

                                <div class="col-xs-3 text-right">
                                    <button class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="avatar">
                                        <img src="img/Friends/bird.jpg" alt="Circle Image"
                                             class="img-circle img-no-padding img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    Maria gustami
                                </div>

                                <div class="col-xs-3 text-right">
                                    <button class="btn btn-sm btn-azure btn-icon"><i class="fa fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="avatar">
                                        <img src="img/Friends/bird.jpg" alt="Circle Image"
                                             class="img-circle img-no-padding img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    Angellina mcblown
                                </div>

                                <div class="col-xs-3 text-right">
                                    <button class="btn btn-sm btn-azure btn-icon"><i class="fa
                                    fa-user-plus"></i></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->
    <!-- End people yout may know -->


    <!-- Task List -->
    <div class="widget">
        <div class="widget-header">
            <h3 class="widget-caption">Tasks</h3>
        </div>
        <div class="widget-body bordered-top bordered-sky">
            <div class="card">
                <div class="content">
                    <ul id="right__task_list" class="list-unstyled">
                        <!-- output from js -->
                    </ul>
                </div>

                <div class="mb2">
                    <a href="<?= ROOT_URI ?>task">
                        <button class="btn btn-link btn-icon"><i class="fa fa-edit"></i>
                            View More...</button>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- End task list -->


</div><!-- end right posts -->
<!--modal for showing post-->
<div class="modal fade" id="view_post_modal" tabindex="-1" role="dialog" aria-labelledby="Modal for deleting a
post">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabel"><span id="show_post__author"></span> shared this
                    publication <span id="show_post__date"></span></h4>
            </div>
            <div class="modal-body">
                <div class="box-body" style="display: block;">
                    <div id="show_post__message"></div>
                    <div class="image-body " id="show_post__image"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= ROOT_URI; ?>js/_shared/right_sidebar.js"></script>
<script src="<?= ROOT_URI; ?>js/pages/task.js"></script>