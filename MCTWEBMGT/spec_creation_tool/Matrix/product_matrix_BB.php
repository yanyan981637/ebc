<?
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

if($_REQUEST['sorting']<>''){
$sorting=$_REQUEST['sorting'];
}else{
$sorting="MatrixID";
}

if($_REQUEST['PMatrix_id']<>''){
$PMatrix_id=$_REQUEST['PMatrix_id'];
  if($PMatrix_id==101 || $PMatrix_id==103){
  $type_style="";
  $type_style_buttom="sub";
  $Cvalues="QPI";
  }else if($PMatrix_id==102 || $PMatrix_id==104){
  $type_style="main_A";
  $type_style_buttom="sub_A";
  $Cvalues="HT";
  }
}else{
$PMatrix_id=101;
  
  $type_style="";
  $type_style_buttom="sub";
  $Cvalues="QPI";
}
if($_REQUEST['PMatrix_tname']<>''){
$PMatrix_tname=$_REQUEST['PMatrix_tname'];
}

if($_REQUEST['PMCat_id']<>''){
$PMCat_id=$_REQUEST['PMCat_id'];  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TYAN Product Matrix - Intel Mainboard</title>
<link rel=stylesheet type="text/css" href="css/product_martix_table.css">
<script language="JavaScript">
function MM_o(selObj){
window.open(document.getElementById('SEL_PMAT').options[document.getElementById('SEL_PMAT').selectedIndex].value,"_self");
}
</script>
</head>
<body><a name="top"></a>
<div id="pm_header">
<div style="float:left"><a href="/index.aspx"><img src="http://www.tyan.com/images/index/TYAN_index_logo.gif" style="margin-right:80px" /></a></div>
<div class="nav1">
<h1>TYAN Product Matrix - </h1>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_type="select ProductTypeID,ProductTypeName from ProductTypes";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result)){

  if($ProductTypeID==101 || $ProductTypeID==102){
  $P_URL="product_matrix_tmp.php";
  }
  if($ProductTypeID==103 || $ProductTypeID==104){
  $P_URL="product_matrix_BB.php";
  }
  if($ProductTypeID==106){
  $P_URL="product_matrix_HBA.php";
  }
?>
 | &nbsp;<? if($ProductTypeID==105 || $ProductTypeID==107) { ?>
 <?=$ProductTypeName;?>
 <?
 }else{
 ?> 
 <a href="<?=$P_URL;?>?PMatrix_id=<?=$ProductTypeID;?>&PMatrix_tname=<?=$ProductTypeName;?>" /><?=$ProductTypeName;?></a> 
 <?
 }
 ?> 
<?
}
mysqli_Close($link_db);
?>
</div>
<p class="clear"></p>
<div class="nav2">
<a href="#">PRODUCTS</a> &nbsp;&gt;&nbsp; <a href="#">Home</a> &nbsp;&gt;&nbsp; <a href="#">Products</a> &nbsp;&gt;&nbsp; <?=$PMatrix_tname;?> :
<select id="SEL_PMAT" name="SEL_PMAT" onChange="MM_o(this)">
    <option selected="selected" value="">Select...</option>
    <?   
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    //$select=mysqli_select_db($dataBase, $link_db);

    $str_pm="select Product_Matrix_Cid,Matrix_CategoryName from product_matrix_categories where ProductTypeID=".$PMatrix_id." and IsStatus='1' order by Product_Matrix_Cid";
    $pm_result=mysqli_query($link_db,$str_pm);
    while(list($Product_Matrix_Cid,$Matrix_CategoryName)=mysqli_fetch_row($pm_result)){
    ?>
    <option value="?PMCat_id=<?=$Product_Matrix_Cid;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>" <? if($PMCat_id==$Product_Matrix_Cid) { echo "selected"; } ?> ><?=$Matrix_CategoryName;?></option>
    <?
    }
    mysqli_close($link_db);
    ?>
</select>
</div>
</div>
<?=$str_pm;?>
<p style="height:160px">&nbsp;</p>
<!--後台設定排第一的Matrix Category table start here-->
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

