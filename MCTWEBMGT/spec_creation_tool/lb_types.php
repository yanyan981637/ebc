<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_REQUEST['PType_id'])!=''){
$PType_id=intval($_REQUEST['PType_id']);
}else{
$PType_id="";
}
if(isset($_REQUEST['SPCC_ID'])!=''){
$SPCC_ID=intval($_REQUEST['SPCC_ID']);
}else{
$SPCC_ID="";
}

if(isset($_REQUEST['kinds'])!=''){
if($_REQUEST['kinds']=='add_types'){
/* Start */
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$PType_id;
$type_result_s=mysqli_query($link_db,$str_type_s);
$data_p=mysqli_fetch_row($type_result_s);
mysqli_close($link_db);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from SPECTypes where SPECCategoryID=".$SPCC_ID." order by SPECTypeName";
$Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName)=mysqli_fetch_row($Typesresult_Pa))
{
 $SP_Pa.=$SPECTypeID.",";
}
mysqli_close($link_db);

  if($SPCC_ID==106 || $SPCC_ID==122){
    $data_p_value=$data_p[2];
  }else if($SPCC_ID<>106 || $SPCC_ID<>122){
    $data_p_value=$data_p[1];
  }

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from SPECTypes where (SPECCategoryID=".$SPCC_ID." and (SPECTypeID not in (1024,1030,1031,1161,1301,1304,1305,1407,1411,1412) or INSTR('".$SP_Pa."',ParentSpec)>0)) order by SPECTypeName";
  $Typesresult=mysqli_query($link_db,$str_Types);  
  while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$ParentSpec,$IsShow)=mysqli_fetch_row($Typesresult)){
   
   //if(eregi($SPECTypeID,$data_p_value)!=''){
   if(strpos($data_p_value,$SPECTypeID)!='' || strpos($data_p_value,$SPECTypeID)===0){
    $s_str01.= $SPECTypeID.",";
   }
  
  }
/* End */

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_POST['T1'])!=''){
$T1=htmlspecialchars($_POST['T1'], ENT_QUOTES);
}else{
$T1="";
}
if(isset($_POST['ptyps_Aname'])!=''){
$PType_Aid01=trim($_POST['ptyps_Aname']);
}else{
$PType_Aid01="";
}
//$SPCT_ID01=$_REQUEST['SPCC_ID'];

$str_c="select SPECTypeName from SPECTypes where SPECCategoryID=".$SPCC_ID." and SPECTypeName='".$T1."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

      $str_m="select SPECTypeID FROM SPECTypes order by SPECTypeID desc limit 1";
      $check_m=mysqli_query($link_db,$str_m);
      $Max_CTypeID=mysqli_fetch_row($check_m);
      $MCount=$Max_CTypeID[0]+1;

	function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
	}

	$guid = getGUID();
	$guid = com_create_guid();
	$guid = preg_replace("/{/i", '', $guid);
	$guid = preg_replace("/}/i", '', $guid);

//$str_t="insert into SPECTypes (SPECCategoryID,SPECTypeName,WebOrder,ParentSpec,InputTypeID,GUID,crea_d,crea_u) values ($SPCC_ID,'$T1','',0,2,'$guid','$now','1782')";
$str_t="insert into SPECTypes (SPECTypeID,SPECCategoryID,SPECTypeName,WebOrder,InputTypeID,GUID,crea_d,crea_u) values ($MCount,$SPCC_ID,'$T1','',2,'$guid','$now','1782')";
$cmd_t=mysqli_query($link_db,$str_t);
 if($cmd_t==true):
 
 if(isset($_COOKIE["type_cookie".$SPCC_ID.""])<>''){
 $Mcount01=$MCount.",".$_COOKIE["type_cookie".$SPCC_ID.""];
 }else{
 $Mcount01=$MCount.",".$s_str01;
 } 
 setcookie("type_cookie".$SPCC_ID,$Mcount01,time()+1800); //set cookie約1800秒
 echo "<script>alert('Add Types it!');self.location='lb_types.php?SPCC_ID=$SPCC_ID&PType_id=$PType_Aid01'</script>";
 endif;
else:
echo "<script>alert('SPECTypesName目前已經存在,請重新輸入!');self.location='lb_types.php?SPCC_ID=$SPCC_ID&PType_id=$PType_Aid01'</script>";
exit();
endif;
mysqli_close($link_db);
}

