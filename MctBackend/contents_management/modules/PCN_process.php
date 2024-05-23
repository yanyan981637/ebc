<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$options = [
	PDO::ATTR_PERSISTENT => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_STRINGIFY_FETCHES => false,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
];

//資料庫連線
try {
	$pdo = new PDO($pdo, $db_user, $db_pwd, $options);
	$pdo->exec('SET CHARACTER SET utf8mb4');
} catch (PDOException $e) {
	throw new PDOException($e->getMessage());
}

function dowith_sql($str)
{
	//$str = str_replace("and","",$str);
	$str = str_replace("execute","",$str);
	$str = str_replace("update","",$str);
	$str = str_replace("count","",$str);
	$str = str_replace("chr","",$str);
	$str = str_replace("mid","",$str);
	$str = str_replace("master","",$str);
	$str = str_replace("truncate","",$str);
	$str = str_replace("char","",$str);
	$str = str_replace("declare","",$str);
	$str = str_replace("select","",$str);
	$str = str_replace("create","",$str);
	$str = str_replace("delete","",$str);
	$str = str_replace("insert","",$str);
	$str = str_replace("'","",$str);
	$str = str_replace('"',"",$str);
	$str = str_replace(".","",$str);
//$str = str_replace("or","",$str);  //2017.5.24暫時註解, 因舊資料sku會擋(Transport FX27)
	$str = str_replace("=","",$str);
	$str = str_replace("?","",$str);
	$str = str_replace("%","",$str);
	$str = str_replace("0x02BC","",$str);
	$str = str_replace("<script>","",$str);
	$str = str_replace("</script>","",$str);
	return $str;
}

$kinds=dowith_sql($_POST['kind']);
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kinds=='AddPlatform'){
	$add_PP=filter_var($_POST['add_PP']);
	$data = [$add_PP, $now];
	$str = "INSERT INTO pcn_platform (Platform, C_DATE) VALUES (?, ?)";
	$cmd = $pdo->prepare($str);
	try {
		if($cmd->execute($data)){
	    echo "refresh";   
	  }else{
			echo "error";
		}
	} catch (PDOException $e) {
		echo $e; 
	}
}

if($kinds=='EditPlatform'){
	$MID=filter_var($_POST['MID']);
	$edit_Platform=filter_var($_POST['edit_Platform']);
	$data = [$edit_Platform, $now];
	$str = "UPDATE pcn_platform SET Platform = ?, U_DATE=? WHERE ID = '".$MID."'";
	$cmd = $pdo->prepare($str);
	try{
		if($cmd->execute($data)) {
			echo "refresh";   
	  }else{
	    echo "error"; 
	  }
	}catch(PDOException $e) {
		echo $e; 
	}
}

if($kinds=='AddKC'){
	$add_KC=filter_var($_POST['add_KC']);
	$data = [$add_KC, $now];
	$str = "INSERT INTO pcn_key_characteristics (Characteristics, C_DATE) VALUES (?, ?)";
	$cmd = $pdo->prepare($str);
	try {
		if($cmd->execute($data)){
	    echo "refresh";   
	  }else{
			echo "error";
		}
	} catch (PDOException $e) {
		echo $e; 
	}
}

if($kinds=='EditKC'){
	$MID=filter_var($_POST['MID']);
	$edit_KC=filter_var($_POST['edit_KC']);
	$data = [$edit_KC, $now];
	$str = "UPDATE pcn_key_characteristics SET Characteristics = ?, U_DATE=? WHERE ID = '".$MID."'";
	$cmd = $pdo->prepare($str);
	try{
		if($cmd->execute($data)) {
			echo "refresh";   
	  }else{
	    echo "error"; 
	  }
	}catch(PDOException $e) {
		echo $e; 
	}
}

//關閉資料庫
unset($pdo);
exit();
?>