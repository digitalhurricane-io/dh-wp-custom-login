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
					
					if (!res.success) {
						console.log('no success');
						$('#dh_form_errors').text(res.data);
						return;
					}

					window.location.href = $('input[name="redirect_to"]').val();
				},
				error: function (a,b,c) {
					console.log(a,b,c);
				}
			});

		});
		
	});

})( jQuery );
