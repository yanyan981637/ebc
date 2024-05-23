<?
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$conn = mysqli_connect($db_host,$db_user,$db_pwd);
if(!$conn) die("資料庫連結失敗！");

if(@mysqli_select_db("tyanweb", $conn))
{
      //$SQL="ALTER TABLE `product_matrix` ADD `New_Field` varchar(100) default '1'";      
      $SQL="ALTER TABLE `product_matrix` DROP `New_Field`";
      mysqli_query($SQL,$conn);
      
      //建立資料欄位
      if (@mysqli_query($SQL))
        {
          echo "New_Field 新增成功\n";
        }
      else
        {
          echo "資料欄位建立失敗或資料欄位已經存在";
        }       
        
} 
?>