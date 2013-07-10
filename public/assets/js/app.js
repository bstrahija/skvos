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
	}

};
