
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
  
		else
		{
			return true;
		}			
	}
</script>


<?php
include('server.php') ;
if (isset($_SESSION['username'])){ 
    $username=$_SESSION['username'];
?>
 


</script>

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
        <table >
            <tr>
                <td style="color: white; text-align: center;padding: 20px;";><h2>Edit User</h2></td>
                <td>
                <a class="text-right col-12" href="index.php?logout='1'" style="color: red; text-align: right;">Logout</a> 
               </td>   
            </tr>
        </table>

	</div>
	
	<form method="post" action="server.php"   enctype="multipart/form-data" onsubmit="return validate()" >

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" id="username" value="<?php echo $username; ?>">
		</div>


		<div class="input-group ">
			<label>Email</label>
			<input type="email" name="email"  id="email" value="<?php echo $email; ?>">
            <input type="hidden" name="update_id"  id="update_id" value="<?php echo $editId; ?>">
            <input type="hidden" name="current_email"  id="current_email" value="<?php echo $email ; ?>">
		</div>
        <div>
			<label>File Upload (Optional)</label>
			<input type="file" name="file_name" id="file_name">
		</div>

        <div class="input-group">
			<button type="submit" class="btn" name="update_user">Update</button>
		</div>
		
	</form>
</body>
</html>
<?php } else{ header("location: login.php");} ?>