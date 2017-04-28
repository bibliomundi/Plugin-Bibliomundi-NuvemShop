<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<p class="email-dear">
		<span>Dear {{ $recipientName }},</span>
	</p>
	<p class="email-thanks">
		<span>Thank you for buying our products. Here is the download links: </span>
	</p>
	@if (count($downloadLinks))
		<ul class="email-links">
			@foreach ($downloadLinks as $link)
			    <li><a href="{{ $link }}" title="">{{ $link }}</a></li>
			@endforeach
		</ul>
	@endif
	<p class="email-regards">
		<span>Thank you and Best Regards,</span>
	</p>
	<p class="email-signal">
		<span>NuvemShop-BiblioMundi</span>
	</p>
</body>
</html>