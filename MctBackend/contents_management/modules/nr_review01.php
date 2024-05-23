<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - (Newsroom) Press Review</title>
<link rel=stylesheet type="text/css" href="../../backend.css">
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: (Newsroom) Press Review</h1></div>

<div id="logout"><a href="../../login.html">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="../default.html">Products</a>

</li>
<li> <a href="../modules.html">Contents</a> 
      <ul>
		<li><a href="../modules.html">Modules</a></li>	  
      </ul>
</li>
<li ><a href="../newsletter.html">Newsletters</a>
<ul><li><a href="../subscribe.html">Subscription</a></li></ul>
</li>
</ul>
</div>


<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>  &nbsp;&gt;&nbsp; (Newsroom) Press Review</h2> 
</div>

<div id="content">

<br />
<div class="right">| &nbsp;<a href="nr_pr.php" />Press Release</a>&nbsp; | &nbsp;<a href="nr_events.php" />Events</a>&nbsp; | &nbsp;<a href="nr_awards.php" />Awards</a>&nbsp; | &nbsp;</div>
<br />

<h3>Press Review Lists:
</h3>
<div class="pagination left">
<p><select>
<option selected>English</option>
<option>簡體</option><option>繁體</option><option>日文</option>
</select> <input name="" type="text" size="30" value=""  /> <input name="" type="button" value="Search"  />  <span style="color:#0F0">**Key word search: "Reviewed Products"  欄位 </span> </p>
<p>Total: <span class="w14bblue">xxxx</span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="10" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;<select name="">
<option selected="selected">1</option>
</select></p>
</div>

<table class="list_table">
  <tr>
    <th >*Review Date</th><th  >Media</th><th>Title</th><th  >Reviewed Products</th><th  >Language</th><th  >*Status</th><th><div class="button14" style="width:50px;" onClick="location='#'">Add</div></th>
  </tr>
    <tr>
    <td >2011/04/13</td><td>STH</td><td><a href="http://www.servethehome.com/tyan-s5512wgm2nr-c204-xeon-e3-lsi-sas2008-motherboard-review/" target="blank" />S5512 Press Review ....</a></td><td>S5512WGM2NR</td><td>ENG</td><td>Online</td><td ><a href="#">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
</table>

<p >&nbsp;</p><p >&nbsp;</p>
  <P style="color:#0F0">
  - "Title" 只show 前100個characters、link to the URL in a popup window<br >
  - "Status" 決定此則review是否online<br >
  - click "Del" 要popup a confirmation window to proceed<br >
    - * 表可sorting<br >- List 順序：新至舊

  </p>
<p class="clear">&nbsp;</p>
<!--Click Edit and add -->							
<div class="subsettings">
<h1>Add / Edit a press review:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href=""> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Review Date:  </th>
<td>(calendar: date picker)</td>
</tr>
<tr>
<th>Media:  </th>
<td><input name="" type="text" size="80" value=""  /></td>
</tr>
<tr>
<th>Title: </th>
<td><input name="" type="text" size="80" value=""  />
</td>
</tr>
<tr>
<th>Summary: </th>
<td><input name="" type="text" size="80" value=""  />
</td>
</tr>
<tr>
<th>URL:  </th>
<td><input name="" type="text" size="80" value=""  /></td>
</tr>
<tr>
<th>Image: </th>
<td><input name="" type="text" size="30" value=""  />&nbsp;&nbsp;<input name="" type="button" value="Browse" /></td>
</tr>

<tr>
<th>Review Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_supported_pros.html" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <p>S7053GM2NR;&nbsp;&nbsp;S7053WGM4NR;&nbsp;&nbsp;</p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Language:</th>
<td><select>
<option selected>English</option>
<option>簡體</option><option>繁體</option><option>日文</option>
</select></td>
</tr>
<tr>
<th>Status:</th>
<td><select><option selected>Online</option><option >Offline</option></select>
</td>
</tr>
<tr><td colspan="2">
<input name="" type="button" value="Done" />&nbsp;&nbsp;<input name="" type="button" value="Cancel" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</div>
<p class="clear">&nbsp;</p>
</div>

<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
</body>
</html>