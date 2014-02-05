App.Stats = {

	init: function() {
		App.Matches.initAlways();
	},

	initAlways: function() {
		// ! Toggle stats
		$(".inter-player-toggle").click(function() {
			var $el = $(this);
			var $tr = $(".inter-player-" + $el.attr("data-toggle"));
			$tr.toggle();

			return false;
		});

		// Matches
		$(".total-matches-text").each(function() {
			var $el = $(this);
			var txt = $el.html();
			$el.closest("tbody").prev("thead").find(".total-matches-text-target").html(txt);
		});

		// Sets
		$(".total-sets-text").each(function() {
			var $el = $(this);
			var txt = $el.html();
			$el.closest("tbody").prev("thead").find(".total-sets-text-target").html(txt);
		});

	}

};
