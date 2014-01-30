App = {

	/**
	 * App setup
	 * @type {Object}
	 */
	params: {
		url:  APP_URL,
		hash: window.location.hash.replace(/\#/g, "")
	},

	/**
	 * Initialize core app
	 * @return {void}
	 */
	init: function() {
		console.log("App initializing...");

		App.Content.init();
		// App.Layout.init();
		// App.Events.init();

		// iOS tweaks
		App.iosTweaks();

		// Submit buttons
		$("form a.submit").click(function() {
			$(this).closest("form").submit();
			return false;
		});

		// Remove yellow chrome bg
		if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
			var intervalId = 0;
			$(window).load(function() {
				intervalId = setInterval(function () { // << somehow  this does the trick!
					if ($('input:-webkit-autofill').length > 0) {
						clearInterval(intervalId);
						$('input:-webkit-autofill').each(function () {
							var text = $(this).val();
							var name = $(this).attr('name');
							$(this).after(this.outerHTML).remove();
							$('input[name=' + name + ']').val(text);
						});
					}
				}, 1);
			});
		}
	},

	/**
	 * Simply build an app URL
	 * @param  {string} path
	 * @return {string}
	 */
	url: function(path) {
		return App.params.url + path;
	},

	/**
	 * Displays an alert box on the page
	 * @param  {string} message
	 * @param  {string} type
	 * @return {void}
	 */
	notify: function(message, type) {
		if ( ! type) type = 'success';

		alertify.log(message, type);
	},

	/**
	 * Get app param
	 * @param  {string} key
	 * @return {mixed}
	 */
	get: function(key) {
		return App.params[key];
	},

	/**
	 * Set an app param
	 * @param {string} key
	 * @param {mixed}  val
	 */
	set: function(key, val) {
		App.params[key] = val;
	},

	/**
	 * Get query string params
	 * @param  {string} key
	 * @return {string}
	 */
	input: function(key) {
		var name = key.replace(/[[]/, "\\[").replace(/[]]/, "\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.search);
		if (results === null) {
			return "";
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	},

	/**
	 * Some iOS tweaks
	 * @return {void}
	 */
	iosTweaks: function() {
		App.preventSafariLinks();

		// Detect iOS
		var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

		// Detect fullscreen app
		if (window.navigator.standalone) {
			$("body").addClass("fullscreen");
		}

		// Add touchstart event for faster touch response
		document.addEventListener("touchstart", function(){}, true);

		// Remove delay on touch
		FastClick.attach(document.body);

		// Fix some focus issues with fixed elements on iOS
		if (iOS) {
			$(document).on('focus', 'input, textarea, select', function() {
				$("header, footer").hide();
			});
			$(document).on('blur', 'input, textarea, select', function() {
				$("header, footer").fadeIn(250);
			});
		}
	},

	/**
	 * Prevent opening links in Safari when on home screen
	 * @return {void}
	 */
	preventSafariLinks: function() {
		if (("standalone" in window.navigator) && window.navigator.standalone) {
			var noddy, remotes = false;
			document.addEventListener('click', function(event) {
				noddy = event.target;

				while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
					noddy = noddy.parentNode;
				}

				if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
				{
					event.preventDefault();
					document.location.href = noddy.href;
				}

			},false);
		}
	}

};
