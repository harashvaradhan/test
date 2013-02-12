<?php
session_start();
if ($_SESSION['username'] != '') {

	include_once('header.php');
	include_once('includes/website.php');
	include_once('includes/user.php');
	$website_id = $_GET['website_id'];
	$website = new Website();
	$username = $_SESSION['username'];
	$user = new User();
	$result = $user->getuserid($username);
	$row = $user->fetch_object($result);
	$user_id = $row->id;
?>
<body>
<div id ='dialog-home-page' title='Select Main Page For Website'>
	<form id="newwebsite">
    <fieldset>
        <?php
        	$result = $website->getpages($website_id);
        	if ($website->num_rows($result)<=0) {
        ?>
        		<label for="name">Come back after adding pages to website.</label>
        <?php } else { ?>
   					<label for="name">Select first page for website</label>
   				<?php
					while ($row = $website->fetch_array($result)) {
						$page_name = $row['page_name'];
						$page_id = $row['page_id'];
				?>
         		<input type="radio" name="page" id="name" value='<?php echo $page_id; ?>'/>
         		<label for="name"><?php echo $page_name;?></label>
        	<?php 	}
    		}
        	?>
        	<input type='hidden' name='website_id' value = '<?php echo $website_id; ?>' />
    </fieldset>
    <p class="validateTips"></p>
    </form>
</div>
</body>
<?php
include_once('footer.php');
} else {
	header("Location: ./login");
}
?>