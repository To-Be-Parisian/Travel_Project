<?php
  include "./db.php"; ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>Travel_Project Login</title>
<link rel="stylesheet" type="text/css" href="./static/css/login.css" />
</head>
<body>
	<div id="login_box">
		<h1>Login</h1>							
			<form method="post" action="./user/login_ok.php">
				<table align="center" border="0" cellspacing="0" width="200">
        			<tr>
            			<td width="130" > 
                		<input type="text" name="userid" class="inph">
            			</td>
            			<td rowspan="1" width="100" > 
                		<button type="submit" id="btn" >Login</button>
            			</td>
        			</tr>
					<tr>
					<td colspan="3" align="bottom" class="mem"> 
					<a href="./user/user.php">Create Account</a>
					</td>
					</tr>
    			</table>
  			</form>
	</div>
</body>
</html>