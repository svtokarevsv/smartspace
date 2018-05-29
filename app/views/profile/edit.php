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
                                    
                                <div class="col-lg-12 form-group">
                                    <label for="form__picture">Profile Picture</label>
                                    <div class="col-xs-8 input-group">
                                        <input type="file" name="form__profile_pic">
                                    </div>
                                </div>
    
                                <div class="col-lg-6 form-group <?= !empty($data['errors']['fnErrMsg'])?'has-error':'' ?>">
                                    <label for="form__fname">First Name*</label>
                                    <input type="text" class="form-control" id="form__fname" name='form__fname' placeholder="First Name" value="<?= $data['student']->first_name; ?>">
                                    <div class="text-danger"><?= $data['errors']['fnErrMsg']??'' ?></div>
                                </div>
                                <div class="col-lg-6 form-group <?= !empty($data['errors']['lnErrMsg'])?'has-error':'' ?>">
                                    <label for="form__lname">Last Name*</label>
                                    <input type="text" class="form-control" id="form__lname" name="form__lname" placeholder="Last Name" value="<?= $data['student']->last_name; ?>">
                                    <div class="text-danger"><?= $data['errors']['lnErrMsg']??'' ?></div>
                                </div>
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['dobErrMsg'])?'has-error':'' ?>">
                                    <label for="form__dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="form__dob" name="form__dob" value="<?= $data['student']->dob; ?>">
                                    <div class="text-danger"><?= $data['errors']['dobErrMsg']??'' ?></div>
                                </div>
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['genderErrMsg'])?'has-error':'' ?>">
                                <label for="form__gender">Gender*</label>
                                    <div class="row col-lg-12">
                                        <div class="form-check col-md-4 col-sm-4 col-xs-12">
                                            <div class="radio">
                                                <label><input type="radio" name="form__gender" value="Female" <?= $data['student']->gender=='Female'?'checked':'' ?>><span class="text">Female</span></label>
                                            </div>
                                        </div>
                                        <div class="form-check col-md-4 col-sm-4 col-xs-12">
                                            <div class="radio">
                                                <label><input type="radio" name="form__gender" value="Male" <?php echo $data['student']->gender=='Male'?'checked':'' ?>><span class="text">Male</span></label>
                                            </div>
                                        </div>
                                        <div class="form-check col-md-4 col-sm-4 col-xs-12">
                                            <div class="radio">
                                                <label><input type="radio" name="form__gender" value="Other" <?php echo $data['student']->gender=='Other'?'checked':'' ?>><span class="text">Other</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-danger"><?= $data['errors']['genderErrMsg']??'' ?></div>
                                </div>
    

                                <div class="col-lg-7 form-group">
                                    <label for="form__school">Find your School by Country</label>
                                    <select class="form-control" id="form__schoolLoc" name="form__schoolLoc">
                                       <option>-- Select Location --</option>
                                        <?php foreach($data['countries'] as $c): ?>
                                            <option value='<?=$c->id ?>' <?= $data['current_school']->country_id===$c->id?'selected':''?>><?= $c->country ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                      

                                <div class="col-lg-5 form-group <?= !empty($data['errors']['schoolErrMsg'])?'has-error':'' ?>">
                                    <label for="form__school">Current School</label>
                                    <select class="form-control" id="form__school" name="form__school">
                                        <option value='' <?= isset($data['student']->school_id)?'':'selected'?> >-- Select your school --</option>           
                                       <?php foreach($data['schools'] as $s): ?>
                                            <option value='<?=$s->id ?>' <?= $data['student']->school_id==$s->id?'selected':''?> ><?= $s->school_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="text-danger"><?= $data['errors']['schoolErrMsg']??'' ?></div>
                                </div>                      
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['programErrMsg'])?'has-error':'' ?>">
                                    <label for="form__program">Current Program</label>
                                    <select class="form-control" id="form__program" name="form__program">
                                        <option value='' <?= isset($data['student']->program_id)?'':'selected'?> >-- Select your program --</option>
                                        <?php foreach($data['programs'] as $p): ?>
                                            <option value='<?=$p->id ?>' <?= $data['student']->program_id==$p->id?'selected':''?> ><?= $p->program_name ?></option>                                        
                                        <?php endforeach; ?>

                                    </select>
                                    <div class="text-danger"><?= $data['errors']['programErrMsg']??'' ?></div>
                                </div>
                                    <div class="text-danger"><?= $data['errors']['workErrMsg']??'' ?></div>
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['workErr'])?'has-error':'' ?>">
                                    <label for="form__work">Other Occupation</label>
                                    <input type="text" class="form-control" id="form__work" name="form__work" placeholder="Current work" value="<?= $data['student']->occupation ?>">
                                    <div class="text-danger"><?= $data['errors']['workErrMsg']??'' ?></div>
                                </div>
    
                                
                                <div class="col-lg-7 form-group">
                                    <label for="form__country">Country</label>
                                    <select class="form-control" id="form__country" name="form__country">
                                        <option value='' >-- Select your country of residence --</option>
                                        <?php foreach($data['countries'] as $c): ?>
                                            <option value='<?=$c->id ?>' <?= $data['student']->country_id==$c->id?'selected':''?> ><?= $c->country ?></option>
                                        <?php endforeach; ?>
                                    </select>                               
                                    <div class="text-danger"><?= $data['errors']['countryErrMsg']??'' ?></div>
                                </div>

                                <div class="col-lg-5 form-group <?= !empty($data['errors']['cityErrMsg'])?'has-error':'' ?>">
                                    <label for="form__city">City</label>
                                    <select class="form-control" id="form__city" name="form__city">
                                        <option value='' <?= isset($data['student']->city_id)?'':'selected'?> >-- Select your city of residence --</option>
                                        <?php foreach($data['cities'] as $c): ?>
                                            <option value='<?=$c->id ?>' <?= $data['student']->city_id==$c->id?'selected':''?> ><?= $c->city ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="text-danger"><?= $data['errors']['cityErrMsg']??'' ?></div>
                                </div>
    
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['emailErrMsg'])?'has-error':'' ?>">
                                    <label for="form__email">Email Address</label>
                                    <input type="text" class="form-control" id="form__email" name="form__email" placeholder="myContact@email.com" value="<?= $data['student']->display_email; ?>">
                                    <div class="text-danger"><?= $data['errors']['emailErrMsg']??'' ?></div>
                                </div>
                                <div class="col-lg-12 form-group <?= !empty($data['errors']['webErrMsg'])?'has-error':'' ?>">
                                    <label for="form__web">Website</label>
                                    <input type="text" class="form-control" id="form__web" name="form__web" placeholder="http://myWebsite.com" value="<?= $data['student']->website; ?>">
                                    <div class="text-danger"><?= $data['errors']['webErrMsg']??'' ?></div>
                                </div>
    
                                    <div class="text-danger"><?= $data['errors']['dscrErrMsg']??'' ?></div>
                                    <div class="col-lg-12 form-group <?= !empty($data['errors']['dscrErr'])?'has-error':'' ?>">
                                    <label for="form__dscr">Description</label>
                                    <textarea class="form-control" id="form__dscr" name="form__dscr" rows="2" ><?= $data['student']->description; ?></textarea>
                                    <div class="text-danger"><?= $data['errors']['dscrErrMsg']??'' ?></div>
                                </div>
    
                                <div class="col-lg-12 form-group">
                                    <input type="submit" value="Update" name='form__submit' class="btn col-xs-5 btn-azure pull-right">
                                </div>
                            </form>    
                        </div><!-- end edit profile form -->
                    </div>
                </div>
            </div> <!-- end of widget body-->
        </div><!-- end of widget -->
    </div><!-- end  main contents -->
    
<!-- End of Main Container -->

<script src="<?=ROOT_URI;?>js/pages/profile.js"></script>
<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
