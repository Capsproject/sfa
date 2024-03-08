<?php
require_once ("../../include/initialize.php");
	 if (!isset($_SESSION['ACCOUNT_ID'])){
      redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;

	case 'aphotos' :
	doupdateimage();
	break;

	case 'deletephoto':
        deletePhoto();
        break;

 
	}
	function getAnnouncementDetails($announce) {
		global $mydb;
	
		// Assuming you have a function to fetch the announcement details from the database
		$mydb->setQuery("SELECT * FROM useraccounts WHERE announce = '{$announce}'");
		$result = $mydb->executeQuery();
	
		if ($result === false) {
			die('Error in SQL query: ' . mysqli_error($mydb->conn));
		}
	
		$announcement = $mydb->fetchObject($result);
	
		return $announcement;
	}
	
	function deletePhoto() {
		global $mydb;
	
		if (isset($_GET['announce'])) {
			$announce = $_GET['announce'];
	
			// Assuming you have a function to get the announcement details, update the photo field to NULL or an empty string
			$announcement = getAnnouncementDetails($announce);
	
			// Assuming you have a function to delete the photo file
			$photoPath = WEB_ROOT . 'admin/announcement/' . $announcement->announce;
			if (file_exists($photoPath)) {
				unlink($photoPath); // Delete the file
			}
	
			// Update the photo field in the database to NULL or an empty string
			// updatePhotoField($announce, ''); // Uncomment and replace with your actual update function
	
			// Redirect back to the page
			redirect('index.php'); // Change 'index.php' to the actual page you want to redirect to
		}
	}
	
   
	function doInsert(){
		global $mydb;

		if(isset($_POST['save'])){
 

		if ($_POST['U_NAME'] == "" OR $_POST['U_USERNAME'] == "" OR $_POST['U_PASS'] == "") {
			$messageStats = false;
			message("All field is required!","error");
			redirect('index.php?view=add');
		}else{	

			$sql = "SELECT * FROM useraccounts WHERE ACCOUNT_USERNAME='" .$_POST['U_USERNAME']."'";
			$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
			$userresult = mysqli_fetch_assoc($res);

			if ($userresult) {
				# code...
				message("Username is already taken.", "error");
				redirect('index.php?view=add');
			}else{

			$user = New User();
			// $user->USERID 		= $_POST['user_id'];
			$user->ACCOUNT_NAME 		= $_POST['U_NAME'];
			$user->ACCOUNT_USERNAME		= $_POST['U_USERNAME'];
			$user->ACCOUNT_PASSWORD		=sha1($_POST['U_PASS']);
			$user->ACCOUNT_TYPE			=  $_POST['U_ROLE'];
			$user->create();

						// $autonum = New Autonumber(); 
						// $autonum->auto_update(2);

			message("New [". $_POST['U_NAME'] ."] created successfully!", "success");
			redirect("index.php");

			} 
		}
		}

	}

	function doEdit(){
		global $mydb;

	if(isset($_POST['save'])){
		// $sql = "SELECT * FROM useraccounts WHERE ACCOUNT_USERNAME='" .$_POST['U_USERNAME']."'";
		// 	$res = mysqli_query($mydb->conn,$sql) or die(mysqli_error($mydb->conn));
		// 	$userresult = mysqli_fetch_assoc($res);

		// 	if ($userresult) {
		// 		# code...
		// 		message("Username is already taken.", "error");
		// 		redirect('index.php?view=add');
		// 	}else{
				$user = New User(); 
			$user->ACCOUNT_NAME 		= $_POST['U_NAME'];
			$user->ACCOUNT_USERNAME		= $_POST['U_USERNAME'];
			$user->ACCOUNT_PASSWORD		=sha1($_POST['U_PASS']);
			$user->ACCOUNT_TYPE			= $_POST['U_ROLE'];
			$user->update($_POST['USERID']);

			  message("[". $_POST['U_NAME'] ."] has been updated!", "success");
			redirect("index.php");
			// }
 
			
		}
	}


	function doDelete(){
		global $mydb;

		
		// if (isset($_POST['selector'])==''){
		// message("Select the records first before you delete!","info");
		// redirect('index.php');
		// }else{

		// $id = $_POST['selector'];
		// $key = count($id);

		// for($i=0;$i<$key;$i++){

		// 	$user = New User();
		// 	$user->delete($id[$i]);

		
				$id = 	$_GET['id'];

				$user = New User();
	 		 	$user->delete($id);
			 
			message("User already Deleted!","info");
			redirect('index.php');
		// }
		// }

		
	}

	function doupdateimage(){
		global $mydb;

 
			$errofile = $_FILES['photo']['error'];
			$type = $_FILES['photo']['type'];
			$temp = $_FILES['photo']['tmp_name'];
			$myfile =$_FILES['photo']['name'];
		 	$location="aphotos/".$myfile;


		if ( $errofile > 0) {
				message("No Image Selected!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
		}else{
	 
				@$file=$_FILES['photo']['tmp_name'];
				@$image= addslashes(file_get_contents($_FILES['photo']['tmp_name']));
				@$image_name= addslashes($_FILES['photo']['name']); 
				@$image_size= getimagesize($_FILES['photo']['tmp_name']);

			if ($image_size==FALSE ) {
				message("Uploaded file is not an image!", "error");
				redirect("index.php?view=view&id=". $_GET['id']);
			}else{
					//uploading the file
					move_uploaded_file($temp,"aphotos/" . $myfile);
		 	
					 

						$user = New User();
						$user->announce = $location;
						$user->update($_SESSION['ACCOUNT_ID']);
						redirect("index.php");
						 
							
					}
			}
			 
		}
 
?>