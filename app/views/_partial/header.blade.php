<div class="navbar navbar-inverse navbar-fixed-top" id="hd1">
	<div class="navbar-inner">
		<div class="container-fluid">
			<header>
				@if ( ! Auth::guest())
					<a href="{{ route('settings') }}" class="button button-circle button-tiny pull-left"><i class="icon-cog"></i></a>
					<a href="{{ route('logout') }}" class="button button-circle button-tiny pull-right"><i class="icon-lock"></i></a>
				@endif

				<h1><a href="{{ route('dashboard') }}">Skvosh.in</a></h1>
			</header>
		</div>
	</div>
</div>


