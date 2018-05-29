function getErrorsHtml(errors) {
	if(errors.length===0) return '';
	let html='<ul class="alert alert-warning col-sm-12 pl3">'
	for(let error of errors){
		html+=`<li>${error}</li>`
	}
	html+='<ul>'
	return html
}
function getErrors(errors) {
	if(errors.length===0) return '';
	let html='<ul>'
	for(let error of errors){
		html+=`<li>${error}</li>`
	}
	html+='<ul>'
	return html
}
function notifyDanger(message) {
	$.notify({
		message
	}, {
		type: "danger",
		placement: {
			from: "bottom"
		}
	});
}
function notifySuccess(message) {
	$.notify({
		message
	}, {
		type: "success",
		placement: {
			from: "bottom"
		}
	});
}
function notifyInfo(message) {
	$.notify({
		message
	}, {
		type: "info",
		placement: {
			from: "bottom"
		}
	});
}
const debounce = (func, delay) => {
	let inDebounce
	return function() {
		const context = this
		const args = arguments
		clearTimeout(inDebounce)
		inDebounce = setTimeout(() =>
				func.apply(context, args)
			, delay)
	}
}
function attachToScroll(callback,allItemsLoaded) {
	function scrollListener() {
		const pageEnd = $(".footer").offset().top;
		const viewEnd = $(window).scrollTop() + window.outerHeight;
		const distance = pageEnd - viewEnd;
		if (distance < 10 && !allItemsLoaded.loaded) {
			dettach()
			callback();
		}
	}


	function attach() {
		$(window).scroll(scrollListener);
	}

	function dettach() {
		$(window).unbind('scroll', scrollListener);
	}
	return{
		dettach,
		attach
	}
}
function humanizeDate(date) {
	const momentDate = moment(date)
	if(momentDate.isBefore(moment().day(-1)) ){
		return momentDate.calendar()
	}else{
		return momentDate.fromNow(false)
	}
}