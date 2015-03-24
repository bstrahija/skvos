App = {

	// Detect iOS
	ios: ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false ),

	/**
	 * Init app
	 * @return {void}
	 */
	init: function() {
		// Detect fullscreen app
		if (window.navigator.standalone) {
			$("body").addClass("fullscreen");
		}

		// ! Toggle the menu
		$(".menu-toggle").click(function() {
			$("#nav, #main, #hd1, #off-canvas").toggleClass("menu-active");

			return false;
		});
		$("#off-canvas").click(function() {
			$("#nav, #main, #hd1, #off-canvas").removeClass("menu-active");
		});

		App.initAlways();
		Crajax.init();
	},

	/**
	 * Init after every ajax link
	 * @return {void}
	 */
	initAlways: function() {
		// ! Knobs
		$(".knob").knob();

		// ! Some fancy rotations
		$(".stat canvas").addClass("rotate-reverse");
		$(".stat").click(function() {
			$(this).find("canvas").toggleClass("rotate");
			$(this).find("canvas").toggleClass("rotate-reverse");
		});

		// ! Foundation
		$(document).foundation();

		// ! Dependencies
		App.Matches.initAlways();
		App.Invitations.initAlways();
		App.Events.initAlways();
		App.Stats.initAlways();
		App.Comments.initAlways();
		App.initState();
	},

	/**
	 * Init last state from local storage
	 * @return {void}
	 */
	initState: function() {
		var loading = false;

		// Only when supported and on homepage
		if ($("html").hasClass("localstorage")) {
			if (document.URL == APP_URL+"/") {
				var lastUrl = localStorage.getItem("lasturl");

				if (lastUrl && lastUrl != APP_URL && lastUrl != APP_URL+"/" && lastUrl != APP_URL+"/login" && ! document.referrer)
				{
					loading = true;
					localStorage.removeItem("lasturl");
					Crajax.init();
					Crajax.load(lastUrl, true, true);
				}
			}

			// Save the state on all other pages
			else {
				App.saveState();
			}
		}

		if ( ! loading) $("#main").show();
	},

	/**
	 * Save the state for easy recovery
	 * @return {void}
	 */
	saveState: function() {
		localStorage.setItem("lasturl", document.URL);
	}

};
