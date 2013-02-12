
<form id = "add-menu-form">
	<fieldset>
	<?php
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location: login");
	}
	include_once ('includes/website.php');
	$website_id = $_REQUEST['website_id'];
	$website = new Website();
	$result = $website->getpages($website_id);
	while ($row = $website->fetch_array($result)) {
		$pagename = $row['page_name'];
		$id = $row['page_id'];
		$menu_flag = $row['menu'];
	?>
	<label for='name'><?php echo $pagename ;?></label>
	<input type='checkbox' name='checkname[]' value='<?php echo $id;?>' <?php if($menu_flag == 'Yes') echo "checked"; ?> />
	<?php }
	?>
	<input type='hidden' id ='website_id' name='website_id' value ='<?php echo $website_id; ?>'/>
	</fieldset>
</form>
<p class="validateTips">All pages created successfully,select menu pages for your website.</p>