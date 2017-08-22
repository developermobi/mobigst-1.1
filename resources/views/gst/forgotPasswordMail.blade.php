<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style>
		table tr td{
			padding:10px;
		}
		table tr th{
			padding:10px;
		}
		table {
			width:100%;
		}
		button{
			padding:1em;
			background-color:#b32b26;
			color:#fff;
		}
	</style>

	<table>
		<tbody>
			<tr>
				<td>
					<table>
						<tbody><tr>
							<td><img src="{{ env('APP_URL') }}/images/mobitaxlogo.png"></td>
						</tr>
					</tbody></table>
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<table>
		<tbody><tr>
			<td>
				<table>
					<tbody><tr>
						<td>
							<h1>Hi,</h1><br>
							<p>
								Reset Password Link.<br><br><br>
								<a href="{{ env('APP_URL') }}/resetPassword/{{encrypt($mailInfo['user_id'])}}/{{$mailInfo['forget_password_id']}}" target="_blank">
									<button class="btn btn-success">Reset Passowrd</button></a><br><br>
								</p>
								<p>Thanks,<br>
									<strong>Mobisoft Technology India Pvt Ltd</strong>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<table>
					<tbody>
						<tr>
							<td>
								<p>To get GST ready,</p>
								<p><strong>Simplify GST with MobiTax GST</strong></p>
								<p>Website: <a href="#" target="_blank">www.mobitax.in/gst</a></p>
								<p>Sales: 8108004545 | <a href="#" target="_blank">gst@mobitax.in</a></p>
								<P>Support: <a href="#" target="_blank"</a>Support@mobiTax.in</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>