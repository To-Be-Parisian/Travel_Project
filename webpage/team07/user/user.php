<?php 
	include "../db.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Create Account</title>
	<link rel="stylesheet" type="text/css" href="../static/css/createuser.css" />
</head>
<body>
	<form method="post" action="user_ok.php">
		<h1>CREATE ACCOUNT</h1>
		<fieldset>
			<table>
				<tr>
					<td>ID</td>
					<td><input type="number" size="35" name="userid" placeholder="id"></td>
				</tr>
				<tr>
					<td>SEX</td>
					<td>Male<input type="radio" name="sex" value="Male"> Female<input type="radio" name="sex" value="Female"></td>
				</tr>
				<tr>
					<td>AGE</td>
					<td>
						<select name="age">
							<option value="15">15-20</option>
							<option value="21">21-30</option>
							<option value="31">31-40</option>
							<option value="41">41-50</option>
							<option value="51">51-60</option>
							<option value="61">61 and above</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>COUNTRY</td>
					<td>
						<select name="country">
							<option value="Other">Other</option>
							<option value="Taiwan">Taiwan</option>
							<option value="Germany">Germany</option>
							<option value="Russia">Russia</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Mongolia">Mongolia</option>
							<option value="USA">USA</option>
							<option value="Vietnam">Vietnam</option>
							<option value="Singapore">Singapore</option>
							<option value="UK">UK</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Japan">Japan</option>
							<option value="China">China</option>
							<option value="Middle East">Middle East</option>
							<option value="Canada">Canada</option>
							<option value="Thailand">Thailand</option>
							<option value="France">France</option>
							<option value="Philippines">Philippines</option>
							<option value="Australia">Australia</option>
							<option value="Hong Kong">Hong Kong</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" value="submit" />
		</fieldset>
	</form>
</body>
</html>
