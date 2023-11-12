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
							<td><input type="number" size="35" name="age" placeholder="age"></td>
						</tr>
						<tr>
							<td>COUNTRY</td>
							<td><input type="text" size="35" name="country" placeholder="country"></td>
						</tr>
				
					</table>

				<input type="submit" value="submit" />
			
		</fieldset>
	</form>
</body>
</html>