if($_REQUEST['PMCat_id']<>''){
$str_matrix_s="select * from product_matrix_categories where Product_Matrix_Cid=".$PMCat_id;
$matrixresult_s=mysqli_query($link_db,$str_matrix_s);
}
if($_REQUEST['PMCat_id']<>''){
list($Product_Matrix_Cid,$ProductTypeID,$Page_Status,$Matrix_CategoryName,$IsStatus,$Matrix_SKUs,$ico_img)=mysqli_fetch_row($matrixresult_s);
} 
?>
<h1 class="product_matrix"><? if($ico_img!=''){ ?><img src="../<?=$ico_img;?>" /><? } ?> <?=$Matrix_CategoryName;?></h1>
<?
  if($_REQUEST['sorting']<>''){
  
  $sorting_Value_str=$_REQUEST['sorting'];
  $Tm01="ModelCode";
  $Tm02="SKU";
  $Tm03="Dim_H";
  $Tm04="Dim_W";
  $Tm05="Dim_D";
  $Tm06="Power_Supply";
  $Tm07="CPU_Series";
  $Tm08="Mem_Max";
  $Tm09="Mem_Type";
  $Tm10="HDD_Max";
  $Tm11="HDD_Type";
  $Tm12="HDD_HF";
  $Tm13="NIC_GbE";
  $Tm14="NIC_10GbE";
  $Tm15="PCIx";
  $Tm16="PCI";
  $Tm17="PCIe";
  $Tm18="Sr_Mgt";
  $Tm19="RHS_typ";

  
  if($sorting_Value_str=="ModelCode"){
  $sorting=$sorting_Value_str;
  $Tm01="ModelCode_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="ModelCode_A"){
  $sorting="ModelCode";
  $Tm01="ModelCode";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="SKU"){
  $sorting=$sorting_Value_str;
  $Tm02="SKU_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="SKU_A"){
  $sorting="SKU";
  $Tm02="SKU";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Dim_H"){
  $sorting=$sorting_Value_str;
  $Tm03="Dim_H_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Dim_H_A"){
  $sorting="Dim_H";
  $Tm03="Dim_H";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Dim_W"){
  $sorting=$sorting_Value_str;
  $Tm04="Dim_W_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Dim_W_A"){
  $sorting="Dim_W";
  $Tm04="Dim_W";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Dim_D"){
  $sorting=$sorting_Value_str;
  $Tm05="Dim_D_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Dim_D_A"){
  $sorting="Dim_D";
  $Tm05="Dim_D";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Power_Supply"){
  $sorting=$sorting_Value_str;
  $Tm06="Power_Supply_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Power_Supply_A"){
  $sorting="Power_Supply";
  $Tm06="Power_Supply";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="CPU_Series"){
  $sorting=$sorting_Value_str;
  $Tm07="CPU_Series_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="CPU_Series_A"){
  $sorting="CPU_Series";
  $Tm07="CPU_Series";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Mem_Max"){
  $sorting=$sorting_Value_str;
  $Tm08="Mem_Max_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Mem_Max_A"){
  $sorting="Mem_Max";
  $Tm08="Mem_Max";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Mem_Type"){
  $sorting=$sorting_Value_str;
  $Tm09="Mem_Type_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Mem_Type_A"){
  $sorting="Mem_Type";
  $Tm09="Mem_Type";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="HDD_Max"){
  $sorting=$sorting_Value_str;
  $Tm10="HDD_Max_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="HDD_Max_A"){
  $sorting="HDD_Max";
  $Tm10="HDD_Max";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="HDD_Type"){
  $sorting=$sorting_Value_str;
  $Tm11="HDD_Type_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="HDD_Type_A"){
  $sorting="HDD_Type";
  $Tm11="HDD_Type";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="HDD_HF"){
  $sorting=$sorting_Value_str;
  $Tm12="HDD_HF_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="HDD_HF_A"){
  $sorting="HDD_HF";
  $Tm12="HDD_HF";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="NIC_GbE"){
  $sorting=$sorting_Value_str;
  $Tm13="NIC_GbE_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="NIC_GbE_A"){
  $sorting="NIC_GbE";
  $Tm13="NIC_GbE";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="NIC_10GbE"){
  $sorting=$sorting_Value_str;
  $Tm14="NIC_10GbE_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="NIC_10GbE_A"){
  $sorting="NIC_10GbE";
  $Tm14="NIC_10GbE";
  $P_value="Asc";
  }

  if($sorting_Value_str=="PCIx"){
  $sorting=$sorting_Value_str;
  $Tm15="PCIx_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="PCIx_A"){
  $sorting="PCIx";
  $Tm15="PCIx";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="PCI"){
  $sorting=$sorting_Value_str;
  $Tm16="PCI_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="PCI_A"){
  $sorting="PCI";
  $Tm16="PCI";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="PCIe"){
  $sorting=$sorting_Value_str;
  $Tm17="PCIe_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="PCIe_A"){
  $sorting="PCIe";
  $Tm17="PCIe";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Sr_Mgt"){
  $sorting=$sorting_Value_str;
  $Tm18="Sr_Mgt_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Sr_Mgt_A"){
  $sorting="Sr_Mgt";
  $Tm18="Sr_Mgt";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="RHS_typ"){
  $sorting=$sorting_Value_str;
  $Tm19="RHS_typ_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="RHS_typ_A"){
  $sorting="RHS_typ";
  $Tm19="RHS_typ";
  $P_value="Asc";
  }
  
  }else{
  
  $sorting="MatrixID";
  
    $Tm01="ModelCode";
    $Tm02="SKU";
    $Tm03="Dim_H";
    $Tm04="Dim_W";
    $Tm05="Dim_D";
    $Tm06="Power_Supply";
    $Tm07="CPU_Series";
    $Tm08="Mem_Max";
    $Tm09="Mem_Type";
    $Tm10="HDD_Max";
    $Tm11="HDD_Type";
    $Tm12="HDD_HF";
    $Tm13="NIC_GbE";
    $Tm14="NIC_10GbE";
    $Tm15="PCIx";
    $Tm16="PCI";
    $Tm17="PCIe";
    $Tm18="Sr_Mgt";
    $Tm19="RHS_typ";
  
  }
  
