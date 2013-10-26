<?php session_start();
ob_start();
include ("loginconfig.php");

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];


if(!$_REQUEST['username'] || !$_REQUEST['password']){
 echo "missing parameter";
 }

else {
   $querry = "select *from users where username ='$username' and password ='$password'";
   $responce = mysql_query($querry);
   
	   if(mysql_num_rows($responce)>0){
	   $_SESSION['username']=$username;
	   header("Location:http://".$_SERVER['SERVER_NAME']."/antigua/smartrecycler/homePage/exchange_list.php");
	   
	   }
	   else {
	   echo '<script language="javascript">';
       echo "alert('you are not registered');";
       echo("window.location ='http://appsmartrecycling.es/antigua/smartrecycler/login/login.php'");
       echo '</script>';
	    }
	   
}

?>
