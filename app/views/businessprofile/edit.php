<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>



<!-- Main Content-->

<div class="col-md-6">
    <div class="widget">
        <div class="widget-header">
            <h1 class="widget-caption">Edit Your Profile</h1>
        </div>
        <div class="widget-body bordered-top bordered-sky">
            <div class="row">
                <div class="col-md-12">
                    <div><!-- edit profile -->
                        <p class="col-lg-12 text-success"><?= $data['successMsg'] ?></p>
                        <form method='post' action='Edit' class="was-validated" enctype="multipart/form-data">

                            <div class="col-lg-12 mb-5 form-group">
                                <label for="form__picture">Profile Picture</label>
                                <div class="col-xs-8 mb-5 input-group">
                                    <input type="file" name="form__profile_pic">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-5 form-group <?= !empty($data['errors']['fnErrMsg'])?'has-error':'' ?>">
                                <label for="form__fname"><span class="text-danger">* </span>First Name</label>
                                <input type="text" class="form-control" id="form__fname" name='form__fname' placeholder="First Name" value="<?= $data['employer']->first_name; ?>">
                                <div class="text-danger"><?= $data['errors']['fnErrMsg']??'' ?></div>
                            </div>
                            <div class="col-lg-6 mb-5 form-group <?= !empty($data['errors']['lnErrMsg'])?'has-error':'' ?>">
                                <label for="form__lname"><span class="text-danger">* </span>Last Name</label>
                                <input type="text" class="form-control" id="form__lname" name="form__lname" placeholder="Last Name" value="<?= $data['employer']->last_name; ?>">
                                <div class="text-danger"><?= $data['errors']['lnErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['emailErrMsg'])?'has-error':'' ?>">
                                <label for="form__email"><span class="text-danger">* </span>Personal email</label>
                                <input type="text" class="form-control" id="form__email" name="form__email" placeholder="myContact@email.com" value="<?= $data['employer']->email; ?>">
                                <div class="text-danger"><?= $data['errors']['emailErrMsg']??'' ?></div>
                            </div>
                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['websiteErrMsg'])?'has-error':'' ?>">
                                <label for="form__website">Website</label>
                                <input type="text" class="form-control" id="form__website" name="form__website" placeholder="http://companywebsite.com" value="<?= $data['employer']->website; ?>">
                                <div class="text-danger"><?= $data['errors']['websiteErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-7 mb-5 form-group">
                                <label for="form__country">Country</label>
                                <select class="form-control" id="form__country" name="form__country">
                                    <option value='' <?= isset($data['employer']->country_id)?'':'selected'?> >-- Select your company country --</option>
                                    <?php foreach ($data['countries'] as $item) {
                                        echo "<option value='" . $item->id . "'" . (($data['employer']->country_id == $item->id)? "selected" : "") . ">" . $item->country . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= $data['errors']['countryErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-5 mb-5 form-group <?= !empty($data['errors']['cityErrMsg'])?'has-error':'' ?>">
                                <label for="form__city">City</label>
                                <select class="form-control" id="form__city" name="form__city">
                                    <option value='' <?= isset($data['employer']->city_id)?'':'selected'?> >-- Select your company city --</option>
                                    <?php
                                    foreach ($data['cities'] as $item) {
                                        echo "<option value='" . $item->id . "'" . (($data['employer']->city_id == $item->id)? "selected" : "") . ">" . $item->city . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= $data['errors']['cityErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['descriptionErr'])?'has-error':'' ?>">
                                <label for="form__description">Description</label>
                                <textarea class="form-control" id="form__description" name="form__description" rows="2" ><?= $data['employer']->description; ?></textarea>
                                <div class="text-danger"><?= $data['errors']['descriptionErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['companyErr'])?'has-error':'' ?>">
                                <label for="form__company">Company name</label>
                                <input type="text" class="form-control" id="form__company" name="form__company" placeholder="Your company name" value="<?= $data['employer']->company_name; ?>">
                                <div class="text-danger"><?= $data['errors']['companyErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['industryErr'])?'has-error':'' ?>">
                                <label for="form__industry">Industry: </label>
                                <select class="form-control" name="form__industry" id="form__industry">
                                    <option value='' <?= isset($data['employer']->industry_id)?'':'selected'?> >-- Select your company's industry --</option>
                                    <?php foreach ($data['industries'] as $item) {
                                        echo "<option value='" . $item->id . "'" . (($data['employer']->industry_id == $item->id)? "selected" : "") . ">" . $item->industry . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= $data['errors']['industryErrMsg']??'' ?></div>
                            </div>

                            <div class="text-danger"><?= $data['errors']['displayEmailErrMsg']??'' ?></div>
                            <div class="col-lg-12 mb-5 form-group <?= !empty($data['errors']['displayEmailErr'])?'has-error':'' ?>">
                                <label for="form__displayEmail">Company's email</label>
                                <input type="text" class="form-control" id="form__displayEmail" name="form__displayEmail" placeholder="companyContact@email.com" value="<?= $data['employer']->display_email; ?>">
                                <div class="text-danger"><?= $data['errors']['displayEmailErrMsg']??'' ?></div>
                            </div>

                            <div class="col-lg-12 mb-5 form-group">
                                <button class="btn col-xs-5 btn-azure pull-right" name="form__submit">Update</button>
                            </div>
                            <div class="text-right mr2">
                            <a href="<?=ROOT_URI?>businessprofile">Back to profile</a>
                            </div>
                        </form>
                    </div><!-- end edit profile form -->
                </div>
            </div>
        </div> <!-- end of widget body-->
    </div><!-- end of widget -->
</div><!-- end  main contents -->

<!-- End of Main Container -->

<script src="<?=ROOT_URI;?>js/pages/business-profile.js"></script>
<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
