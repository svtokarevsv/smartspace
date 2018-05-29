document.addEventListener('DOMContentLoaded', function (e) {

    $('#timetable__create-button').click(function () {
        $('#timetable__create-form').submit()
    });
    $('#timetable__create-form').submit(function (e) {
        e.preventDefault();
        const that = this;
        $.ajax({
            type: "POST",
            url: ROOT_URI + "timetable/ajax_create_new_note",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if (data['result'] === 'success') {
                    notifySuccess('New note successfully added.');
                    location.reload();
                    that.reset()
                } else {
                    notifyDanger('Server error.')
                }
            },
        });
    });



    $('#timetable__edit-button').click(function () {
        $('#timetable__edit-form').submit()
    });
    $('#timetable__edit-form').submit(function (e) {
        e.preventDefault();
        const that = this;
        $.ajax({
            type: "POST",
            url: ROOT_URI + "timetable/ajax_edit_note",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if (data['result'] === 'success') {
                    notifySuccess('Note successfully edited.');
                    location.reload();
                    that.reset()
                } else {
                    notifyDanger('Server error.')
                }
            },
        });
    });



    $('#timetable__delete-button').click(function () {
        $('#timetable__delete-form').submit()
    });

    $('#timetable__delete-form').submit(function (e) {
        e.preventDefault();
        const that = this;
        $.ajax({
            type: "POST",
            url: ROOT_URI + "timetable/ajax_delete_note",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else if (data['result'] === 'success') {
                    notifySuccess('Note successfully deleted.');
                    location.reload();
                    that.reset()
                } else {
                    notifyDanger('Server error.')
                }
            },
        });
    });


});
