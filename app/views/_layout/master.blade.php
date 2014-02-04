<!doctype html>
<html lang="en">
<head>
	@include('_partial.meta')

	@assets('app.css')
</head>
<body id="app">

<?php
echo '<pre>'; print_r(var_dump($_SERVER['HTTP_USER_AGENT'])); echo '</pre>';

 ?>

<div id="canvas" class="@yield('body_class')" data-role="canvas">
	@include('_partial.navigation')

	@include('_partial.header')

	<div class="container" id="main" data-role="page">

		@include('_partial.alerts')

		@yield('main')

	</div>

	<a id="off-canvas"></a>
</div>

<script>
var APP_URL = "{{ url() }}";
var API_URL = "{{ url('api') }}";
</script>

@assets('app.js')

</body>
</html>
