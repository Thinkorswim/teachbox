<div style="background:#2c3e50;">
	<div style="margin-left:60px;">
		<a href="www.teachbox.io">
			<img src="{{ URL::asset('img/unnamed.png') }}" style="margin:10px auto;" alt="teachbox logo">
		</a>
	</div>
</div>
<div style="background:#efefef; padding-top:20px;padding-bottom:20px">
<div style="background:#fff;margin-left:40px; margin-right:40px;">
		<img src="{{ URL::asset('https://lh5.googleusercontent.com/_U2es8b6HFTFW1ChGB7uBM8Bt9HzipzGpJdMSMlo3MFWHCk3Vz6LIuSWy_Yj9tjj45iVgUQKFqQ=w1342-h547') }}" alt="your first steps in teachbox" style="max-width:100%; height:auto">
		<h1 style="color:#2c3e50; padding-left:20px;padding-right:20px">Congratulations {{  $user->name }},</h1>
		<p style="color:#000; padding-left:20px;padding-right:20px">Your course "{{$course->name}}" is sent for approvement. Please be patient, it will be reviewed as soon as possible.</p>
		<p style="color:#000; padding-left:20px;padding-right:20px">You are already changing the education system. If you need help check our "How to create a professional online course" course.</p>
		<a style="text-decoration:none;padding: 10px; background:#1abc9c;color:#fff; margin-left:20px;margin-right:20px" href="#">Help is here for you.</a>
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