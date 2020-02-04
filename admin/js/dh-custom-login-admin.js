(function( $ ) {
	'use strict';

	$(document).ready(function() {

		document.getElementById('dhcl_create_pages').addEventListener('click', async (e) => {
			e.preventDefault();

			await createPages($);

			// since wordpress names submit button 'submit',
			// the submit property doesn't refer to the submit method.
			// so we submit it like this.
			// more info: https://trackjs.com/blog/when-form-submit-is-not-a-function/
			const f = document.getElementById('dhcl-settings-form');
			HTMLFormElement.prototype.submit.call(f);
		});
	});

})( jQuery );


async function createPages($) {
	const loginSlug = $('#dhcl_login_slug').val();
	const signupSlug = $('#dhcl_signup_slug').val();
	const resetRequestSlug = $('#dhcl_password_reset_email_slug').val();
	const resetPasswordSlug = $('#dhcl_reset_password_slug').val();

	const data = [
		{name: 'login_slug', value: loginSlug},
		{name: 'signup_slug', value: signupSlug},
		{name: 'reset_request_slug', value: resetRequestSlug},
		{name: 'reset_password_slug', value: resetPasswordSlug},
		{name: '_wpnonce', value: $('#_wpnonce')}
	]

	let url = '/wp-admin/admin-ajax.php?action=dhcl_create_default_pages';

	let res;
	try {
		res = await ajaxPromise({
			type: "POST",
			url: url,
			data: data, }, $);
	} catch(e) {
		console.log(e);
	}

	console.log('res: ', res); // show response from the php script.

	// const message = res.data;
	// if (message) {
	// 	$('#dh_form_messages').text(message);
	// }

	if (res && res.success) {
		console.log('success');
		return;
	}
	console.log('no success');
}

function ajaxPromise(options, $) {
	return new Promise((resolve, reject) => {
		$.ajax(options).done(resolve).fail(reject);
	});
}