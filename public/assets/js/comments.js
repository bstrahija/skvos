App.Comments = {

	refreshInterval: false,

	init: function() {

	},

	initAlways: function() {
		// Refresh in interval
		clearInterval(App.Comments.refreshInterval);
		App.Comments.refreshInterval = setInterval(function() {
			var event_id = $(".comments-container form").find("input[name=event_id]").val();
			if (event_id) App.Comments.refresh(event_id);
		}, 5000);

		$(".comments-container form").submit(function() {
			var $form      = $(this);
			var $container = $form.closest('.comments-container');
			var $input     = $form.find('input[name=text]');
			var message    = $form.find('input').val();
			NProgress.start();

			$.ajax({
				url: APP_URL + '/api/comments',
				type: 'POST',
				data: {
					text:     $input.val(),
					event_id:  $form.find('input[name=event_id]').val(),
					author_id: $form.find('input[name=author_id]').val()
				}
			})
			.done(function(response) {
				/*$('html, body').animate({
					scrollTop: $("#comments-container").offset().top
				}, 100);*/

				App.Comments.refresh(response.event_id);
			})
			.fail(function() {
				alert("Greška!");
			})
			.always(function() {
				console.log("complete");
				$input.val("");
				NProgress.done();
			});

			return false;
		});
	},

	refresh: function(eventId) {
		$.ajax({
			url: APP_URL + '/comments/items/' + eventId
		})
		.done(function(response) {
			$(".comments").html(response);
		})
		.fail(function() {
			console.log("error");
		});
	}

};
