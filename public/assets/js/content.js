App.Content = {

	init: function() {
		this.initDashboard();
		this.initSelectboxes();
	},

	initDashboard: function() {
		$(".panel .toggle").click(function() {
			var $el     = $(this);
			var $panel  = $el.closest("li");
			var $people = $panel.find(".people");

			$people.slideToggle(100);

			return false;
		});
	},

	initSelectboxes: function() {
		if ( ! this.isMobile()) {
			$(".select2").select2({
				width: "100%",
				placeholder: "Biraj...",
				allowClear: true
			});

			$(".multiselect").multiselect({
				buttonClass: 'btn',
				buttonWidth: '100%'
			});
		}
	},

	isMobile: function() {
		if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) return true;

		return false;
	}

};
