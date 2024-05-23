<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Download Type</title>
<link rel=stylesheet type="text/css" href="../../backend.css">
<style type="text/css">
</style>
</head>
<body style="backbround:#f9f9f9">
<h2>Edit / Add Download Type:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue">xxxx</span> records &nbsp;&nbsp;| &nbsp;&nbsp;<input name="" type="text" size="1" value="10" /> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;<select name="">
<option selected="selected">1</option>
</select></p>
</div>
<p class="clear"></p>
<table class="list_table">

  <tr>
    <th >Name</th><th>Introduction</th><th>Subcategory</th><th>OS</th><th><div class="button14" style="width:50px;" onClick="location='#'">Add</div></th>
  </tr>
<!--add a download Type-->
  <tr>
    <td ><input name="" type="text" size="20" value=""  /></td><td ><textarea  name="" rows="1" cols="50" style="max-width: 100px; max-height: 20px;"></textarea></td>
	<td style="width:120px"><input type="checkbox" name="" value="subcategory" checked > Yes&nbsp;&nbsp;<img src="../../images/icon_edit.png" alt="Edit" />
	</td>
	<td style="width:120px"><input type="checkbox" name="" value="OS" checked > Yes&nbsp;&nbsp;<img src="../../images/icon_edit.png" alt="Edit" />
	</td>
	<td style="width:150px"><input name="" type="button" value="Done" /><input name="" type="button" value="Cancel" /></td>
  </tr>
<!--end add a download Type-->
  <tr>
    <td >BIOS</td><td >TYAN makes no warranties to the usability of a BIOS on our website and are made available to the public on an "as-is" basis. Upgrading a BIOS without knowing the implications may cause serious adverse affects....(只show 100 characters).</td><td>No</td><td>No</td><td ><a href="">Edit</a>&nbsp;&nbsp;<a href="#">Del</a></td>
  </tr>
</table>
<p style="color:#0F0">- 與舊系統整合4個 download type: BIOS, IPMI/iKVM Firmware, Drivers, Utility。其中的 Drivers & Utility 有 Subcategory 的設定跟舊資料整合。<br />- 舊資料整合：(1) OS lists=> http://www.tyan.com/TYANWEBMGT/c_sp_os.aspx<br /> - 舊資料整合：(2) http://www.tyan.com/TYANWEBMGT/c_sp_drivers_category.aspx => Drivers 下面的 subcategory<br />- 舊資料整合：(3) http://www.tyan.com/TYANWEBMGT/c_sp_utility_category.aspx => Utility 下面的 subcategory<br />
- Introduction textarea 要能允許html code<br />- List 順序：由新至舊</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<!--編輯subcategory: 有勾選 Subcategory yes 後，click edit icon 才會show 出-->
<div class="subsettings" >
<h1>Add / Edit subcategories for "抓[Downlaod Type]"</h1>
	<div>
<table id="insidebox_module" >
<tr><th>Name</th><th>Image</th><th>URL</th><th>Description</th><th><input name="" type="button" value="Add" /></th></tr>
<!--add an new subcategory-->
<tr ><td ><input name="" type="text" size="20" value=""  /></td><td ><input name="" type="text" size="15" value=""  /> <input name="" type="button" value="Browse"  /></td><td ><input name="" type="text" size="15" value=""  /></td><td ><textarea  name="" rows="2" cols="30" style="max-width: 100px; max-height: 100px;"></textarea></td><td >&nbsp;</td></tr>
<!--end adding an new subcategory-->
<tr><td >TSM</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
<tr><td >Audio</td><td>/drivers/images/driver_icon_audio.gif</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
</table></div>
</div>
<p style="color:#0F0">- List 順序：由新至舊</p>
<!--end 編輯subcategory-->
<p class="clear">&nbsp;</p>
<!--編輯 OS: 有勾選 OS yes 後，click edit icon 才會show 出-->
<div class="subsettings" >
<h1>Add / Edit OS List</h1>
	<div>
<table id="insidebox_module" >
<tr><th>OS Name</th><th><input name="" type="button" value="Add" /></th></tr>
<!--add an new OS-->
<tr ><td ><input name="" type="text" size="20" value=""  /></td><td >&nbsp;</td></tr>
<!--end adding an new OS-->
<tr><td >Windows 7 Enterprise 64-bit</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
<tr><td >Windows 8 Enterprise 64-bit</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
</table></div>
</div>
<p style="color:#0F0">- List 順序：由新至舊</p>
<!--end 編輯 OS-->
</body>
</html>