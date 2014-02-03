<!doctype html>
<html lang="en">
<head>
	@include('_partial.meta')

	@assets('app.css')
</head>
<body id="app" class="@yield('body_class')">

<div id="canvas">
	@include('_partial.navigation')

	@include('_partial.header')

	<div class="container" id="main" data-role="page">

		@include('_partial.alerts')

		@yield('main')

	</div>

	<a class="exit-off-canvas"></a>
</div>

<script>
var APP_URL = "{{ url() }}";
var API_URL = "{{ url('api') }}";
</script>

@assets('app.js')

</body>
</html>
