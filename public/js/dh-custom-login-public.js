(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$('form').on('submit', function(e) {
			e.preventDefault();

			let form = $(this);
			let actionUrl = form.attr('action');
			form = form.serializeArray();

			console.log('action url: ', actionUrl);
			console.log('making request');

			const urlParams = new URLSearchParams(window.location.search);
			const rpKey = urlParams.get('key');
			const rpLogin = urlParams.get('login');
			if (rpKey && rpLogin) {
				form = form.concat([
					{name: 'rp_key', value: rpKey},
					{name: 'login', value: rpLogin}
				]);
			}

			console.log(form);


			$.ajax({
				type: "POST",
				url: actionUrl,
				data: form, // serializes the form's elements.
				success: function (res) {
					console.log('res: ', res); // show response from the php script.

					const message = res.data;
					if (message) {
						$('#dh_form_messages').text(message);
					}
					
					if (!res.success) {
						console.log('no success');
						return;
					}

					// look for redirect location provided as query param 'next'
					const urlParams = new URLSearchParams(window.location.search);
					console.log('urlParams: ', urlParams);
					const next = urlParams.get('next');
					console.log('next: ', next);
					if (next) {
						window.location.href = next;
						return;
					}

					// look for redirect location provided in hidden input
					const redirectUrl = $('input[name="redirect_to"]').val();
					if (!redirectUrl) {
						window.location.href = redirectUrl;
						return;
					}

				},
				error: function (a,b,c) {
					console.log(a,b,c);
					$('#dh_form_messages').text(c);
				}
			});

		});
		
	});

})( jQuery );
