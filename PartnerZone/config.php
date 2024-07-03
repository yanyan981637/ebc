<?php
if(strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!=''){
	echo "<script language='javascript'>self.location='/index.html'</script>";
	exit;
}

$db_host="10.88.26.74:3306";
$db_user="sa";
$db_pwd="Kazumi2008";
$dataBase="tony_ebc1";

$mail_host = "email-smtp.us-east-1.amazonaws.com";
$mail_port = "587";
$mail_user = "AKIAI42EEMNDM2OMFQRA";
$mail_pwd = "BFrFD5EU7Ci4qFeuzIRZELVI+9WOicehBG4IQErP9VTZ";

function encrypt($data, $key)
{
	$key    =   md5($key);
	$x      =   0;
	$len    =   strlen($data);
	$l      =   strlen($key);
	for ($i = 0; $i < $len; $i++)
	{
		if ($x == $l)
		{
			$x = 0;
		}
		$char .= $key{$x};
		$x++;
	}
	for ($i = 0; $i < $len; $i++)
	{
		$str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
	}
	return base64_encode($str);
}

function decrypt($data, $key)
{
	$key = md5($key);
	$x = 0;
	$data = base64_decode($data);
	$len = strlen($data);
	$l = strlen($key);
	for ($i = 0; $i < $len; $i++)
	{
		if ($x == $l)
		{
			$x = 0;
		}
		$char .= substr($key, $x, 1);
		$x++;
	}
	for ($i = 0; $i < $len; $i++)
	{
		if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
		{
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}
		else
		{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return $str;
}
?>