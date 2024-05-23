<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
?>
<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<!--<script type="text/javascript" src="../jquery.min.js"></script>-->
<script type="text/javascript" src="jquery.cookie.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var ST,SP,SK,UP,PN1,PN2,PN3,PN4,PN5,PN6,PN7,PN8,PN9,PN10;
  var PMT03,PMT04,PMT05,PMT06,PMT07,PMT08,PMT09,PMT10,PMT11,PMT12,PMT13,PMT14,PMT15,PMT16,PMT17,PMT18,PMT19;
  var n003,n004,n005,n006,n007,n008,n009,n010,n011,n012,n013;
  ST=parent.form1.PT1.value;
  SP=parent.form1.SEL_PMODEL.value;
  SK=parent.form1.SKU_value.value;
  UP=parent.form1.UPC_value.value;  
  
  //PMT03=$("#SEL_PMT003").parent("selected").find("option:selected").text();  
  /*
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
  */
  
  PMT03=$("#SEL_PMT003").find("option:selected").text();
  PMT04=$("#SEL_PMT004").find("option:selected").text();
  PMT05=$("#SEL_PMT005").find("option:selected").text();
  PMT06=$("#SEL_PMT006").find("option:selected").text();
  PMT07=$("#SEL_PMT007").find("option:selected").text();
  PMT08=$("#SEL_PMT008").find("option:selected").text();
  PMT09=$("#SEL_PMT009").find("option:selected").text();
  PMT10=$("#SEL_PMT010").find("option:selected").text();
  PMT11=$("#SEL_PMT011").find("option:selected").text();
  PMT12=$("#SEL_PMT012").find("option:selected").text();
  PMT13=$("#SEL_PMT013").find("option:selected").text();

  if(ST==101 || ST==102){
  PN1=parent.form1.SEL_PN1.value;
  SPN1=parent.form1.SSMN1_1.value;
  PN2=parent.form1.SEL_PN2.value;
  SPN2=parent.form1.SSMN1_2.value;
  PN3=parent.form1.SEL_PN3.value;
  SPN3=parent.form1.SSMN1_3.value;
  
  /*
  n014=parent.form1.SEL_PMT014.selectedIndex;
  PMT14=parent.form1.SEL_PMT014.options[n014].text;
  n015=parent.form1.SEL_PMT015.selectedIndex;
  PMT15=parent.form1.SEL_PMT015.options[n015].text;
  n016=parent.form1.SEL_PMT016.selectedIndex;
  PMT16=parent.form1.SEL_PMT016.options[n016].text;
  */
  
  PMT14=$("#SEL_PMT014").find("option:selected").text();
  PMT15=$("#SEL_PMT015").find("option:selected").text();
  PMT16=$("#SEL_PMT016").find("option:selected").text();
  
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
	
    if(PN1=="Add"){
	 if(parent.form1.SEL_PN1.length>0){
	 $.cookie("SEL_PN1", SPN1);
	 }
    }else{
	 if(parent.form1.SEL_PN1.length>0){
	 $.cookie("SEL_PN1", PN1);
	 }
	}
    if(PN2=="Add"){
	 if(parent.form1.SEL_PN2.length>0){
	 $.cookie("SEL_PN2", SPN2);
	 }
    }else{
	 if(parent.form1.SEL_PN2.length>0){
	 $.cookie("SEL_PN2", PN2);
	 }
	}
    if(PN3=="Add"){
	 if(parent.form1.SEL_PN3.length>0){
	 $.cookie("SEL_PN3", SPN3);	
	 }
    }else{
	 if(parent.form1.SEL_PN3.length>0){
	 $.cookie("SEL_PN3", PN3);
	 }
	}
  
  }else if(ST==103 || ST==104){
  PN4=parent.form1.SEL_PN4.value;
  SPN4=parent.form1.SSMN1_4.value;
  PN5=parent.form1.SEL_PN5.value;
  SPN5=parent.form1.SSMN1_5.value;
  PN6=parent.form1.SEL_PN6.value;
  SPN6=parent.form1.SSMN1_6.value;
  
  /*
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
  */
  PMT14=$("#SEL_PMT014").find("option:selected").text();
  PMT15=$("#SEL_PMT015").find("option:selected").text();
  PMT16=$("#SEL_PMT016").find("option:selected").text();
  PMT17=$("#SEL_PMT017").find("option:selected").text();
  PMT18=$("#SEL_PMT018").find("option:selected").text();
  PMT19=$("#SEL_PMT019").find("option:selected").text();
  
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
    
	if(PN4=="Add"){
	 if(parent.form1.SEL_PN4.length>0){
     $.cookie("SEL_PN4", SPN4);
     }
	}else{
	 if(parent.form1.SEL_PN4.length>0){
     $.cookie("SEL_PN4", PN4);
     }
	}
	
	if(PN5=="Add"){
	 if(parent.form1.SEL_PN5.length>0){
     $.cookie("SEL_PN5", SPN5);
     }
	}else{
     if(parent.form1.SEL_PN5.length>0){
     $.cookie("SEL_PN5", PN5);
     }
	}
	
	if(PN6=="Add"){
	 if(parent.form1.SEL_PN6.length>0){
     $.cookie("SEL_PN6", SPN6);
     }
	}else{
     if(parent.form1.SEL_PN6.length>0){
     $.cookie("SEL_PN6", PN6);
     }
    }
	
  }else if(ST==105 || ST==106){
  PN7=parent.form1.SEL_PN7.value;
  SPN7=parent.form1.SSMN1_7.value;
  PN8=parent.form1.SEL_PN8.value;
  SPN8=parent.form1.SSMN1_8.value;
  PN9=parent.form1.SEL_PN9.value;
  SPN9=parent.form1.SSMN1_9.value;
    
	if(PN7=="Add"){
	 if(parent.form1.SEL_PN7.length>0){
     $.cookie("SEL_PN7", SPN7);
	 }
    }else{
	 if(parent.form1.SEL_PN7.length>0){
     $.cookie("SEL_PN7", PN7);
	 }
	}
	
	if(PN8=="Add"){
     if(parent.form1.SEL_PN8.length>0){
     $.cookie("SEL_PN8", SPN8);
     }
	}else{
	 if(parent.form1.SEL_PN8.length>0){
     $.cookie("SEL_PN8", PN8);
     }
	}
	 
	if(PN9=="Add"){ 
     if(parent.form1.SEL_PN9.length>0){
     $.cookie("SEL_PN9", SPN9);
     }
    }else{
	 if(parent.form1.SEL_PN9.length>0){
     $.cookie("SEL_PN9", PN9);
     }
	}
	
  }else if(ST==107){
  PN5=parent.form1.SEL_PN5.value;
  SPN5=parent.form1.SSMN1_5.value;
  PN6=parent.form1.SEL_PN6.value;
  SPN6=parent.form1.SSMN1_6.value;
  PN10=parent.form1.SEL_PN10.value;
  SPN10=parent.form1.SSMN1_10.value;
    
	if(PN5=="Add"){
	 if(parent.form1.SEL_PN5.length>0){
     $.cookie("SEL_PN5", SPN5);
     }
    }else{
	 if(parent.form1.SEL_PN5.length>0){
     $.cookie("SEL_PN5", PN5);
     }
	}
	
	if(PN6=="Add"){
	 if(parent.form1.SEL_PN6.length>0){
     $.cookie("SEL_PN6", SPN6);
	 }
	}else{
     if(parent.form1.SEL_PN6.length>0){
     $.cookie("SEL_PN6", PN6);
	 }
	}
	
	if(PN10=="Add"){
	 if(parent.form1.SEL_PN10.length>0){
     $.cookie("SEL_PN10", SPN10);
     }
	}else{
	 if(parent.form1.SEL_PN10.length>0){
     $.cookie("SEL_PN10", PN10);
     }
	}
	
  }
  
  $.cookie("SEL_PMODEL01", SP);
  $.cookie("SKU_value01", SK);
  $.cookie("UPC_value01", UP);  
  
});
</script>
<?php
/*
echo var_dump($_POST);
echo $_POST['SSMN1_4']."<br />";
*/
$str_sb="select SKUs_Sid FROM skus_sublist order by SKUs_Sid desc limit 1";
$check_sb=mysqli_query($link_db,$str_sb);
$Max_SSubID=mysqli_fetch_row($check_sb);
$MCount=$Max_SSubID[0]+1;

