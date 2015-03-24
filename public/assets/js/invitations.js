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
			var $btn = $(this);

			swal({
				title: "Potvrda",
				text: "Želiš potvrditi dolazak na termin?",
				type: "success",
				showCancelButton: true,
				confirmButtonColor: "#A6DB8A",
				confirmButtonText: "Da!",
				cancelButtonText: "Ne"
			}, function() {
				var $event = $btn.closest(".event");

				App.Invitations.confirmInvitation($btn, $event);
			});

			return false;
		});

		$(".button.cancel-invitation").click(function() {
			var $btn = $(this);

			swal({
				title: "Potvrda",
				text: "Želiš otkazati dolazak na termin?",
				type: "error",
				showCancelButton: true,
				confirmButtonColor: "#A6DB8A",
				confirmButtonText: "Da!",
				cancelButtonText: "Ne"
			}, function() {
				var $event = $btn.closest(".event");

				App.Invitations.cancelInvitation($btn, $event);
			});

			return false;
		});
	},

	confirmInvitation: function($btn, $event) {
		NProgress.start();
		$event.fadeTo(100, .2);

		$.ajax({
			url: API_URL + '/invitations/confirm/' + $btn.attr('data-id'),
			type: 'POST'
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
	},

	cancelInvitation: function($btn, $event) {
		NProgress.start();
		$event.fadeTo(100, .2);

		$.ajax({
			url: API_URL + '/invitations/cancel/' + $btn.attr('data-id'),
			type: 'POST'
		})
		.done(function() {
			NProgress.done();
			$event.addClass('event-canceled');
			Crajax.refresh();
		})
		.fail(function() {
			alert("Greška!");
		})
		.always(function() {
			NProgress.done();
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
