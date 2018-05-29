document.addEventListener('DOMContentLoaded', function (e) {
    const job_container = $('#job-list')
    let page = 0
    let allItemsLoaded = {loaded: false}
    const scrollListener = attachToScroll(getJobs, allItemsLoaded)
    getJobs()
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('job__show-delete-modal'):
                const delete_id = elem.getAttribute('data-delete-id')
                openDeleteModal(delete_id)
                break
            case elem.classList.contains('job__show-edit-modal'):
                const edit_id = elem.getAttribute('data-edit-id')
                openEditModal(edit_id)
                break
        }
    })

    $('#job__edit-button').click(function (e) {
        $('#job__edit-form').submit()
    })

    $('#job__edit-form').submit(function (e) {
        e.preventDefault()
        const form=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "jobs/ajax_editJob",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if(data['result']==='ok') {
                    notifySuccess('Job successfully updated.')
                    reloadJobList()
                    //reset form after successful group creation
                    form.reset()
                }else{
                    notifyDanger('Server error')
                }
                $('#job__edit-modal').modal('hide')
            },
        });
    })

    $('#job__delete-button').click(function (e) {
        $('#job__delete-form').submit()
    })

    $('#job__delete-form').submit(function (e) {
        e.preventDefault()
        const form=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "jobs/ajax_deleteJob",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if(data['result']==='ok') {
                    notifySuccess('Job successfully deleted.')
                    reloadJobList()
                    //reset form after successful group creation
                    form.reset()
                }else{
                    notifyDanger('Server error')
                }
                $('#job__delete-modal').modal('hide')
            },
        });
    })

    $('#job__edit-country').change(function (e,callback) {
        var countryId = $(this).val();
        getCityByCountryId(countryId,callback);
    });

    function getCityByCountryId(countryId,callback){
        var output = "<option value=''>- Please select your job city -</option>";
        $.getJSON(ROOT_URI + "geo/ajax_getCitiesByCountryId", { countryId }, function (data) {
            $.each(data['cities'], function(index, value) {
                output += "<option value='" + value.id + "'>" + value.city + "</option>";
            });
            $("#job__edit-city").html(output);
            if(typeof callback==='function'){
                callback()
            }
        })
    }

    function openEditModal(edit_id) {
        $.getJSON(ROOT_URI + "jobs/ajax_getJobById", {edit_id}, function (data) {
            let dataJob = data.jobById
            $('#job__edit-id').val(edit_id)
            $('#job__edit-title').val(dataJob.title)
            $('#job__edit-description').val(dataJob.description)
            $('#job__edit-type').val(dataJob.type)
            $('#job__edit-dateclosed').val(dataJob.date_closed)
            $('#job__edit-salary').val(dataJob.salary)
            $('#job__edit-industry').val(dataJob.industry_id)
            $('#job__edit-country')
                .val(dataJob.country_id)
                .trigger("change",function () {
                        $('#job__edit-city').val(dataJob.city_id)
                    })
        })
        $('#job__edit-modal').modal('show')
    }

    function openDeleteModal(delete_id) {
        $('#job__delete-id').val(delete_id)

        $('#job__delete-modal').modal('show')
    }

    function fillJobs(jobs) {
        var html = "";
        for (var job of jobs){
            html += ` <div class="panel panel-heading event_dashboard" style="border-top: 2px solid #2dc3e8">
                        <h3 class="text-center text-info">
                            <a href='${ROOT_URI + "jobs/view/" + job['id']}'>${job['title']}</a>
                        </h3>
                        <h4 class="text-center">
                            <span class="text-info">at </span>
                            <span>${job['city']}, ${job['country']}</span>
                        </h4>
                        <div class="row">
                            <h5 class="col-xs-6" style="display: flex; justify-content: flex-end">
                                <span>${moment(job['date_posted']).format('ll')}</span>
                            </h5>
                            <h5 class="col-xs-6">
                                <span>${moment(job['date_closed']).format('ll')}</span>
                            </h5>
                        </div>
                        <div><a class="job__show-edit-modal" data-edit-id=${job['id']}>Edit</a></div>
                        <div><a class="job__show-delete-modal" data-delete-id=${job['id']}>Delete</a></div>
                    </div>`

        }
        job_container.append(html);


    }

    function getJobs() {
        $('#loader').show();
        $.getJSON(ROOT_URI + "jobs/ajax_getJobList", {page}, function (data) {
            page++
            fillJobs(data.jobs)
            if (data.jobs.length < PER_PAGE) {
                allItemsLoaded.loaded = true
            }
            $('#loader').hide();
            scrollListener.attach()
        })
    }

    function reloadJobList() {
        page = 0
        allItemsLoaded.loaded = false
        scrollListener.dettach()
        job_container.html('')
        getJobs();
    }

})