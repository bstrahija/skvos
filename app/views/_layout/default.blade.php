<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Skvosh.in</title>

	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-responsive.min.css') }}">
</head>
<body>
<div class="container">
	@include('_partial.header')

	<div class="row">

		@yield('content')

	</div>
</div>

<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
</body>
</html>
