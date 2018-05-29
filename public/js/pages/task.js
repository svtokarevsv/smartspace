document.addEventListener('DOMContentLoaded', function (e) {
        
    // add subtasks  
    var tasks = [];
    $('#task__add_subtask').click(function (e) {
        if($('#task__subtask').val()!=''){
            tasks.push($('#task__subtask').val());
            $('#task__subtasks').append($('#task__subtask').val() + ',');
            $('#task__subtasks_list').append("<li>"+$('#task__subtask').val());
            $('#task__subtask').val('');
        }
        return false;
    })

    // Clear subtasks
    $('#task__clear_subtask').click(function (e) {
        $('#task__subtasks').empty();
        $('#task__subtasks_list').empty();
        $('#task__subtask').val('');
        return false;
    })


    // update subtask on the right sidebar
    $(document).change(function (e) {
		const element = e.target;
		switch (true) {
			case element.classList.contains('subtask__check'):
            const checkboxId = element.id
			updateSubtaskStatus(checkboxId);
			break;
		}
    })
    
    // Update status of subtask in the subtask page
    // 1. get id of clicked checkbox (=id of the subtask)
    // $('.subtask__check').change(function (e) {
    //     var checkboxId = $(this)[0].id;        
    //     updateSubtaskStatus(checkboxId);
    //  })
 
    function updateSubtaskStatus(checkboxId){
        $('#'+checkboxId).attr("disabled", true);
        // ajax request
        $.get(ROOT_URI + "task/ajax_updateSubtaskStatusBySubtaskId", {checkboxId}, function (data) {
            var res = data.substr(0,data.length-2);
            var json = JSON.parse(res);
            $('#progress-bar'+json.taskId).css({width:json.progress+'%'});
            $('#'+checkboxId).attr("disabled", false);

        }, 'text')
    }
    

    // remove task
    $('.task__remove').click(function(e){
        var taskId = $(this)[0].id;
        removeTask(taskId);
        $('#task__list'+taskId).empty();
    })

    function removeTask(taskId){
        // ajax request
        $.get(ROOT_URI + "task/ajax_deleteTaskByTaskId", {taskId}, function (data) {          
        })
    }

})
