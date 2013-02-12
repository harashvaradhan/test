<?php
session_start();
if ($_SESSION['username'] != null) {
include_once("header.php");
include_once('menu.php');
 if (!isset($_GET['website_id'])) {
 	header("Location: create-website.php");
 } else {
	
?>
<body>
	<div id ="dialog-add-menu" title ="Select Menu Pages"></div>
	<h2>Add Pages</h2>
	<hr>
	<form name= 'add-page-form' autocomplete='off'>
		<!-- <div id='pagecountdiv'>
			<input type='hidden' id= 'website_id' name='website_id' value ='<?php //echo "".$_GET['website_id'];?>'>

			Number of pages :<input type= 'text' id ='pagecount'  name='pagecount'>
			<input type='button' id='ok' value='Ok' />
		</div> -->
		<div id='pages'></div>
		<input type='hidden' id= 'website_id' name='website_id' value ='<?php echo "".$_GET['website_id'];?>'>
		<input type='button' id='addpages' value='Add page'>
		<input type='button' id='create' value='Create' />
	</form>
</body>
<?php 
include_once("footer.php");
	 }
} else {
	header('Location: ../login');
}
?>
