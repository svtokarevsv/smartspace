document.addEventListener('DOMContentLoaded', function (e) {
    const search_container = $('#search_container')
    let search_term = $('#search_term')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(searchUsers, allItemsLoaded)
    //search users
    searchUsers()
    // submits search form
    $('#search-form').submit(function (e) {
        e.preventDefault()
        make_new_search();
    })
    //checks if search button is clicked
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('send_request_link'):
                const reqId = elem.getAttribute('data-id')
                sendRequest(reqId)
                break

        }
    })
    //function to send requests
    function sendRequest(reqId) {
        $.post(ROOT_URI + "friends/ajax_send_request", {reqId})
            .done(function (data) {
                if (data['result'] === 'ok') {
                    make_new_search()
                    notifyInfo('Request sent. Awaiting approval')
                }
                else{
                    $('#errors_container').html(getErrorsHtml(data['errors']))
                    notifyDanger('Error sending Request')
                }
            })
            .fail(function () {
                $('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
                notifyDanger('Sorry, we have problems. Try again later')
            });
    }
    // if new search is made
    function make_new_search() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        search_container.html('')
        searchUsers()
    }
    //search for users
    function searchUsers() {
        $('#loader').show();
        $.getJSON(ROOT_URI + "friends/ajax_searchUsers", {search_term: search_term.val(),page}, function (data) {
            page++
            fillUsers(data.users)
            if (data.users.length < PER_PAGE) {
                allItemsLoaded.loaded = true

            }
            $('#loader').hide();
            scrollListener.attach()
        })
    }
    //fill all users
    function fillUsers(users) {
        let html = ''
        for (let user of users) {
            html += `
			 <article class="white-card text-center col-md-3 animated fadeIn">
						<a href="${ROOT_URI + 'profile/view/' + user.id}">
							<img src="${ROOT_URI + user.avatar_path}" alt="${user.user_name}">
							<h3>${user.user_name}</h3>
						</a>
						<p><span class="white-card__title">Country: </span>${user.country || 'unknown'}</p>
						<p><span class="white-card__title">School: </span>${user.school_name || 'unknown'}</p>
						<p><span class="white-card__title">Program: </span>${user.program_name || 'unknown'}</p>
						${user.isFriend==1?'<span class="btn btn-light">Friends</span>':user.friendRequestSent==1?'<span class="btn btn-light">Awaiting Approval</span>':
                `<button style="cursor: pointer;" class="btn btn-azure send_request_link" data-id="${user.id}">Add Friend</button>`}
					</article>
			`
        }
        search_container.append(html);
    }
})