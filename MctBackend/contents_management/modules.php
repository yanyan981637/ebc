<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location.href='../login.php';</script>";
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
</head>

<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Modules</h1></div>

<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="default.php">Products</a></li>
<li> <a href="modules.php">Contents</a> 
<ul>
<li><a href="modules.php">Modules</a></li>	  
</ul>
</li>
<li ><a href="newsletter.php">Newsletters</a>
<ul><li><a href="subscribe.php">Subscription</a></li></ul>
</li>
</ul>
</div>

<div class="clear"></div>

<div id="Search">
<h2>Contents&nbsp;&gt;&nbsp;Modules List </h2> 
</div>
<p class="clear"></p>
<div id="content">
<br />
<!--datatable starts here-->

<p class="clear"></p>
<table class="list_table">
	<tr>
		<th>Name</th>	
	</tr>
	<tr class="order">
		<td>(Product) - &nbsp; | &nbsp; <a href="modules/pro_type_module.php" />Product Type</a>&nbsp; | &nbsp;<a href="modules/pro_info.php" />Product Info</a>&nbsp; | &nbsp;<a href="modules/category_module.php" />Category Product List page</a>&nbsp;</td>     		
	</tr>	
	<tr class="order" onclick="javascript:location.href='modules/icons_module.php'">
		<td>(Product) Icons Module</td>       		             
	</tr>
	<tr class="order">
		<td><a href="modules/doc_mgt.php">(Product) Document management</a>&nbsp; | &nbsp;<a href="modules/pro_descrp.php" />Product Description</a>&nbsp; | &nbsp;<a href="modules/pro_brief.php" />Brief</a>&nbsp; | &nbsp;<a href="modules/pro_exptab.php" />Expansion tabs</a></td>       		              
	</tr>
	<tr class="order">
		<td>
			<a href="modules/download_module.php" />(Product) Download management </a>
		</td>   		               
	</tr>
	<tr class="order">
		<td><a href="modules/support_module.php" />(Product) Support Lists management (General)</a>&nbsp; | &nbsp;<a href="modules/support_memory.php" />Memory Lists</a>&nbsp; | &nbsp;<a href="modules/support_hdd.php" />HDD/SSD Lists</a></td>   		               
	</tr>	
	<tr class="order">
		<td><a href="modules/corporation.php" />Corporation</a>&nbsp; | &nbsp;<a href="modules/corp_stories.php" />Success Stories</a></td>    		              
	</tr>
	<!--<tr class="order" onclick="javascript:location.href='modules/wheretobuy.html'" >
		<td>Where to buy <b>(do coding)</b></td>    		              
	</tr>-->
	<tr class="order">
		<td>(Newsroom)&nbsp; | &nbsp;<a href="modules/nr_pr.php" />Press Release</a>&nbsp; | &nbsp;<a href="modules/nr_events.php" />Events</a>&nbsp; | &nbsp;<a href="modules/nr_review.php" />Press Review</a> &nbsp; | &nbsp;<a href="modules/home_news.php" />MCT News</a>&nbsp;</td>    		              
	</tr>
	<tr class="order">
		<td><a href="modules/DM.php" />eDM management (for 2022 Global Top Menu)</a></td>    		              
	</tr>
	<!--<tr class="order" onclick="javascript:location.href='modules/catalog.html'" >
		<td>Catalog Page Module <b>(do coding)</b></td>      		             
	</tr>-->
	<!--DSG Modules-->		

	<tr>
		<th>DSG Modules</th>	
	</tr>
	<tr class="order">
		<td><a href="modules/DSG_Security_Advisories.php" />DSG Security Advisories</a></td>       		              
	</tr>
	<tr class="order">
		<td><a href="modules/doc_mgt_dsg.php">Docs Management</a></td>       		              
	</tr>
	<tr class="order">
		<td><a href="modules/article_mgt.php">Article Management</a></td>       		              
	</tr>
	<tr class="order">
		<td><a href="modules/EULA_mgt.php" />EULA</a></td>       		              
	</tr>
	<tr class="order" >
		<td><a href="modules/download_module_dsg.php" />Product Download Management</a></td>   		               
	</tr>
	<tr class="order" >
		<td><a href="modules/PCN_mgt.php" />PCN</a></td>   		               
	</tr>
	<tr class="order" >
		<td><a href="modules/accessory_mgt.php" />Accessories</a></td>   		               
	</tr>
	 
		
	<!--end DSG Modules-->	
</table>			
<!--end of datatable-->	
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>