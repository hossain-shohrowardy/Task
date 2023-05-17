
<script>
	function validate()
	{
		if(document.getElementById('username').value=="")
		{
			alert("Please provide your username");
			return false;
		}
		else if(document.getElementById('email').value=="")
		{
			alert("Please provide your email");
			return false;
		}
        else if(document.getElementById('password_1').value=="")
		{
			alert("Please provide your password");
			return false;
		}
        else if(document.getElementById('password_2').value=="")
		{
			alert("Please provide your conformation password");
			return false;
		}
		else
		{
             if(document.getElementById('password_1').value!=document.getElementById('password_1').value){
                return false;

            }

			return true;
		}			
	}



 function passwordVisbility() {
  var x = document.getElementById("password_1");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

  var y = document.getElementById("password_2");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}
</script>

<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="register.php"  enctype="multipart/form-data" onsubmit="return validate()" >

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" id="username" value="<?php echo $username; ?>">
		</div>


		<div class="input-group ">
			<label>Email</label>
			<input type="email" name="email"  id="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password"  name="password_1"  id="password_1" >
		</div>

        <div>
			<input type="checkbox"  name="show_pass"  id="show_pass" onclick="passwordVisbility()">
            <span  style ='font-size:14px;'>show password </span>
		</div>
    
     
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2" id="password_2">
		</div>
        <div>
			<label>File Upload (Optional)</label>
			<input type="file" name="file_name" id="file_name">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>
		<p>
			a member? <a href="login.php">Sign in</a>
		</p>
		
	</form>
</body>
</html>