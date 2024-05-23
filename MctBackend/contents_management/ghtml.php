<?php
/*
if(isset($_POST['n4']) && !empty($_POST['n4'])){
// 記得檢查此 URL 是不是你發出的 request
echo file_get_contents($_POST['n4']);
echo $_POST['n4'];
}
*/
$content = @file_get_contents('http://www.tyan.com/card/V49/49.htm');
echo $content;
?>