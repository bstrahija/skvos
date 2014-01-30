@if (User::isAdmin())

<br><br><br><br><br><br>

<footer id="fnav">
	<nav>
		<ul>
			<li class="action-stats"><a href="{{ route('stats') }}"><i class="icon-dashboard"></i></a></li>
			<li class="action-calendar"><a href="#"><i class="icon-calendar"></i></a></li>
			<li class="action-home"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
			<li class="action-settings"><a href="#" onclick="window.location.reload(true); return false;"><i class="icon-refresh"></i></a></li>
			<li class="action-logout"><a href="{{ route('logout') }}"><i class="icon-lock"></i></a></li>
		</ul>
	</nav>
</footer>

@endif
