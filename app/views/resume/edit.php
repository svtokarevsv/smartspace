<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>


<!-- Main Content-->

    <div class="col-md-6">
        <div class="widget">
            <div class="widget-header">
                <h1 class="widget-caption">Edit Your Resume</h1>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <div class="row">                
                    <div class="col-md-12">
                        <div><!-- edit profile -->
                            <form method='post' action='Edit' class="was-validated" enctype="multipart/form-data">
                                    
                                <div class="col-lg-12 mb-5 form-group mb2">
                                    <label for="form__resume">Upload your Resume</label>
                                    <div class="col-xs-8 mb-5 input-group">
                                        <input type="file" name="form__resume">
                                        <?php foreach($data['errors'] as $err): ?>
                                        <p class="text-danger"><?= $err ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb3">
                                    <label for="resume__add_tag">Add Tags</label>
                                    <div class="col-md-12 text-muted mb1">
                                        Tags will be used for finding your resume by employers.
                                    </div>
                                    <p class="text-info bold">Only a-z, 0-9, underscores(_) are allowed.</p>
                                    <div class="input-group">
                                        <input type="text" id="resume__add_tag" class="form-control" name="resume__add_tag" placeholder="Type your keyword...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id="resume__submit_tag" name="resume__submit_tag">Add Tag</button>
                                        </span>
                                    </div>
                                    <div>
                                        <button class="btn btn-link" id="resume__clear_tag">Clear Tags</button>
                                    </div>
                                    <div>
                                        <ul id="resume__tag_list">
                                            
                                        </ul>
                                    </div>
                                    <div>
                                        <textarea id="resume__tags" name="resume__tags" class="hidden"></textarea>
                                    </div>

                                    <div class="row form-group">
                                        <input type="submit" value="Update" name='resume__submit' class="btn col-md-5 btn-azure pull-right">
                                    </div>
                                    <div class="row form-group">
                                        <input type="submit" value="Delete Resume" name='resume__delete' class="btn btn-link btn-sm pull-right">
                                    </div>
                                </div>
                            </form>    

                        </div><!-- end edit profile form -->
    
                    </div>
                </div>
            </div> <!-- end of widget body-->
        </div><!-- end of widget -->
    </div><!-- end  main contents -->
    
<!-- End of Main Container -->



<script src="<?=ROOT_URI;?>js/pages/resume-tags.js"></script>
<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
