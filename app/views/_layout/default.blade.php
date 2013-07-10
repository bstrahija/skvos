<!doctype html>
<html lang="en">
<head>
	@include('_partial.meta')
</head>
<body>
@include('_partial.header')

<div id="app">
	<div class="container-fluid" id="main">
		<div class="row-fluid">

			@yield('content')

		</div>
	</div>
</div>

@include('_partial.assets_foot')

</body>
</html>