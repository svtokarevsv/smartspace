document.addEventListener('DOMContentLoaded', function (e) {
	fillCurrentUserGroups()
	$('#create_group').click(function (e) {
		$('#create_group_form').submit()
	})
	$('#update_group').click(function (e) {
		$('#edit_group_form').submit()
	})
	$('#create_group_form').submit(function (e) {
		e.preventDefault()
		const that=this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "groups/ajax_create_group",
			data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Couldn\'t create the group, server error')
				} else {
					notifySuccess('Group successfully created')
					fillCurrentUserGroups()
					//reset form after successful group creation
					that.reset()
				}
				$('#create_group_modal').modal('hide')
			},
		});
	})
	$('#edit_group_form').submit(function (e) {
		e.preventDefault()
		const that=this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "groups/ajax_update_group_by_id",
			data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Couldn\'t edit the group')
				} else {
					fillCurrentUserGroups()
					notifySuccess('Group successfully updated')
					//reset form after successful group update
					that.reset()
				}
				$('#edit_group_modal').modal('hide')
			},
		});
	})
	$(document).click(function (e) {
		const elem = e.target
		switch (true){
			case elem.classList.contains('edit_group_link'):
				const id = elem.getAttribute('data-id')
				openEditModal(id)
				break
			case elem.classList.contains('group_leave'):
				const groupId = elem.getAttribute('data-id')
				leaveGroup(groupId)
				break
		}
	})
	function leaveGroup(groupId) {
		$.post(ROOT_URI + "groups/ajax_leave_group", {groupId})
			.done(function (data) {
				if (data['result'] === 'ok') {
					fillCurrentUserGroups()
					notifyDanger('You left the group')
				}else{
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Error leaving the group')
				}
			})
			.fail(function () {
				$('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
				notifyDanger('Sorry, we have problems. Try again later')
			});
	}
	function fillCurrentUserGroups() {
		$.getJSON(ROOT_URI + "groups/ajax_getCurrentUserGroups", function (data) {
			fillGroups(data.groups)
		})
	}
	function openEditModal(id) {
		$.getJSON(ROOT_URI + "groups/ajax_getGroupById",{id}, function (data) {
			const modal = $('#edit_group_modal')
			const form = $('#edit_group_form')[0]
			form['elements']['edit_group_name'].value=data['name']
			form['elements']['edit_group_description'].value=data['description']
			form['elements']['edit_group_id'].value=data['id']
			modal.modal('show')
		})
	}
	function fillGroups(groups) {
		let html = ''
		for (let group of groups) {
			html += `
			 <div class="col-md-6 groups-list__item">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><a href="${ROOT_URI}groups/view/${group['id']}">${group['name']}</a></h3>
                            ${group['creator_id']===CURRENT_USER_ID?`<span class="edit_group_link" data-id="${group.id}">Edit</span>`:''}
                        </div>
                        <div class="panel-body">
                           <div class="col-xs-3">
								<a href="${ROOT_URI}groups/view/${group['id']}">
									<img  src="${ROOT_URI + group['avatar_path']}" alt="${group['name']}">
								</a>
							</div>
							<div class="col-xs-7">
							   <p>${group['description'].length>50?group['description'].substring(0, 50)+'...':group['description']}</p>
							</div>
							<div class="col-xs-2">
								<div class="row">
									<button class="btn btn-danger group_leave" data-id="${group['id']}">Leave</button>
								</div>
							</div>                            
                        </div>
                    </div>
                </div>
			`
		}
		$('#groups-list__container').append(html);
	}
})
