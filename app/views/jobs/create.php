<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-9">
    <div class="box box-widget">
        <div class="box box-header">
            <h2>Add new job postings</h2>
        </div>
        <div class="box-body">
            <div class="text-center">
            <p>Please fill out all required fields.</p>
            <div class="text-danger mb2">*: required</div>
            </div>
            <form action='' method='post'>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="title"><span class="text-danger">* </span>Title: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" id="title" value="<?= $title ?>" placeholder="Job title...">
                        <span class="text-danger"><?= $data['titleErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="description"><span class="text-danger">* </span>Description: </label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="description" id="description" placeholder="Job description..."><?= $error ? $description : null; ?></textarea>
                        <span class="text-danger"><?= $data['descriptionErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="type"><span class="text-danger">* </span>Type: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="type" id="type" placeholder="Full time/Part time" value="<?= $error ? $type : null; ?>">
                        <span class="text-danger"><?= $data['typeErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="dateclosed">Date closed: </label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="dateclosed" id="dateclosed" value="<?= $error ? $dateClosed : null; ?>">
                        <span class="text-danger"><?= $data['dateClosedErr']?></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="salary"><span class="text-danger">* </span>Salary: </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="salary" id="salary" placeholder="Job salary..." value="<?= $error ? $salary : null; ?>">
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
                                echo "<option value='" . $item->id . "'>" . $item->industry . "</option>";
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
                                echo "<option value='" . $item->id . "'>" . $item->country . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-offset-1 text-right" for="city"><span class="text-danger">* </span>City: </label>
                    <div class="col-md-8">
                        <select class="form-control" name="city" id="city">
                        </select>
                        <span class="text-danger"><?= $data['cityErr']?></span>
                    </div>
                </div>
                <div class="text-center">
                    <button name='create' class='btn btn-default'>Add</button>
                </div>
            </form>
        <div class="text-center mb2">
            <a href="<?=ROOT_URI?>jobs">Back to profile</a>
        </div>
    </div>
</div>
<script src="<?=ROOT_URI;?>js/pages/jobs-create.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>

