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

		// Chart
		App.Stats.drawCharts();

	},

	drawCharts: function() {
		var $el  = $("#chart-320").get(0);
		var $el2 = $("#chart-640").get(0);

		if ($el) {
			var ctx = $el.getContext("2d");
			var myNewChart = new Chart(ctx);

			$.getJSON(APP_URL + '/api/stats/user-chart/4', {}, function(json, textStatus) {
				console.log(json);
				// new Chart(ctx).Line(json);
				new Chart(ctx).Bar(json);
			});

			var ctx2 = $el2.getContext("2d");
			var myNewChart2 = new Chart(ctx2);

			$.getJSON(APP_URL + '/api/stats/user-chart/4?limit=40', {}, function(json, textStatus) {
				console.log(json);
				// new Chart(ctx).Line(json);
				new Chart(ctx2).Bar(json);
			});



			var data = {
				labels : ["January","February","March","April","May","June","July"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : [65,59,90,81,56,55,40]
					},
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						data : [28,48,40,19,96,27,100]
					}
				]
			};


		}
	}

};
