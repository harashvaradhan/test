<?php
session_start();
	include_once('website.php');
	include_once('user.php');
	$website = new Website();
	if (isset($_POST['website_name'])) {
		$website_name = trim($_POST['website_name']);
		$user = new User();
		$username = $_SESSION['username'];
		$result = $user->getuserid($username);
		$row = $user->fetch_object($result);
		$user_id = $row->id;
		addwebsite($user_id,$website_name);
	}

	function addwebsite($user_id,$website_name)
	{
		$website = new Website();
		$result = $website->createwebsite($user_id,$website_name);
		if ($website->rowsaffected()>0) {
			$result1 = $website->getwebsiteid($user_id,$website_name);
			$row = $website->fetch_object($result1);
			echo ''.$row->website_id;
		}
		else {
			echo '0';
		}
	}

	function getuserwebsites()
	{
		$website = new Website();
		$user = new User();
		$result = $user->getuserid($_SESSION['username']);
		$row = $user->fetch_object($result);
		$user_id = $row->id;
		$result = $website->getuserwebsites($user_id);
		if ($website->num_rows($result)>0) {
	        while ($row = $website->fetch_array($result)) {
	        	$main_page= $row['main_page'];
	        	// error_log("main page ".$main_page);
	        	if (is_null($main_page)) {
	        		// echo "<tr><td><a href='set-home-page.php?website_id=".$row['website_id']."' title='Set home page for website'>".$row['website_name']."</a></td>";
	        		echo "<tr><td><a href='set_home_page/".$row['website_id']."' title='Click to go website'>".$row['website_name']."</a></td>";
	        		 // echo "<script>alert('Please set your website home page first.')</script>";
	        	} else {
	            	// echo "<tr>
	            	//  <td><a href=websitepreview.php?website_id=".$row['website_id']."&pageurlid=".$main_page." title='Click to go website' target='_blank'>".$row['website_name']."</a></td>";
	            	echo "<tr>
	            	 <td><a href=preview/".$row['website_id']."/".$main_page." title='Click to go website' target='_blank'>".$row['website_name']."</a></td>";
	            }
	            // echo "<td><a href=add-pages.php?website_id=".$row['website_id'].">Add Pages</a></td><td><a href=viewpages.php?website_id=".$row['website_id'].">View pages</td>";
	            echo "<td><a href=addpages/".$row['website_id'].">Add Pages</a></td><td><a href=viewpages.php?website_id=".$row['website_id'].">View pages</td>";
	            // echo "<td><a href=change-main-page.php?website_id=".$row['website_id'].">Change main page</a></td></tr>";
	        }
	    }
	    else{
	        echo "<tr><td>There are no websites.</td></tr>";
	    }
	}
?>