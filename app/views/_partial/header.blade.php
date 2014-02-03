<header id="hd1">
	@if (Auth::check())
		<a href="#nav" class="left-off-canvas-toggle menu-icon icon menu-toggle"><span></span></a>
		<a href="{{ route('stats.my') }}" class="icon stats">{{ icn('graph-bar') }}</a>
	@endif

	<h1>
		<a href="{{ route('home') }}">Skvosh.in</a>

		<?php /*<a href="#" onclick="window.location.reload(true); return false;" class="refresh">{{ icn('refresh') }}</a>*/ ?>
	</h1>
</header>
