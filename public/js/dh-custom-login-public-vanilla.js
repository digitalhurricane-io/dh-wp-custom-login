
const dhclForm = document.getElementsByName('dhclform')[0];

dhclForm.addEventListener("submit", function(e) {
	e.preventDefault();

	// these will only exist if we're on signup page
	try {
		document.getElementsByClassName('sign-up-btn-text')[0].classList.add('pnp-hide');
		document.getElementsByClassName('pnp-loading-spinner')[0].classList.remove('pnp-hide');
		document.getElementsByClassName('signup-button')[0].disabled = true;
	} catch(e) {console.log(e);}

	let actionUrl = dhclForm.action;

	formData = formToObject(dhclForm);
	console.log('formData: ', formData);

	const urlParams = new URLSearchParams(window.location.search);
	const rpKey = urlParams.get('key');
	const rpLogin = urlParams.get('login');
	if (rpKey && rpLogin) {
		formData['rp_key'] = rpKey;
		formData['login'] = rpLogin;
	}

	var formBody = [];
	for (var property in formData) {
		var encodedKey = encodeURIComponent(property);
		var encodedValue = encodeURIComponent(formData[property]);
		formBody.push(encodedKey + "=" + encodedValue);
	}
	formBody = formBody.join("&");

	fetch(actionUrl, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
		},
		body: formBody
	}).then((res) => {

		if (!res.ok) {
			console.error("request failure. status code: ", res.status);
			dhclResetForm("request failure");
			return;
		}

		res.json().then((body) => {
			console.log('body: ', body);
			const message = body.data;
			if (message) {
				dhclResetForm(message);
			}

			if (!body.success) {
				return;
			}

			// look for redirect location provided as query param 'next'
			const urlParams = new URLSearchParams(window.location.search);

			const next = urlParams.get('next');

			if (next) {
				window.location.href = next;
				return;
			}

			// look for redirect location provided in hidden input
			const redirectUrl = document.getElementsByName('redirect_to')[0].value;

			if (redirectUrl) {
				window.location.href = redirectUrl;
				return;
			}
		})
		.catch((e) => {
			console.error(e);
			dhclResetForm(e.message);
		});

	})
	.catch((e) => {
		console.error(e);
		dhclResetForm(e.message);
	});;

});

function formToObject(form) {
	const inputElements = form.getElementsByTagName("input");
	const obj = {};

	for (var i = 0; i < inputElements.length; i++) {
		const inputElement = inputElements[i];
		obj[inputElement.name] = inputElement.value;
	}

	return obj;
}

// set message and enable button
function dhclResetForm(message) {

	const m = message ? message : '';

	try {
		document.getElementById('dh_form_messages').innerText = m;
	} catch(e) {}

	try {
		// these will only exist if we're on signup page
		document.getElementsByClassName('sign-up-btn-text')[0].classList.remove('pnp-hide');
		document.getElementsByClassName('pnp-loading-spinner')[0].classList.add('pnp-hide');
		document.getElementsByClassName('signup-button')[0].disabled = false;
	} catch(e) {console.log(e);}

}
		



