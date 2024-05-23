<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
exit();
}
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);
$mm_modellist="";$mm_skulist="";$mb_modellist="";$mb_skulist="";$chs_skulist="";$nh_modellist="";$nh_skulist="";$as_modellist="";$as_skulist="";$jbo_modellist="";$jbo_skulist="";$tpm_modellist="";$tpm_skulist="";$op_modellist="";$op_skulist="";

	if(isset($_REQUEST['cid'])!=''){
	$cid=intval($_REQUEST['cid']);

	if($cid!=''){
	$str_module="SELECT `ID`, `List_NAME`, `Label_NAME`, `Url`, `MODEL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `sp_list` WHERE `ID`=".$cid;
	$module_result=mysqli_query($link_db,$str_module);

	$module_data=mysqli_fetch_row($module_result);
	$module_data[4]=preg_replace('/\s(?=)/', '', trim($module_data[4]));
	}
	}

if(isset($_REQUEST['kinds'])=="add_sku"){

if(isset($_POST['mm_model'])!=''){
foreach($_POST['mm_model'] as $mm_model01){
 $mm_modellist=$mm_modellist.$mm_model01.",";
}
}else{
 $mm_modellist="";
}

if(isset($_POST['mm_sku'])!=''){
foreach($_POST['mm_sku'] as $mm_sku01){
 $mm_skulist=$mm_skulist.$mm_sku01.",";
}
}else{
 $mm_skulist="";
}

if(isset($_POST['mb_model'])!=''){
foreach($_POST['mb_model'] as $mb_model01){
 $mb_modellist=$mb_modellist.$mb_model01.",";
}
}else{
 $mb_modellist="";
}

if(isset($_POST['mb_sku'])!=''){
foreach($_POST['mb_sku'] as $mb_sku01){
 $mb_skulist=$mb_skulist.$mb_sku01.",";
}
}else{
 $mb_skulist="";
}

if(isset($_POST['chs_sku'])!=''){
foreach($_POST['chs_sku'] as $chs_sku01){
 $chs_skulist=$chs_skulist.$chs_sku01.",";
}
}else{
 $chs_skulist="";
}

if(isset($_POST['nh_model'])!=''){
foreach($_POST['nh_model'] as $nh_model01){
 $nh_modellist=$nh_modellist.$nh_model01.",";
}
}else{
 $nh_modellist="";
}

if(isset($_POST['nh_sku'])!=''){
foreach($_POST['nh_sku'] as $nh_sku01){
 $nh_skulist=$nh_skulist.$nh_sku01.",";
}
}else{
 $nh_skulist="";
}

if(isset($_POST['as_model'])!=''){
foreach($_POST['as_model'] as $as_model01){
 $as_modellist=$as_modellist.$as_model01.",";
}
}else{
 $as_modellist="";
}

if(isset($_POST['as_sku'])!=''){
foreach($_POST['as_sku'] as $as_sku01){
 $as_skulist=$as_skulist.$as_sku01.",";
}
}else{
 $as_skulist="";
}

if(isset($_POST['jbo_model'])!=''){
foreach($_POST['jbo_model'] as $jbo_model01){
 $jbo_modellist=$jbo_modellist.$jbo_model01.",";
}
}else{
 $jbo_modellist="";
}

if(isset($_POST['jbo_sku'])!=''){
foreach($_POST['jbo_sku'] as $jbo_sku01){
 $jbo_skulist=$jbo_skulist.$jbo_sku01.",";
}
}else{
 $jbo_skulist="";
}

if(isset($_POST['tpm_model'])!=''){
foreach($_POST['tpm_model'] as $tpm_model01){
 $tpm_modellist=$tpm_modellist.$tpm_model01.",";
}
}else{
 $tpm_modellist="";
}

if(isset($_POST['tpm_sku'])!=''){
foreach($_POST['tpm_sku'] as $tpm_sku01){
 $tpm_skulist=$tpm_skulist.$tpm_sku01.",";
}
}else{
 $tpm_skulist="";
}

if(isset($_POST['op_sku'])!=''){
foreach($_POST['op_sku'] as $op_sku01){
 $op_skulist=$op_skulist.$op_sku01.",";
}
}else{
 $op_skulist="";
}
$tt=$mm_modellist.$mb_modellist.$nh_modellist.$as_modellist.$mm_skulist.$mb_skulist.$chs_skulist.$nh_skulist.$as_skulist.$jbo_modellist.$jbo_skulist.$tpm_modellist.$tpm_skulist.$op_modellist.$op_skulist;
echo "<script language='Javascript'>parent.document.forms['form2'].relProd_valM.value='".$tt."';";
/*echo "<script language='Javascript'>";
echo "try{";
echo "  if(parent.window.opener != null && !parent.window.opener.closed)";
echo "  {";
//echo "    parent.window.opener.document.forms['form2'].relProd_valM.value = '".$mm_skulist.$mb_skulist.$chs_skulist.$nh_skulist.$as_skulist."'";
echo "    parent.window.opener.document.forms['form2'].relProd_valM.value = '".$mm_modellist.$mm_skulist.$mb_modellist.$mb_skulist.$chs_skulist.$nh_modellist.$nh_skulist.$as_modellist.$as_skulist.$jbo_modellist.$jbo_skulist.$tpm_modellist.$tpm_skulist.$op_modellist.$op_skulist."'";
echo "  }";
echo "  ";
echo "  }catch(e){ alert(e.description);}";*/
echo "parent.jQuery.fancybox.close()";
echo "</script>\n";
exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Supported Products</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<style type="text/css">
table{border:0px solid #c0c0c0; width:90%}
td{ padding:5px 15px; cursor: pointer;}
td:hover{background: #dcf2fd;}
a:hover{text-decoration:none;}
a{text-decoration:none;}
<!--ul{margin:0;padding:0;list-style-type: none;}-->
ul.submenu{display:'';}

	#abgne_float_ad {
		display: none;
		position: absolute;
	}
	#abgne_float_ad .abgne_close_ad {
		display: block;
		text-align: right;
		cursor: pointer;
		font-size: 12px;
	}
	#abgne_float_ad a img {
		border: none;
	}
	div.bigDiv {
		height: 3000px;
	}
