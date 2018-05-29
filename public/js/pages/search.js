document.addEventListener('DOMContentLoaded', function (e) {
	let search_term = $('#search_term')
	let page = 0
	let allItemsLoaded = {loaded: false}
	make_new_search()

	const scrollListener = attachToScroll(lazyLoadItems, allItemsLoaded)

	$('#search-form').submit(function (e) {
		e.preventDefault()
		make_new_search()
	})
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.getAttribute('role') === 'tab':
				make_new_search()
				break
		}
	})

	function make_new_search() {
		let containerId = $('#search__nav li.active>a').attr('href')
		page = 0
		allItemsLoaded.loaded = false
		$(containerId).html('')
		lazyLoadItems()
	}

	function lazyLoadItems() {
		// Each time the user scrolls
		let requestUri = ''
		let containerId = $('#search__nav li.active>a').attr('href')

		$('#loader').show();
		switch (containerId) {
			case '#people':
				requestUri = 'search/ajax_searchUsers'
				break
			case '#groups':
				requestUri = 'search/ajax_searchGroups'
				break
			case '#events':
				requestUri = 'search/ajax_searchEvents'
				break
			case '#jobs':
				requestUri = 'search/ajax_searchJobs'
				break
			default:
				return;
		}
		$.getJSON(ROOT_URI + requestUri, {search_term: search_term.val(), page}, function (data) {
			page++
			switch (containerId) {
				case '#people':
					fillPeople(data.users)
					if (data.users.length < PER_PAGE) {
						allItemsLoaded.loaded = true
					}
					break
				case '#groups':
					fillGroups(data.groups)
					if (data.groups.length < PER_PAGE) {
						allItemsLoaded.loaded = true
					}
					break
				case '#events':
					fillEvents(data.events)
					break
				case '#jobs':
					fillJobs(data.jobs)
					break
				default:
					return;
			}

			$('#loader').hide();
			scrollListener.attach()
		})
	}

	function fillPeople(users) {
		let html = ''
		for (let user of users) {
			html += `
					<article class="white-card col-md-2 animated fadeIn">
						<a href="${ROOT_URI + 'profile/view/' + user.id}">
							<img src="${ROOT_URI + user.avatar_path}" alt="${user.user_name}">
							<h3>${user.user_name}</h3>
						</a>
						<p><span class="white-card__title">Country: </span>${user.country || 'unknown'}</p>
						<p><span class="white-card__title">School: </span>${user.school_name || 'unknown'}</p>
						<p><span class="white-card__title">Program: </span>${user.program_name || 'unknown'}</p>
					</article>
			`
		}
		$('#people').append(html);
	}

	function fillGroups(groups) {
		let html = ''
		for (let group of groups) {
			html += `
					<article class="white-card col-md-3 animated fadeIn">
						<a href="${ROOT_URI + 'groups/view/' + group.id}">
							<img src="${ROOT_URI + group.avatar_path}" alt="${group.name}">
							<h3>${group.name}</h3>
						</a>
						<p>${group.description}</p>
					</article>`
		}
		$('#groups').append(html);
	}

})