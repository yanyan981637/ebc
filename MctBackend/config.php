<?php
   $db_host="localhost:3306";
   $db_user="root";
   $db_pwd="";
   $dataBase="cbuweb2";

$Config["DB_HOST"]="localhost:3306";
$Config["DB_USER"]="root";
$Config["DB_PWD"]="";
$Config["DB_NAME"]="cbuweb2";

class CDB
{
	var $db;
	function CDB($db_type = "mysql")
	{
		global $Config;
		if($db_type == "mysql")
			$this->db = new CMysql();
		else if($db_type == "sqlite")
			$this->db = new CSqlite();
	}
};

class CMysql
{
	var $db;

	function __construct() {
      // connecting to database
      $this->conn = $this->CMysql();
    }
 
	function CMysql()
	{
		global $Config;
		$db = mysqli_connect($Config["DB_HOST"], $Config["DB_USER"], $Config["DB_PWD"], $Config["DB_NAME"]) or die ("Could not Connect:" . mysqli_error());
		mysqli_query($db,"SET NAMES utf8");
		//mysqli_select_db($Config["DB_NAME"]);		
		return $db;
	}
	function CMysqlClose()
	{
	    global $Config;
		$this->db = mysqli_connect($Config["DB_HOST"], $Config["DB_USER"], $Config["DB_PWD"], $Config["DB_NAME"]) or die ("Could not Connect:" . mysqli_error());
		mysqli_close($this->db);
	}
};
?>