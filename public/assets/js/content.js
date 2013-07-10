App.Content = {

	init: function() {
		this.initDashboard();
	},

	initDashboard: function() {
		$(".panel .toggle").click(function() {
			var $el     = $(this);
			var $panel  = $el.closest("li");
			var $people = $panel.find(".people");

			$people.slideToggle(100);

			return false;
		});
	}

};
