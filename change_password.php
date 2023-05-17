
<script>
function oldPasswordVisbility() {
  var x = document.getElementById("old_pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function newPasswordVisbility() {
  var x = document.getElementById("new_pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
function checkOldPasswordValidity(){
var changeId=document.getElementById('change_id').value;
var password=document.getElementById('old_pass').value;
if (window.XMLHttpRequest) {
	xmlhttp=new XMLHttpRequest();
 } 
else{  
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }


 var url="server.php?"+"&changeId="+changeId+"&oldPass="+password;
 //alert(url);
xmlhttp.open("GET",url,false);
xmlhttp.onreadystatechange=fetchValidityStatus;
xmlhttp.send(); 

}
function fetchValidityStatus(){
	if (xmlhttp.readyState==4 && xmlhttp.status==200){
		var val = xmlhttp.responseText;
		var jsonData = JSON.parse(val);
		if(jsonData.status=="yes"){
			document.getElementById("new_pass").disabled = false;
			document.getElementById("update_pass").disabled = false;

		}
		else{
			alert("Give your valid current password otherwise you can't update your password.");
			document.getElementById("new_pass").disabled = true;
			document.getElementById("update_pass").disabled = true;
			
		}
	} 
		
}
</script> 


<?php
include('server.php') ;
if (isset($_SESSION['username'])){ 
    $username=$_SESSION['username'];
	if (isset($_POST['change_pass'])) {
        $changeId=$_POST['change_id'];		
?>
 


</script>

<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
        <table >
            <tr>
                <td style="color: white; text-align: center;padding: 20px;";><h2>Change Password</h2></td>
                <td>
                <a class="text-right col-12" href="index.php?logout='1'" style="color: red; text-align: right;">Logout</a> 
               </td>   
            </tr>
        </table>

	</div>
	
	<form method="post" action="server.php" onsubmit="return validate()" >

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Old Password</label>
			<input type="password" name="old_pass" id="old_pass" value="" onblur="checkOldPasswordValidity()">
			<input type="hidden" name="change_id"  id="change_id" value="<?php echo $changeId; ?>">
		</div>

		<div>
			<input type="checkbox"  name="show_pass"  id="show_pass" onclick="oldPasswordVisbility()">
            <span  style ='font-size:14px;'>show old password </span>
		</div>


		<div class="input-group ">
			<label>New Pasword</label>
			<input type="password" name="new_pass"  id="new_pass" value="" disabled>
          
            
		</div>
		<div>
			<input type="checkbox"  name="show_new_pass"  id="show_new_pass" onclick="newPasswordVisbility()">
            <span  style ='font-size:14px;'>show new password </span>
		</div>

        <div class="input-group">
			<button type="submit" class="btn" name="update_pass"id="update_pass" disabled>Update</button>
		</div>
		
	</form>
</body>
</html>
<?php } } else{ header("location: login.php");} ?>