</style>

		<link type="text/css" href="../lib/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../lib/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
				// Accordion
				$("#accordion").accordion({ header: "h3" });
				// Progressbar
				$("#progressbar").progressbar({
					value: 20
				});
				//hover states on the static widgets				
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
		<script type="text/javascript">
		function checkAll(id){		
		var s=0;
		for(s=0;s<document.form_support.elements.length;s++){
		if((document.form_support.elements[s].type == "checkbox") && (document.form_support.elements[s].name == "mm_sku[]") && (document.form_support.elements[s].title == id))
		{ 
			var Fname = '.SeMo' + id;  //mm_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[s].checked=true;
			}else{
			document.form_support.elements[s].checked=false;
			}         
		}
		}		
		}
		
		function checkAll_Ba(id){		
		var b=0;
		for(b=0;b<document.form_support.elements.length;b++){

		if((document.form_support.elements[b].type == "checkbox") && (document.form_support.elements[b].name == "mb_sku[]") && (document.form_support.elements[b].title == id))
		{ 
			var Fname = '.SeBa' + id;  //mb_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[b].checked=true;
			}else{
			document.form_support.elements[b].checked=false;
			}         
		}
		}
		
		}
		
		function checkAll_Ad(id){
		
		var c=0;
		for(c=0;c<document.form_support.elements.length;c++){

		if((document.form_support.elements[c].type == "checkbox") && (document.form_support.elements[c].name == "nh_sku[]") && (document.form_support.elements[c].title == id))
		{ 
			var Fname = '.SeAd' + id;  //nh_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[c].checked=true;
			}else{
			document.form_support.elements[c].checked=false;
			}         
		}
		}
		
		}
		
		function checkAll_Ac(id){
		
		var d=0;
		for(d=0;d<document.form_support.elements.length;d++){

		if((document.form_support.elements[d].type == "checkbox") && (document.form_support.elements[d].name == "as_sku[]") && (document.form_support.elements[d].title == id))
		{ 
			var Fname = '.AcCs' + id;  //as_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[d].checked=true;
			}else{
			document.form_support.elements[d].checked=false;
			}         
		}
		}
		
		}
		
		function checkAll_Tpm(id){
		
		var e=0;
		for(e=0;e<document.form_support.elements.length;e++){

		if((document.form_support.elements[e].type == "checkbox") && (document.form_support.elements[e].name == "tpm_sku[]") && (document.form_support.elements[e].title == id))
		{ 
			var Fname = '.tpm' + id;  //tpm_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[e].checked=true;
			}else{
			document.form_support.elements[e].checked=false;
			}         
		}
		}
		
		}
		
		function checkAll_Op(id){
		
		var e=0;
		for(e=0;e<document.form_support.elements.length;e++){

		if((document.form_support.elements[e].type == "checkbox") && (document.form_support.elements[e].name == "op_sku[]") && (document.form_support.elements[e].title == id))
		{ 
			var Fname = '.OpPr' + id;  //OpPr_sku[] Class
			var len = $(Fname+":checked").length;
			
			if(len>0){
			document.form_support.elements[e].checked=true;
			}else{
			document.form_support.elements[e].checked=false;
			}         
		}
		}
		
		}
		
		</script>		
