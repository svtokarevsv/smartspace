<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-9">
    <div class="box box-widget">
        <div class="box box-header">
            <h2>Edit your job postings</h2>
        </div>
        <div class="box-body">
            <div class="text-center">
                <p>Please fill out all required fields.</p>
                <div class="text-danger mb2">*: required</div>
            </div>
            <form action='' method='post'>
                <input type="hidden" value="<?= $_POST['update_id'] ?>" name="jid" id="jid">
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="title"><span class="text-danger">* </span>Title: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Job title..." value="<?= $data['jobsById']->title ?>">
                        <span class="text-danger"><?= $data['titleErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="description"><span class="text-danger">* </span>Description: </label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="description" id="description" placeholder="Job description..."><?= $data['jobsById']->description ?></textarea>
                        <span class="text-danger"><?= $data['descriptionErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="type"><span class="text-danger">* </span>Type: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="type" id="type" placeholder="Full time/Part time" value="<?= $data['jobsById']->type ?>">
                        <span class="text-danger"><?= $data['typeErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="dateclosed">Date closed: </label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="dateclosed" id="dateclosed" value="<?= $data['jobsById']->dateclosed ?>">
                        <span class="text-danger"><?= $data['dateClosedErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="salary"><span class="text-danger">* </span>Salary: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="salary" id="salary" placeholder="Job salary..." value="<?= $data['jobsById']->salary ?>">
                        <span class="text-danger"><?= $data['salaryErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="industry"><span class="text-danger">* </span>Industry: </label>
                    <div class="col-md-8">
                        <select class="form-control" name="industry" id="industry">
                            <option value=''>- Please select your job industry -</option>
                            <?php
                            foreach ($data['industries'] as $item) {
                                echo "<option value='" . $item->id . "'" . (($item->id == $data['jobsById']->industry_id)? "selected='selected'" : "") . ">" . $item->industry . "</option>";
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= $data['industryErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="country">Country: </label>
                    <div class="col-md-8">
                        <select class="form-control" name="country" id="country">
                            <option value=''>- Please select your job location -</option>
                            <?php
                            foreach ($data['countries'] as $item) {
                                echo "<option value='" . $item->id . "'" . (($item->id == $data['jobsById']->country_id)? 'selected = "selected"' : "") . ">" . $item->country . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="city"><span class="text-danger">* </span>City: </label>
                    <div class="col-md-8">
                        <select class="form-control" name="city" id="city">
                            <?php
                            foreach ($data['cities'] as $item) {
                                echo "<option value='" . $item->id . "'" . (($item->id == $data['jobsById']->city_id)? "selected='selected'" : "") . ">" . $item->city . "</option>";
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= $data['cityErr']?></span>
                    </div>
                </div>
                <div class="text-center">
                    <button name='save' class='btn btn-default'>Save</button>
                </div>
            </form>
            <div class="text-center"><a href="<?=ROOT_URI?>jobs">Back to profile</a></div>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
<script src="<?=ROOT_URI;?>js/pages/jobs-edit.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>

