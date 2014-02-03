@if (Auth::check())
	<aside id="nav">
		<div class="meta row">
			<div class="columns small-2">
				@if (Auth::user()->photo)
					<div class="photo" style="background-image: url({{ Image::thumb('/' . Auth::user()->photo, 50) }});"></div>
				@else
					<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 50) }});"></div>
				@endif
			</div>

			<div class="columns small-10">
				<h3>
					Bok, <em>{{ Auth::user()->nickname }}</em>
					<a href="#" onclick="window.location.reload(true); return false;" class="refresh right"><i class="fi-refresh"></i></a>
				</h3>
			</div>
		</div>

		<hr>

		<ul>
			<li><a href="{{ route('home')         }}"><i class="fi-home"></i>      Pregled</a></li>
			<li><a href="{{ route('events.index') }}"><i class="fi-calendar"></i>  Termini</a></li>
			<li><a href="{{ route('stats')        }}"><i class="fi-graph-bar"></i> Statistika</a></li>
			<li><a href="{{ route('profile')      }}"><i class="fi-torso"></i>     Profil</a></li>

			@if (role('admin'))
				<li class="sep"><a href="{{ route('events.create') }}"><i class="fi-plus"></i> Novi termin</a></li>
				<li><a href="{{ route('users.index') }}"><i class="fi-torso"></i> Igrači</a></li>
			@endif

			<li class="sep"><a href="{{ route('logout') }}" data-ajax="false"><i class="fi-lock"></i> Odjava</a></li>
		</ul>
	</aside>
@endif
