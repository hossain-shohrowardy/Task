<?php 
if(!isset($_SESSION['username'])){
	session_start();

	// variable declaration
	$username = "";
}

else{
    $username = $_SESSION['username']; 
}
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";


	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'task');

	// REGISTER USER
/*	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password) 
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}*/

    if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        $userNameVaildityStr="select user_name from user_info where user_name='$username'";
        $userNameValidityQuery=mysqli_query($db, $userNameVaildityStr);
        $countUserName= mysqli_num_rows($userNameValidityQuery);

        $userEmailVaildityStr="select user_email from user_info where user_email='$email'";
        $userEmailValidityQuery=mysqli_query($db, $userEmailVaildityStr);
        $countUserEmail= mysqli_num_rows($userEmailValidityQuery);

        if($countUserName > 0){
            array_push($errors, "UserName is already exists");
        }
        if($countUserEmail > 0){
            array_push($errors, "User Email is already exists");
        }

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			
            $password=password_hash($password_1, PASSWORD_DEFAULT);
		 	$query = "INSERT INTO user_info (user_name, user_email, user_password) 
					  VALUES('$username', '$email', '$password')";
             mysqli_query($db, $query);

            if (!empty($_FILES['file_name']['name'])) {
                
                $filename=$username.'_'.$_FILES["file_name"]["name"];
                move_uploaded_file($_FILES["file_name"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$_FILES["file_name"]["name"]);
			    rename($_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$_FILES["file_name"]["name"],$_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$filename);
                $query = "Update user_info set file_name='$filename' where user_name='$username'"; 
                 mysqli_query($db, $query);
                

            }

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			//$password = md5($password);
          // $password=password_hash($password, PASSWORD_DEFAULT);
			$query = "SELECT * FROM user_info WHERE user_name='$username'";
			$results = mysqli_query($db, $query);
            $hashedPassword="";
            while($row=mysqli_fetch_object($results)){
                $hashedPassword=$row->user_password;
             }
            // echo $password.'\n'. $hashedPassword; return;

			if(password_verify($password,$hashedPassword)) {
            	$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

    if (isset($_POST['edit_user'])) {
      
            $editId=$_POST['edit_id'];
            $query="select * from user_info where id='$editId'";
            $userInfo=mysqli_query($db,$query);
            while($row=mysqli_fetch_object($userInfo)){
            $username=$row->user_name;
            $email=$row->user_email;
            }
            
    }

    if (isset($_POST['update_user'])) {
        
        $username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
        $updateId=$_POST['update_id'];
        $currentEmail=$_POST['current_email'];
        $countUserName=0;
        $countUserEmail=0;

        if($currentEmail!=$email){
            $userEmailVaildityStr="select user_email from user_info where user_email='$email'";
            $userEmailValidityQuery=mysqli_query($db, $userEmailVaildityStr);
            $countUserEmail= mysqli_num_rows($userEmailValidityQuery);
         }

        if($username!=$_SESSION['username']){
            $userNameVaildityStr="select user_name from user_info where user_name='$username'";
            $userNameValidityQuery=mysqli_query($db, $userNameVaildityStr);
            $countUserName= mysqli_num_rows($userNameValidityQuery);
         }


        if($countUserName > 0){
            array_push($errors, "UserName is already exists");
        }
        if($countUserEmail > 0){
            array_push($errors, "User Email is already exists");
        }

        if (!empty($_FILES['file_name']['name'])) { 
              
            $filename=$username.'_'.$_FILES["file_name"]["name"];
            move_uploaded_file($_FILES["file_name"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$_FILES["file_name"]["name"]);
            rename($_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$_FILES["file_name"]["name"],$_SERVER['DOCUMENT_ROOT']."/TASK/uploadfile/".$filename);
            $query = "Update user_info set file_name='$filename' where id='$updateId'"; 
             mysqli_query($db, $query);
       }

        if (count($errors) == 0) {
          
		    $query = "Update user_info set user_name='$username', user_email='$email' 
            where id='$updateId' ";               
			mysqli_query($db, $query);
          
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "User Information has been updated successfully";
			header('location: index.php');
		}
        else{
            header('location: edit_user.php');
        }

    }

    if (isset($_POST['delete_user'])) {
           $deleteId=$_POST['delete_id'];
           $query="Delete From user_info where id='$deleteId'";
           mysqli_query($db, $query);
           $_SESSION['success'] = "User Information has been Deleted successfully";
           header('location: index.php');


    }
    if(isset($_GET['changeId']) && isset($_GET['oldPass']) ){
        $changeId=$_GET['changeId'];
        $oldPass=$_GET['oldPass'];

        $query = "SELECT * FROM user_info WHERE id='$changeId'";
        $results = mysqli_query($db, $query);
        $hashedPassword="";
        while($row=mysqli_fetch_object($results)){
            $hashedPassword=$row->user_password;
         }

         if(password_verify($oldPass,$hashedPassword)) {
            $data['status'] = 'yes';
          
         }
         else{
            $data['status'] = 'no'; 
         }

         echo json_encode($data);

    }

    if (isset($_POST['update_pass'])) {
        $changeId=$_POST['change_id'];
        $newPassword=$_POST['new_pass'];
        $hashedPassword=password_hash($newPassword, PASSWORD_DEFAULT);
       
        $query = "Update user_info set user_password='$hashedPassword'
        where id='$changeId'";               
        mysqli_query($db, $query);
        session_destroy();
		unset($_SESSION['username']);
        header('location: index.php');

    }

?>