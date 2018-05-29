
document.addEventListener('DOMContentLoaded', function (e) {
    const posts_container = $('#posts-list__container')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(fillCurrentUserPosts, allItemsLoaded)
    //calls a function that will fill all user posts
    function new_posts() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        posts_container.html('')
        fillCurrentUserPosts()
    }
    //fill user posts
    fillCurrentUserPosts()
    //to show image chose for upload
    $('input[type=file]').on("change", function() {
        let file = this.files[0];
        if(file){
            $('#show_image_path').text(file['name'])
        }
        else {
            $('#show_image_path').text('')
        }
    });
    //create form submits on clicking post button
    $('#create_post').click(function (e) {
        $('#create_post_form').submit()
    })
    //update post form will be submitted on clicking edit button
    $('#update_post').click(function (e) {
        $('#edit_post_form').submit()
    })
    //delete post form will be submitted on clicking delete button
    $('#delete_post').click(function (e) {
        $('#delete_post_form').submit()
    })
    //on submission of create post form
    $('#create_post_form').submit(function (e) {
        e.preventDefault()
        const that = this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "posts/ajax_create_post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Couldn\'t create the post, Enter message..')
                } else {
                    notifySuccess('Post created  successfully')
                    new_posts()
                    $('#errors_container').html('')
                    //reset form after successful group creation
                    that.reset()
                    $('#show_image_path').text('')
                }
            }
        });
    })
    //on submitting edit post form
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
                    notifyDanger('Couldn\'t edit Post.')
                } else {
                    notifySuccess('Post updated  successfully')
                    new_posts()
                    //reset form after successful group update
                    that.reset()
                }
                $('#edit_post_modal').modal('hide')
            },
        });
    })
    //on submitting delete post form
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
                    notifyDanger('Couldn\'t delete post')
                } else {
                    notifySuccess('post deleted successfully')
                    new_posts()
                    //reset form after successful group update
                    that.reset()
                }
                $('#delete_post_modal').modal('hide')
            },
        });
    })
    //condition if edit or delete button is clicked
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
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
    //function to fill current posts
    function fillCurrentUserPosts() {
        $('#loader').show();
        $.getJSON(ROOT_URI + "posts/ajax_get_posts",{page}, function (data) {
            page++
            fillPosts(data.posts)
            if (data.posts.length < PER_PAGE) {
                allItemsLoaded.loaded = true

            }
            $('#loader').hide();
            scrollListener.attach()
        })
    }
    //open edit modal
    function openEditModal(id) {
        $.getJSON(ROOT_URI + "posts/ajax_getPostsById",{id}, function (data) {
            const modal = $('#edit_post_modal')
            const form = $('#edit_post_form')[0]
            form['elements']['edit_post_message'].value=data['post_message']

            form['elements']['edit_post_id'].value=data['id']
            modal.modal('show')
        })
    }
    //open delete modal
    function openDeleteModal(id) {
        $.getJSON(ROOT_URI + "posts/ajax_getPostsById",{id}, function (data) {
            const modal = $('#delete_post_modal')
            const form = $('#delete_post_form')[0]
            form['elements']['delete_post_message'].value=data['post_message']

            form['elements']['delete_post_id'].value=data['id']
            modal.modal('show')
        })
    }
    //function to fill posts
    function fillPosts(posts) {
        let html = ''
        for (let post of posts) {
            let editHtml=''
            let deleteHtml=''
            if(post['creator_id']===CURRENT_USER_ID){
                editHtml=`<span style="cursor: pointer;" class="edit_post_link" data-id="${post.id}">Edit</span>`
            }
            if(post['creator_id']===CURRENT_USER_ID){
                deleteHtml=`<span style="cursor: pointer;" class="delete_post_link" data-id="${post.id}">Delete</span>`
            }
            html += `
            <div class="widget">
                <div class="widget-body">
                    <div class="wall-user-thumb">
                        <img src="${ROOT_URI + post['userimg_path']}" alt="User Image">
                    </div>
                    <div class="wall-user-details">
                        <h3><a href="${ROOT_URI}profile">${post.user_name}</a> shared a Post</h3>
                        <div>
                            <span class="timeago">${humanizeDate(post.creation_date)}</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <p class="wall-user-status">`
                         if( post['post_message'] !== null){
                                html += `   <div>
                                                <span >${post.post_message}</span>
                                            </div>`
                            }
                            if(post['image_id'] !== null) {
                                html += `<div class="image-body ">
                                                <img class="post-image img-responsive center-block" src="${ROOT_URI + post['image_path']}" alt="post image" />
                                           </div>`
                            }
                     html += `</p>
                    <div class="wall-status-container wall-border">
                        <div class="wall-time-action">
                          ${editHtml}
                             <span>-</span>
                         ${deleteHtml}
                           
                        </div>
                    </div>`
			if(window.getCommentBlockHtml && typeof window.getCommentBlockHtml==='function'){
				html+=getCommentBlockHtml(post.id)
			}
			html+=`
                </div>
            </div>`

        }
        //append posts
        posts_container.append(html);
    }
})