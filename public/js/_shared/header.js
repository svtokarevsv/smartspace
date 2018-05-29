document.addEventListener('DOMContentLoaded', function (e) {
	"use strict"
	let previous_number_new_messages = null
	const notif_audio = new Audio(ROOT_URI + 'media/notif.mp3');
	checkNewMessages()
	setInterval(checkNewMessages, 10000)

	function checkNewMessages() {
		$.getJSON(ROOT_URI + "messages/ajax_get_count_unviewed_messages", function (number_of_new_messages) {
			number_of_new_messages = parseInt(number_of_new_messages)
			if (number_of_new_messages > previous_number_new_messages&&previous_number_new_messages!==null) {
				notif_audio.play();
			}
			if (number_of_new_messages !== previous_number_new_messages) {
				updateNewMessageNotifications(number_of_new_messages)
			}
		})
	}

	function updateNewMessageNotifications(number_of_new_messages) {
		number_of_new_messages = number_of_new_messages || ''
		$('.new-message-notification').text(number_of_new_messages)
		previous_number_new_messages = number_of_new_messages
	}
})