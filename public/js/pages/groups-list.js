document.addEventListener('DOMContentLoaded', function (e) {
	const groups_container = $('#groups-list__container')
	let search_term = $('#search_term')
	let page = 0
	let allItemsLoaded = {loaded: false}
	const scrollListener = attachToScroll(searchGroups, allItemsLoaded)

	searchGroups()
	$('#search-form').submit(function (e) {
		e.preventDefault()
		make_new_search();
	})
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('group_join'):
				const groupId = elem.getAttribute('data-id')
				joinGroup(groupId)
				break
		}
	})

	function joinGroup(groupId) {
		$.post(ROOT_URI + "groups/ajax_join_group", {groupId})
			.done(function (data) {
				if (data['result'] === 'ok') {
					$('#search-form').submit()
					notifySuccess("Group successfully joined")
				} else {
					$('#errors_container').html(getErrorsHtml(data['errors']))
					notifyDanger('Couldn\'t join the group')
				}
			})
			.fail(function () {
				$('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
			});
	}

	function make_new_search() {
		page = 0
		allItemsLoaded.loaded = false
		scrollListener.dettach()
		groups_container.html('')
		searchGroups()
	}
	function searchGroups() {
		$('#loader').show();
		$.getJSON(ROOT_URI + "groups/ajax_searchGroups", {search_term: search_term.val(),page}, function (data) {
			page++
			fillGroups(data.groups)
			if (data.groups.length < PER_PAGE) {
				allItemsLoaded.loaded = true

			}
			$('#loader').hide();
			scrollListener.attach()
		})
	}

	function fillGroups(groups) {
		let html = ''
		for (let group of groups) {
			html += `
			 <div class="col-md-6 groups-list__item">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><a href="${ROOT_URI}groups/view/${group['id']}">${group['name']}</a></h3>
                            ${group['creator_id'] === CURRENT_USER_ID ? `<span class="edit_group_link" data-id="${group.id}">Edit</span>` : ''}
                        </div>
                        <div class="panel-body">
							<div class="col-xs-3">
								<a href="${ROOT_URI}groups/view/${group['id']}">
									<img  src="${ROOT_URI + group['avatar_path']}" alt="${group['name']}">
								</a>
							</div>
							<div class="col-xs-7">
							   <p>${group['description'].length > 50 ? group['description'].substring(0, 50) + '...' : group['description']}</p>
							</div>
							<div class="col-xs-2">
								${parseInt(group['isMember']) > 0 ?
				'<span class="checkmark"></span>' :
				`<button class="btn btn-primary group_join" data-id="${group['id']}">Join</button>`}
							</div>                            
                        </div>
                    </div>
                </div>
			`
		}
		groups_container.append(html);
	}
})