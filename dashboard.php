<?php if (isset($_SESSION['username'])){ 
   $username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<?php include("header.php") ?>
<body>

 <div class="container">
 <div class="col-lg-12">
 <br><br>
 <table>
    <tr>
        <td>
        <h1 class="text-warning text-left col-12" > User Profile Management </h1> 
        </td>
        <td>
        <a class="text-right col-12" href="index.php?logout='1'" style="color: red;">Logout</a> 
        </td>
    <tr>
 </table>

 <br>
 <table  id="tabledata " class=" table table-striped table-hover table-bordered">
 
 <tr class="bg-dark text-white text-center">
 
 
 <th> Username </th>
 <th> Email</th>
 <th> Action </th>
 <th> Action </th>
 <th> Change Password </th>
 <th> File </th>

 </tr >

 <?php

 include 'includes/db.php'; 
  $q = "select * from user_info where user_name='$username'";
  $path= 'http://localhost/TASK/uploadfile/';

 $query = mysqli_query($db,$q);

 while($res = mysqli_fetch_array($query)){
 ?>
 <tr class="text-center">

 <td> <?php echo $res['user_name'];  ?> </td>
 <td> <?php echo $res['user_email'];  ?> </td>

 <td> 
    <form method="post" action="edit_user.php">
        <input type="hidden" name="edit_id" value="<?php echo $res['id'];?>" >
        <input type="submit" class="btn-info btn" name="edit_user" value="Edit"> 
   </form>
    
</td> 
 <td> 
    <form method="post" action="server.php">
        <input type="hidden" name="delete_id" value="<?php echo $res['id'];?>" >
        <input type="submit" class="btn-danger btn" name="delete_user" value="Delete"> 
   </form>
    
</td>
<td>
    <form method="post" action="change_password.php">
            <input type="hidden" name="change_id" value="<?php echo $res['id'];?>" >
            <input type="submit" class="btn-info btn" name="change_pass" value="Change"> 
    </form>
 </td>
<?php if($res['file_name']!='none') {?>
<td> 
<a href="<?php echo $path.$res['file_name'];?>" download="<?php echo $res['file_name']?>"> Download</a>
 </td>
 <?php } else {?>
    <td>none<td>
    <?php } ?>     
</tr>

 <?php 
 }
  ?>
 
 </table>  

 </div>
 </div>

 <script type="text/javascript">
 
 $(document).ready(function(){
 $('#tabledata').DataTable();
 }) 
 
 </script>

</body>
</html>

<?php } else{ header("location: login.php");} ?>