if($_REQUEST['kinds']=='types_set'){	
	$spt_SPECTypeID_all="";
	if(isset($_POST['spt_SPECTypeID'])<>''){
		
		foreach($_POST['spt_SPECTypeID'] as $spt_SPECTypeID_str) {
		$spt_SPECTypeID_all.=$spt_SPECTypeID_str.","; // SPECTypeID is checked
		}
	
	}else{
		$spt_SPECTypeID_all='';
	}
	
	if(isset($_REQUEST['SPCC_ID'])!=''){
	$SPCC_ID01=intval($_REQUEST['SPCC_ID']);
	}else{
	$SPCC_ID01="";
	}
	
	if(isset($_POST['ptyps_name'])!=''){
	$ptyps_name=trim($_POST['ptyps_name']);
	}else{
	$ptyps_name="";
	}
	
	setcookie("type_cookie".$SPCC_ID01,$spt_SPECTypeID_all,time()+1800); //set cookie is about 1800 Sec	
	//echo $spt_SPECTypeID_all."<br />";	
	$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link_db,'SET NAMES utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
	//$select=mysqli_select_db($dataBase, $link_db);
		
	$str_Ptypes_Pa="SELECT SPECType,SPECType_Sub FROM `producttypes` where ProductTypeID=".$ptyps_name;
	$PTypesresult_Pa=mysqli_query($link_db,$str_Ptypes_Pa);
	$PTyp_data=mysqli_fetch_row($PTypesresult_Pa);
	$PTyp_str=$PTyp_data[0];
	$PTyp_sub_str=$PTyp_data[1];
	    
		$SPECType_str="";
		if($SPCC_ID==106){
		 
		 $str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from spectypes where SPECCategoryID=".$SPCC_ID." and `ParentSpec`<>''";
		 $Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
		 while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName)=mysqli_fetch_row($Typesresult_Pa)){	    
		   $SPECType_str.=$SPECTypeID.","; //得到所有的SPECTypeID		
		   $PTyp_sub_str=str_replace($SPECTypeID.",","",$PTyp_sub_str); //先取代所有該SPECTypeID的值		 
		 }		 
		 $str_Ptypes_upset="update `producttypes` set SPECType_Sub='".$PTyp_sub_str.$spt_SPECTypeID_all."' where ProductTypeID=".$_POST['ptyps_name'];
		
		}else if($SPCC_ID<>106){
		
		 $str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from spectypes where SPECCategoryID=".$SPCC_ID." and IsShow='1' order by SPECTypeName";
		 $Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
		 while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName)=mysqli_fetch_row($Typesresult_Pa)){	    
		   $SPECType_str.=$SPECTypeID.","; //得到所有的SPECTypeID
		   $PTyp_str=str_replace($SPECTypeID.",","",$PTyp_str); //先取代所有該SPECTypeID的值
		 }		
	     $str_Ptypes_upset="update `producttypes` set SPECType='".$PTyp_str.$spt_SPECTypeID_all."' where ProductTypeID=".$_POST['ptyps_name'];	     
        
		}
		
		//$PTypesresult_upset=mysqli_query($link_db,$str_Ptypes_upset);	
	echo "<script>alert('設定SPECTypes成功!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
	mysqli_close($link_db);
	exit();	
