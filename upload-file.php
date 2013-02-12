<?php
session_start();
include_once("header.php");
include_once('menu.php');

if (!isset($_SESSION['username'])) {
	header("Location: login");
}
?>

<body>
	<h1>File upload</h1>
	<hr>
	<form name ='upload-file-form' method='POST' action='includes/upload-file-processing.php' enctype="multipart/form-data">
	Select Image/Video Files <input type = 'file' name= 'file'> <br />
	<input type = 'submit' name ='btnupload' value ='Upload file' onClick="return validatefileupload()">
	<input type ='reset' name ='Clear'>
	</form>

	<!-- <a href="view-file.php">View Files</a> -->
	<button type='button' onClick="return goto(this.value)" value='view-file.php'>View Files</button>
</body>


<?php
include_once("footer.php");
?>