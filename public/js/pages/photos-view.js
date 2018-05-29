document.addEventListener('DOMContentLoaded', function (e) {
    const user_id=ROUTER.params[0]
    getUserImages(user_id)
    $(document).click(function (e) {
        const elem = e.target
        switch (true){
            case elem.classList.contains('photos-list__image'):
                const src = elem.getAttribute('src')
                const title = elem.getAttribute('alt')
                openViewModal(src,title)
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

    function getUserImages(user_id) {
        $.getJSON(ROOT_URI + "photos/ajax_get_user_images",{user_id}, function (images) {
            fillImages(images)
        })
    }
    function fillImages(images) {
        let html = ''
        for (let image of images) {
            html += `
			 <div class="col-sm-6 col-xs-12 photos-list__item">
                    <figure class="tac">
                        <img  class="photos-list__image" src="${ROOT_URI+image.image_path}" alt="${image.image_title}">
                        <figcaption>${image.image_title}
                        </figcaption>
                    </figure>
                </div>
			`
        }
        $('#photos-list__container').html(html);
    }
})