<script language="javascript">
$(function(){
	$(".menu li a").click(function(){
		var _this=$(this);
		if(_this.next("ul").length>0){
			if(_this.next().is(":visible")){
				//隱藏子選單並替換符號
				_this.html(_this.html().replace("▼","►")).next().hide();
			}else{
				//開啟子選單並替換符號
				_this.html(_this.html().replace("►","▼")).next().show();
			}
			//關閉連結
			return false;
		}
	});
	//消除連結虛線框
	$("a").focus( function(){
		$(this).blur();
	});
});
</script>
<script type="text/javascript">
	// 當網頁載入完
	$(window).load(function(){
		var $win = $(window),
			$ad = $('#abgne_float_ad').css('opacity', 0).show(),	// 讓廣告區塊變透明且顯示出來
			_width = $ad.width(),
			_height = $ad.height(),
			_diffY = 20, _diffX = 20,	// 距離右及上方邊距
			_moveSpeed = 800;	// 移動的速度
		
		// 先把 #abgne_float_ad 移動到定點
		$ad.css({
			top: _diffY,	// 往上
			left: $win.width() - _width - _diffX,
			opacity: 1
		});
		
		// 幫網頁加上 scroll 及 resize 事件
		$win.bind('scroll resize', function(){
			var $this = $(this);
			
			// 控制 #abgne_float_ad 的移動
			$ad.stop().animate({
				top: $this.scrollTop() + _diffY,	// 往上
				left: $this.scrollLeft() + $this.width() - _width - _diffX
			}, _moveSpeed);
		}).scroll();	// 觸發一次 scroll()
		
		// 關閉廣告
		$('#abgne_float_ad .abgne_close_ad').click(function(){
			$ad.hide();
		});
	});
</script>
</head>
<body style="backbround:#f9f9f9">
<h2>Add Products:</h2>
<div id="abgne_float_ad">
<!--<span class="abgne_close_ad">Close[X]</span>-->
<a href="#BOTTOM"><img src="down-icon.gif" width="52" height="52" title="bottom" /></a>
</div>
<div>
<?php
$str_count="SELECT count(Product_SKU_Auto_ID) FROM `product_skus` a inner join `product_models` b on a.MODELCODE=b.ModelCode where a.Web_Disable=0";
$count_result=mysqli_query($link_db,$str_count);
$cdata=mysqli_fetch_row($count_result);
?>
<div class="pagination left">Total: <span class="w14bblue"><?=$cdata[0];?></span> records &nbsp;&nbsp;
</div> <div class="left">
 <!--<input name="" type="text" size="20" value="Search"  /> -->
 </div>
 </div>
<br class="clear" />
<form id="form_support" name="form_support" method="post" action="?kinds=add_sku">

		<div id="accordion">
