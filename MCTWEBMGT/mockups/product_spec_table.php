<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
ini_set('display_errors', 0); //隱藏錯誤訊息 => 0;開啟錯誤訊息 => 1;

@session_start();

$skus_id= trim($_REQUEST['sku_id']);
$skus_name= trim($_REQUEST['sku_name']);
$skus_mcode= trim($_REQUEST['sku_mcode']);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$skus_name;?></title>

<style type="text/css">
.clear{clear:both}
.All_tb
{
	font-size: 8.0pt;	
	font-family: "Arial", "Helvetica", "sans-serif";
	font-color: #0069B0;
	border:1 px;
	margin:0;
	border-collapse:collapse;
	BORDER-BOTTOM:solid silver 1.0pt; 
}
.Spec1
{
	background-color: #F3F3F3;	
}
.Spec2
{
	background-color: #FFFFFF;	
}
.Level1
{
	font-weight:bold;	
	color: #0069B0;	
	BORDER-TOP:solid silver 1.0pt; 	
}
.Level2
{
	font-weight:bold;
	color: #333333;
	BORDER-TOP:solid silver 1.0pt; 	
}
.Level3
{
	color: #333333;
	BORDER-TOP:solid silver 1.0pt; 	
}

</style>
</head>
<body>
<?php
if($skus_id<>''){
?>
<table class='All_tb' align="center">
  <tr>
    <th colspan="3"><?=$skus_name;?> Specifications</th>
  </tr>
<?php
$ParentSpec_va_all_Sub="";$SPECTypeID_va_all="";$ParentSpec_va_all="";

$data_type_s="";
$str_type_s="select a.SPECTypeID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where a.SPECValue<>'' and Product_SKU_Auto_ID=".$skus_id;
$type_result_s=mysqli_query($link_db,$str_type_s);
while($data_p=mysqli_fetch_row($type_result_s)){
$data_type_s.=$data_p[0].",";
}

$data_optionc_s="";
$str_optionc_s="select SPECTypeID from `specvalues` where SPECValue<>'' and (INSTR('".$data_type_s."',SPECTypeID)>0) and Product_SKU_Auto_ID=".$skus_id;
$optionc_result_s=mysqli_query($link_db,$str_optionc_s);
while($data_optc=mysqli_fetch_row($optionc_result_s)){
$data_optionc_s.=$data_optc[0].",";
}
$data_optionc_s=str_replace(',,', ',', $data_optionc_s);


  $str_sku_m="select * from product_skus where Product_SKU_Auto_ID=".$skus_id;
  $cmd_sku_m=mysqli_query($link_db,$str_sku_m);
  $record_sku_m=mysqli_fetch_row($cmd_sku_m);
  
  if(empty($record_sku_m)):
  else:
    $SM13=$record_sku_m[24];
	$SM14=$record_sku_m[25];
  endif;
   
	//$str_specv="SELECT distinct speccategroies.SPECCategoryID,speccategroies.SPECCategoryName FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID inner join speccategroies on speccategroies.SPECCategoryID=spectypes.SPECCategoryID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') ORDER BY FIELD(speccategroies.SPECCategoryID,".substr($SM13, 0, strlen($SM13)-1).")";
	$str_specv="SELECT distinct speccategroies.SPECCategoryID,speccategroies.SPECCategoryName FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID inner join speccategroies on speccategroies.SPECCategoryID=spectypes.SPECCategoryID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') AND speccategroies.SPECCategoryID in (".substr($SM13, 0, strlen($SM13)-1).") ORDER BY FIELD(speccategroies.SPECCategoryID,".substr($SM13, 0, strlen($SM13)-1).")";
	$specv_result=mysqli_query($link_db,$str_specv);
	$p=0;
    while(list($SPECCategoryID,$SPECCategoryName)=mysqli_fetch_row($specv_result))
    {
	$p+=1;
?>
<tbody class="greybg">
    
	<tr class='Spec1'>
    <th class='Level1' width="150"><?=$SPECCategoryName;?> </th>
    <td></td>
    <td class='Level2'>        
		<table border="0" class="sectable">
		    <colgroup class="greybg"></colgroup>
		    <colgroup ></colgroup>
		
        <?php
	$str_GetParent1="select distinct ParentSpec from spectypes where SPECCategoryID=".$SPECCategoryID." and (ParentSpec IS NOT NULL) and INSTR('".$SM14."',SPECTypeID)>0";
	$GetParentresult1=mysqli_query($link_db,$str_GetParent1);
	$GetParentresult1Num=mysqli_num_rows($GetParentresult1);
	while(list($ParentSpec)=mysqli_fetch_row($GetParentresult1)){
	$ParentSpec_va_all.=$ParentSpec.",";
	}
	if($GetParentresult1Num>0){
	$ParentSpec_va_all_Sub=$SM14;
	}
	
	$str_GetSType1="select SPECTypeID as SPECTypeID_va from spectypes where SPECCategoryID=".$SPECCategoryID." and (ParentSpec IS NULL) and INSTR('".$SM14."',SPECTypeID)>0";
	$GetSTyperesult1=mysqli_query($link_db,$str_GetSType1);
	while(list($SPECTypeID_va)=mysqli_fetch_row($GetSTyperesult1)){
	$SPECTypeID_va_all.=$SPECTypeID_va.",";
	}
		
		$j=0;$k=0;$l=0;$r=0;$i=0;$v=0;$str1="";
        //$str_specv1="SELECT Case When spectypes.InputTypeID= 4 Then specvalues.SPECValue else Fun_Get_SPECValue(specvalues.SPECValue) End CSPECValue, SPECTypeName, spectypes.SPECTypeID, spectypes.SPECCategoryID, spectypes.WebOrder, spectypes.SPECTypeSort, spectypes.ParentSort FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') AND spectypes.SPECCategoryID=".$SPECCategoryID."  order by spectypes.SPECTypeID";
        $str_specv1="SELECT Case When spectypes.InputTypeID= 4 Then specvalues.SPECValue else Fun_Get_SPECValue(specvalues.SPECValue) End CSPECValue, SPECTypeName, spectypes.SPECTypeID, spectypes.SPECCategoryID, spectypes.WebOrder, spectypes.SPECTypeSort, spectypes.ParentSort FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') AND spectypes.SPECCategoryID=".$SPECCategoryID."  order by spectypes.ParentSort, spectypes.`SPECTypeSort`";
		$specv_result1=mysqli_query($link_db,$str_specv1);
        while(list($CSPECValue,$SPECTypeName,$SPECTypeID,$SPECCategoryID,$WebOrder)=mysqli_fetch_array($specv_result1))
        {	  
          $str_P='';
          $str_Parentspecv1="select ParentSpec from spectypes where SPECCategoryID=".$SPECCategoryID." and SPECTypeID=".$SPECTypeID;
          $Parentspecresult=mysqli_query($link_db,$str_Parentspecv1);    
          list($ParentSpec)=mysqli_fetch_row($Parentspecresult); 
		  
          if($ParentSpec!=''){	  
		  $j+=1;
		  $str_SPECCat_chk="select SPECTypeID,SPECTypeName from spectypes where SPECTypeID=".$ParentSpec;
		  $SPECCat_result_chk=mysqli_query($link_db,$str_SPECCat_chk);
          $SPECCat_str_chk=mysqli_fetch_row($SPECCat_result_chk);
          
          $SPECCat_str_chk_id=$SPECCat_str_chk[0];
          $SPECCat_str_chk_name=$SPECCat_str_chk[1];
		  $SName['SPN'.$v]=$SPECCat_str_chk[1];		  
		  $str_P=$SPECCat_str_chk_name;
		  
		  $SPECCat_str_chk_name_str.=$SPECCat_str_chk[1].",";
			
			if($SPECCat_str_chk_id==$ParentSpec){
			  if($SName['SPN'.$v]==$SPECCat_str_chk[1]){
			   $SName[$SPECCat_str_chk[1]]+=1;
			   $v+=1;
			  }else{
			   $v=0;
			  }
			}else{
			$v=0;
			}

		  }else{
		  $j=0;
		  }		  
		  
        ?>
        <?php
		if($SName[$SPECCat_str_chk[1]]==1 && $_SESSION['rs_'.$str_P]!=''){
		?>
		<th class='Level2' width="160" rowspan="<?=$_SESSION['rs_'.$str_P];?>">		
		<font color=""><?=$str_P;?> </font>
		</th>
        <?php
		}
		?>
		<th class='Level2' width="160"><?=$SPECTypeName;?> </th>
	<?php
	$SP_STypeID="SELECT `SKU_Type` FROM `product_skus` WHERE `Product_SKU_Auto_ID`=".$skus_id;
	$STypeID_cmd=mysqli_query($link_db,$SP_STypeID);
	$STypeID_data=mysqli_fetch_row($STypeID_cmd);
	
	$SP_Pa="";
    $str_Types_Pa="select SPECTypeID from spectypes where SPECCategoryID=".$SPECCategoryID." and (ParentSpec is NULL)";
    $Typesresult_Pa=mysqli_query($link_db,$str_Types_Pa);
	while($Typesresult_PaData=mysqli_fetch_row($Typesresult_Pa)){
	$SP_Pa.=$Typesresult_PaData[0].",";
	}
	
	$str_Types_sub="select SPECTypeID,SPECTypeName,ParentSpec from spectypes where SPECCategoryID=".$SPECCategoryID." and (INSTR(',".$STypeID_data[0]."',SPECTypeID)>0 or INSTR(',".$SP_Pa."',ParentSpec)>0) order by SPECTypeSort";
	$Typesresult_sub=mysqli_query($link_db,$str_Types_sub);	
	while($sub_sdate=mysqli_fetch_row($Typesresult_sub)){		
		if($SPECTypeID==$sub_sdate[2]){
			if($sub_sdate[2]!=NULL){
			echo "<th><td>".$sub_sdate[1]."</td></th>";
			}else{
			echo "";
			}			
		}else{
		}		
	}
	?>
        <td class='Level3' width="260"><?=str_replace(' /', ', ', $CSPECValue);?></td>    
        </tr>
        <?php
        }
        ?>
        </table>
    </td>
    </tr>
</tbody>
<?php
}
?>
</table>
<?php
}
		$str_Pare01="select distinct a.SPECTypeName from `spectypes` a inner join (SELECT distinct `ParentSpec` FROM  `spectypes` WHERE `ParentSpec` IS NOT NULL) b on a.SPECTypeID=b.ParentSpec";
		$Pare01_cmd=mysqli_query($link_db,$str_Pare01);
		while($Pare01_data=mysqli_fetch_row($Pare01_cmd)){			
			$SName_chk[$Pare01_data[0]]=$SName[$Pare01_data[0]];
			if($SName[$Pare01_data[0]]!=''){
			$_SESSION['rs_'.$Pare01_data[0]]=$SName[$Pare01_data[0]];
			}
		}
		?>
</body>
</html>
<?php
echo "<script>self.location='product_spec_tmp.php?sku_id='".$_REQUEST['sku_id']."'&sku_name='".$_REQUESGT['sku_name']."'&sku_mcode='".$_REQUEST['sku_mcode']."'</script>";
?>