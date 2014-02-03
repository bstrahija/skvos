App = {

	// Detect iOS
	ios: ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false ),

	/**
	 * Init app
	 * @return {void}
	 */
	init: function() {
		console.log("Init");

		// Detect fullscreen app
		if (window.navigator.standalone) {
			$("body").addClass("fullscreen");
		}

		// ! Toggle the menu
		$(".menu-toggle").click(function() {
			$("#nav, #main, #hd1").toggleClass("menu-active");

			return false;
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
		$(".stat canvas").addClass("rotate-reverse")
		$(".stat").click(function() {
			$(this).find("canvas").toggleClass("rotate");
			$(this).find("canvas").toggleClass("rotate-reverse");
		});

		// ! Foundation
		$(document).foundation();
		// Foundation.libs.reveal.init();

		// ! Dependencies
		App.Matches.initAlways();
		App.Invitations.initAlways();
		App.Events.initAlways();
	}

};
