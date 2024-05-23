<?
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);
echo "123"; exit();
$select_s = "SELECT MODELNAME, MODELCODE, CPUID, SOCKETID, CHIPSETID, CPUSORT, SMALLIMG, IMG, BIGIMG, PRODUCTIMG, BENEFITS, SKU, SPEC, FORMFACTOR, ISDUALCORE, LAUNCH_DATE, NOTES, LANG, UPDATE_USER, UPDATE_DATE, STATUS FROM `p_s_main_systemboards`";
$select_s .=" WHERE `MODELCODE` IN ( 'S2865', 'S2866', 'S3850', 'S2850', 'S2875', 'S2877', 'S2880', 'S2881', 'S2882', 'S2882-D', 'S2885', 'S2891', 'S2892', 'S2895', 'S3870', 'S3891', 'S3892', 'S4881', 'S4882', 'S4882-D', 'S4885', 'S2912', 'S2915', 'S2927', 'S2932', 'S3970G2N-U', 'S3992', 'S4985', 'S4987', 'S8212-LE', 'S2925', 'S2390', 'S2390B', 'S2460', 'S2462', 'S2466', 'S2468', 'S2469', 'S2495', 'S2498', 'S8237' ) AND LANG = 'en-US'";
$cmd=mysqli_query($link_db,$select_s);
while ($data=mysqli_fetch_row($cmd)) {
	$MODELNAME = $data[0];
	$MODELCODE = $data[1];
	$CPUID = $data[2];
	$SOCKETID = $data[3];
	$CHIPSETID = $data[4];
	$CPUSORT = $data[5];
	$SMALLIMG = $data[6];
	$IMG = $data[7];
	$BIGIMG = $data[8];
	$PRODUCTIMG = $data[9];
	$BENEFITS = $data[10];
	$SKU = $data[11];
	$SPEC = $data[12];
	$FORMFACTOR = $data[13];
	$ISDUALCORE = $data[14];
	$LAUNCH_DATE = $data[15]; 
	$NOTES = $data[16];
	$LANG = $data[17];
	$UPDATE_USER = $data[18];
	$UPDATE_DATE = $data[19]; 
	$STATUS = $data[20];

	$insert = "insert into p_s_main_systemboards (MODELNAME, MODELCODE, CPUID, SOCKETID, CHIPSETID, CPUSORT, SMALLIMG, IMG, BIGIMG, PRODUCTIMG, BENEFITS, SKU, SPEC, FORMFACTOR, ISDUALCORE, LAUNCH_DATE, NOTES, LANG, UPDATE_USER, UPDATE_DATE, STATUS)";
	$insert .=" values ('$MODELNAME', '$MODELCODE', '$CPUID', '$SOCKETID', '$CHIPSETID', '$CPUSORT', '$SMALLIMG', '$IMG', '$BIGIMG', '$PRODUCTIMG', '$BENEFITS', '$SKU', '$SPEC', '$FORMFACTOR', '$ISDUALCORE', '$LAUNCH_DATE', '$NOTES', 'zh-TW', '$UPDATE_USER', '$UPDATE_DATE', '$STATUS')";
	mysqli_query($insert);
	$insert1 = "insert into p_s_main_systemboards (MODELNAME, MODELCODE, CPUID, SOCKETID, CHIPSETID, CPUSORT, SMALLIMG, IMG, BIGIMG, PRODUCTIMG, BENEFITS, SKU, SPEC, FORMFACTOR, ISDUALCORE, LAUNCH_DATE, NOTES, LANG, UPDATE_USER, UPDATE_DATE, STATUS)";
	$insert1 .=" values ('$MODELNAME', '$MODELCODE', '$CPUID', '$SOCKETID', '$CHIPSETID', '$CPUSORT', '$SMALLIMG', '$IMG', '$BIGIMG', '$PRODUCTIMG', '$BENEFITS', '$SKU', '$SPEC', '$FORMFACTOR', '$ISDUALCORE', '$LAUNCH_DATE', '$NOTES', 'zh-CN', '$UPDATE_USER', '$UPDATE_DATE', '$STATUS')";
	mysqli_query($insert1);
	$insert2 = "insert into p_s_main_systemboards (MODELNAME, MODELCODE, CPUID, SOCKETID, CHIPSETID, CPUSORT, SMALLIMG, IMG, BIGIMG, PRODUCTIMG, BENEFITS, SKU, SPEC, FORMFACTOR, ISDUALCORE, LAUNCH_DATE, NOTES, LANG, UPDATE_USER, UPDATE_DATE, STATUS)";
	$insert2 .=" values ('$MODELNAME', '$MODELCODE', '$CPUID', '$SOCKETID', '$CHIPSETID', '$CPUSORT', '$SMALLIMG', '$IMG', '$BIGIMG', '$PRODUCTIMG', '$BENEFITS', '$SKU', '$SPEC', '$FORMFACTOR', '$ISDUALCORE', '$LAUNCH_DATE', '$NOTES', 'ja-JP', '$UPDATE_USER', '$UPDATE_DATE', '$STATUS')";
	mysqli_query($insert2);

}
echo "OK";

?>