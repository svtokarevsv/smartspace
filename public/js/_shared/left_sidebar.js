document.addEventListener('DOMContentLoaded', function (e) {
	$(document).click(function (e) {
		const elem = e.target
		switch (true) {
			case elem.classList.contains('button-random-info'):
				createRandomFactOrJoke()
				break
			// case elem.classList.contains('delete_post_link'):
			// 	const delid = elem.getAttribute('data-id')
			// 	openDeleteModal(delid)
			// 	break
		}
	})

	function createRandomFactOrJoke() {
		let source = Math.floor(Math.random() * 3 + 1)
		switch (source) {
			case 1:
				$.getJSON(ROOT_URI+'external/ajax_get_random_fact_by_year',fillFact)
				break
			case 2:
				source =
				$.getJSON(ROOT_URI+'external/ajax_get_random_fact_by_date', fillFact)
				break
			case 3:
				$.getJSON('https://api.chucknorris.io/jokes/random', function(data){
					fillFact(data.value)
				})
				break
		}

	}

	function fillFact(data) {
		$('#interecting_fact__paragraph').text(data)
		$('#interesting_fact_modal').modal('show')
	}
})
