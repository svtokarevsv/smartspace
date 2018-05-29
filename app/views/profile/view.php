<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>

<!-- Main Content-->
<div class="col-md-6">
    <div class="widget">
        <div class="widget-body bordered-top  bordered-sky">
            <!-- Start displaying name-->
            <div class="box-layout meta bottom">
                <div class="col-md-9 clearfix">
                    <span class="img-wrapper pull-left mt2 mr2">
                      <img src="<?=ROOT_URI . $data['student']->path?>" alt="avatar" style="width:64px" class="br-radius">
                    </span>
                    <div class="media-body">
                        <h3><?= $data['student']->first_name .' '.  $data['student']->last_name; ?></h3>
                        <h5><?= $data['student']->display_email ?></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="pull-right mt2">
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle btn btn-azure" href="#"
                               aria-expanded="false">More...<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?=ROOT_URI . 'friends/list/'. $data['student']->id?>">Friends List</a></li>
                                <li><a href="<?=ROOT_URI?>messages?receiver_id=<?=$data['student']->id;?>">Private
                                        message</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=ROOT_URI?>photos/view/<?=$data['student']->id;?>">Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--/ meta -->
            <!-- Start displaying profile-->
            <div class="row">
                <div class="col-md-12">
                    <div class="widget mb1">
                        <div class="widget-body bordered-top bordered-sky">
                            <ul class="list-unstyled profile-about margin-none">
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Birthday</span></div>
                                        <div class="col-sm-7"><?= $data['student']->dob ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Gender</span></div>
                                        <div class="col-sm-9"><?= $data['student']->gender ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Location</span></div>
                                        <div class="col-sm-9"><?= $data['geo_name']->city?><?= empty($data['geo_name']->city)?'':', ' ?><?= $data['geo_name']->country ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Education</span></div>
                                        <div class="col-sm-9"><?= $data['program_name']->program_name?><?= empty($data['program_name']->program_name)?'':', ' ?><?= $data['school_name']->school_name ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Work</span></div>
                                        <div class="col-sm-9"><?= $data['student']->occupation ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Website</span></div>
                                        <div class="col-sm-9"><?= $data['student']->website ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Description</span></div>
                                        <div class="col-sm-9"><?= $data['student']->description ?></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row center-block mb3">
                <div class="col-md-6 mb1">
                    <a href="<?=ROOT_URI?>resume/view/<?= $data['userId']?>">
                        <button type="button" class="btn btn-azure col-md-12">View <?= $data['student']->first_name; ?> <?= $data['student']->last_name; ?>&#39;s Resume</button>
                    </a>
                </div>
                <div class="col-md-6 mb1">
                    <a href="<?=ROOT_URI?>friends/list/<?=$data['userId']?>">
                        <button type="button" class="btn btn-azure col-md-12"><?= $data['student']->first_name; ?> <?= $data['student']->last_name; ?>&#39;s Friends</button>
                    </a>
                </div>
            </div>

        </div> <!-- end of widget body-->
    </div><!-- end of widget -->
</div><!-- end  main contents -->

<!-- End of Main Container -->


<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
