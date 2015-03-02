<div style="background:#2c3e50;">
	<div style="margin-left:60px;">
		<a href="www.teachbox.io">
			<img src="{{ URL::asset('img/unnamed.png') }}" style="margin:10px auto;" alt="teachbox logo">
		</a>
	</div>
</div>
<div style="background:#efefef; padding-top:20px;padding-bottom:20px">
<div style="background:#fff;margin-left:40px; margin-right:40px;">
		<img src="{{ URL::asset('img/passenger.jpg') }}" alt="your first steps in teachbox" style="max-width:100%; height:auto">
		<h1 style="color:#2c3e50; padding-left:20px;padding-right:20px">Hello <strong>{{ $name }}</strong>,</h1>
		<p style="color:#000; padding-left:20px;padding-right:20px">Your education adventure will start with activating your profile.</p>
		<p style="color:#000; padding-left:20px;padding-right:20px">To do so use the following link:</p>
		<a style="text-decoration:none;padding: 10px; background:#1abc9c;color:#fff; margin-left:20px;margin-right:20px" href="{{ $link }}">Click here</a>
		<br><br>
		<p style="color:#000; padding-left:20px;padding-right:20px">
		Teachbox Team
		<br><br>
		</p>
	</div>
</div>
<div style="background:#2c3e50; text-align:center; padding:20px;">
<p style="font-size:1px;">{{generateRandomInt(13) }}</p>
<p style="color:#fff">Web: <a style="color:#1abc9c" href="www.teachbox.io">www.teachbox.io</a> | T: +359886 624 880 | E-mail:
info@teachbox.io</p>

</div>