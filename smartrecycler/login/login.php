<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

<script type="text/javascript">
function validateForm()
{
var un=document.forms["login"]["username"].value;
var pw=document.forms["login"]["password"].value;
if (un==null || un=="") {
    alert("username must be filled out");
    document.login.username.focus();
    return false;
  }
  else if (pw==null || pw=="") {
    alert("password must be filled out");
    document.login.password.focus();
    return false;
  }
}
</script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Welcome To SmartRecycler</a></h1>
		<form name="login" id="form_320148" class="appnitro"  method="post" action="apilogin.php" onsubmit="return validateForm()">
					<div class="form_description">
			<h2>Welcome To SmartRecycler</h2>
			<p> </p>
		</div>						
			<ul >
			
					<li class="section_break">
			<h3>Enter Login Credentials</h3>
			<p></p>
		</li>		<li id="li_2" >
		<label class="description" for="element_2">UserName </label>
		<div>
			<input id="element_2" name="username" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Password </label>
		<div>
			<input id="element_3" name="password" class="element text medium" type="password" maxlength="255" value=""/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="320148" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
		<div id="footer">
			Designed By
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>