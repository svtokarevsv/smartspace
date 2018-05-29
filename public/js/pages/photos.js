document.addEventListener('DOMContentLoaded', function (e) {
    getCurrentUserImages()
    $('#add_image').click(function (e) {
        $('#add_image_form').submit()
    })
    $('#delete_image').click(function (e) {
        $('#delete_image_form').submit()
    })
    $('#add_image_form').submit(function (e) {
        e.preventDefault()
        const that=this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "photos/ajax_add_image",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else {
                    notifySuccess('Image successfully added')
                    getCurrentUserImages()
                    //reset form after successful group creation
                    that.reset()
                }
                $('#create_image_modal').modal('hide')
            },
        });
    })
    $('#delete_image_form').submit(function (e) {
        e.preventDefault()
        const that = this
        $.ajax({
            type: "POST",
            url: ROOT_URI + "photos/ajax_delete_image_by_id",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data['errors'] && data['errors'].length > 0) {
                    notifyDanger(getErrors(data['errors']))
                } else {
                    notifySuccess('image deleted successfully')
                    getCurrentUserImages()
                    //reset form after successful group update
                    that.reset()
                }
                $('#delete_image_modal').modal('hide')
            },
        });
    })
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('photos-list__image'):
                const src = elem.getAttribute('src')
                const title = elem.getAttribute('alt')
                openViewModal(src,title)
                break
            case elem.classList.contains('photos-list__delete'):
                const id = elem.getAttribute('data-id')
                openDeleteModal(id)
                break
        }
    })
    function openViewModal(src,title) {
        const modal = $('#view_image_modal')
        const image = $('#view_image__photo')
        image.attr('src',src)
        image.attr('alt',title)
        $('#view_image__title').text(title)
        modal.modal('show')
    }
    function openDeleteModal(id) {
        const modal = $('#delete_image_modal')
        $('#delete_image_id').val(id)
        modal.modal('show')
    }
    function getCurrentUserImages() {
        $.getJSON(ROOT_URI + "photos/ajax_get_current_user_images", function (images) {
            fillImages(images)
        })
    }
    function fillImages(images) {
        let html = ''
        for (let image of images) {
            html += `
			 <div class="col-md-4 col-sm-6 col-xs-12 photos-list__item">
                    <figure  class="tac">
                        <img  class="photos-list__image" src="${ROOT_URI+image.image_path}" alt="${image.image_title}">
                        <figcaption>${image.image_title}${image.creator_id===CURRENT_USER_ID?
                `<button data-id="${image.id}" class="btn btn-danger photos-list__delete" type="button">Delete</button>`:
                ''}
                        </figcaption>
                    </figure>
                </div>
			`
        }
        $('#photos-list__container').html(html);
    }
})
