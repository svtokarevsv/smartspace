<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>

<div class="col-md-9">
    <div class="box box-widget">
        <div class="box box-header">
            <h2>Timetable</h2>
            <h3>This week schedule</h3>
        </div>
        <div class="table">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
                </thead>
                <tbody>
                <?php
                /* foreach ($data['timetables'] as $row){
                     $row['day'] = date('D',strtotime($row['start_date']));
                     $cell= "<td>
                                   <div>To do: " . $row['note'] . "</div>
                                   <div>" . date( "h:i a", strtotime($row['startTime'])) . " - " . date( "h:i a", strtotime($row['endTime'])) . "</div>
                               </td>";
                     switch ($row['day']) {
                         case 'Mon':
                             echo "<tr><td></td>";
                             echo $cell;
                             echo "<td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                             break;
                         case 'Tue':
                             echo "<tr><td></td><td></td>";
                             echo $cell;
                             echo "<td></td><td></td><td></td><td></td><td></td></tr>";
                             break;
                         case 'Wed':
                             echo "<tr><td></td><td></td><td></td>";
                             echo $cell;
                             echo "<td></td><td></td><td></td><td></td></tr>";
                             break;
                         case 'Thu':
                             echo "<tr><td></td><td></td><td></td><td></td>";
                             echo $cell;
                             echo "<td></td><td></td><td></td></tr>";
                             break;
                         case 'Fri':
                             echo "<tr><td></td>";
                             echo $cell;
                             echo "<td></td><td></td><td></td></tr>";
                             break;
                         case 'Sat':
                             echo "<tr><td></td><td></td><td></td><td></td><td></td>";
                             echo $cell;
                             echo "<td></td><td></td></tr>";
                             break;
                         case 'Sun':
                             echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td>";
                             echo $cell;
                             echo "</tr>";
                             break;

                     }
                 }*/
                echo "<tr>";
                foreach ($data['weekdays'] as $day) {
                    echo "<td>";
                    foreach ($day as $note) {
                        $data['noteId'] = $note['id'];
                        $data['noteContent'] = $note['note'];
                        $data['noteDate'] = $note['date'];
                        $data['noteStartTime'] = $note['startTime'];
                        $data['noteEndTime'] = $note['endTime'];
                        echo "<div>
                                  <div><span class='text-muted bold'>To do: </span>" . $note['note'] . "</div>
                                  <div>" . date( "h:i a", strtotime($note['startTime'])) . " - " . date( "h:i a", strtotime($note['endTime'])) . "</div>
                                  <input type='hidden' name='' value=" . $note['id'] . " />
                              </div>
                              <div>
                                  <a id='delete' data-toggle='modal' data-target='.timetable__edit-modal' href='#'>Edit</a> |
                                  <a id='delete' data-toggle='modal' data-target='.timetable__delete-modal' href='#'>Delete</a>
                              </div>";
                    }
                    echo "</td>";
                }
                echo "</tr>";
                ?>
                </tbody>
            </table>
        </div>
        <div class="box-body">

            <!-- Create modal -->
        </div>
        <div class="modal fade timetable__create-modal" tabindex="-1" role="dialog" aria-labelledby="Add new note">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add new note</h4>
                    </div>
                    <div class="modal-body">
                        <form id="timetable__create-form" method='post'>
                            <div class="form-group">
                                <label for="timetable__create-note"><span class="text-danger">* </span>Note: </label>
                                <div>
                                    <input type="text" class="form-control" name="timetable__create-note" id="timetable__create-note">
                                    <span class="text-danger"><?= $data['errors']['noteErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__create-date"><span class="text-danger">* </span>Date: </label>
                                <div>
                                    <input type="date" class="form-control" name="timetable__create-date" id="timetable__create-date">
                                    <span class="text-danger"><?= $data['errors']['dateErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__create-endDate">End date: </label>
                                <div>
                                    <input type="date" class="form-control" name="timetable__create-endDate" id="timetable__create-endDate">
                                    <span class="text-danger"><?= $data['errors']['endDateErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__create-startTime"><span class="text-danger">* </span>Start time: </label>
                                <div>
                                    <select class="form-control" name="timetable__create-startTime" id="timetable__create-startTime">
                                        <option value=''>---</option>
                                        <?php
                                        foreach ($data['periods'] as $item) {
                                            echo "<option value='" . $item->id . "'>" . $item->period . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['startTimeErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__create-endTime"><span class="text-danger">* </span>End time: </label>
                                <div>
                                    <select class="form-control" name="timetable__create-endTime" id="timetable__create-endTime">
                                        <option value=''>---</option>
                                        <?php
                                        foreach ($data['periods'] as $item) {
                                            echo "<option value='" . $item->id . "'>" . $item->period . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['endTimeErr']??'' ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="timetable__create-button" name ="timetable__create-button" class="btn btn-default">Add</button>
                    </div>
                </div>
            </div>
        </div> <!--end of create modal-->

        <!-- Edit modal -->
        <div class="modal fade timetable__edit-modal" tabindex="-1" role="dialog" aria-labelledby="Edit note">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit note</h4>
                    </div>
                    <div class="modal-body">
                        <form id="timetable__edit-form" method='post'>
                            <input type="hidden" name="timetable__edit-id" id="timetable__edit-id" value="<?=$data['noteId']?>" />
                            <div class="form-group">
                                <label for="timetable__edit-note"><span class="text-danger">* </span>Note: </label>
                                <div>
                                    <input type="text" class="form-control" name="timetable__edit-note" id="timetable__edit-note" value="<?=$data['noteContent']?>">
                                    <span class="text-danger"><?= $data['errors']['noteErr'] ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__edit-date"><span class="text-danger">* </span>Date: </label>
                                <div>
                                    <input type="date" class="form-control" name="timetable__edit-date" id="timetable__edit-date" value="<?=$data['noteDate']?>">
                                    <span class="text-danger"><?= $data['errors']['dateErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__edit-startTime"><span class="text-danger">* </span>Start time: </label>
                                <div>
                                    <select class="form-control" name="timetable__edit-startTime" id="timetable__edit-startTime">
                                        <option value=''>---</option>
                                        <?php
                                        foreach ($data['periods'] as $item) {
                                            echo "<option value='" . $item->id . "'" . (($data['noteStartTime'] == $item->period)? "selected" : "") . ">" . $item->period . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['startTimeErr']??'' ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timetable__edit-endTime"><span class="text-danger">* </span>End time: </label>
                                <div>
                                    <select class="form-control" name="timetable__edit-endTime" id="timetable__edit-endTime">
                                        <option value=''>---</option>
                                        <?php
                                        foreach ($data['periods'] as $item) {
                                            echo "<option value='" . $item->id . "'" . (($data['noteEndTime'] == $item->period)? "selected" : "") . ">" . $item->period . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= $data['errors']['endTimeErr']??'' ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="timetable__edit-button" name ="timetable__edit-button" class="btn btn-default">Edit</button>
                    </div>
                </div>
            </div>
        </div> <!-- end of edit modal-->

        <!-- Confirm delete modal-->
        <div class="modal fade timetable__delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete confirmation">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="timetable__delete-label">Delete note</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this note?
                        <form id="timetable__delete-form" method='post'>
                        <input type="hidden" name="timetable__delete-id" id="timetable__delete-id" value="<?=$data['noteId']?>" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="timetable__delete-button" name ="timetable__delete-button" class="btn btn-default">Delete</button>
                    </div>
                </div>
            </div>
        </div> <!-- end of confirm delete modal-->

        <div class="box-footer text-right">
            <a class="btn btn-azure" id='timetable__create' data-toggle='modal' data-target='.timetable__create-modal' href='#'>Add new</a>
        </div>
    </div>
</div>
<script src="<?= ROOT_URI; ?>js/pages/timetable.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
