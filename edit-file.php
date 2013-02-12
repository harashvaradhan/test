<?php
session_start();
if ($_SESSION['username'] != null) {

	include_once('header.php');
	include_once('menu.php');
	include_once('includes/file.php');
	include_once('includes/user.php');
	$action = $_GET['action'];
	$id = $_GET['id'];
	$username = $_SESSION['username'];
	$file = new Fileclass();
	// echo "Action:".$action." Id:".$id." User_id :".$user_id;
	if ($action == 'replace') {
		error_log("in Replace");
	echo"<h3>Select image to replace with </h3><br>";
	$file = new Fileclass();
	$user = new User();
	$result = $user->getuserid($username);
	$row = $user->fetch_object($result);
	$user_id = $row->id;
	$result = $file->gettrashfiles($user_id);
	if ($file->num_rows($result)>0) {
			
		
		while ($row = $user->fetch_object($result)) {
			$id = $row->id;
			$file = $row->file_path.$row->file_name;
			$pos =strpos($file, '/');
			$filename = substr($file, $pos+1);
			error_log("".$file .", ".$filename);
	?>
		<img src='<?php echo $file; ?>' height='100' width='100'>
		<?php echo "<a href='edit-file.php?action=replace&id=$id'> Replace</a>";?>
		<?php echo " |<a href='edit-file.php?action=edit&id=$id'> Edit</a>";?>
		<?php echo " |<a href='edit-file.php?action=delete&id=$id'> Delete</a>";?>
	<?php
		}
	} else {
		echo "No files found.";
	}

?>



	<?php
	}
	if ($action == 'edit') {
		// echo "Editing image";
	?>
		<!-- <a href="view-file.php">Go Back</a><br> -->
		<button type='button' onClick="return goto(this.value)" value='view-file.php'>Go Back</button>
		<form name ='upload-file-form' method='POST' action='includes/edit-file-processing.php' enctype="multipart/form-data">
		<input type='hidden' name='id' value='<?php echo $id;?>'>	
		Select Image/Video Files <input type = 'file' name= 'file'> <br />
		<input type = 'submit' name ='btnupload' value ='Upload file' onClick="return validatefileupload()"> 
		<input type ='reset' name ='Clear'>  

	<?php
	}
	if ($action == 'delete') {
		// echo "Deleting image";
		$backup_path = "backup/";
	
		$result = $file->getfile($id);
		$row = $file->fetch_object($result);
		$filename = $row->file_name;
		$filepath =  $row->file_path;
		// error_log("File path:".$filepath.",Name:".$filename);
		$pos = strpos($filepath, '/');
		$filepath = substr($filepath, $pos+1);
		$destination_path = $backup_path.$filepath.$filename;
		$source_path = $filepath.$filename;
		// error_log("source_path:".$source_path.",destination_path:".$destination_path);
		copy($source_path, $destination_path);
		unlink($filepath.$filename);
		$target_path = $backup_path.$filepath;
		// error_log("Backup path :".$target_path);
		$result = $file->movetotrash($id,$target_path);
		if ($file->affected_rows()>0) {
			echo "<script>alert('File has been deleted');</script>";
			echo "<script>window.location.href='view-file.php'</script>";
		} else {
			echo "<script>alert('File not deleted,some error occured,please try again.');</script>";
			echo "<script>window.location.href='view-file.php'</script>";
		}
	}
	include_once('footer.php');
} else {
	header('Location: ./login');
}
?>