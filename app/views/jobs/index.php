<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-6 job">
    <div class="box box-widget">
        <div class="box box-header">
            <h2 class="job__title">Your job postings</h2>
            <a href="<?=ROOT_URI?>jobs/create" class="btn btn-default">Add a Job Posting</a>
        </div>

        <div class="box-body" id="job-list">


        <!-- Confirm delete modal -->
        </div>
        <div class="loader" id="loader"></div>

        <div class="modal fade" id="job__delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmation">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete job posting</h4>
                    </div>
                    <div class="modal-body">
                        <form id="job__delete-form">
                            <input type="hidden" id="job__delete-id" name="job__delete-id" value="" />
                        </form>
                        Are you sure you want to delete this job posting?
                    </div>
                    <div class="modal-footer">
                        <button id='job__delete-button' type="button" class="btn btn-default">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit modal -->
        <div class="modal fade" id="job__edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit job">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit job posting</h4>
                    </div>
                    <div class="modal-body">
                        <form id="job__edit-form">
                            <input type="hidden" id="job__edit-id" name="job__edit-id" value="" />



                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-title"><span class="text-danger">* </span>Title: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="job__edit-title" id="job__edit-title" placeholder="Job title..." value="">
                                    <span class="text-danger"><?= $data['errors']['titleErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-description"><span class="text-danger">* </span>Description: </label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="job__edit-description" id="job__edit-description" placeholder="Job description..." value=""></textarea>
                                    <span class="text-danger"><?= $data['errors']['descriptionErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-type"><span class="text-danger">* </span>Type: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="job__edit-type" id="job__edit-type" placeholder="Full time/Part time" value="">
                                    <span class="text-danger"><?= $data['errors']['typeErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-dateclosed">Date closed: </label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="job__edit-dateclosed" id="job__edit-dateclosed" value="">
                                    <span class="text-danger"><?= $data['errors']['dateClosedErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-salary"><span class="text-danger">* </span>Salary: </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="job__edit-salary" id="job__edit-salary" placeholder="Job salary..." value="">
                                    <span class="text-danger"><?= $data['errors']['salaryErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-industry"><span class="text-danger">* </span>Industry: </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="job__edit-industry" id="job__edit-industry">
                                        <option value=''>- Please select your job industry -</option>
                                        <?php
                                        foreach ($data['industries'] as $item) {
                                            echo "<option value='" . $item->id . "'>" . $item->industry . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['industryErr']?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-country">Country: </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="job__edit-country" id="job__edit-country">
                                        <option value=''>- Please select your job location -</option>
                                        <?php
                                        foreach ($data['countries'] as $item) {
                                            echo "<option value='" . $item->id . "'>" . $item->country . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-lg-offset-1 text-right" for="job__edit-city"><span class="text-danger">* </span>City: </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="job__edit-city" id="job__edit-city">
                                        <?php
                                        foreach ($data['cities'] as $item) {
                                            echo "<option value='" . $item->id . "'" . (($item->id == $data['jobsById']->city_id)? "selected='selected'" : "") . ">" . $item->city . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['cityErr']?></span>
                                </div>
                            </div>






                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id='job__edit-button' type="button" class="btn btn-default">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?= ROOT_URI; ?>js/pages/jobs.js"></script>
</div>
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
