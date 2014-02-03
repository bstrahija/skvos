;(function(factory) {
	if (typeof module === 'function') {
		module.exports = factory(this.jQuery || require('jquery'));
	} else {
		this.Crajax = factory(this.jQuery);
	}
})(function($) {
	var Crajax = {};
	Crajax.version = '0.1.0';

	/**
	 * URL's
	 * @type {string}
	 */
	Crajax.oldUrl = window.location.href;

	/**
	 * Default settings
	 * @type {object}
	 */
	var Settings = Crajax.settings = {

	};

	/**
	 * Override default config
	 * @param  {object} options
	 */
	Crajax.configure = function(options) {
		$.extend(Settings, options);
		return this;
	};

	/**
	 * Initialize ajax pages lib
	 * @return {void}
	 */
	Crajax.init = function(selector) {
		// Default selector for all links
		if ( ! selector) selector = "a";

		// Additional selectors
		selector += ',div[data-ajax=true]';

		// ! Bind click events
		$("body").on("click", selector, function() {
			if ($(this).attr("data-ajax") != 'false') {
				var href = $(this).attr("href");
				if ( ! href) href = $(this).attr("data-href");

				return Crajax.load(href);
			}
		});

		/**
		 * Refresh current page via ajax
		 * @return {void}
		 */
		Crajax.refresh = function(noFade) {
			Crajax.load(document.URL, true, noFade);
		};

		/**
		 * Load a page via ajax
		 * @param  {string} href
		 */
		Crajax.load = function(href, skipValidation, noFade) {
			var $target = $("div[data-role=page]");

			// Modals
			$('.reveal-modal').foundation('reveal', 'close');

			// Validate URL
			var urlregex  = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(dev|loc|com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
			var validHref = skipValidation ? skipValidation : urlregex.test(href);
			var notOldUrl = skipValidation ? skipValidation : (href != Crajax.oldUrl);

			// Check if target exists
			if ( ! $target.length) alert("No content target set!");

			// Only load if URL is different
			if (validHref && $target.length && href && notOldUrl) {
				Crajax.oldUrl = href;

				// Close sidebar
				$("#nav, #main, #hd1").removeClass("menu-active");

				// Fade it out
				if ( ! noFade) $target.delay(1000).dequeue().stop().fadeTo(10, .0001);

				// Start loading bar
				if (NProgress) NProgress.start();

				// Load contents
				$.ajax({
					url: href,
					dataType: 'html',
				})
				.done(function(data) {
					$src  = $(data);
					title = $src.attr('title');
					$page = $src.find("div[data-role=page]");
					$(document).find("title").text(title);

					// Scroll to top
					window.scrollTo(0, 0);

					// Push history
					try {
						window.history.pushState({ id: href }, href, href);
					} catch(err) { console.error(err); }

					// Set HTML
					$target.html($page.html());

					// Init
					if (App.initAlways) App.initAlways();

					// Done
					if (NProgress) NProgress.done();
					$target.dequeue().stop().fadeTo(200, 1);
				})
				.error(function(el, err, msg) {
					alert("Couldn't load page!");
					console.error(msg);

					// Done
					if (NProgress) NProgress.done();
					$("#nav, #main, #hd1").removeClass("menu-active");
					$target.dequeue().stop().fadeTo(200, 1);
				});
			} else if (href == Crajax.oldUrl) {
				window.scrollTo(0, 0);
			}

			// Prevent default if loaded
			if (href) return false;
		};

		// ! Back button
		window.onpopstate = function (data) {
			if (data.state) {
				var backTo = data.state.id;

				if (backTo != Crajax.oldUrl) {
					Crajax.load(backTo);
				}
			}
		};
	}

	return Crajax;
});










/*! NProgress (c) 2013, Rico Sta. Cruz
 *  http://ricostacruz.com/nprogress */

;(function(factory) {

	if (typeof module === 'function') {
		module.exports = factory(this.jQuery || require('jquery'));
	} else {
		this.NProgress = factory(this.jQuery);
	}

})(function($) {
	var NProgress = {};

	NProgress.version = '0.1.2';

	var Settings = NProgress.settings = {
		minimum: 0.08,
		easing: 'ease',
		positionUsing: '',
		speed: 200,
		trickle: true,
		trickleRate: 0.02,
		trickleSpeed: 800,
		showSpinner: true,
		template: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
	};

	/**
	 * Updates configuration.
	 *
	 *     NProgress.configure({
	 *       minimum: 0.1
	 *     });
	 */
	NProgress.configure = function(options) {
		$.extend(Settings, options);
		return this;
	};

	/**
	 * Last number.
	 */

	NProgress.status = null;

	/**
	 * Sets the progress bar status, where `n` is a number from `0.0` to `1.0`.
	 *
	 *     NProgress.set(0.4);
	 *     NProgress.set(1.0);
	 */

	NProgress.set = function(n) {
		var started = NProgress.isStarted();

		n = clamp(n, Settings.minimum, 1);
		NProgress.status = (n === 1 ? null : n);

		var $progress = NProgress.render(!started),
				$bar      = $progress.find('[role="bar"]'),
				speed     = Settings.speed,
				ease      = Settings.easing;

		$progress[0].offsetWidth; /* Repaint */

		$progress.queue(function(next) {
			// Set positionUsing if it hasn't already been set
			if (Settings.positionUsing === '') Settings.positionUsing = NProgress.getPositioningCSS();

			// Add transition
			$bar.css(barPositionCSS(n, speed, ease));

			if (n === 1) {
				// Fade out
				$progress.css({ transition: 'none', opacity: 1 });
				$progress[0].offsetWidth; /* Repaint */

				setTimeout(function() {
					$progress.css({ transition: 'all '+speed+'ms linear', opacity: 0 });
					setTimeout(function() {
						NProgress.remove();
						next();
					}, speed);
				}, speed);
			} else {
				setTimeout(next, speed);
			}
		});

		return this;
	};

	NProgress.isStarted = function() {
		return typeof NProgress.status === 'number';
	};

	/**
	 * Shows the progress bar.
	 * This is the same as setting the status to 0%, except that it doesn't go backwards.
	 *
	 *     NProgress.start();
	 *
	 */
	NProgress.start = function() {
		if (!NProgress.status) NProgress.set(0);

		var work = function() {
			setTimeout(function() {
				if (!NProgress.status) return;
				NProgress.trickle();
				work();
			}, Settings.trickleSpeed);
		};

		if (Settings.trickle) work();

		return this;
	};

	/**
	 * Hides the progress bar.
	 * This is the *sort of* the same as setting the status to 100%, with the
	 * difference being `done()` makes some placebo effect of some realistic motion.
	 *
	 *     NProgress.done();
	 *
	 * If `true` is passed, it will show the progress bar even if its hidden.
	 *
	 *     NProgress.done(true);
	 */

	NProgress.done = function(force) {
		if (!force && !NProgress.status) return this;

		return NProgress.inc(0.3 + 0.5 * Math.random()).set(1);
	};

	/**
	 * Increments by a random amount.
	 */

	NProgress.inc = function(amount) {
		var n = NProgress.status;

		if (!n) {
			return NProgress.start();
		} else {
			if (typeof amount !== 'number') {
				amount = (1 - n) * clamp(Math.random() * n, 0.1, 0.95);
			}

			n = clamp(n + amount, 0, 0.994);
			return NProgress.set(n);
		}
	};

	NProgress.trickle = function() {
		return NProgress.inc(Math.random() * Settings.trickleRate);
	};

	/**
	 * (Internal) renders the progress bar markup based on the `template`
	 * setting.
	 */

	NProgress.render = function(fromStart) {
		if (NProgress.isRendered()) return $("#nprogress");
		$('html').addClass('nprogress-busy');

		var $el = $("<div id='nprogress'>")
			.html(Settings.template);

		var perc = fromStart ? '-100' : toBarPerc(NProgress.status || 0);

		$el.find('[role="bar"]').css({
			transition: 'all 0 linear',
			transform: 'translate3d('+perc+'%,0,0)'
		});

		if (!Settings.showSpinner)
			$el.find('[role="spinner"]').remove();

		$el.appendTo(document.body);

		return $el;
	};

	/**
	 * Removes the element. Opposite of render().
	 */

	NProgress.remove = function() {
		$('html').removeClass('nprogress-busy');
		$('#nprogress').remove();
	};

	/**
	 * Checks if the progress bar is rendered.
	 */

	NProgress.isRendered = function() {
		return ($("#nprogress").length > 0);
	};

	/**
	 * Determine which positioning CSS rule to use.
	 */

	NProgress.getPositioningCSS = function() {
		// Sniff on document.body.style
		var bodyStyle = document.body.style;

		// Sniff prefixes
		var vendorPrefix = ('WebkitTransform' in bodyStyle) ? 'Webkit' :
											 ('MozTransform' in bodyStyle) ? 'Moz' :
											 ('msTransform' in bodyStyle) ? 'ms' :
											 ('OTransform' in bodyStyle) ? 'O' : '';

		if (vendorPrefix + 'Perspective' in bodyStyle) {
			// Modern browsers with 3D support, e.g. Webkit, IE10
			return 'translate3d';
		} else if (vendorPrefix + 'Transform' in bodyStyle) {
			// Browsers without 3D support, e.g. IE9
			return 'translate';
		} else {
			// Browsers without translate() support, e.g. IE7-8
			return 'margin';
		}
	};

	/**
	 * Helpers
	 */

	function clamp(n, min, max) {
		if (n < min) return min;
		if (n > max) return max;
		return n;
	}

	/**
	 * (Internal) converts a percentage (`0..1`) to a bar translateX
	 * percentage (`-100%..0%`).
	 */

	function toBarPerc(n) {
		return (-1 + n) * 100;
	}


	/**
	 * (Internal) returns the correct CSS for changing the bar's
	 * position given an n percentage, and speed and ease from Settings
	 */

	function barPositionCSS(n, speed, ease) {
		var barCSS;

		if (Settings.positionUsing === 'translate3d') {
			barCSS = { transform: 'translate3d('+toBarPerc(n)+'%,0,0)' };
		} else if (Settings.positionUsing === 'translate') {
			barCSS = { transform: 'translate('+toBarPerc(n)+'%,0)' };
		} else {
			barCSS = { 'margin-left': toBarPerc(n)+'%' };
		}

		barCSS.transition = 'all '+speed+'ms '+ease;

		return barCSS;
	}

	return NProgress;
});
