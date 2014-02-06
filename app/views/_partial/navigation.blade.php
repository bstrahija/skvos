@if (Auth::check())
	<aside id="nav">
		<div class="meta row" data-ajax="true" data-href="{{ route('profile') }}">
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

					@if (role('admin'))
						<a href="#" onclick="window.location.reload(true); return false;" class="refresh right">{{ icn('refresh') }}</a>
					@endif
				</h3>
			</div>
		</div>

		<hr>

		<ul>
			<li><a href="{{ route('home')         }}">{{ icn('home') }}      Pregled</a></li>
			<li><a href="{{ route('events.index') }}">{{ icn('calendar') }}  Termini</a></li>
			<li><a href="{{ route('stats')        }}">{{ icn('graph-bar') }} Statistika</a></li>
			<li><a href="{{ route('profile')      }}">{{ icn('torso') }}     Profil</a></li>

			@if (role('admin'))
				<li class="sep"><a href="{{ route('events.create') }}">{{ icn('plus') }} Novi termin</a></li>
				<li><a href="{{ route('users.index') }}">{{ icn('torsos') }} Igrači</a></li>
				<li><a href="{{ route('groups.index') }}">{{ icn('torsos-all') }} Grupe</a></li>
			@endif

			<li class="sep"><a href="{{ route('logout') }}">{{ icn('lock') }} Odjava</a></li>
		</ul>
	</aside>
@endif
