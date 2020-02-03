(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$('form').on('submit', function(e) {
			e.preventDefault();

			let form = $(this);
			let url = form.attr('action');

			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				success: function (res) {
					console.log(res); // show response from the php script.
					
					if (!res.success) {
						console.log('no success');
						console.log($('#dh_form_errors'));
						$('#dh_form_errors').text(res.data);
						return;
					}

					window.location.href = $('input[name="redirect_to"]').val();
				}
			});

		});
		
	});

})( jQuery );
