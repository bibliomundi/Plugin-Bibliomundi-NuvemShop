<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ __('mail.tittle') }}</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0;padding:0;width:100%">
		<table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px;border:1px solid #cccccc;">
			<tbody>
				<tr>
					<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px;text-align:center;background-color:#f2f4f6;">
						<?php echo $header; ?>
					</td>
				</tr>
				<tr>
					<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px;text-align:left;">
						<?php echo $content; ?>
					</td>
				</tr>
				<tr>
					<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px;text-align:center;background-color:#f2f4f6;">
						<?php echo $footer; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
