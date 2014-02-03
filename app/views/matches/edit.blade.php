@extends('_layout.master')

@section('page_title') Izmijeni Meč @stop

@section('main')

<div class="page match edit-match">

	<h2 class="pg">
		{{ icn('trophy') }} Izmijeni meč
		<em class="right"><a href="{{ route('events.show') }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
	</h2>

	<hr>

	{{ Form::open(['route' => ['matches.update', $match->id], 'method' => 'put', 'class' => 'edit-match-form']) }}

		<div class="match-playing row">
			<div class="columns small-6">
				<select name="player1_id" id="player1">
					@foreach ($players as $player)
						<option value="{{ $player->id }}" {{ $player->id == $match->player1->id ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
					@endforeach
				</select>

				<ul class="button-group round">
					<li><a href="#" class="inc-dec dec button">{{ icn('minus') }}</a></li>
					<li><span class="button secondary res1 res"><input type="text" name="player1_score" class="score" value="{{ $match->player1_score }}" readonly="readonly"></span></li>
					<li><a href="#" class="inc-dec inc button success">{{ icn('plus') }}</a></li>
				</ul>
			</div>

			<div class="columns small-6">
				<select name="player2_id" id="player1">
					@foreach ($players as $player)
						<option value="{{ $player->id }}" {{ $player->id == $match->player2->id ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
					@endforeach
				</select>

				<ul class="button-group round right">
					<li><a href="#" class="inc-dec dec button">{{ icn('minus') }}</a></li>
					<li><span class="button secondary res2 res"><input type="text" name="player2_score" class="score" value="{{ $match->player2_score }}" readonly="readonly"></span></li>
					<li><a href="#" class="inc-dec inc button success">{{ icn('plus') }}</a></li>
				</ul>
			</div>
		</div>

		<hr>

		<div class="row match-add-actions">
			<button type="submit" class="button success round">{{ icn('download') }} Spremi</button>
		</div>
	{{ Form::close() }}

	@if (role('admin'))
		<hr>

		<p class="not-found">{{ icn('alert') }} Pažnja!</p>

		<div class="row button-actions match-add-actions button-actions">
			{{ Form::open(['route' => ['matches.destroy', $match->id], 'method' => 'delete', 'class' => 'match-delete-form']) }}
				<button type="submit" class="button alert success round">{{ icn('trash') }} Obriši meč</button>
			{{ Form::close() }}
		</div>
	@endif

</div>

@stop
