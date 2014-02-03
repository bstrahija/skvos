@extends('_layout.master')

@section('page_title') Pregled @stop

@section('main')

<div class="dashboard">
	@include('dashboard.event')

	<div class="row stat-row">
		<div class="stat stat-mvp small-6 columns">
			<i class="fi-crown icon-mvp"></i>
			<div class="circle">
				<input type="text" class="knob" data-width="100" data-height="100"
					data-fgColor="#8dd700"
					data-thickness=".04"
					data-displayPrevious="true"
					data-readOnly="true"
					data-angleOffset="-90"
					data-linecap="round"
					data-max="50"
					value="{{ $stats->mvp_count }}">
			</div>
			<div class="input">{{ $stats->mvp_count }}</div>
			<p title="MVP title">MVP</p>
		</div>

		<div class="stat stat-matches small-6 columns">
			<i class="fi-social-dribbble icon-matches"></i>
			<div class="circle">
				<input type="text" class="knob" data-width="100" data-height="100"
					data-fgColor="#48a4ff"
					data-thickness=".04"
					data-displayPrevious="true"
					data-readOnly="true"
					data-angleOffset="180"
					data-linecap="round"
					data-max="{{ ceil($stats->matches_played / 100) * 100 }}"
					value="{{ $stats->matches_played }}">
			</div>
			<div class="input">{{ $stats->matches_played }}</div>
			<p title="Matches player">MP</p>
		</div>
	</div>

	<div class="info">
		@if (Auth::user()->photo)
			<div class="photo" style="background-image: url({{ Image::thumb('/' . Auth::user()->photo, 100) }});"></div>
		@else
			<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 100) }});"></div>
		@endif

		<h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
	</div>

	<div class="row stat-row">
		<div class="stat stat-efficiency small-6 columns">
			<i class="fi-trophy icon-efficiency"></i>
			<div class="circle">
				<input type="text" class="knob" data-width="100" data-height="100"
					data-fgColor="#f3bb00"
					data-skin="tron"
					data-thickness=".04"
					data-displayPrevious="true"
					data-readOnly="true"
					data-angleOffset="90"
					data-linecap="round"
					value="{{ round($stats->match_efficiency, 1) }}">
			</div>
			<div class="input">{{ number_format($stats->match_efficiency, 1, ".", null) }}%</div>
			<p title="Match efficiecy">ME</p>
		</div>

		<div class="stat stat-sets small-6 columns">
			<i class="fi-target icon-sets"></i>
			<div class="circle">
				<input type="text" class="knob" data-width="100" data-height="100"
					data-fgColor="#52e3c6"
					data-skin="tron"
					data-thickness=".04"
					data-displayPrevious="true"
					data-readOnly="true"
					data-angleOffset="0"
					data-linecap="round"
					value="{{ round($stats->set_efficiency, 1) }}">
			</div>
			<div class="input">{{ number_format($stats->set_efficiency, 1, ".", null) }}%</div>
			<p title="Set efficiecy">SE</p>
		</div>
	</div>

	<hr>

	<div>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="{{ route('showcase', Auth::user()->id) }}" data-text="Moji squash rezultati #squash #skvoshin" data-via="skvoshin" data-lang="hr">Tweet</a>
		<div class="fb-like" data-href="{{ route('showcase', Auth::user()->id) }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="false" data-colorscheme="dark"></div>
	</div>

</div>

@stop
