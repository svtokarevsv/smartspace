document.addEventListener('DOMContentLoaded', function (e) {
    //pagination constants
    const feed_container = $('#feed-list__container')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(fillCurrentUserFeed, allItemsLoaded)
    //calls function to fill news feed
    function new_feed() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        feed_container.html('')
        fillCurrentUserFeed()
    }
    //fill posts
    fillCurrentUserFeed()
    //displays name of image to when chosen
    $('input[type=file]').on("change", function() {
        let file = this.files[0];
        if(file){
            $('#show_image_path').text(file['name'])
        }
        else {
            $('#show_image_path').text('')
        }


    });
    //submits create posts form on clicking post button
    $('#create_post').click(function (e) {
        $('#create_post_form').submit()
    })
    //submits create post form
    $('#create_post_form').submit(function (e) {
        e.preventDefault()
        const that = this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "feed/ajax_create_post",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('couldn\'t create post. Enter message..')
                } else {
                    notifySuccess('Post created successfully')
					new_feed()
                    $('#errors_container').html('')
                    //reset form after successful group creation
                    that.reset()
                    $('#show_image_path').text('')
                }
            }
        });
    })
    function fillCurrentUserFeed() {


        $('#loader').show();
        $.getJSON(ROOT_URI + "feed/ajax_get_feed",{page}, function (data) {
            page++
            fillFeed(data.posts)
            if (data.posts.length < PER_PAGE) {
                allItemsLoaded.loaded = true

            }
            $('#loader').hide();
            scrollListener.attach()
        })
    }
    //fill user posts
    function fillFeed(posts) {
        let html = ''
        for (let post of posts) {

            html += `
			<div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="${ROOT_URI + post['userimg_path']}" alt="User Image">
                        <h3 class="username"><a href="${ROOT_URI+'profile/view/'+post.user_id}">${post.user_name}</a> shared a Post</h3>
                        <div>
                            <span class="timeago">${humanizeDate(post.creation_date)}</span>
                        </div>     
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

        feed_container.append(html);
    }

})