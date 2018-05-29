window.fbAsyncInit = function() {
    FB.init({
        appId            : '411568342647090',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v2.12'
    });


   /* FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });*/
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response) {
    if(response.status === 'connected'){
        console.log('logged in and authorized');
        testAPI();
    }else{
        console.log('not authorized');
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function testAPI(){
    FB.api('/me?fields=name,email', function(response){
        if(response && !response.error){
            console.log(response);
        }
		$.post(ROOT_URI + "authorization/ajax_login_with_fb", response)
			.done(function (data) {
				if (data['errors'] && data['errors'].length > 0) {
					notifyDanger(getErrors(data['errors']))
				} else if(data.redirect){
					notifySuccess('You are logged in. Redirecting...')
					location.href=data.redirect
					//reset form after successful group creation
				}else{
					notifyDanger('Unfortunately, couldn\'t connect using Facebook. Try default login')
				}
			})
			.fail(function () {
				$('#errors_container').html('<p>Sorry, we have problems. Try again later</p>')
				notifyDanger('Sorry, we have problems. Try again later')
			});
    })
}