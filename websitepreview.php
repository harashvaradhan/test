<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login");
}
include_once("preview_header.php");
include_once('includes/website.php');

if (isset($_GET['website_id'])) {
    $_SESSION['website_id']=$_GET['website_id'];
}
$website_id=$_SESSION['website_id'];

if(isset($_GET['pageurlid']))
{
    $pageid=addslashes($_GET['pageurlid']);
    $website_id=$_SESSION['website_id'];
    $viewpage= new Website();

   /******* fetching website information ***************/
    $webres= $viewpage->fetchewebsiteinfo($website_id);
    $db=new DBConnection();
    $webrow=$db->fetch_assoc($webres);
    //print_r($pagerow);
                $webid=$webrow['website_id'];
                $webname=$webrow['website_name'];
                $webusr=$webrow['user_id'];
                $webkeyword=$webrow['keyword'];
                $websitetitle=$webrow['site_title'];
                $webdescription=$webrow['meta_description'];

    /***********for fetching particular page information  *************/

    $res=$viewpage->fetchpage($website_id,$pageid);
    $db=new DBConnection();
    $pagerow=$db->fetch_assoc($res);
                //print_r($pagerow);
                $pageid=$pagerow['page_id'];
                $pagename=$pagerow['page_name'];
                $pagecontent=$pagerow['page_content'];
}
?>
Header content
<!-- BEGIN: Page Content -->
    <title><?php echo $websitetitle."-".$pagename; ?></title>
    <meta name="description" content="<?php if($webdescription !=NULL) echo $webdescription ; ?>">
    <meta name="keywords" content="<?php if($webkeyword!=NULL) echo $webkeyword;?>">
    <meta charset="UTF-8">
    </head>
    <div id ='menu'>
    <ul>
    <?php

    $website = new Website();
    $result = $website->getmenupages($website_id);

    while ($row = $website->fetch_array($result)) {
    ?>
        <li><?php 
            // echo "<a href='websitepreview.php?website_id=".$website_id."&pageurlid=$row[page_id]'>$row[page_name]</a>";
        echo "<a href='/MTP/preview/".$website_id."/".$row['page_id']."'>".$row['page_name']."</a>";
        ?></li>
    <?php
    }
    ?>
    </ul>
</div>
<div id="container">
<h2>Page Name:<?php echo $pagename;?></h2>
<h3> <?php echo $pagecontent;?></h3>
</div>

<?php include_once("footer.php");?>



