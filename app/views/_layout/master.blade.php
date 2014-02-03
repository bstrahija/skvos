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
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=596696940410826";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
