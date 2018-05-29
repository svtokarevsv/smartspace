
document.addEventListener('DOMContentLoaded', function (e) {
    fillCurrentFriendRequests()
    //click decline request button
    $('#remove_request').click(function (e) {
        $('#remove_request_form').submit()
    })
    //submits decline request form
    $('#remove_request_form').submit(function (e) {
        e.preventDefault()
        const that = this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "friends/ajax_delete_requests_by_id",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data['result'] === 'ok') { {
                    fillCurrentFriendRequests()
                    notifyInfo('Friend Request deleted')
                }} else {
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Couldn\'t delete Friend Request from list')
                    //reset form after successful group update
                    that.reset()
                }
                $('#remove_request_modal').modal('hide')
            },
        });
    })
    //check if decline or accept button is clicked
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('decline_request_link'):
                const id = elem.getAttribute('data-id')
                openRemoveModal(id)
                break
            case elem.classList.contains('accept_request_link'):
                const reqId = elem.getAttribute('data-id')
                processRequest(reqId)
                break

        }
    })
    //process request- delete request from user requests table and calls accept request function
    function processRequest(reqId) {
        acceptRequest(reqId)
        $.post(ROOT_URI + "friends/ajax_delete_request", {reqId})
            .done(function (data) {
                if (data['result'] === 'ok') {
                    fillCurrentFriendRequests()
                    notifyInfo('You accept the request. You are now friends.')
                }
                else{
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Error accepting Request')
                }
            })
            .fail(function () {
                $('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
                notifyDanger('Sorry, we have problems. Try again later')
            });
    }
    //accepts friend request and add users to friends table
    function acceptRequest(reqId) {
        $.post(ROOT_URI + "friends/ajax_add_new_friend_fromrequest", {reqId})
            .done(function (data) {
                if (data['result'] === 'ok') {
                    fillCurrentFriendRequests()
                }
                else{
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Error accepting Request')
                }
            })
            .fail(function () {
                $('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
                notifyDanger('Sorry, we have problems. Try again later')
            });
    }
    //open decline modal
    function openRemoveModal(id) {
        $.getJSON(ROOT_URI + "friends/ajax_getRequestsById",{id}, function (data) {
            const modal = $('#remove_request_modal')
            const form = $('#remove_request_form')[0]

            form['elements']['remove_request_id'].value=data['id']
            modal.modal('show')
        })
    }

    function fillCurrentFriendRequests() {
        $.getJSON(ROOT_URI + "friends/ajax_get_friend_requests", function (data) {
            fillRequests(data.friendRequests)

        })
    }
    //displays friend requests
    function fillRequests(friendRequests) {
        let html = ''
        for (let request of friendRequests) {
            html += ` <div class="widget col-md-12">
             <div class="widget-body">
                <div class="request-image ">
                     <a href="${ROOT_URI+'profile/view/'+ request.sender_id}"><img class="sender-image" src="${ROOT_URI + request['sender_image_path']}" alt="User Image"></a>
                </div>
                 <div class="wall-user-details">
                     <h3><a href="${ROOT_URI+'profile/view/'+ request.sender_id}">${request.sender_name}</a> sent you a Friend Request.</h3>
                 </div>
                 <div class="pull-right">
                 
                     <button style="cursor: pointer;" class=" btn btn-azure accept_request_link mr2" data-id="${request.id}">Accept</button>
                     <button style="cursor: pointer;" class="btn btn-azure decline_request_link" data-id="${request.id}">Decline</button>
                 </div>
                 <div class="clearfix"></div>
             </div>
         </div>`
        }
        $('#friend-request__container').html(html);
    }
})