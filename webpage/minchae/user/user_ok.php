<?php
	include "../db.php";

	$userid = $_POST['userid'];
	$sex = $_POST['sex'];
	$age = $_POST['age'];
	$country = $_POST['country'];

$sql = mq("INSERT INTO user (ID, sex, age, country) VALUES ('".$userid."', '".$sex."', '".$age."', '".$country."')");

?>

<meta charset="utf-8" />
<script type="text/javascript">alert('create user');</script>
<meta http-equiv="refresh" content="0 url=../login.php">