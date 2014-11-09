<html>
	<head>
		<title> Teachbox </title>
	</head>
	<body>
		<li><a href="{{ URL::route('sign-out') }}">Sign out</a> </li>
		<li><a href="{{ URL::action('ProfileController@user', [Auth::user()->id]) }}"> Profile </a></li>
	    @yield('content')
	</body>
</html>