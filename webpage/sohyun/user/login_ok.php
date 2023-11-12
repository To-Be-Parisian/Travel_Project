<meta charset="utf-8" />
<?php	
	include "../db.php";

	//POST로 받아온 아이디가 비었다면 알림창을 띄우고 전 페이지로 돌아갑니다.
	if($_POST["userid"] == ""){
		echo '<script> alert("Please enter your ID"); history.back(); </script>';
	}else{

	//sql문으로 POST로 받아온 아이디값을 찾습니다.
	$sql = mq("select * from user where id='".$_POST['userid']."'");
	$user = $sql->fetch_array();
	

	if(isset($user) && $user["id"] == $userid) //user id가 있다면 main.php파일로 넘어갑니다.
	{
		$_SESSION['userid'] = $user["ID"];
		echo "<script> location.href='../testpage.php';</script>";
	}else{ // 일치하는 useid가 없으면 알림창을 띄우고 전 페이지로 돌아갑니다
		echo "<script>alert('check your id.'); history.back();</script>";
	}
}
?>