<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{shortname} (Universe {s})</title>
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/reset.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/toolbox.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/login.css' media='screen' />
</head>

<body id="login">

    <form name="xnova" method="post" action="login.php">
	<input type="hidden" name="s" value="{s}" class="input" />
        <h1><span>{shortname}</span></h1>
        <div id="error" style="display: block">
        	<p>{bad} incorrect!<br>Please try again...<p>
        </div>
	        <div id="loginwrapper">
	
	        	<div class="textLeft wrap-inner">
		            <h2>{Login} ({Universe} {s})</h2>
	    	    	<label for="login">{Username}</label>
	        		<input type="text" name="username" id="login" value="" tabindex="1" class="input">
	        		<label for="pass">{Password}</label> 
		        	<input type="password" name="password" id="pass" tabindex="2" class="input">
	    	    	<input type="submit" value="{Login}" tabindex="3" class="buttonSave">
	        	</div>
	
	    	    <div id="advice">
	        		<p>{NewReg} <a href='./reg.php?s={s}'>Register</a></p>
		        </div>
	            <br class="clear" />
	        </div>
    </form>
    
</body>

</html>