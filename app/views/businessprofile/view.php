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
                <div class="col-md-8 clearfix">
                    <span class="img-wrapper pull-left mt2 mr2">
                      <img src="<?=ROOT_URI?><?= $data['employer']->path?>" alt="avatar" style="width:64px" class="br-radius">
                    </span>
                    <div class="media-body">
                        <h3><?= $data['employer']->first_name; ?> <?= $data['employer']->last_name; ?></h3>
                        <p><?= $data['employer']->email ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pull-right mt2">
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle btn btn-azure" href="#" aria-expanded="false"> More... <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?=ROOT_URI . 'friends/list/'. $data['student']->id?>">Friends List</a></li>
                                <li><a href="<?=ROOT_URI?>messages?receiver_id=<?=$data['student']->id;?>">Private message</a></li
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--/ end displaying name -->
            <!-- Start displaying profile-->
            <div class="row">
                <div class="col-md-12">
                    <div class="widget mb1">
                        <div class="widget-body bordered-top bordered-sky">
                            <ul class="list-unstyled profile-about margin-none">
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Location</span></div>
                                        <div class="col-sm-7"><?= $data['employer']->city?><?= empty($data['employer']->city)?'':', ' ?><?= $data['employer']->country ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Company</span></div>
                                        <div class="col-sm-9"><?= $data['employer']->company_name ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Website</span></div>
                                        <div class="col-sm-9"><a href="<?= $data['employer']->website ?>"><?= $data['employer']->website ?></a></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Description</span></div>
                                        <div class="col-sm-9"><?= $data['employer']->description ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Industry</span></div>
                                        <div class="col-sm-9"><?= $data['employer']->industry ?></div>
                                    </div>
                                </li>
                                <li class="padding-v-5">
                                    <div class="row">
                                        <div class="col-sm-3"><span class="text-muted bold">Company's email Address</span></div>
                                        <div class="col-sm-8"><?= $data['employer']->display_email ?></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!-- end displaying profile -->
            <?php
            ?>
            <div class="box-body">
                <h4>Available job positions</h4>
                <?php foreach ($data['jobs'] as $value) {
                    $job_id = $value->id;
                    echo "<h5 class='lead mb1 text-muted bold'> " . $value->title. "</h5>";
                    echo "<div class='row padding-v-5'>
                            <div class='col-sm-3 text-muted bold'>Description: </div>
                            <div class='col-sm-9'>$value->description</div>
                          </div>
                          <div class='row padding-v-5'>
                            <div class='col-sm-3 text-muted bold'>Status:</div>
                            <div class='col-sm-9'>$value->status</div>
                          </div>";
                    if ($value->date_posted !== null) {
                        $dt = new DateTime($value->date_posted);
                        echo "<div class='row padding-v-5'>
                          <div class='col-sm-3 text-muted bold'>Date posted:</div>
                          <div class='col-sm-9'>" . $dt->format('Y-m-d') . "</div>
                          </div>";
                    }
                    if ($value->date_closed !== null) {
                        echo "<div class='row padding-v-5'>
                          <div class='col-sm-3 text-muted bold'>Date closed:</div>
                          <div class='col-sm-9'>$value->date_closed</div>
                          </div>";
                    }
                    echo "<div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>Salary:</div>
                        <div class='col-sm-9'>$value->salary</div>
                      </div>
                      <div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>Industry:</div>
                        <div class='col-sm-9'>$value->industry</div>
                      </div>
                      <div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>Country:</div>
                        <div class='col-sm-9'>$value->country</div>
                      </div>
                      <div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>City:</div>
                        <div class='col-sm-9'>$value->city</div>
                      </div>";
                }
                ?>
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
