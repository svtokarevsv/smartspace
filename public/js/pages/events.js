document.addEventListener('DOMContentLoaded', function (e) {
    const events_container = $('#events')
    let search_term = $('#search_term_events')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(searchEvents, allItemsLoaded)
    searchEvents()

    $('#search-form').submit(function (e) {
        e.preventDefault()
        make_new_search();
    })


    $('#create_event').click(function (e) {
        $('#create_event_form').submit()
    })

    $('#create_event_form').submit(function (e) {
        e.preventDefault()
        const that=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "events/ajax_create_event",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if(data['result']==='ok') {
                    notifySuccess('Event successfully created')
                    make_new_search()
                    //reset form after successful group creation
                    that.reset()
                }else{
                    notifyDanger('Server error')
                }
                $('#create_event_modal').modal('hide')
            },
        });
    })











    $('#edit_event').click(function (e) {
        $('#edit_event_form').submit()
    })

    $('#edit_event_form').submit(function (e) {
        e.preventDefault()
        const that=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "events/ajax_edit_event",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if(data['result']==='ok') {
                    notifySuccess('Event successfully updated')
                    make_new_search()
                    //reset form after successful event update
                    that.reset()
                }else{
                    notifyDanger('Server error')
                }
                $('#edit_event_modal').modal('hide')
            },
        });
    })

    function openEditModal(id) {
        $.getJSON(ROOT_URI + "events/ajax_getEventById", {id}, function (data) {
            const modal = $('#edit')
            const form = $('#edit_event_form')[0]
            form['elements']['edit_event_name'].value = data['event_name']
            form['elements']['edit_event_location'].value = data['event_location']
            form['elements']['edit_event_start'].value = new Date(data['event_start']).toISOString().substring(0, 10)
            form['elements']['edit_event_end'].value = new Date(data['event_end']).toISOString().substring(0, 10)
            form['elements']['edit_event_description'].value = data['event_description']

            form['elements']['edit_event_id'].value = data['id']

            modal.modal('show')
        })
    }

    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('edit_form'):
                const edit_id = elem.getAttribute('data-id')
                openEditModal(edit_id)
                break
            case elem.classList.contains('delete_form'):
                const delete_id = elem.getAttribute('data-id')
                openDeleteModal(delete_id)
                break

        }
    })
















    $('#delete_event').click(function (e) {
        $('#delete_event_form').submit()
    })

    $('#delete_event_form').submit(function (e) {
        e.preventDefault()
        const that=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "events/ajax_delete_event",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if(data['result']==='ok') {
                    notifySuccess('Event successfully deleted')
                    make_new_search()
                    //reset form after successful event delete
                    that.reset()
                }else{
                    notifyDanger('Server error')
                }
                $('#delete_event_modal').modal('hide')
            },
        });
    })

    function openDeleteModal(id) {
        $.getJSON(ROOT_URI + "events/ajax_getEventById", {id}, function (data) {
            const modal = $('#delete')
            const form = $('#delete_event_form')[0]

             form['elements']['delete_event_id'].value = data['id']

            modal.modal('show')
        })
    }












    function fillEventsOfAllUsers() {
        $.getJSON(ROOT_URI + "events/ajax_getAllEvents", function (data) {
            fillEvents(data.events)
        })
    }

    function fillEvents(events) {
        var html = "";
        for (var event of events){
        html += ` <div class="panel panel-heading event_dashboard" style="border-top: 2px solid #2dc3e8">
                        <h3 class="text-center text-info">
                            <span>${event['event_name']}</span>
                        </h3>
                        <h4 class="text-center">
                            <span class="text-info">at </span>
                            <span>${event['event_location']}</span>
                        </h4>
                        <div class="row">
                            <h5 class="col-xs-6" style="display: flex; justify-content: flex-end">
                                <span>${moment(event['event_start']).format('ll')}</span>
                                <span class="text-muted" style="margin:0 5px"> From </span>
                                <span> ${moment(event['event_end_time'], "hh:mm:ss").format("h:mm A")}</span>
                            </h5>
                            <h5 class="col-xs-6">
                                <span>${moment(event['event_end']).format('ll')}</span>
                                <span class="text-muted" style="margin:0 5px"> Till </span>
                                <span> ${moment(event['event_end_time'], "hh:mm:ss").format("h:mm A")}</span>
                            </h5>
                        </div>
                        <hr style="margin-top: 0; margin-bottom: 5px"/>
                        <div style="display: flex; justify-content: flex-end;">
                            <span class="right"><a class="btn btn-default" id="details" href="${ROOT_URI + "events/event_details/" + event["id"]}" >Details</a></span>
                            ${event['creator_id']===CURRENT_USER_ID?`<span><a style="margin: 0 4px" data-id="${event["id"]}" class="edit_form btn btn-warning">Edit</a></span>`: ""}
                            ${event['creator_id']===CURRENT_USER_ID?`<span><a data-id="${event["id"]}" class="delete_form btn btn-danger">Delete</a></span>`: ""}
                        </div>
                    </div>`

        }
        $('#events').append(html);


    }




    function make_new_search() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        events_container.html('')
        searchEvents()
    }

    function searchEvents() {
        $('#loader').show();
        $.getJSON(ROOT_URI + "events/ajax_getAllEvents", {search_term: search_term.val(),page}, function (data) {
            page++
            fillEvents(data.events)
            if (data.events.length < PER_PAGE) {
                allItemsLoaded.loaded = true

            }
            $('#loader').hide();
            scrollListener.attach()
        })
    }
    
})