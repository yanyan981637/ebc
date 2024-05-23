<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
ini_set('max_execution_time', 0);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$id=$_POST['id'];
$mvalue=$_POST['value'];

$num = preg_replace("/ETab_MA_/i", '', $id);

switch($num){ 
    case 3:
    $str_mval=1;
    $$str_sval="";
    break;
    case 4:
    $str_mval=2;
    $str_sval="";
    break;
    case 5:
    $str_mval=3;
    $str_sval="";
    break;
    case 6:
    $str_mval=4;
    $str_sval="PCI-X";
    break;
    case 7:
    $str_mval=4;
    $str_sval="PCI";
    break;
    case 8:
    $str_mval=4;
    $str_sval="PCIe";
    break;
    case 9:
    $str_mval=5;
    $str_sval="Max.";
    break;
    case 10:
    $str_mval=5;
    $str_sval="Type";
    break;
    case 11:
    $str_mval=6;
    $str_sval="Audio (A)";
    break;
    case 12:
    $str_mval=6;
    $str_sval="Video (G)";
    break;
    case 13:
    $str_mval=6;
    $str_sval="LAN (N)";
    break;
    case 14:
    $str_mval=6;
    $str_sval="RAID (R)";
    break;
    case 15:
    $str_mval=7;
    $str_sval="Server Mgmt.";
    break;
    case 16:
    $str_mval=8;
    $str_sval="RoHS (Type)";
    break;
    }
    
    $str_values="select MValue_id FROM `matrix_values` order by MValue_id desc limit 1";
    $check_values=mysqli_query($link_db,$str_values);
    $Max_CValID=mysqli_fetch_row($check_values);
    $MCount=$Max_CValID[0]+1;
         
    $guid = com_create_guid();
    $guid = preg_replace("/{/i", '', $guid);
    $guid = preg_replace("/}/i", '', $guid);
    
    putenv("TZ=Asia/Taipei");
    $now=date("Y/m/d H:i:s");
          
    $strs="insert into `matrix_values` (`MValue_id`, `MValue_Mid`, `MValue_SUBName`, `MValue_VName`, `SKUs`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `Tooltips`) values ($MCount,".$str_mval.",'".$str_sval."','".$mvalue."','','','$now','1782','1','')";
    $cmds=mysqli_query($link_db,$strs);
    
    if($cmds==true){
    session_start();
    $_SESSION['PMA_Value'] = $mvalue;
    }
?>