<ul class="menu">
	<li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Industrial Panel PC</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (1) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Embedded System</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (2) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Industrial Motherboard</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (3) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OCP Server</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (4) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OCP Mezz</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (5) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JBOD / JBOF </h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (6) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OCP Rack</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (7) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
    <li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;POS</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (8) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
	<li>
    	<a href="#"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5G Edge Computing</h3></a>
		<ul class="submenu">
        	<!--<p><input name="" type="checkbox" value="" /> [Model]: (<input name="" type="checkbox" value="" /> SKU,&nbsp;<input name="" type="checkbox" value="" /> SKU,)</p>-->
			<li><?php
				$str_MM_model="SELECT `ModelID`, `ModelCode`, `ProductCateID` FROM `product_models` where `ProductCateID` in (9) GROUP BY `ModelCode` order by `ModelCode`"; //cateID table : productcategories
				$MM_model_record=mysqli_query($link_db,$str_MM_model);
				$m=0;
				while($MM_model_data=mysqli_fetch_row($MM_model_record)){
				$m+=1;
				?>
				<input id="mm_model[]" name="mm_model[]" type="checkbox" value="S.<?=$MM_model_data[1];?>" <?php if(strpos($m_data[0],"S.".$MM_model_data[1].",")!='' || strpos($m_data[0],"S.".$MM_model_data[1].",")===0){ echo "checked"; } ?> /> <?=$MM_model_data[1];?>
				  <?php if($MM_model_data==true){?>
			  
				  <?php
				  //$str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `Web_Disable`=0 and `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $str_MM="SELECT `Product_SKU_Auto_ID`, `ProductTypeID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE `MODELCODE`='".$MM_model_data[1]."' ORDER BY `MODELCODE`";
				  $MM_record=mysqli_query($link_db,$str_MM);
				  $MM_Tcount=mysqli_num_rows($MM_record);

				  if($MM_Tcount>0){
				  ?>
				  <input class="SeMo<?=$MM_model_data[0];?>" id="mm_model_all[]" name="mm_model_all[]" type="checkbox" value="All" onclick="checkAll(<?=$MM_model_data[0];?>)" />
				  <?php
				  echo ":  (";
				  $MMLast_str=")";
				  }else{
				  $MMLast_str="";
				  }
				  while($MM_data=mysqli_fetch_row($MM_record)){
				  $MM_data[2]=preg_replace('/\s(?=)/', '', trim($MM_data[2]));
				  //$MM_data_Re=str_replace('[BTO]','',$MM_data[2]);
				  ?>
				  <input class="SeMo_Sub<?=$MM_model_data[0];?>" id="mm_sku[]" name="mm_sku[]" type="checkbox" title="<?=$MM_model_data[0];?>" value="<?=$MM_data[2];?>" <?php if(strpos($m_data[0], $MM_data[2].",")!="" || strpos($m_data[0], $MM_data[2].",")===0){ echo "checked"; } //if(preg_match("/\b".$MM_data[2].",\b/i",$prod_data[14]) || preg_match("/\b".$MM_data_Re."[[:upper:]],/i",$prod_data[14])) {echo "checked";} ?> /> <?=$MM_data[2];?>,&nbsp;
				  <?php
				  }
				  ?>
				  <?=$MMLast_str;?>
				  <?php
				  }
				  ?>
				<br style="margin:10px 0;" />
				<?php
				}
				?>
			</li>
        </ul>		
    </li>
	
</ul>			
</div> 

<p class="clear">&nbsp;</p><p><input name="B1" type="submit" value="Done"  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="R1" type="reset" value="Cancel" /></p>
</form>
<div id="BOTTOM"></div>
<P style="color:#0F0;display:none">
- By Product Type 列出，每個 Product Type 下的 Model 及其 SKUs。每個 model 列一列，下面再列其下的 SKU。<br >
- ** SKU 請依 中英文數字排序<br >
- 可勾選多筆SKUs ，勾選modle 則所有SKU 都自動被check<br >
</p>
</body>
</html>