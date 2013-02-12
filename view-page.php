<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: login");
}
include_once ('header.php');
include_once ('includes/website.php');

$website_id = $_SESSION['website_id'] =1 ;
$website = new Website();
$result = $website->getmenupages($website_id);
?>
<body>
<div id ='menu'>
	<ul>
	<?php
	while ($row = $website->fetch_array($result)) {
	?>
		 <!--<?php //echo "Menu Page_id:".$row['page_id']."page_name :".$row['page_name']."<br>"; ?>-->
		<li><a href='#'><?php echo $row['page_name']; ?></a></li>
	<?php
	}
	?>
	</ul>
</div>
</body>
<?php include_once('footer.php');?>