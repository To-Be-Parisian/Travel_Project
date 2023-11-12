 <?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "thgus201";
  $dbname = "php";
  $db = new mysqli($servername, $username, $password, $dbname);
  $db->set_charset("utf8");

  function mq($sql){
    global $db;
    return $db->query($sql);
  }

  ?>