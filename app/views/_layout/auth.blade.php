<!doctype html>
<html lang="en">
<head>
	@include('_partial.meta')
</head>
<body class="auth">
<div id="app">
	<div class="container-fluid" id="main">
		<div class="row-fluid">

			@yield('content')

		</div>
	</div>
</div>

<footer>
	<p>&copy; <?php echo date('Y'); ?> <a href="http://creolab.hr">Skvoš &amp; Beer inc.</a></p>
</footer>

@include('_partial.assets_foot')

</body>
</html>
