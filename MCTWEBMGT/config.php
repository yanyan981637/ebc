<?php
$db_host="10.88.26.74:3306";
$db_user="sa";
$db_pwd="Kazumi2008";
$dataBase="tony_ebc1";

$Config["DB_HOST"]="10.88.26.74:3306";
$Config["DB_USER"]="sa";
$Config["DB_PWD"]="Kazumi2008";
$Config["DB_NAME"]="tony_ebc1";

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