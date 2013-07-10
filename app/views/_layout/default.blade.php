<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Skvosh.in</title>

	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-responsive.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>
<div id="app">
	<div class="container-fluid">
		@include('_partial.header')

		<div class="row-fluid">

			@yield('content')

		</div>
	</div>
</div>

<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
</body>
</html>
