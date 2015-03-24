<?php

return array(

	// ! Styles
	'app_css' => array(
		'assets' => array(
			'vendor/components/foundation/css/normalize.css',
			'vendor/components/foundation/css/foundation.min.css',
			'vendor/components/foundation-icon-fonts/foundation-icons.css',
			'vendor/components/font-awesome/css/font-awesome.min.css',
			'vendor/components/sweetalert/lib/sweet-alert.css',
			'vendor/crajax/crajax.css',
			'css/app.css',
		),
		'name'    => 'app.css',
		'type'    => 'css',
		'combine' => true,
		'filters' => array('cssmin'),
	),

	// ! Scripts
	'app_js' => array(
		'assets' => array(
			'vendor/components/jquery/jquery.min.js',
			'vendor/components/foundation/js/foundation.min.js',
			'vendor/components/jquery-knob/js/jquery.knob.js',
			'vendor/components/nnnick-chartjs/Chart.min.js',
			'vendor/components/sweetalert/lib/sweet-alert.min.js',
			'vendor/crajax/crajax.js',
			'js/app.js',
			'js/events.js',
			'js/invitations.js',
			'js/matches.js',
			'js/stats.js',
			'js/comments.js',
			'js/init.js',
		),
		'name'    => 'app.js',
		'type'    => 'js',
		'combine' => true,
		'filters' => array('jsmin'),
	),

);
