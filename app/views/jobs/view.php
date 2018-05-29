<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-6">
    <div class="box box-widget">
        <div class="box box-header">
            <h2>Your job postings</h2>
        </div>
        <div>

        </div>
        <div class="box-body">
            <?php foreach ($data['jobs'] as $value) {
                $job_id = $value->id;
                echo "<h3>" . $value->title. "</h3>";
                echo "<a id='edit' href='" . ROOT_URI . "jobs/edit/" . $value->id . "'>Edit</a> | ";
                echo "<a id='delete' data-toggle='modal' data-target='.job-delete-modal' href='#'>Delete</a>";
                echo "<div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>Description: </div>
                        <div class='col-sm-9'>$value->description</div>
                      </div>
                      <div class='row padding-v-5'>
                        <div class='col-sm-3 text-muted bold'>Type:</div>
                        <div class='col-sm-9'>$value->type</div>
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
            <!-- Confirm delete modal -->
        </div>
        <div class="modal fade job-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmation">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Delete job posting</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this job posting?
                    </div>
                    <div class="modal-footer">
                        <a id='delete' class="btn btn-default" href="<?=ROOT_URI?>jobs/delete/<?=$value->id?>">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">
            <a href="<?=ROOT_URI?>jobs/create" class="btn btn-default">Add a Job Posting</a>
        </div>
    </div>
</div>
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
