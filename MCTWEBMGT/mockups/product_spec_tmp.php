<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
ini_set('display_errors', 0);

@session_start();

function base64_url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}
if(!is_numeric($_REQUEST['sku_id'])) {
 $skus_id= @base64_url_decode($_REQUEST['sku_id']);
}
$skus_name= @base64_url_decode($_REQUEST['sku_name']);
$skus_mcode= @base64_url_decode($_REQUEST['sku_mcode']);

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
  table.pro_spec
  {   width:900px; font-family: "Lucida Grande", Tahoma, Arial, Helvetica, sans-serif; font-size:12px;
  color:#313131;
  background:#ffffff;
  border-collapse:collapse;
  border-bottom:1px solid #c0c0c0;     
}
table.pro_spec th{ font-size: 12px; padding:0px 5px; text-align:left; border-bottom:0px dotted #c0c0c0; }
table.pro_spec th.greentext{ font-size: 12px; padding:0px 5px; text-align:left; color:#639527;}
table.pro_spec td{padding:0px; border-bottom:1px solid #c0c0c0;}
table.pro_spec tbody.greybg:nth-child(even) {background-color:rgba(243,243,243,0.6);	border-bottom:1px solid #c0c0c0;}
table.pro_spec tbody.greybg{background-color:rgba(248,248,248, 0.1);	border-bottom:1px solid #c0c0c0; }
table.pro_spec colgroup.greybg{background-color:rgba(242,242,242,0.6);}

table.pro_spec thead th{font-size:14px; border-bottom:2px solid #c0c0c0;  color:#ffffff; background-color:rgb(137,137,137); padding:5px; }
table.pro_spec a{color:#639527; text-decoration:none}

table.pro_spec th a{color:#000000; text-decoration:none}
table.pro_spec th a:hover{color:#333333}

table.sectable td{padding:3px 5px; border-bottom:1px dotted #dddddd; }
table.sectable th{padding:3px 5px; border-bottom:1px dotted #dddddd; }
table.sectable a{color:#639527; text-decoration:none}
table.sectable a:visited{color:#639527;}
table.sectable a:hover{color:#00a0e9;}
table.sectable a:active{color:#00a0e9;}

table.group_skus
{   font-family: "Lucida Grande", Tahoma, Arial, Helvetica, sans-serif; font-size:12px;
color:#313131;
background:#ffffff;
border-collapse:collapse;
width:900px;
}
table.group_skus thead th{font-size:14px; border-bottom:2px solid #c0c0c0;  color:#639527; text-align:left }
table.group_skus th{ padding:7px 14px;  color:#639527; }
table.group_skus td{ padding:7px 14px; }
table.group_skus tbody.greybg{ 
  background-color:rgb(248,248,248);
  background-color:rgba(238,238,238,0.4);	border-bottom:1px solid #c0c0c0; text-align:left}
  table.group_skus tbody th{text-align:left}
  table.group_skus tr{ border-bottom:1px dotted #c0c0c0; }
  table.group_skus tbody.con{  cursor: pointer;}
  table.group_skus tr:hover{background-color:rgba(238,238,238,0.4);}

  button{font-family: "Lucida Grande", Tahoma, Arial, Helvetica, sans-serif; font-size:10px}
  </style>
</head>
<body >
  <table class="group_skus">
    <thead>
      <tr>
        <th colspan="5">TYAN <?=$skus_mcode;?> Product SKUS  </th>
      </tr>
    </thead>
    <?php
    $str_main="select Product_SKU_Auto_ID,ProductTypeID from `product_skus` where Product_SKU_Auto_ID=".$skus_id;
    $str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where SPECCategoryID in (".substr($data_p[0],0,strlen($data_p[0])-1).") order by FIELD(SPECCategoryID, ".substr($data_p[0],0,strlen($data_p[0])-1).")"; 
    $mcmd=mysqli_query($link_db,$str_main);
    $m_result=mysqli_fetch_row($mcmd);

    if(empty($m_result)):

      else:
        $chk_m=$m_result[1];
      endif;
      ?>
      <tbody class="greybg" >
        <tr >
          <th>Standard Model</th>
          <?php
          $cols_num="";
          if($chk_m==101 || $chk_m==102){
            $str_mnum="1, 2, 3"; /* Networking, SAS, Form Factor */
          }else if($chk_m==103){
            $str_mnum="11, 5, 6"; /* PCI-E slot, HDD_Bay, PSU */
          }else if($chk_m==104){
            $str_mnum="4, 5, 6"; /* Riser, HDD_Bay, PSU */
          }else if($chk_m==105 || $chk_m==0106){
            $str_mnum="7, 8, 9"; /* Host_IF, Conn_Type, Conn_Qty */
          }else if($chk_m==107){
            $str_mnum="5, 6, 10"; /* HDD_Bay, PSU, FAN */
          }else if($chk_m==108){
            $str_mnum="11, 5, 6"; /* PCI-E slot, HDD_Bay, PSU */
          }else if($chk_m==117){
            $str_mnum="10, 5, 6"; /* FAN, HDD Bay, PSU */
          }else if($chk_m==1109){
            $str_mnum="12"; /* Chip */
            $cols_num=3;
          }else if($chk_m==1111 || $chk_m==1112 || $chk_m==1113){
            $str_mnum="7, 8, 9"; /* Host_IF, Conn_Type, Conn_Qty */  
          }


          $str_mainsub1="SELECT SKUs_Mid, SKUs_MiName, IsShow FROM skus_mainsub where SKUs_Mid IN (".$str_mnum.") ORDER BY FIELD(SKUs_Mid, ".$str_mnum.");";
          $mainsub1_cmd=mysqli_query($link_db,$str_mainsub1);
          while($mainsub1_data=mysqli_fetch_row($mainsub1_cmd)){
            echo "<th colspan='".$cols_num."'>".$mainsub1_data[1]."</th>";
          }
          ?>
          <th>UPC code</th>
        </tr>
      </tbody>
      <tbody class="con" >
        <?php
        $str_Pskus="SELECT DISTINCT product_skus.SKU,product_skus.NetWorking,product_skus.SAS,product_skus.FormFactor,product_skus.Riser,product_skus.HDD_Bay,product_skus.PSU,product_skus.Host_IF,product_skus.Conn_Type,product_skus.Conn_Qty,product_skus.UPCcode,product_skus.FAN,product_skus.producttypeID,product_skus.`PCI-E_slot`,product_skus.`Chip`,product_skus.`Product_SKU_Auto_ID` FROM product_skus INNER JOIN producttypes ON product_skus.ProductTypeID = producttypes.ProductTypeID INNER JOIN vw_modelname ON product_skus.MODELCODE = vw_modelname.ModelCode Where product_skus.MODELCODE='".$skus_mcode."'";
        $Pskus_result=mysqli_query($link_db,$str_Pskus);
        while($sku_data=mysqli_fetch_row($Pskus_result))
        {
          ?>  
          <tr>
            <td><a href="../spec_creation_tool/edit_spec.php?p_id=<?=$sku_data[15];?>" target="_blank"><?=$sku_data[0];?></td>
            <?php
            if($sku_data[12]==101 || $sku_data[12]==102){
              ?>
              <td><?=$sku_data[1];?></td>
              <td><?=$sku_data[2];?></td>
              <td><?=$sku_data[3];?></td>
              <?php
            }else if($sku_data[12]==103){
              ?>
              <td><?=$sku_data[13];?></td>
              <td><?=$sku_data[5];?></td>
              <td><?=$sku_data[6];?></td>
              <?php
            }else if($sku_data[12]==104){
              ?>
              <td><?=$sku_data[4];?></td>
              <td><?=$sku_data[5];?></td>
              <td><?=$sku_data[6];?></td>
              <?php
            }else if($sku_data[12]==105 || $sku_data[12]==0106){
              ?>
              <td><?=$sku_data[7];?></td>
              <td><?=$sku_data[8];?></td>
              <td><?=$sku_data[9];?></td>
              <?php
            }else if($sku_data[12]==107){
              ?>
              <td><?=$sku_data[5];?></td>
              <td><?=$sku_data[6];?></td>
              <td><?=$sku_data[11];?></td>
              <?php
            }else if($sku_data[12]==108){
              ?>
              <td><?=$sku_data[1];?></td>
              <td><?=$sku_data[5];?></td>
              <td><?=$sku_data[6];?></td>
              <?php
            }else if($sku_data[12]==117){
              ?>
              <td><?=$sku_data[11];?></td>
              <td><?=$sku_data[5];?></td>
              <td><?=$sku_data[6];?></td>
              <?php
            }else if($sku_data[12]==1109){
              ?>
              <td colspan="3"><?=$sku_data[14];?></td>
              <?php
            }else if($sku_data[12]==1110 || $sku_data[12]==1111 || $sku_data[12]==1112 || $sku_data[12]==1113){
              ?>
              <td><?=$sku_data[7];?></td>
              <td><?=$sku_data[8];?></td>
              <td><?=$sku_data[9];?></td>
              <?php
            }
            ?>
            <td><?=$sku_data[10];?></td>  
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>

    <p class="clear">&nbsp;</p>

    <?php
    if($skus_id<>''){
      ?>
      <table class="pro_spec" border=0>

        <thead>
          <tr>
            <th colspan="3"><?=$skus_name;?> Specifications <button name="pdfbutton01" id="pdfbutton01" style="float:right; margin-right:10px" type="button" class="button14 left" onclick="location.href='product_spec_table.php?sku_id=<?=$skus_id;?>&sku_name=<?=$skus_name;?>&sku_mcode=<?=$skus_mcode;?>';">Open SPEC Table</button></th>				
          </tr>
        </thead>

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

             <tr>
              <th class="greentext" width="150"><?=$SPECCategoryName;?> </th>
              <td></td>
              <td>        
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
                 //echo $str_GetSType1;
                 $GetSTyperesult1=mysqli_query($link_db,$str_GetSType1);
                 while(list($SPECTypeID_va)=mysqli_fetch_row($GetSTyperesult1)){
                   $SPECTypeID_va_all.=$SPECTypeID_va.",";
                 }

                 $j=0;$k=0;$l=0;$r=0;$i=0;$v=0;$str1="";
                 $str_specv1="SELECT Case When spectypes.InputTypeID= 4 Then specvalues.SPECValue else Fun_Get_SPECValue(specvalues.SPECValue) End CSPECValue, SPECTypeName, spectypes.SPECTypeID, spectypes.SPECCategoryID,spectypes.ParentSpec, spectypes.WebOrder, spectypes.SPECTypeSort, spectypes.ParentSort FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') AND spectypes.SPECCategoryID=".$SPECCategoryID."  order by spectypes.ParentSort, spectypes.`SPECTypeSort`";
                 //$str_specv1="SELECT Case When spectypes.InputTypeID= 4 Then specvalues.SPECValue else Fun_Get_SPECValue(specvalues.SPECValue) End CSPECValue, SPECTypeName, spectypes.SPECTypeID, spectypes.SPECCategoryID, spectypes.WebOrder FROM specvalues INNER JOIN spectypes ON specvalues.SPECTypeID = spectypes.SPECTypeID WHERE (specvalues.Product_SKU_Auto_ID = ".$skus_id.") AND (specvalues.SPECValue <> '') AND spectypes.SPECCategoryID=".$SPECCategoryID."";
                 //echo $str_specv1;
                 $specv_result1=mysqli_query($link_db,$str_specv1);
                 while(list($CSPECValue,$SPECTypeName,$SPECTypeID,$SPECCategoryID,$ParentSpec,$WebOrder)=mysqli_fetch_array($specv_result1))
                 {	  
                  $str_P='';
                  $str_Parentspecv1="select ParentSpec from spectypes where SPECCategoryID=".$SPECCategoryID." and SPECTypeID=".$SPECTypeID;
                  $Parentspecresult=mysqli_query($link_db,$str_Parentspecv1);    
                  list($ParentSpec)=mysqli_fetch_row($Parentspecresult); 

                  if($ParentSpec!=''){	  
                    $j+=1;
                    $str_SPECCat_chk="select SPECTypeID,SPECTypeName from spectypes where SPECTypeID=".$ParentSpec;
                    //echo $str_SPECCat_chk;
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
                <th width="160" rowspan="<?=$_SESSION['rs_'.$str_P];?>">		
                  <font color=""><?=$str_P;?> </font>
                </th>
                <?php
              }
              ?>
              <th width="160"><?=$SPECTypeName;?> </th>
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

           $str_Pspec="select distinct ParentSpec from spectypes where SPECCategoryID=".$SPECCategoryID." and (ParentSpec IS NOT NULL) and INSTR('".$SM14."',SPECTypeID)>0";
           //echo $str_Pspec;
           $Pspecresult=mysqli_query($link_db,$str_Pspec); 
           $nums=mysqli_num_rows($Pspecresult);
           $i=0;
           if($nums>0){
            while ($result=mysqli_fetch_row($Pspecresult)) {
              if ($ParentSpec=="1030" || $ParentSpec=="1441" || $result[0]=="1161" || $ParentSpec=="1024") {
                
              }else{
                $i++;
              }
            }
            if($i>0){
              echo "<th width=160></th>";
            }
            echo "<td width=260>".$CSPECValue."</td>";
           }else{
           ?>
            <td width="260"><?=$CSPECValue;?></td>    
           <?php
           }
           ?>
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
?>
<?php
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