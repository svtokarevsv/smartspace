document.addEventListener('DOMContentLoaded', function (e) {
    //pagination constants
    const friends_container = $('#friend-list__container')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(fillCurrentUserFriends, allItemsLoaded)
    //calls a function to get friends list
    function new_friends() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        friends_container.html('')
        fillCurrentUserFriends()
    }
    fillCurrentUserFriends()
    //form will be submitted on clicking unfriend button
    $('#remove_frnd').click(function (e) {
        $('#remove_frnd_form').submit()
    })
    //submits unfriend form
    $('#remove_frnd_form').submit(function (e) {
        e.preventDefault()
        const that = this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "friends/ajax_delete_friends_by_id",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Couldn\'t delete Friend from list')
                } else {
                    new_friends()
                    notifySuccess('Friend removed successfully')
                    //reset form after successful group update
                    that.reset()
                }
                $('#remove_frnd_modal').modal('hide')
            },
        });
    })
    //check if unfriend button is clicked
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('remove_frnd_link'):
                const id = elem.getAttribute('data-id')
                openRemoveModal(id)
                break

        }
    })
    //open unfriend modal
    function openRemoveModal(id) {
        $.getJSON(ROOT_URI + "friends/ajax_getFriendsById",{id}, function (data) {
            const modal = $('#remove_frnd_modal')
            const form = $('#remove_frnd_form')[0]

            form['elements']['remove_frnd_id'].value=data['id']
            modal.modal('show')
        })
    }
    function fillCurrentUserFriends() {
        $('#loader').show();
        $.getJSON(ROOT_URI + "friends/ajax_get_friends",{page}, function (data) {
            page++
            fillFriends(data.friends)
            if (data.friends.length < PER_PAGE) {
                allItemsLoaded.loaded = true

            }
            $('#loader').hide();
            scrollListener.attach()


        })
    }
    //display friends list
    function fillFriends(friends) {
        let html = ''
        let lihtml = ''
        for (let friend of friends) {
            lihtml += ` <li><a href="${ROOT_URI+'profile/view/'+friend.user_id}">
                                    <img src="${ROOT_URI + friend['frnd_image_path']}" alt="people" class="img-responsive">
                                </a></li>`

            html +=` <div class="col-md-4">
                        <div class="contact-box center-version">
                            <a href="${ROOT_URI+'profile/view/'+friend.user_id}">
                                <img alt="image" class="img-circle" src="${ROOT_URI + friend['frnd_image_path']}" />
                                <h3 class="m-b-xs"><strong>${friend.frnd_name}</strong></h3>
                                <div class="font-bold">${friend.frnd_occupation}</div>
                            </a>
                            <div class="contact-box-footer">
                                <div class="m-t-xs btn-group">
                                     <a href="${ROOT_URI+'messages?receiver_id=' + friend.user_id}" class="btn btn-xs btn-white">
                                        <i class="fa fa-envelope"></i>
                                        <span>Send Messages</span>
                                     </a>
                                     <a class="btn btn-xs btn-white">
                                        <i class="fa fa-user-times"></i>
                                        <span class="remove_frnd_link" data-id="${friend.id}">UnFriend</span>
                                    </a>
                                    <div class="text-md-center">
                                        <a class="btn btn-xs btn-white " href="${ROOT_URI+'friends/list/' + friend.user_id}">
                                        <i class="fa fa-user"></i>
                                        <span class="frnd_list_link" data-id="${friend.id}">friends list</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`
        }
        $('#li-container').html(lihtml);
        friends_container.append(html);
    }






})