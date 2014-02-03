App.Invitations = {

	/**
	 * Init invites
	 * @return {void}
	 */
	init: function() {
		// ...
	},

	/**
	 * Init invites, always run
	 * @return {void}
	 */
	initAlways: function() {
		App.Invitations.initConfirmation();
		App.Invitations.publicConfirmation();
	},

	/**
	 * Init invite confirmation
	 * @return {void}
	 */
	initConfirmation: function() {
		$(".button.confirm-invitation").click(function() {
			if (confirm('Želiš potvrditi dolazak na termin?')) {
				var $btn   = $(this);
				var $event = $btn.closest(".event");

				// Progress
				NProgress.start();
				$event.fadeTo(100, .2);

				$.ajax({
					url: API_URL + '/invitations/confirm/' + $btn.attr('data-id'),
					type: 'POST',
					data: { param1: 'value1' },
				})
				.done(function() {
					NProgress.done();
					$event.addClass('event-confirmed');
					Crajax.refresh();
				})
				.fail(function() {
					alert("Greška!");
				})
				.always(function() {
					NProgress.done();
				});
			}

			return false;
		});
	},

	publicConfirmation: function() {
		$(".confirmation-form .button").click(function() {
			var $btn = $(this);
			var action = "confirm";
			if ($btn.hasClass("btn-cancel-invite")) action = "cancel";

			$("input[name=action]").val(action);
			$(".confirmation-form").submit();

			return false;
		});
	},

};