/*
$typs_name = explode(",", $_POST['typs_name'],-1);
$typs_count = count($typs_name); //Types總數

for($i=0;$i<$typs_count;$i++){

$typs_name_re=str_replace("spt_","",$typs_name[$i]);


  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Ts="update SPECTypes set IsShow='".$_POST[$typs_name[$i]]."' where SPECTypeID=".$typs_name_re;
  $Tysresult=mysqli_query($link_db,$str_Ts); 

}
//echo "<script>alert('設定SPECTypes成功!');self.location='lb_types.php?SPCC_ID=$SPCC_ID'</script>";
echo "<script>alert('設定SPECTypes成功!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
*/
}
}
$reurl="http://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Edit Product Category's Types</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<style type="text/css">
table{border:1px solid #c0c0c0; width:95%}
thead{background:#00a0e9; color:#fff; font-weight:bolder;padding:5px 15px;}
td{ padding:5px 15px;}
td.two{padding-left:50px}
tr{  cursor: pointer; }
tr:hover{background: #dcf2fd;}
tbody:nth-child(even) {
	background: #f8f8f8;
}
</style>
<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript">
<!--
  var ST,SP,SK,UP,PN1,PN2,PN3,PN4,PN5,PN6,PN7,PN8,PN9,PN10;
  var PMT03,PMT04,PMT05,PMT06,PMT07,PMT08,PMT09,PMT10,PMT11,PMT12,PMT13,PMT14,PMT15,PMT16,PMT17,PMT18,PMT19;
  ST=parent.form1.PT1.value;
  SP=parent.form1.SEL_PMODEL.value;
  SK=parent.form1.SKU_value.value;
  UP=parent.form1.UPC_value.value;

  //PMT03=$("#SEL_PMT003").parent("selected").find("option:selected").text();  
  
  n003=parent.form1.SEL_PMT003.selectedIndex;  
  PMT03=parent.form1.SEL_PMT003.options[n003].text;
  n004=parent.form1.SEL_PMT004.selectedIndex;
  PMT04=parent.form1.SEL_PMT004.options[n004].text;
  n005=parent.form1.SEL_PMT005.selectedIndex;
  PMT05=parent.form1.SEL_PMT005.options[n005].text;
  n006=parent.form1.SEL_PMT006.selectedIndex;
  PMT06=parent.form1.SEL_PMT006.options[n006].text;
  n007=parent.form1.SEL_PMT007.selectedIndex;
  PMT07=parent.form1.SEL_PMT007.options[n007].text;
  n008=parent.form1.SEL_PMT008.selectedIndex;
  PMT08=parent.form1.SEL_PMT008.options[n008].text;
  n009=parent.form1.SEL_PMT009.selectedIndex;
  PMT09=parent.form1.SEL_PMT009.options[n009].text;
  n010=parent.form1.SEL_PMT010.selectedIndex;
  PMT10=parent.form1.SEL_PMT010.options[n010].text;
  n011=parent.form1.SEL_PMT011.selectedIndex;
  PMT11=parent.form1.SEL_PMT011.options[n011].text;
  n012=parent.form1.SEL_PMT012.selectedIndex;
  PMT12=parent.form1.SEL_PMT012.options[n012].text;
  n013=parent.form1.SEL_PMT013.selectedIndex;
  PMT13=parent.form1.SEL_PMT013.options[n013].text;

  if(ST==101 || ST==102){
  PN1=parent.form1.SEL_PN1.value;
  PN2=parent.form1.SEL_PN2.value;
  PN3=parent.form1.SEL_PN3.value;
  
  n014=parent.form1.SEL_PMT014.selectedIndex;
  PMT14=parent.form1.SEL_PMT014.options[n014].text;
  n015=parent.form1.SEL_PMT015.selectedIndex;
  PMT15=parent.form1.SEL_PMT015.options[n015].text;
  n016=parent.form1.SEL_PMT016.selectedIndex;
  PMT16=parent.form1.SEL_PMT016.options[n016].text;  
    
    $.cookie("c_seVal03", PMT03);
	$.cookie("c_seVal04", PMT04);
	$.cookie("c_seVal05", PMT05);
	$.cookie("c_seVal06", PMT06);
	$.cookie("c_seVal07", PMT07);
	$.cookie("c_seVal08", PMT08);
	$.cookie("c_seVal09", PMT09);
	$.cookie("c_seVal10", PMT10);
    $.cookie("c_seVal11", PMT11);
	$.cookie("c_seVal12", PMT12);
	$.cookie("c_seVal13", PMT13);
	$.cookie("c_seVal14", PMT14);
	$.cookie("c_seVal15", PMT15);
	$.cookie("c_seVal16", PMT16);   
  
	if(parent.form1.SEL_PN1.length>0){
	$.cookie("SEL_PN1", PN1);
	}
	if(parent.form1.SEL_PN2.length>0){
	$.cookie("SEL_PN2", PN2);
	}
	if(parent.form1.SEL_PN3.length>0){
	$.cookie("SEL_PN3", PN3);
	}
  
  }else if(ST==103 || ST==104){
  PN4=parent.form1.SEL_PN4.value;
  PN5=parent.form1.SEL_PN5.value;
  PN6=parent.form1.SEL_PN6.value;
  
  n014=parent.form1.SEL_PMT014.selectedIndex;
  PMT14=parent.form1.SEL_PMT014.options[n014].text;
  n015=parent.form1.SEL_PMT015.selectedIndex;
  PMT15=parent.form1.SEL_PMT015.options[n015].text;
  n016=parent.form1.SEL_PMT016.selectedIndex;
  PMT16=parent.form1.SEL_PMT016.options[n016].text;
  n017=parent.form1.SEL_PMT017.selectedIndex;
  PMT17=parent.form1.SEL_PMT017.options[n017].text;
  n018=parent.form1.SEL_PMT018.selectedIndex;
  PMT18=parent.form1.SEL_PMT018.options[n018].text;
  n019=parent.form1.SEL_PMT019.selectedIndex;
  PMT19=parent.form1.SEL_PMT019.options[n019].text;
  
    $.cookie("c_seVal03", PMT03);
	$.cookie("c_seVal04", PMT04);
	$.cookie("c_seVal05", PMT05);
	$.cookie("c_seVal06", PMT06);
	$.cookie("c_seVal07", PMT07);
	$.cookie("c_seVal08", PMT08);
	$.cookie("c_seVal09", PMT09);
	$.cookie("c_seVal10", PMT10);
    $.cookie("c_seVal11", PMT11);
	$.cookie("c_seVal12", PMT12);
	$.cookie("c_seVal13", PMT13);
	$.cookie("c_seVal14", PMT14);
	$.cookie("c_seVal15", PMT15);
	$.cookie("c_seVal16", PMT16);
    $.cookie("c_seVal17", PMT17);
	$.cookie("c_seVal18", PMT18);
	$.cookie("c_seVal19", PMT19);	
    
	if(parent.form1.SEL_PN4.length>0){
    $.cookie("SEL_PN4", PN4);
    }
    if(parent.form1.SEL_PN5.length>0){
    $.cookie("SEL_PN5", PN5);
    }
    if(parent.form1.SEL_PN6.length>0){
    $.cookie("SEL_PN6", PN6);
    }
  
  }else if(ST==105 || ST==106){
  PN7=parent.form1.SEL_PN7.value;
  PN8=parent.form1.SEL_PN8.value;
  PN9=parent.form1.SEL_PN9.value;
    
	if(parent.form1.SEL_PN7.length>0){
    $.cookie("SEL_PN7", PN7);
    }
    if(parent.form1.SEL_PN8.length>0){
    $.cookie("SEL_PN8", PN8);
    }
    if(parent.form1.SEL_PN9.length>0){
    $.cookie("SEL_PN9", PN9);
    }
  
  }else if(ST==107){
  PN5=parent.form1.SEL_PN5.value;
  PN6=parent.form1.SEL_PN6.value;
  PN10=parent.form1.SEL_PN10.value;
    
	if(parent.form1.SEL_PN5.length>0){
    $.cookie("SEL_PN5", PN5);
    }
    if(parent.form1.SEL_PN6.length>0){
    $.cookie("SEL_PN6", PN6);
	}
	if(parent.form1.SEL_PN10.length>0){
    $.cookie("SEL_PN10", PN10);
    }
	
  }
  
  $.cookie("SEL_PMODEL01", SP);
  $.cookie("SKU_value01", SK);
  $.cookie("UPC_value01", UP);  
  
  
//-->
</script>
<script language="JavaScript">
<!--
function Final_Check(){
  if(document.form2.T1.value==''){
  alert ("請輸入Types！");
  document.form2.T1.focus();
  return false;
  }
  return true;
}
//-->
</script>
</head>
<body style="backbround:#f9f9f9">
<p>
<form id="form2" name="form2" method="post" action="?kinds=add_types&SPCC_ID=<?=$SPCC_ID?>&PType_id=<?=$PType_id;?>" onsubmit="return Final_Check();">
Types <input name="T1" type="text" size="25" value=""  /> &nbsp;&nbsp;&nbsp;&nbsp;Enter tooltips <input name="T2" type="text" size="25" value=""  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="ptyps_Aname" type="hidden" value="<?=$PType_id;?>"><input type="submit" value="Add"  /> <a href="#" onclick="javascript:parent.location.reload();parent.jQuery.fancybox.close();">Close</a></p>
</form>
<form id="form1" name="form1" method="post" action="?kinds=types_set&SPCC_ID=<?=$SPCC_ID?>">
<table>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$PType_id;
$type_result_s=mysqli_query($link_db,$str_type_s);
$data_p=mysqli_fetch_row($type_result_s);
//echo $data_p[0];
mysqli_close($link_db);

$SP_Pa="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
//$str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from SPECTypes where SPECCategoryID=".$SPCC_ID." and (ParentSpec is NULL) and IsShow='1'";
$str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from spectypes where SPECCategoryID=".$SPCC_ID." order by SPECTypeName";
$Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName)=mysqli_fetch_row($Typesresult_Pa)){
 $SP_Pa.=$SPECTypeID.",";
}
mysqli_close($link_db);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_Category="select SPECCategoryID,SPECCategoryName from speccategroies where SPECCategoryID=".$SPCC_ID;
$Categoryresult=mysqli_query($link_db,$str_Category);
$data=mysqli_fetch_row($Categoryresult);
?>
<thead><tr><td ><?=$data[1];?> :</td></tr></thead>
<tbody>
<?php
  //if($SPCC_ID==106 || $SPCC_ID==122){
  //$data_p_value=$data_p[2];
  //}else if($SPCC_ID<>106 || $SPCC_ID<>122){
  //$data_p_value=$data_p[1];
  //}
  $data_p_value=$data_p[1].$data_p[2]; 

	if(isset($_COOKIE["type_cookie".$SPCC_ID.""])!=''){
	$data_p_value01=$_COOKIE["type_cookie".$SPCC_ID.""];
	}else{
	$data_p_value01=$data_p_value;
	}  
  
  $str="";
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);
  //$str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from SPECTypes where SPECCategoryID=".$SPCC_ID." and INSTR('".$SP_Pa."',SPECTypeID)>0 order by SPECTypeName";
  //$str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from SPECTypes where SPECCategoryID=".$SPCC_ID." and (ParentSpec is NULL) and INSTR('".$data_p[1]."',SPECTypeID)>0 order by SPECTypeName";
  //$str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from spectypes where (SPECCategoryID=".$SPCC_ID." and (SPECTypeID not in (1024,1030,1031,1161,1301,1304,1305,1407,1411,1412) or INSTR('".$SP_Pa."',ParentSpec)>0)) order by SPECTypeName";
  $str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from spectypes where (SPECCategoryID=".$SPCC_ID." and SPECTypeID not in (SELECT distinct `ParentSpec` FROM  `spectypes` WHERE  `ParentSpec` IS NOT NULL )) or INSTR('".$SP_Pa."',ParentSpec)>0 order by SPECTypeName";
  $Typesresult=mysqli_query($link_db,$str_Types);  
  while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$ParentSpec,$IsShow)=mysqli_fetch_row($Typesresult)){
  $str=$str."spt_".$SPECTypeID.",";  
  if($ParentSpec!=NULL){
  
    $str_Types_PStr="select SPECTypeName from spectypes where SPECTypeID='".$ParentSpec."'";
    $Typesresult_PStr=mysqli_query($link_db,$str_Types_PStr);
    $PStr_Val=mysqli_fetch_row($Typesresult_PStr);  
    $SPE_SName=$PStr_Val[0]." -> ".$SPECTypeName;
	//$SPE_SName=$PStr_Val[0].$SPECTypeName;
      
  }else if($ParentSpec==NULL){
    $SPE_SName=$SPECTypeName;
  }
  //name="spt_$SPECTypeID"
?>
<tr><td><input name="typs_name" type="hidden" value="<?=$str;?>"><input name="ptyps_name" type="hidden" value="<?=$PType_id;?>"><input name="spt_SPECTypeID[]" type="checkbox" value="<?=$SPECTypeID;?>" <?php if(preg_match("/".$SPECTypeID."/i",$data_p_value01)!='') echo "checked"; ?> /> <?=$SPE_SName;?></td></tr>
<?php
 }
 mysqli_close($link_db);
?>
<tr><td><p style="padding:5px 20px; "><input type="submit" value="Done"  /></p></td></tr>
</tbody>
</table>
</form>
<P style="color:#0F0;display:none">
- show 這個 category 下面所有設定的types, check to set.<br>
- Add New box 可輸入新的type, add後出現在下面table
- 參考
http://dbushell.github.com/Nestable/  &  http://mjsarfatti.com/sandbox/nestedSortable/<br>
以table 方式呈現兩層，可用拖拉 rows 進行兩層grouping & 排序
</p>
</body>
</html>