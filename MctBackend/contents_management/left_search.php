<?php
$i=0;
$str_ptype="SELECT ProductTypeID,ProductTypeName,PMM_ProdType,slang,upd_d FROM `producttypes_las` where slang='EN'";
mysqli_query($link_db, 'SET NAMES utf8');
$ptype_result=mysqli_query($link_db,$str_ptype);
while($ptype_data=mysqli_fetch_row($ptype_result)){
$i+=1;
?>   
 <!--1st Product Type-->
<h1 data-toggle="collapse" data-target="#pt<?=$i?>">
 <i class="fa fa-plus-square-o"></i> <?=$ptype_data[1];?>
</h1>
<div id="pt<?=$i?>" class="collapse in marginleft20">
<?php
 $i1=0;
 $str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where CONCAT(',',PTYPE_Value,',') like '%,".$ptype_data[0].",%'";
 mysqli_query($link_db, 'SET NAMES utf8');
 $pinfo_result=mysqli_query($link_db, $str_pinfo);
 $pinfo_secVal=mysqli_num_rows($pinfo_result);
 echo "<input type='hidden' id='PINFO_SecNum".$i."' name='PINFO_SecNum".$i."' size='2' value='".$pinfo_secVal."' />";
 while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))      
 {
 $i1+=1;
?>
 <!--1st Info of this Product Type-->
 <p><input name="PINFO_TPVal0<?=$i;?><?=$i1;?>[]" type="checkbox" value="0<?=$i;?><?=$i1;?>" style="display:none"> <?=$PI_Name;?> :</p>
 <ul>
 <?php
   $str_pinfoVal="SELECT `PIV_id`, `PI_id`, `PIV_Value` FROM `product_infovalue_las` where `PIV_flag`=1 and `PI_id`=".$PI_id;
   mysqli_query($link_db, 'SET NAMES utf8');
   $pinfoVal_result=mysqli_query($link_db,$str_pinfoVal);
   while($pinfoVal_data=mysqli_fetch_array($pinfoVal_result)){
   $pinfoVal_data002=htmlspecialchars($pinfoVal_data[2], ENT_QUOTES);
 ?>
 <li><input id="PINFO_Val<?=$i?>[]" name="PINFO_Val<?=$i?>[]" class="PINFO_Val_S0<?=$i?><?=$i1;?>" type="checkbox" value="<?php if($PI_id==45){ echo $pinfoVal_data002; }else{ echo $pinfoVal_data[0]; }?>" onClick="return checkData(<?=$i?>,<?=$i1;?>,<?=$pinfoVal_data[0];?>)"> <?=$pinfoVal_data[2];?> </li>
 <?php
   }
 ?>
 </ul>
 <!--end 1st Info of this Product Type-->
<hr>
<?php
 }
?>
</div>
 <!--end 1st Product Type-->
<?php
}
?>
<input type="hidden" name="PINFO_Num" size="2" value="<?=$i;?>" /> 