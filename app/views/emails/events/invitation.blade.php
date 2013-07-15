<!DOCTYPE html>
<html lang="hr-HR">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Pozivnica za {{ $title }}</h2>

		<div>
			Novi termin na koji si pozvan. Svoj dolazak možeš potvrditi klikom na link ispod:<br><br>
			<a href="{{ $confirmation_link }}">{{ $confirmation_link }}</a>
		</div>
	</body>
</html>
