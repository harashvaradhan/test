<?php
/*
* View
*/
session_start();
if ($_SESSION['username'] != null) {

	include_once("header.php");
	include_once('menu.php');
	include_once('includes/file.php');
	include_once('includes/user.php');

	// echo "In View ";
	$username = $_SESSION['username'];
	// echo "Username ".$username."<br>";
?>
	<!-- <a href='upload-file.php'>Add new file</a> -->
	<!-- <a href="upload-file.php">Go Back</a> -->
	<!-- <button type='button' onClick="return goto(this.value)" value='upload-file.php'>Add new file</button> -->
	<br><button type='button' onClick="return goto(this.value)" value='upload-file.php'>Go Back</button>
	<br><br>
<?php
	$file = new Fileclass();
	$user = new User();
	$result = $user->getuserid($username);
	$row = $user->fetch_object($result);
	$user_id = $row->id;
	// echo "User ID :".$user_id."<br>";
	$result = $file->getuserfiles($user_id);
	if ($file->num_rows($result)>0) {


		while ($row = $user->fetch_object($result)) {
			$id = $row->id;
			$file = $row->file_path.$row->file_name;
			$pos =strpos($file, '/');
			$filename = substr($file, $pos+1);
			// echo "$file $filename";
?>
		<img src='<?php echo $filename; ?>' height='100' width='100'>
		<?php echo "<a href='edit-file.php?action=replace&id=$id'> Replace</a>";?>
		<?php echo " |<a href='edit-file.php?action=edit&id=$id'> Edit</a>";?>
		<?php echo " |<a href='edit-file.php?action=delete&id=$id'> Delete</a>";?>
<?php
		}
	} else {
		echo "No files found.";
	}

?>

<?php include_once("footer.php");
} else {
	header('Location: ./login');
}
?>