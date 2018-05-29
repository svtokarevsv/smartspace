<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header_login.php';
?>

<div class="wrapper authorization">
    <div class="parallax filter-black">
        <div class="parallax-image"></div>
        <div class="small-info">
            <div class="row center">
                <img class="authorization__logo" src="img/logo.svg">
            </div>
            <div class="col-sm-10 col-sm-push-1 col-md-6 col-md-push-3 col-lg-6 col-lg-push-3">
                <div class="card-group animated flipInX">
                    <div class="card">
                        <div class="card-block">
                            <div class="center">
                                <h4 class="m-b-0"><span class="icon-text">Login</span></h4>
                                <p class="text-muted">Access your account</p>
                            </div>
                            <form action="" method="post">
                                <div class="alert-warning">
                                    <?= $data['errors']['login']['email'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email_login" class="form-control" value="lee@mail.ru"
                                           placeholder="Email Address">


                                    <!-- --><?php //if ($data['errors']['login']['fname']){
                                    //      echo $data['errors']['login']['fname'];
                                    //     }else{
                                    //      echo '';
                                    //     }
                                    //      ?>
                                    <!-- --><? //=$data['errors']['login']['fname']?$data['errors']['login']['fname']:''?>


                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['login']['password'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_login" class="form-control" value="12345"
                                           placeholder="Password">
                                </div>
                                <div class="alert-danger">
                                    <?= $data['errors']['login']['email&password'] ?? '' ?>
                                </div>
                                <div class="center">
                                    <button class="btn  btn-azure">Log In</button>
                                </div>
                                <div>
                                    <p>or Login with your Facebook account</p>
                                </div>
                                <div class="center">
                                    <fb:login-button
                                            scope="public_profile,email"
                                            onlogin="checkLoginState();">
                                    </fb:login-button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block center">
                            <h4 class="m-b-0">
                                <span class="icon-text">Sign Up</span>
                            </h4>
                            <p class="text-muted">Create a new account</p>
                            <form action="" method="post">
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['fname'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="f_name_registration" class="form-control"
                                           placeholder="First Name">
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['lname'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="l_name_registration" class="form-control"
                                           placeholder="Last Name">
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['occupation'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <select name="occupation_registration" class="form-control">
                                        <option value="">Select occupation</option>
                                        <option value="1">Student</option>
                                        <option value="2">Employer</option>
                                    </select>
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['gender'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <select name="gender_registration" class="form-control">
                                        <option value="">Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['email'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email_registration" class="form-control"
                                           placeholder="Email">
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['password'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_registration" class="form-control"
                                           placeholder="Password">
                                </div>
                                <div class="alert-warning">
                                    <?= $data['errors']['registration']['confirm_password'] ?? '' ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password_registration" class="form-control"
                                           placeholder="Confirm Password">
                                </div>
                                <button type="submit" class="btn btn-azure">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include VIEWS_PATH . DS . '_shared' . DS . 'footer_login.php';
    ?>

