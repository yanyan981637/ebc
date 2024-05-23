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
  }else if($PMatrix_id==106){
  $type_style="";
  $type_style_buttom="sub";
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
  $Tm03="FormFactor";
  $Tm04="Dim_W";
  $Tm05="Dim_D";
  $Tm06="Chipset";
  $Tm07="Cache_Freq";
  $Tm08="Host_Interface";
  $Tm09="Int_Port";
  $Tm10="Ext_Port";
  $Tm11="SW_RAID";
  $Tm12="HW_RAID";
  $Tm13="Enhanced_RAID";
  $Tm14="Optional_BBU";
  $Tm15="RHS_typ";
  
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
  
  if($sorting_Value_str=="FormFactor"){
  $sorting=$sorting_Value_str;
  $Tm03="FormFactor_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="FormFactor_A"){
  $sorting="FormFactor";
  $Tm03="FormFactor";
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
  
  if($sorting_Value_str=="Chipset"){
  $sorting=$sorting_Value_str;
  $Tm06="Chipset_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Chipset_A"){
  $sorting="Chipset";
  $Tm06="Chipset";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Cache_Freq"){
  $sorting=$sorting_Value_str;
  $Tm07="Cache_Freq_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Cache_Freq_A"){
  $sorting="Cache_Freq";
  $Tm07="Cache_Freq";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Host_Interface"){
  $sorting=$sorting_Value_str;
  $Tm08="Host_Interface_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Host_Interface_A"){
  $sorting="Host_Interface";
  $Tm08="Host_Interface";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Int_Port"){
  $sorting=$sorting_Value_str;
  $Tm09="Int_Port_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Int_Port_A"){
  $sorting="Int_Port";
  $Tm09="Int_Port";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Ext_Port"){
  $sorting=$sorting_Value_str;
  $Tm10="Ext_Port_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Ext_Port_A"){
  $sorting="Ext_Port";
  $Tm10="Ext_Port";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="SW_RAID"){
  $sorting=$sorting_Value_str;
  $Tm11="SW_RAID_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="SW_RAID_A"){
  $sorting="SW_RAID";
  $Tm11="SW_RAID";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="HW_RAID"){
  $sorting=$sorting_Value_str;
  $Tm12="HW_RAID_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="HW_RAID_A"){
  $sorting="HW_RAID";
  $Tm12="HW_RAID";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Enhanced_RAID"){
  $sorting=$sorting_Value_str;
  $Tm13="Enhanced_RAID_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Enhanced_RAID_A"){
  $sorting="Enhanced_RAID";
  $Tm13="Enhanced_RAID";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="Optional_BBU"){
  $sorting=$sorting_Value_str;
  $Tm14="Optional_BBU_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="Optional_BBU_A"){
  $sorting="Optional_BBU";
  $Tm14="Optional_BBU";
  $P_value="Asc";
  }
  
  if($sorting_Value_str=="RHS_typ"){
  $sorting=$sorting_Value_str;
  $Tm15="RHS_typ_A";
  $P_value="Desc";
  }else if($sorting_Value_str=="RHS_typ_A"){
  $sorting="RHS_typ";
  $Tm15="RHS_typ";
  $P_value="Asc";
  } 
  
  }else{
  
  $sorting="MatrixID";
  
  $Tm01="ModelCode";
  $Tm02="SKU";
  $Tm03="FormFactor";
  $Tm04="Dim_W";
  $Tm05="Dim_D";
  $Tm06="Chipset";
  $Tm07="Cache_Freq";
  $Tm08="Host_Interface";
  $Tm09="Int_Port";
  $Tm10="Ext_Port";
  $Tm11="SW_RAID";
  $Tm12="HW_RAID";
  $Tm13="Enhanced_RAID";
  $Tm14="Optional_BBU";
  $Tm15="RHS_typ";
  
  }
?>
<table id="product_matrix">
    <thead>
    	  <tr>
        	<th class="<?=$type_style;?>" colspan="2" title="Intel MainBoard">HBA</th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm03;?>">Form Factor</a></th>
          <th class="<?=$type_style;?>" colspan="2">Dim. (inch)</th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm06;?>">Chipset</a></th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm07;?>">Cache Freq.</a></th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm08;?>">Host Interface</a></th>
          <th class="<?=$type_style;?>" colspan="2"># of Devices</th>
          <th class="<?=$type_style;?>" colspan="3">Integrated Features</th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm14;?>">Optional BBU</a></th>
          <th class="<?=$type_style;?>" rowspan="2"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm15;?>">RoHS (Type)</a></th>
        </tr>
        
		    <tr>
        	<th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm01;?>">Model</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm02;?>">SKU</a></th> 
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm04;?>">W</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm05;?>">D</a></th>          
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm09;?>">Int. Port</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm10;?>">Ext. Port(X)</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm11;?>">S/W RAID(SR)</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm12;?>">H/W RAID(HR)</a></th>
          <th class="<?=$type_style_buttom;?>"><a href="?PMCat_id=<?=$PMCat_id;?>&PMatrix_id=<?=$PMatrix_id;?>&PMatrix_tname=<?=$PMatrix_tname;?>&sorting=<?=$Tm13;?>">Enhanced RAID(E)</a></th>
       </tr>
    </thead>
    <?php
    if($Product_Matrix_Cid<>''){    
    ?>
    <tbody>
      <?
      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
      //$select=mysqli_select_db($dataBase, $link_db);
      $str_matrix_sub="select * from product_matrix_h where IsShow='1' and SocketR_NameID=".$Product_Matrix_Cid." order by ".$sorting." ".$P_value." ";
      $matrixresult_sub=mysqli_query($link_db,$str_matrix_sub);
  
      while(list($MatrixID,$SocketR_NameID,$ModelCode,$SKU,$FormFactor,$Dim_W,$Dim_D,$Chipset,$Cache_Freq,$Host_Interface,$Int_Port,$Ext_Port,$SW_RAID,$HW_RAID,$Enhanced_RAID,$Optional_BBU,$RHS_typ,$IsShow)=mysqli_fetch_row($matrixresult_sub)){
      
      $i=$i+1;
      ?>
    	<tr onClick="location='#'">
        	<td><?=$ModelCode;?></td>
            <td>
            <?
            $str2="select Product_SKU_Auto_ID,ProductTypeID,SKU,MODELCODE,Host_IF,Conn_Type,Conn_Qty from Product_SKUs where Product_SKU_Auto_ID=".$SKU;
            $sku_nresult=mysqli_query($link_db,$str2);
            $data_sku=mysqli_fetch_row($sku_nresult);
            
            $data_m=preg_replace($data_sku[3],'',$data_sku[2]);
            echo $data_m;  
            ?>
            </td>
            
            <td>  
            <?
			if($FormFactor<>'' && $FormFactor<>'NO'){
              $str3="SELECT MValue_VName,Tooltips FROM `matrix_values` where MValue_id='".$FormFactor."'";      
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
			}else if($FormFactor=='NO'){
			  echo $FormFactor;
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
            if($Dim_D<>'' && $Dim_D=='NO'){
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
            if($Chipset<>'' && $Chipset<>'NO'){  
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Chipset."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Chipset=='NO'){
			  echo $Chipset;
			}
			?>
			</td>
            <td>
			<?
            if($Cache_Freq<>'' && $Cache_Freq<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Cache_Freq."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Cache_Freq=='NO'){
			  echo $Cache_Freq;
			}
			?>
			</td>
            <td>
			<?
			if($Host_Interface<>'' && $Host_Interface<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Host_Interface."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Host_Interface=='NO'){
			  echo $Host_Interface;
			}
			?>
			</td>
            <td>
			<?
            if($Int_Port<>'' && $Int_Port<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Int_Port."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Int_Port=='NO'){
			  echo $Int_Port;
			}
			?>
			</td>        
            <td>
			<?
			if($Ext_Port<>'' && $Ext_Port<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Ext_Port."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Ext_Port=='NO'){
			  echo $Ext_Port;
			}
			?>
			</td>
			<td>
			<?
            if($SW_RAID<>'' && $SW_RAID<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$SW_RAID."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($SW_RAID=='NO'){
			  echo $SW_RAID;
			}
			?>
			</td>
            <td>
			<?
            if($HW_RAID<>'' && $HW_RAID<>'NO'){ 
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$HW_RAID."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($HW_RAID=='NO'){
			  echo $HW_RAID;
			}
			?>
			</td>
            <td>
			<?
            if($Enhanced_RAID<>'' && $Enhanced_RAID<>'NO'){
			  $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Enhanced_RAID."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Enhanced_RAID=='NO'){
			  echo $Enhanced_RAID;
			}
			?>
			</td>
            <td>
			<?
			if($Optional_BBU<>'' && $Optional_BBU<>'NO'){
              $str_u="SELECT MValue_VName FROM `matrix_values` where MValue_id='".$Optional_BBU."'";      
              $result_mu=mysqli_query($link_db,$str_u, $link_db);
              list($MValue_VName)=mysqli_fetch_row($result_mu);
              echo $MValue_VName;
            }else if($Optional_BBU=='NO'){
			  echo $Optional_BBU;
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