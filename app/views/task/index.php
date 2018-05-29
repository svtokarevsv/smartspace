<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>

<!-- Main Content-->

    <div class="col-md-9">
        <div class="widget">
            <div class="widget-header">
                <h1 class="widget-caption">Task List</h1>
            </div>
            <div class="widget-body bordered-top bordered-sky">
                <div class="row mb3">
                    <div class="col-md-12">

                        <div><!-- Task form -->
                            <p class="col-lg-12 text-success"><?= $data['successMsg'] ?></p>
                            <form method='post' action='task' class="was-validated">
                            
                                <div class="col-lg-9 mb-5 form-group <?= !empty($data['errors']['tName'])?'has-error':'' ?>">
                                    <label for="task__task">Task*</label>
                                    <input type="text" class="form-control" id="task__task" name='task__task' placeholder="Prepare for the exam" value="">
                                    <div class="text-danger"><?= $data['errors']['tName']??'' ?></div>
                                </div>

                                <div class="col-lg-9 mb-5 form-group <?= !empty($data['errors']['tDue'])?'has-error':'' ?>">
                                    <label for="task__due">Due*</label>
                                    <input type="date" class="form-control" id="task__due" name='task__due'>
                                    <div class="text-danger"><?= $data['errors']['tDue']??'' ?></div>
                                </div>
    
                                <div class="col-md-9">
                                    <label for="task__add_subtask">Subtasks*</label>
                                    <div class="input-group <?= !empty($data['errors']['taskString'])?'has-error':'' ?>">
                                        <input type="text" id="task__subtask" class="form-control" name="task__subtask" placeholder="Review course handouts">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" id="task__add_subtask" name="task__add_subtask">Add Subtask</button>
                                        </span>
                                    </div>
                                    <div class="text-danger"><?= $data['errors']['taskString']??'' ?></div>
                                    <div><button class="btn btn-link" id="task__clear_subtask">Clear Subtasks</button></div>
                                    <div>
                                        <ol id="task__subtasks_list">
                                            
                                        </ol>
                                    </div>
                                    <div>
                                        <textarea id="task__subtasks" name="task__subtasks" style="display:none"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-9 mb-5 form-group">
                                    <input type="submit" value="Add Task" name='task__submit' class="btn col-xs-5 btn-azure pull-right">
                                </div>
                            </form>    
                        </div><!-- end task form -->
                    </div>
                </div>

                <!-- Task List -->
                <div class="row">
                    <div class="col-md-12">
                        <p class="h4 mb2">Tasks</p>
                        <div class="row center-block">
             
                        
                            <ul class="list-unstyled col-md-12">
                        
                                <?php foreach($data['task'] as $t): ?>
                                    <li id=<?='task__list'.$t->id?> class="bg-info col-md-12 mb3">
                                        <div class="mb2"></div>
                                        <div class="row mb2">
                                            <div class="col-md-12">
                                                <div class="bold"><?= $t->task_name?></div>
                                                <div>Due: <?= $t->due?></div>
                                            </div>
                                        </div>
                                        <div class="row col-md-12 center-block">
                                            <div class="progress">
                                                <div id=<?='progress-bar'.$t->id?> class="progress-bar  progress-bar-info" role="progressbar" style="width: <?=$t->progress ?>%;"></div>
                                            </div>
                                        </div>
                                        <div class="row mb3">
                                            <form method="post" action="index">
                                                <ul class="list-unstyled">
                                                    <?php foreach($t->subtaskOfTaskId as $st): ?>
                                                        <li>
                                                            <div class="checkbox col-xs-offset-1">
                                                                <label>
                                                                    <input type="checkbox" id="<?=$st->id?>" class="subtask__check" name="subtask__check" <?= $st->status==1?"checked":""?>>
                                                                    <span class="text"><?=$st->name?></span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </form>
                                            <button id="<?='remove'+$t->id?>" name="task__remove" class="task__remove btn btn-link">Remove</button>
                                        </div>
                                    </li>
                                
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div> <!--end of row-->
                
            </div> <!-- end of widget body-->
        </div><!-- end of widget -->
    </div><!-- end  main contents -->
    
<!-- End of Main Container -->

<script src="<?=ROOT_URI;?>js/pages/task.js"></script>
<!-- Footer and Right sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
