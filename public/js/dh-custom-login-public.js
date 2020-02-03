(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$('form').on('submit', function(e) {
			e.preventDefault();

			let form = $(this);
			let url = form.attr('action');
			console.log('action url: ', url);
			console.log('making request');

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
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

					const redirectUrl = $('input[name="redirect_to"]').val();
					if (!redirectUrl) {
						// we're not on a page that needs / wants a redirect
						return;
					}

					window.location.href = redirectUrl;
				},
				error: function (a,b,c) {
					console.log(a,b,c);
				}
			});

		});
		
	});

})( jQuery );
