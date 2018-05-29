document.addEventListener('DOMContentLoaded', function (e) {
	"use strict"
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('box-comments__button'):
				let post_id = elem.getAttribute('data-post-id')
				let page = elem.getAttribute('data-page')
				elem.parentNode.removeChild(elem)
				getCommentsToPost(post_id,page)
				break
			// case elem.classList.contains('delete_post_link'):
			// 	const delid = elem.getAttribute('data-id')
			// 	openDeleteModal(delid)
			// 	break
		}
	})
	$(document).on("change", function (e) {
		const input = e.target
		if(input.classList.contains('box-comments__file')){
			let file = input.files[0];
			let postId=input.getAttribute('data-post-id')
			if (file) {
				$('.show_image_path[data-post-id='+postId+']').text(file['name'])
			}
			else {
				$('.show_image_path[data-post-id='+postId+']').text('')
			}
		}



	});
	$(document).submit(function (e) {
		const form =e.target
		if(form.classList.contains('comment-form')){
			e.preventDefault()
			$.ajax({
				type: "POST",
				url: ROOT_URI+'comments/ajax_create_comment',
				data: new FormData(form),
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					if (data['errors'] && data['errors'].length > 0 ) {
						notifyDanger(getErrors(data['errors']))
					} else if(data.result==='ok') {
						notifySuccess('Comment successfully posted')
						form.reset()
						const postId =form.getAttribute('data-post-id')
						$('.show_image_path[data-post-id='+postId+']').text('')
						getCommentsToPost(postId)
					}else{
						notifyDanger('Something went wrong, server error')
					}
				},
			});
		}
	})
})
function getCommentBlockHtml(post_id) {
	getCommentsToPost(post_id)

	return `
		<div class="box-footer box-comments comments-container" data-post-id="${post_id}"></div>
		<div class="box-footer box-comments">
			<form method="post" class="comment-form" data-post-id="${post_id}">
				<input type="hidden" name="post_id" value="${post_id}">
				<img class="img-responsive img-circle img-sm" src="${ROOT_URI+CURRENT_USER_IMG}" 
				alt="${CURRENT_USER_NAME}">
				<div class="img-push">
					<input type="text" name="message" class="form-control input-sm" 
					placeholder="Press enter to post comment">
					<div class="box-comments__photo">
						<label class="control-label" for="comment-file-input-${post_id}">
							<a><i class="fa fa-camera"></i></a>
						</label>
						<div class="hidden">
							<input type="file" class="box-comments__file" 
							id="comment-file-input-${post_id}" 
							data-post-id="${post_id}"
							name="comment_image" />
						</div>
					</div>
					<span class="show_image_path" data-post-id="${post_id}" style="color: #2dc3e8;"></span>
				</div>
							
			</form>
		</div>`
}
function getCommentsToPost(post_id,page=0) {
	page=parseInt(page)
	$.getJSON(ROOT_URI + "comments/ajax_get_comments_by_post_id", {post_id,page}, function (data) {
		fillCommentsToPost(data.comments,post_id,page)
	})
}
function fillCommentsToPost(comments,post_id,page) {
	let html = ''
	const comments_container = $('.comments-container[data-post-id='+post_id+']')
	if(!page){
		comments_container.html('')
	}
	for (let comment of comments) {
		html += `
					<div class="box-comment">
					  <img class="img-circle img-sm" src="${ROOT_URI+comment.userimg_path}" alt="${comment.user_name}">
					  <div class="comment-text">
						<span class="username">
						<a href="${ROOT_URI+'profile/view/'+comment.user_id}">${comment.user_name}</a>
						<span class="text-muted pull-right">${humanizeDate(comment.creation_date)}</span>
						</span>
						${comment.message}
						${comment.image_path?`<img src="${ROOT_URI+comment.image_path}" class="box-comments__image" 
							alt="comment image"/>`:''}
					  </div>
					</div>`
	}
	if(comments.length>=COMMETNS_PER_PAGE){
		html+=`<button class="btn box-comments__button" data-post-id="${post_id}" data-page="${page+1}">more comments</button>`
	}
	comments_container.append(html);
}