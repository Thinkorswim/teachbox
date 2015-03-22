<div style="background:#2c3e50;">
	<div style="margin-left:60px;">
		<a href="www.teachbox.io">
			<img src="{{ URL::asset('img/unnamed.png') }}" style="margin:10px auto;" alt="teachbox logo">
		</a>
	</div>
</div>
<div style="background:#efefef; padding-top:20px;padding-bottom:20px">
<div style="background:#fff;margin-left:40px; margin-right:40px;">
		<img src="{{ URL::asset('img/lock.jpg') }}" alt="your first steps in teachbox" style="max-width:100%; height:auto">
		<h1 style="color:#2c3e50; padding-left:20px;padding-right:20px;text-align:left;">Hello {{ $username }},</h1>
		<p style="color:#000; padding-left:20px;padding-right:20px">It looks like you requested a new password. You will need to ues the following link to activate the new password. If you havent requested a new password, please ignore this e-mail:</p>
		<p style="color:#000; padding-left:20px;padding-right:20px">New password: {{ $password }}</p><br><br>
		<a style="padding-left:20px;" href="{{ $link }}">Activate new password!</a>
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