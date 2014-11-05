<html>
	<head>
		<title> Teachbox </title>
	</head>
	<body>
		<li><a href="{{ URL::route('sign-out') }}">Sign out</a> </li>
	    @yield('content')
	</body>
</html>