$SSBM1="";$SSBM2="";$SSBM3="";
if(isset($_POST['SSMN4'])!=''){
$a=trim($_POST['SSMN4']);

//echo "<script language='Javascript'>Set_Condition_values();</script>\n";

$SSMN4_id = explode(",", $a,-1);
$SSMN4_count = count($SSMN4_id);
  
$SSMN4_sid = array_unique($SSMN4_id);


foreach($SSMN4_sid as $value_c){
  
  if($_POST['SSMN1_'.$value_c.'']<>''){
  
  //$SSBM1=$_POST['SSMN1_'.$value_c.''];
  //$SSBM1=htmlentities($_POST['SSMN1_'.$value_c.''], ENT_QUOTES);
  //$SSBM1=htmlentities($_POST['SSMN1_'.$value_c.''],ENT_NOQUOTES ,'utf-8');  
  //$SSBM1=$_POST['SSMN1_'.$value_c.''];
  
  $SSBM1=htmlspecialchars($_POST['SSMN1_'.$value_c.''], ENT_QUOTES);
  $SSBM2=$_POST['SSMN2_'.$value_c.''];
  $SSBM3=$_POST['SSMN3_'.$value_c.'']; 
  }
}


}else{
}
  
  if($SSBM1<>''){
  echo "<script type='text/javascript'>";
  echo "$(function() {";
  echo "$.cookie('SEL_PN".$SSBM2."', '".$SSBM1."')";
  echo "});";
  echo "</script>";
  
  $str="insert into skus_sublist (SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow) values ($MCount,$SSBM2,$SSBM3,'$SSBM1','1')";
  $cmd_model=mysqli_query($link_db,$str);  
  /*
  echo "refresh_sub";  
  exit();
  else:
  echo "<font color=red><b>Data be exist!</b></font>";
  exit();
  endif;
  */
  mysqli_close($link_db);  
  echo("<meta http-equiv='refresh' content='0'>");
  //echo "refresh_sub";
	//echo "<script language='javascript'>opener.location.reload();</script>";
	//echo "window.location.reload();";	
	
	/*
	echo "<script type='text/javascript'>";
	echo "$(function() {";
	echo "setTimeout(function(){ document.execCommand('Refresh'); }, 1000);";
	echo "});";
	echo "</script>";
	*/

  }else{
   //echo "<script language='Javascript'>alert('".$SSBM1." ".$SSBM2." ".$SSBM3."');</script>\n";
   echo "<font color=red>Please enter your Values.</font>";
   exit();
  }  
?>