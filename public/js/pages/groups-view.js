document.addEventListener('DOMContentLoaded', function (e) {

	const group_id = ROUTER.params[0]
	fillCurrentGroupPosts()
	$('#post_image').on("change", function () {
		let file = this.files[0];
		if (file) {
			$('#show_image_path').text(file['name'])
		}
		else {
			$('#show_image_path').text('')
		}


	});
	$('#join_group').click(joinGroup)
	$('#update_post').click(function (e) {
		$('#edit_post_form').submit()
	})
	$('#delete_post').click(function (e) {
		$('#delete_post_form').submit()
	})
	$('#create_post_form').submit(function (e) {
		e.preventDefault()
		const form = new FormData(this)
		form.append('group_id', group_id)
		const that = this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "posts/ajax_create_post",
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Couldn\'t create the post')
				} else {
					fillCurrentGroupPosts()
					notifySuccess('Post successfully created')
					//reset form after successful post creation
					that.reset()
					$('#show_image_path').text('')
				}
			}
		});
	})

	$('#edit_post_form').submit(function (e) {
		e.preventDefault()
		const that = this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "posts/ajax_update_post_by_id",
			data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Error.Post was not updated')
				} else {
					fillCurrentGroupPosts()
					notifySuccess('Post successfully updated')
					//reset form after successful group update
					that.reset()
				}
				$('#edit_post_modal').modal('hide')
			},
		});
	})
	$('#delete_post_form').submit(function (e) {
		e.preventDefault()
		const that = this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "posts/ajax_delete_post_by_id",
			data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Error. Post was not deleted')
				} else {
					fillCurrentGroupPosts()
					notifyInfo('Post deleted')
					//reset form after successful group update
					that.reset()
				}
				$('#delete_post_modal').modal('hide')
			},
		});
	})
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('edit_post_link'):
				const id = elem.getAttribute('data-id')
				openEditModal(id)
				break
			case elem.classList.contains('delete_post_link'):
				const delid = elem.getAttribute('data-id')
				openDeleteModal(delid)
				break
		}
	})

	function fillCurrentGroupPosts() {
		$.getJSON(ROOT_URI + "groups/ajax_get_posts_by_group_id", {group_id}, function (data) {
			fillPosts(data.posts)
		})
	}

	function joinGroup() {
		$.post(ROOT_URI + "groups/ajax_join_group", {groupId: group_id})
			.done(function (data) {
				if (data['result'] === 'ok') {
					$('#join_container').hide()
					notifySuccess("You successfully joined the group")
					location.reload();
				} else {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Couldn\'t join the group')
				}
			})
			.fail(function () {
				notifyDanger('Sorry, we have problems. Try again later')
			});
	}

	function fillPosts(posts) {
		let html = ''
		for (let post of posts) {
			html += `
					<div class="box box-widget">
						<div class="box-header with-border">
							<div class="user-block">
								<img class="img-circle" src="${ROOT_URI + post['userimg_path']}" alt="User Image">
		
								<h3 class="username"><a href="${ROOT_URI}profile">${post.user_name}</a> shared a Post</h3>
								${post['creator_id'] === CURRENT_USER_ID ?
								`<span class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"                               
									aria-expanded="false"><i class="fa fa-chevron-down pull-right"></i>
								</span>` : ''}		
								<div>
									<span >${humanizeDate(post.creation_date)}</span>
								</div>       
								${post['creator_id'] === CURRENT_USER_ID ?
								`<ul class="dropdown-menu ">
									<li class=""><span class="edit_post_link" data-id="${post.id}">Edit</span></li>
									<li class="divider" role="separator"></li>
									<li class=""><span class="delete_post_link" data-id="${post.id}">Delete</span></li>
								</ul>` : ''}	 
							</div>                 
						</div>
						<div class="box-body">
						${post['post_message'] ?
							`<div>
								<span >${post.post_message}</span>
							</div>`
							: ''}
						${post['image_id'] ?
							`<div class="image-body ">
								<img class="post-image img-responsive center-block" 
								src="${ROOT_URI + post['image_path']}" alt="post image" />
							 </div>`
							: ''}
						</div>
						${window.getCommentBlockHtml && typeof window.getCommentBlockHtml==='function'?
							getCommentBlockHtml(post.id):
							''}
                     </div>`
		}
		$('#posts-list__container').html(html);
	}

	function openEditModal(id) {
		$.getJSON(ROOT_URI + "posts/ajax_getPostsById", {id}, function (data) {
			const modal = $('#edit_post_modal')
			const form = $('#edit_post_form')[0]
			form['elements']['edit_post_message'].value = data['post_message']

			form['elements']['edit_post_id'].value = data['id']
			modal.modal('show')
		})
	}

	function openDeleteModal(id) {
		$.getJSON(ROOT_URI + "posts/ajax_getPostsById", {id}, function (data) {
			const modal = $('#delete_post_modal')
			const form = $('#delete_post_form')[0]
			form['elements']['delete_post_message'].value = data['post_message']

			form['elements']['delete_post_id'].value = data['id']
			modal.modal('show')
		})
	}
})