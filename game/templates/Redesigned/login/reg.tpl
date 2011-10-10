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

    <form name="new" method="post">
    	<input type="hidden" name="step" value="validate" />
        <h1><span>{shortname}</span></h1>
        <div id="error" style="display: none;">
        	<p id="errorInput"><p>
        </div>
        <div id="loginwrapper">
        	<div class="textLeft wrap-inner">

	            <h2>Register</h2>
    	    	<label for="login">Players Name</label>
        		<input type="text" name="character" id="username" value="" tabindex="1" class="input" onfocus="display_info('username');" onkeydown="checkUsername()" onkeyup="checkUsername()">
        		<label for="pass">Email address</label> 
	        	<input type="text" name="email" id="email" value="" tabindex="2" class="input" onfocus="display_info('email');" onkeydown="checkEmail()" onkeyup="checkEmail()">
	        	<input type="checkbox" name="agb" id="agb" tabindex="3" value="on" onfocus="display_info('agb');" >I accept the <a href="http://impressum.gameforge.de/index.php?lang=de&art=tac&special=&&f_text=b1daf2&f_text_hover=ffffff&f_text_h=061229&f_text_hr=061229&f_text_hrbg=061229&f_text_hrborder=9EBDE4&f_text_font=arial%2C+arial%2C+arial%2C+sans-serif&f_bg=000000" target="_blank">T&C</a>    	    	<input type="submit" value="Sign Up" tabindex="3" class="start">

        	</div>
    	    <div id="advice">
        		<p id="infoInput"></p>
	        </div>
            <br class="clear" />
        </div>
        <input type="hidden" name="v" value="2" />
    </form>
    
</html>