?>
<table id="product_matrix">
    <thead>
    	  <tr>
        	<th class="<?=$type_style;?>" colspan="3" title="Intel BareBone"><?=$PMatrix_tname;?></th>
          <th class="<?=$type_style;?>" colspan="3">Dim. (inch)</th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm06;?>">Power Supply</a></th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm07;?>">CPU Series</a></th>
          <th class="<?=$type_style;?>" colspan="2">Memory</th>
          <th class="<?=$type_style;?>" colspan="3">HDD</th>
          <th class="<?=$type_style;?>" colspan="2">NIC</th>
			    <th class="<?=$type_style;?>" colspan="3">Exp. Slots</th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm18;?>">Server Mgmt.</a></th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm19;?>">FF RoHS (Type)</a></th>
        </tr>
        
		    <tr>
        	<th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm01;?>">Model</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm02;?>">SKU</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=">Mainboard</a></th>
			    <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm03;?>">H</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm04;?>">W</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm05;?>">D</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm08;?>">Max.</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm09;?>">Type</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm10;?>">Max.</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm11;?>">Type</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm12;?>">H/F</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm13;?>">GbE</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm14;?>">10GbE</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm15;?>">PCI-X</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm16;?>">PCI</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm17;?>">PCIe</a></th>
          
        </tr>
    </thead>
    <?php
    if($Product_Matrix_Cid<>''){    
    ?>
    <tbody>
      <?
      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
      //$select=mysqli_select_db($dataBase, $link_db);
      $str_matrix_sub="select * from product_matrix_b where IsShow='1' and SocketR_NameID=".$Product_Matrix_Cid." order by ".$sorting." ".$P_value." ";
      $matrixresult_sub=mysqli_query($link_db,$str_matrix_sub);
  
      while(list($MatrixID,$SocketR_NameID,$ModelCode,$SKU,$Dim_H,$Dim_W,$Dim_D,$Power_Supply,$CPU_Series,$Mem_Max,$Mem_Type,$HDD_Max,$HDD_Type,$HDD_HF,$NIC_GbE,$NIC_10GbE,$PCIx,$PCI,$PCIe,$Sr_Mgt,$RHS_typ,$IsShow)=mysqli_fetch_row($matrixresult_sub)){
      $i=$i+1;
      ?>
    	<tr onClick="location='#'">
        	<td><?=$ModelCode;?></td>
            <td>
            <?
              $str2="select Product_SKU_Auto_ID,ProductTypeID,SKU,MODELCODE,NetWorking,SAS,FormFactor from Product_SKUs where Product_SKU_Auto_ID=".$SKU;
              $sku_nresult=mysqli_query($link_db,$str2);
              $data_sku=mysqli_fetch_row($sku_nresult);
            
              $data_m=preg_replace($data_sku[3],'',$data_sku[2]);
              echo $data_m;  
			?>
            </td>
            
            <td>
            <?
              $str_ss="SELECT Case When SPECTypes.InputTypeID= 3 Then SPECValues.SPECValue else Fun_Get_SPECValue(SPECValues.SPECValue) End  CSPECValue, SPECTypeName, SPECTypes.SPECCategoryID, SPECTypes.WebOrder FROM SPECValues INNER JOIN SPECTypes ON SPECValues.SPECTypeID = SPECTypes.SPECTypeID WHERE (SPECValues.Product_SKU_Auto_ID = ".$SKU.") AND (SPECTypeName='Motherboard') AND (SPECValues.SPECValue <> '')";
              $sku_mainresult=mysqli_query($link_db,$str_ss);
              $data_main_sku=mysqli_fetch_row($sku_mainresult);            
              echo $data_main_sku[0];
            ?>
            </td>
            
            <td>
            <?
			if($Dim_H<>'' && $Dim_H<>'NO'){
              $str3="SELECT MValue_VName,Tooltips FROM `matrix_values` where MValue_id='".$Dim_H."'";      
              $result_3=mysqli_query($link_db,$str3, $link_db);
              list($MValue_VName,$Tooltips)=mysqli_fetch_row($result_3);
              if($Tooltips!=''){
            ?>
            <a href="?sorting=FormFactor" >
            <? echo $MValue_VName; ?><span><? echo $Tooltips; ?></span>
            </a>
            <?
              }else if($Tooltips==''){
            ?>
            <? echo $MValue_VName; ?>
            <?
              }
			}else if($Dim_H=='NO'){
			  echo $Dim_H;
			}
            ?>
            </td> 
            <td>
			<?
            if($Dim_W<>'' && $Dim_W<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Dim_W."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
			}else if($Dim_W=='NO'){
			  echo $Dim_W;
			}
            ?>
			</td>
            <td>
			<?
			if($Dim_D<>'' && $Dim_D<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Dim_D."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Dim_D=='NO'){
			  echo $Dim_D;
			}
			?>
			</td>
            <td>
			<?
			if($Power_Supply<>'' && $Power_Supply<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Power_Supply."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Power_Supply=='NO'){
			  echo $Power_Supply;
			}
			?>
			</td>
            <td>
			<?
            if($CPU_Series<>'' && $CPU_Series<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$CPU_Series."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($CPU_Series=='NO'){
			  echo $CPU_Series;
			}
			?>
			</td>
            <td>
			<?
			if($Mem_Max<>'' && $Mem_Max<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Mem_Max."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Mem_Max=='NO'){
			  echo $Mem_Max;
			}
			?>
			</td>
            <td>
			<?
			if($Mem_Type<>'' && $Mem_Type<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Mem_Type."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Mem_Type=='NO'){
			  echo $Mem_Type;
			}
			?>
			</td>        
            <td>
			<?
            if($HDD_Max<>'' && $HDD_Max<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$HDD_Max."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($HDD_Max=='NO'){
			  echo $HDD_Max;
			}
			?>
			</td>
			<td>
			<?
            if($HDD_Type<>'' && $HDD_Type<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$HDD_Type."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($HDD_Type=='NO'){
			  echo $HDD_Type;
			}
			?>
			</td>
            <td>
			<?
            if($HDD_HF<>'' && $HDD_HF<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$HDD_HF."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($HDD_HF=='NO'){
			  echo $HDD_HF;
			}
			?>
			</td>
            <td>
			<?
            if($NIC_GbE<>'' && $NIC_GbE<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$NIC_GbE."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($NIC_GbE=='NO'){
			  echo $NIC_GbE;
			}
			?>
			</td>
            <td>
			<?
            if($NIC_10GbE<>'' && $NIC_10GbE<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$NIC_10GbE."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($NIC_10GbE=='NO'){
			  echo $NIC_10GbE;
			}
			?>
			</td>
			<td>
			<?
            if($PCIx<>'' && $PCIx<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$PCIx."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($PCIx=='NO'){
			  echo $PCIx;
			}
			?>
			</td>
            <td>
			<?
            if($PCI<>'' && $PCI<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$PCI."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($PCI=='NO'){
			  echo $PCI;
			}
			?>
			</td>
            <td>
			<?
            if($PCIe<>'' && $PCIe<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$PCIe."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($PCIe=='NO'){
			  echo $PCIe;
			}
			?>
			</td>                        
            <td>
			<?
            if($Sr_Mgt<>'' && $Sr_Mgt<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Sr_Mgt."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Sr_Mgt=='NO'){
			  echo $Sr_Mgt;
			}
			?>
			</td>
            <td>
			<?
            if($RHS_typ<>'' && $RHS_typ<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$RHS_typ."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($RHS_typ=='NO'){
			  echo $RHS_typ;
			}
			?>
			</td>
      </tr>
      <?
      }
      ?>
    </tbody>
    <?
    }
    ?>
</table>
<p class="clear">&nbsp;</p>
<?
mysqli_close($link_db);
?>
<!--end of 後台設定排第一的Matrix Category table-->
<div id="pm_footer">
Copyright&reg; 2004-2012 MiTAC International Corporation and/or any of its affiliates. All Rights Reserved.</br>Information published on TYAN.com is subject to change without notice. All other trademarks are property of their respective companies.<br/>This site is best viewed using Internet Explorer 7.0 / Firefox 3.5 and their above.
<div class="gotop" onClick="location='#top'">Top &Delta;</div>
</div>
</body>
</html>