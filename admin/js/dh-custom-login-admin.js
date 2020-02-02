(function( $ ) {
	'use strict';

	$(document).ready(function() {

		document.getElementById('dhcl_create_pages').addEventListener('click', async (e) => {
			e.preventDefault();

			await createPages();

			// since wordpress names submit button 'submit',
			// the submit property doesn't refer to the submit method.
			// so we submit it like this.
			// more info: https://trackjs.com/blog/when-form-submit-is-not-a-function/
			const f = document.getElementById('dhcl-settings-form');
			HTMLFormElement.prototype.submit.call(f);
		});
	});

})( jQuery );


async function createPages() {
	const loginSlug = $('#dhcl_login_slug').val();
	const signupSlug = $('#dhcl_signup_slug').val();
	const resetRequestSlug = $('dhcl_password_reset_email_slug').val();
	const resetPasswordSlug = $('dhcl_reset_password_slug').val();

	
}