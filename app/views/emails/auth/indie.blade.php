<div style="background:#2c3e50;">
	<div style="margin-left:60px;">
		<a href="www.teachbox.io">
			<img src="{{ URL::asset('img/unnamed.png') }}" style="margin:10px auto;" alt="teachbox logo">
		</a>
	</div>
</div>
<div style="background:#efefef; padding-top:20px;padding-bottom:20px">
<div style="background:#fff;margin-left:40px; margin-right:40px;">
		<h1 style="color:#2c3e50;padding-top:20px; padding-left:20px;padding-right:20px;text-align:left;">Hi {{$user->name}},</h1>
		<p style="color:#000; padding-left:20px;padding-right:20px">You’re a user since {{getMonth2($user->created_at)}}.{{getYear2($user->created_at)}} and we can’t thank you enough of for your belief in us. </p>
		<p style="color:#000; padding-left:20px;padding-right:20px">Teachbox is moving one step further and needs your support in order to make it possible. We want to make a big change and create a community of open-minded learners.</p>
		<p style="color:#000; padding-left:20px;padding-right:20px"> It all comes down to you. We are so excited to announce our Indiegogo campaign. Have a look and if you like what we do support and share! Every little bit counts!</p>
		<p style="color:#000; padding-left:20px;padding-right:20px">
		<a href="http://bit.ly/1UJ9EDm"> The Indiegogo campaign </a>
		</p>
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