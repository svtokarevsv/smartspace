document.addEventListener('DOMContentLoaded', function (e) {
    getFriendsRecentPosts()
    $(document).click(function (e) {
        const elem = e.target
        switch (true) {
            case elem.classList.contains('post_modal'):
                const id = elem.getAttribute('data-id')
                openPostModal(id)
                break
        }
    })
    $('#search_by_tag_form').submit(function (e) {
        e.preventDefault();
        let searchByTag = $('#search_by_tag').val();
        getStudentTags(searchByTag);
    });
    function getStudentTags(keyword) {
        $.getJSON(ROOT_URI + "businessprofile/ajax_get_student_by_tags", { search_by_tag:keyword }, fillStudentSearch)
    }

    function fillStudentSearch(data) {
        let html = '';
        if (data.studentByTag.length === 0) {
            html = 'No result found.'
        } else {
            for (let student of data.studentByTag) {
                html += `
						<div>
							<div>Name: <a href="${ROOT_URI + 'profile/view/' + student.id}">${student.first_name} ${student.last_name}</a></div>
							<div>Tag: `;
                for (let tag of student.tags) {
                    html += tag===student.tags[student.tags.length-1]?`${tag}`:`${tag}, `
                }
                html += `</div>
						<hr />
						</div>`
                // or use ${student.tags.map(tag=>' ' + tag)}
            }
        }
        $('#search_by_tag_result').html(html);
    }

    function getFriendsRecentPosts() {
        $.getJSON(ROOT_URI + "posts/ajax_get_friends_recent_posts", {number:5}, fillFriendsPosts)
    }
    function fillFriendsPosts(data) {
        let html = ''
        for (let post of data.posts) {
            html += `
					<li>
						<div class="row">
							<div class="col-xs-3 p0 flex-centered">
								<div class="user-block mr">
									<img src="${ROOT_URI+post.userimg_path}" alt="${post.user_name}" class="img-circle img-no-padding img-responsive">
								</div>
							</div>
							<div class="col-xs-9">
								<b><a href="${ROOT_URI+'profile/view/'+post.user_id}">${post.user_name}</a></b> shared a
								<b><a class="post_modal" data-id="${post.id}">publication</a></b>.
								<span class="timeago">${humanizeDate(post.creation_date)}</span>
							</div>
						</div>
					</li>`
        }
        $('#friends_posts').html(html);
    }
    function openPostModal(id) {
        $.getJSON(ROOT_URI + "posts/ajax_getPostsById", {id}, function (data) {
            const modal = $('#view_post_modal')
            modal.find('#show_post__author').text(data.user_name)
            modal.find('#show_post__date').text(humanizeDate(data.creation_date))
            modal.find('#show_post__message').text(data.post_message)
            if(data.image_path){
                let html=`<img class="post-image img-responsive center-block"
                             src="${ROOT_URI + data.image_path}" alt="post image" />`
                modal.find('#show_post__image').html(html)
            }
            modal.modal('show')
        })
    }

    // Task feature
    getTaskList();

    function getTaskList(){
        $.getJSON(ROOT_URI + "task/ajax_getTasks", null, displayTasks)
    }

    function displayTasks(data){
        var output = "";
        var tasks = data.task;

        for (let i = 0; i < tasks.length; i++) {
            var taskName = tasks[i].task_name;
            var taskDue = tasks[i].due;
            var width = tasks[i].progress;

            var stList = "";
            for (let j = 0; j < tasks[i].subtaskOfTaskId.length; j++) {
                var stName = tasks[i].subtaskOfTaskId[j].name;
                var stId = tasks[i].subtaskOfTaskId[j].id;
                var isCompleted = tasks[i].subtaskOfTaskId[j].status==1?"checked":"";

                stList += 	"<li><div class='checkbox col-xs-offset-1'><label>"
                    + "<input type='checkbox' id='" + stId + "'class='subtask__check' name='subtask__check'" + isCompleted + ">"
                    + "<span class='text'>" + stName + "</span>"
                    + "</label></div></li>";

            }

            output += 	"<div class='row mb2 bg-info'>"
                + "<div class='col-lg-12 mt2'>" + taskName + "</div>"
                + "<div class='col-lg-12'>Due: " + taskDue + "</div>"
                // progress bar
                + "<div class='col-lg-12 center-block'><div class='progress'><div id=progress-bar" + tasks[i].id + " class='progress-bar  progress-bar-info' role='progressbar' style='width:"
                + width
                + "%;'></div></div></div>" // end of progress bar
                + "<ul class='list-unstyled'>" + stList + "</ul>"
                + "</div>"
            ;

        }
        $('#right__task_list').html(output);
    }

})
