App.Matches = {

	init: function() {
		App.Matches.initAlways();
	},

	initAlways: function() {
		App.Matches.initNewMatch();

		$(".match-delete-form").submit(function() {
			if (confirm("Jesi siguran?")) {
				return true;
			}

			return false;
		});
	},

	/**
	 * Logic for entering a new match
	 * @return {void}
	 */
	initNewMatch: function() {
		// Set score
		$(".match-playing .button.inc-dec").click(function() {
			var $btn = $(this);
			var inc  = $btn.hasClass('inc') ? 1 : -1;
			var $inp = $btn.closest("ul").find(".score");
			var val  = parseInt($inp.val()) + inc;

			// No negative numbers
			if (val < 0) val = 0;

			// Set it
			$inp.val(val);

			return false;
		});

		// Submit form
		$(".new-match-form").submit(function() {
			var data = {
				player1_id: $("select[name=player1_id]").val(),
				player2_id: $("select[name=player2_id]").val(),
				player1_score: $("input[name=player1_score]").val(),
				player2_score: $("input[name=player2_score]").val(),
				event_id: $("input[name=event_id]").val(),
			};

			// Check players
			if (data.player1_id == data.player2_id) {
				alert('Odaberi različite igrače!');
				return false;
			}

			// Check score
			if (data.player1_score == data.player2_score) {
				alert('Rezultat ne može biti izjednačen!');
				return false;
			}

			$(".new-match-form").stop().fadeTo(100, .2);

			// Send request
			$.ajax({
				url: API_URL+'/matches',
				type: 'POST',
				data: data,
			})
			.done(function() {
				$("select[name=player1_id]").val(1);
				$("select[name=player2_id]").val(1);
				$("input[name=player1_score], input[name=player1_score]").val(0);

				// Refresh results
				App.Matches.refresResults();
			})
			.fail(function() {
				alert("Greška!");
			})
			.always(function() {
				$(".new-match-form").stop().fadeTo(100, 1);
			});

			return false;
		});
	},

	/**
	 * Refresh the results
	 * @return {void}
	 */
	refresResults: function() {
		Crajax.refresh(true);
	}

};
