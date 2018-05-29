document.addEventListener('DOMContentLoaded', function (e) {
	getContactList()
	let isLoading = false
	let previous_contact_id = null
	let previous_messages_count = 0
	const chat_form_contact = $('#contact_id')
	const receiver_from_url = parseInt((new URL(window.location.href)).searchParams.get("receiver_id"));
	if (receiver_from_url) {
		getMessagesWithContact(receiver_from_url)
	}

	setInterval(function () {
		getMessagesWithContact(chat_form_contact.val())
		getContactList()
	}, 7000)
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('friend-list__contact'):
				const id = elem.getAttribute('data-contact-id')
				if (!isLoading) {
					$('#friend_list>li').removeClass('active')
					elem.parentNode.classList.add('active')
				}
				getMessagesWithContact(id)
				break
			case elem.tagName === 'HTML':
				return
			default:
				elem.parentNode.click()
		}
	})
	$('#chat-form').submit(function (e) {
		e.preventDefault()
		const form = this
		$.ajax({
			type: "POST",
			url: ROOT_URI + "messages/ajax_send_message",
			data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					notifyDanger(getErrors(data.errors))
				} else {
					notifySuccess('Message sent')
					getContactList()
					getMessagesWithContact(chat_form_contact.val())
					//reset form after successful group creation
					form.reset()
				}
			},
		});
	})
	const search_users_with_delay = debounce(function (responseCallback) {
		$.getJSON({
			url: ROOT_URI + "search/ajax_searchUsersByNameOrEmail",
			data: {
				search_term: $('#search_contact').val()
			},
			success: function (data) {
				responseCallback(data.users);
			}
		})
	}, 400)
	$("#search_contact").autocomplete({
		source: function (request, response) {
			search_users_with_delay(response)
		},
		focus: function (event, ui) {
			//$( "#search" ).val( ui.item.title ); // uncomment this line if you want to select value to search box
			return false;
		},
		select: function (event, ui) {
			getMessagesWithContact(ui.item.id)
		}
	})
		.data("ui-autocomplete")._renderItem = function (ul, item) {
		let inner_html = `
						<div class="list_item_container">
							<div class="image">
								<img src="${ROOT_URI + item.avatar_path}" >
							</div>
							<div class="label">
								<h4>
									<b> ${item.label} </b>
								</h4>
							</div>
						</div>`;
		return $("<li></li>")
			.data("item.autocomplete", item)
			.append(inner_html)
			.appendTo(ul);
	};

	function shouldMessagesUpdate(contact_id, messages) {
		const should_update = previous_contact_id !== chat_form_contact.val() || messages.length !== previous_messages_count
		if (should_update) {
			previous_contact_id = contact_id
			previous_messages_count = messages.length
		}
		return should_update
	}

	function getContactList() {
		$.getJSON(ROOT_URI + "messages/ajax_get_contact_list", function (data) {
			fillContactList(data)
		})

	}

	function fillContactList(contacts) {
		let html = ''
		for (let contact of contacts) {
			html += `
			 <li class="${chat_form_contact.val() === contact.contact_id ? 'active' : ''}">
				<a data-contact-id="${contact.contact_id}" class="friend-list__contact" class="clearfix">
					<img src="${ROOT_URI + contact.contact_avatar_img}" alt="${contact.contact_name}" class="img-circle">
					<div style="width: 100%">
						<div class="friend-name">
							<strong>${contact.contact_name}</strong>
						</div>
						<div class="last-message text-muted">${contact.last_message}</div>
					</div>
					<span class="label label-info pull-right r-activity">${parseInt(contact.msgs_count) || ''}</span> 	
					<small class="time text-muted">${humanizeDate(contact.last_message_date)}</small>
					<!--<small class="chat-alert label label-danger">1</small>-->
				</a>
			</li>
			`
		}
		$('#friend_list').html(html)
	}

	function getMessagesWithContact(contact_id) {
		if (!contact_id || isLoading) return;
		isLoading = true
		$.getJSON(ROOT_URI + "messages/ajax_get_messages_with_contact", {contact_id}, function (data) {
			isLoading = false
			$("#search_contact").val('')
			if (!data || !data.contact) {
				notifyDanger('Such user wasn\'t found')
				return
			}
			if (shouldMessagesUpdate(contact_id, data.messages)) {
				fillChatHeader(data.contact)
				fillMessagesList(data.messages)
				$('#contact_id').val(contact_id)
				$('.chat-message__item').last()[0].scrollIntoView()
			}
		})
	}

	function fillChatHeader(contact) {
		$('#chat-message__header').html(`
			<a href="${ROOT_URI}profile/view/${contact.id}">
				<img class="img-circle"
					 src="${ROOT_URI + contact.avatar_img}"
					 alt="${contact.user_name}">

				<h3 class="username">
					${contact.user_name}
				</h3>
			</a>
		`)
	}

	function fillMessagesList(messages) {
		let html = ''
		for (let message of messages) {
			html += `
			 <li class="${message.sender_id === CURRENT_USER_ID ? 'right' : 'left'} chat-message__item clearfix">
                  <span class="chat-img ${message.sender_id === CURRENT_USER_ID ? 'pull-right' : 'pull-left'}">
                    <img src="${ROOT_URI + message.sender_avatar}" alt="${ROOT_URI + message.sender_name}">
                  </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">${message.sender_name}</strong>
                            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ${humanizeDate(message.time)}</small>
                        </div>
                        <p>
                            ${message.message}
                        </p>
                    </div>
                </li>
			`
		}
		if (messages.length === 0) {
			html = "<li class=\"text-center\">you don't have any messages with this user yet. Let's have one!</li>"
		}
		$('#messages_list').html(html)
	}

})
