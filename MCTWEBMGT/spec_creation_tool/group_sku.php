<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
  echo "<script language='JavaScript'>location='../login.php'</script>";
  exit();
}

error_reporting(0);

require "../config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_REQUEST['d_id'])!=""){
  $d1=intval($_REQUEST['d_id']);
  $str_d="delete from product_skus_categories where Product_SKU_Cid=".$d1;
  $cmd_d=mysqli_query($link_db,$str_d);
  echo "<script>alert('Del Product_skus!');location.href='group_sku.php'</script>";
  exit();
}
if(isset($_REQUEST['SType_id'])<>""){
  $SType_id=intval($_REQUEST['SType_id']);
}
if(isset($_REQUEST['PType_id'])<>''){
  $PType_id=intval($_REQUEST['PType_id']);
}else{
  $PType_id="";
}
if(isset($_REQUEST['kinds'])!=''){

  if(trim($_REQUEST['kinds'])=="add_groupSKU"){

    $str_a1="select `ProductTypeID` FROM `producttypes` order by `ProductTypeID` desc limit 1";
    $check_a1=mysqli_query($link_db,$str_a1);
    $MaxA_GskuID=mysqli_fetch_row($check_a1);
    $MCountA=$MaxA_GskuID[0]+1;

    if(isset($_POST['SEL_APTYPE'])!=''){
      $SEL_APTYPE01=trim($_POST['SEL_APTYPE']);
    }else{
      $SEL_APTYPE01="";
    }
    $aesr1="";
    if(isset($_POST['AESR1'])!=''){
      $aesr1=trim($_POST['AESR1']);
    }else{
      $aesr1="";
    }
    $skuCo_a="";
    if(isset($_POST['skuCondi_a'])!=''){
      foreach($_POST['skuCondi_a'] as $check){
        $skuCo_a=$skuCo_a.$check.",";
      }
    }
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
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$inser_PTyp="insert into `producttypes` (`ProductTypeID`, `ProductTypeName`, `GUID`, `crea_d`, `crea_u`) values ($MCountA,'$SEL_APTYPE01','$guid','$now','1782')";
$cmd_PTyp=mysqli_query($link_db,$inser_PTyp);
if($cmd_PTyp==true){
}

$str_m1="select Product_SKU_Cid FROM product_skus_categories order by Product_SKU_Cid desc limit 1";
$check_m1=mysqli_query($link_db,$str_m1);
$Max_GskuID=mysqli_fetch_row($check_m1);
$MCount=$Max_GskuID[0]+1;

$str_sc="insert into `product_skus_categories`(`Product_SKU_Cid`,`ProductTypeID`,`SKUs_Conditions`,`GUID`, `crea_u`, `crea_d`,`IsStatus`) values ($MCount,$MCountA,'".$skuCo_a."','$guid','$now','1782','".$aesr1."')";
$cmd_sc=mysqli_query($link_db,$str_sc);
if($cmd_sc==true){
}

/* 寫入 skus_sublist 新增多筆 */
$str_sub1="select SKUs_Sid FROM `skus_sublist` order by SKUs_Sid desc limit 1";
$check_sub1=mysqli_query($link_db,$str_sub1);
$Max_SubID=mysqli_fetch_row($check_sub1);
$SMCount=$Max_SubID[0]+1;

$add=-1;
$str_value="";
for($i=1;$i<=11;$i++){

  if(isset($_POST['sk_ana'.$i])!=""){    
    if(preg_match("/，/i",preg_replace("/,/i", '，', $_POST['sk_ana'.$i]))!='')
    {      
      $str_split = explode("，", preg_replace("/,/i", '，', $_POST['sk_ana'.$i]),-1); 
      for($sp=0;$sp<count($str_split);$sp++){                  
        $add=$add+1;
        $TMCount=$SMCount+$add;      
        $str_split[$sp]=str_replace("$","\"",$str_split[$sp]);          
        $str_value.="(".$TMCount.",".$_POST['sk_ama'.$i].",".$MCountA.",'".$str_split[$sp]."','1'),";      
      }         
    }else{
      $add=$add+1;
      $TMCount=$SMCount+$add;         
      $sk_na_str=str_replace("$","\"",$_POST['sk_ana'.$i]);         
      $str_value.="(".$TMCount.",".$_POST['sk_ama'.$i].",".$MCountA.",'".$sk_na_str."','1'),";
    }
  }

}
$str_value=substr($str_value, 0, strlen($str_value)-1);  
$str_sub="insert into `skus_sublist`(SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow) values ".$str_value." ";
$cmd_insu=mysqli_query($link_db,$str_sub);

echo "<script>alert('AddNew Group SKU!');location.href='group_sku.php'</script>";  
exit();
}

if(trim($_REQUEST['kinds'])=="edit_groupSKU"){
  $str_m1="select Product_SKU_Cid FROM product_skus_categories order by Product_SKU_Cid desc limit 1";
  $check_m1=mysqli_query($link_db,$str_m1);
  $Max_GskuID=mysqli_fetch_row($check_m1);
  $MCount=$Max_GskuID[0]+1;

  if(isset($_POST['m_id'])!=''){
    $m_id=intval($_POST['m_id']);
  }else{
    $m_id="";
  }
  if(isset($_POST['ESR1'])!=''){
    $esr1=$_POST['ESR1'];
  }else{
    $esr1="";
  }

  putenv("TZ=Asia/Taipei");
  $now=date("Y/m/d H:i:s"); 

  $skuCo="";
  if(isset($_POST['skuCondi'])!=''){
    foreach($_POST['skuCondi'] as $check){
      $skuCo=$skuCo.$check.",";
    }
  }

  $str_ed="update `product_skus_categories` set `SKUs_Conditions`='".$skuCo."',`IsStatus`='".$esr1."' where `Product_SKU_Cid`=".$m_id;
  $cmd_ins=mysqli_query($link_db,$str_ed);

  /* 寫入 skus_sublist 新增多筆 */
  $str_sub1="select SKUs_Sid FROM `skus_sublist` order by SKUs_Sid desc limit 1";
  $check_sub1=mysqli_query($link_db,$str_sub1);
  $Max_SubID=mysqli_fetch_row($check_sub1);
  $SMCount=$Max_SubID[0]+1;
  if(isset($_POST['PT_id'])!=''){
    $Pid02=intval($_POST['PT_id']);  
  }else{
    $Pid02="";
  }

  $str_d="delete from `skus_sublist` where ProductTypeID=".$Pid02;
  $cmd_d=mysqli_query($link_db,$str_d);  

  $add=-1;
  $str_value="";
  for($i=1;$i<=12;$i++){

    if(isset($_POST['sk_na'.$i])!=""){

      $sk01=preg_replace("/,/i", '，', $_POST['sk_na'.$i]);
      $sk01=preg_replace('/"/i', '"', $sk01);	  

      if($sk01!=''){
        if(strpos($sk01,"，")!='' || strpos($sk01,"，")===0)
        {      
          $str_split = explode("，", $sk01,-1); 
          for($sp=0;$sp<count($str_split);$sp++){                  
           $add=$add+1;
           $TMCount=$SMCount+$add;      
           $str_split[$sp]=str_replace("$","\"",$str_split[$sp]);
           $str_value.="(".$TMCount.",".$_POST['sk_ma'.$i].",".$Pid02.",'".$str_split[$sp]."','1'),";
         }

       }else{
        $add=$add+1;
        $TMCount=$SMCount+$add;         
        $sk_na_str=str_replace("$","\"",$sk01);         
        $str_value.="(".$TMCount.",".$_POST['sk_ma'.$i].",".$Pid02.",'".$sk_na_str."','1'),";
      }
    }
  }

}
$str_value=substr($str_value, 0, strlen($str_value)-1);
$str_sub="insert into `skus_sublist`(SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow) values ".$str_value." ";
$cmd_insu=mysqli_query($link_db,$str_sub);

echo "<script>alert('Mod Group SKU!');location.href='group_sku.php'</script>";
exit();
}
}

if(intval($PType_id)<>''){

  if(isset($_REQUEST['s_search'])<>''){
    $s_search=trim($_REQUEST['s_search']);
    $str_c="select count(*) from product_skus_categories a inner join ProductTypes b on a.ProductTypeID=b.ProductTypeID where `ProductTypeName` like '%".$s_search."%' and b.ProductTypeID=".$PType_id;
  }else{  
    $str_c="select count(*) from product_skus_categories where ProductTypeID=".$PType_id;
  }

}else{

  if(isset($_REQUEST['s_search'])<>''){
    $s_search=trim($_REQUEST['s_search']);
    $str_c="select count(*) from product_skus_categories a inner join ProductTypes b on a.ProductTypeID=b.ProductTypeID where `ProductTypeName` like '%".$s_search."%'";
  }else{
    $str_c="select count(*) from product_skus_categories";
  }

}
$list_c =mysqli_query($link_db,$str_c);
list($public_count) = mysqli_fetch_row($list_c);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>SPEC Creation Tool - SKU Grouping Conditions </title>
  <link rel="stylesheet" type="text/css" href="../backend.css">
  <script type="text/javascript" src="../jquery.min.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script type="text/javascript">
  $(document).ready(function() {
    $("#Fancy_iframe1").fancybox({
      'width'				: '40%',
      'height'			: '40%',
      'autoScale'			: false,
      'transitionIn'		: 'none',
      'transitionOut'		: 'none',
      'type'				: 'iframe'
    });
  });     

  function Del_id(t_id){    
    if(confirm("確定要刪除此筆資料嗎？")) {
      self.location="?d_id="+t_id;
    }else{
    }
  }
  function search_value(){
    self.location = "?s_search=" + document.form1.sear_txt.value;
    return false;
  }  
  </script>

  <script type="text/javascript">
  $(document).ready(function() {
      /*
       *  Simple image gallery. Uses default settings
       */

      $('.fancybox').fancybox({
        'width':800,
                         'height':700,
                         'autoSize' : false,
                         'type'       : 'iframe'
       });

      /*
       *  Different effects
       */

      // Change title type, overlay opening speed and opacity
      $(".fancybox-effects-a").fancybox({
        helpers: {
          title : {
            type : 'outside'
          },
          overlay : {
            speedIn : 500,
            opacity : 0.95
          }
        }
      });

      // Disable opening and closing animations, change title type
      $(".fancybox-effects-b").fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        helpers : {
          title : {
            type : 'over'
          }
        }
      });

      // Set custom style, close if clicked, change title type and overlay color
      $(".fancybox-effects-c").fancybox({
        wrapCSS    : 'fancybox-custom',
        closeClick : true,

        helpers : {
          title : {
            type : 'inside'
          },
          overlay : {
            css : {
              'background-color' : '#eee'
            }
          }
        }
      });

      // Remove padding, set opening and closing animations, close if clicked and disable overlay
      $(".fancybox-effects-d").fancybox({
        padding: 0,

        openEffect : 'elastic',
        openSpeed  : 150,

        closeEffect : 'elastic',
        closeSpeed  : 150,

        closeClick : true,

        helpers : {
          overlay : null
        }
      });

      /*
       *  Button helper. Disable animations, hide close button, change title type and content
       */

      $('.fancybox-buttons').fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : false,

        helpers : {
          title : {
            type : 'inside'
          },
          buttons : {}
        },

        afterLoad : function() {
          this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
      });


      /*
       *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
       */

      $('.fancybox-thumbs').fancybox({
        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : false,
        arrows    : false,
        nextClick : true,

        helpers : {
          thumbs : {
            width  : 50,
            height : 50
          }
        }
      });

      /*
       *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
      */
      $('.fancybox-media')
        .attr('rel', 'media-gallery')
        .fancybox({
          openEffect : 'none',
          closeEffect : 'none',
          prevEffect : 'none',
          nextEffect : 'none',

          arrows : false,
          helpers : {
            media : {},
            buttons : {}
          }
        });

      /*
       *  Open manually
       */

      $("#fancybox-manual-a").click(function() {
        $.fancybox.open('1_b.jpg');
      });

      $("#fancybox-manual-b").click(function() {
        $.fancybox.open({
          href : 'iframe.html',
          type : 'iframe',
          padding : 5
        });
      });

      $("#fancybox-manual-c").click(function() {
        $.fancybox.open([
          {
            href : '1_b.jpg',
            title : 'My title'
          }, {
            href : '2_b.jpg',
            title : '2nd title'
          }, {
            href : '3_b.jpg'
          }
        ], {
          helpers : {
            thumbs : {
              width: 75,
              height: 50
            }
          }
        });
      });
    });


/*function WCONB(){

$("#CONBtn").click(function(){    

var s_val=document.getElementById("CON_01").value;

if(confirm("Please confirm the Conditions Name is : "+ s_val +"")){

var params = $('input').serialize();
var url = "add_Subconditions.php?val_str="+s_val;
$.ajax({
type: "post",
url: url,
dataType: "html",
data: params,
success: function(data){
if(data == "refresh"){
window.location.reload(true);
}
else{
$("#error_da").html(data);
}
}
});

}

});

}*/
</script>

<script language="JavaScript">
function MM_ST(selObj){
  window.open(document.getElementById('SM1').options[document.getElementById('SM1').selectedIndex].value,"_self");
}

function MM_EST(selObj){
  window.open(document.getElementById('ESM1').options[document.getElementById('ESM1').selectedIndex].value,"_self");
}

function MM_PT(selObj){
  window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}

function MM_o(selObj){
  window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

/*function show_add(){
$("#groupSKU_add").show();
$("#groupSKU_edit").hide();
}*/

/*function hide_add(){
  $("#groupSKU_add").hide();
}*/

function show_edit(){
  $("#groupSKU_add").hide();
  $("#groupSKU_edit").show();
} 

function hide_edit(){
  self.location="group_sku.php";
}

/*function add_conditi(){
$("#conditi_add01").show();
}*/

function close_conditi(){
  $("#conditi_add01").hide();
  document.getElementById("CON_01").value='';
  $("#error_da").html('');
}
</script>
<script language="JavaScript">
function check_type(tval){
  var vals;
  vals=tval.toString();

  var Fname = '.skuCondi_s'+tval;
  var lenA = $(Fname+":checked").length;
  if(lenA>0){
    $("#SKUs_madd"+tval+"").show();         
  }else{
    $("#SKUs_madd"+tval+"").hide();
  }

}

function check_type_A(tval){
  var vals;
  vals=tval.toString();

  var Fname = '.skuCondi_s'+tval;
  var lenA = $(Fname+":checked").length;
  if(lenA>0){
    $("#SKUs_madd"+tval+"").show();         
  }else{
    $("#SKUs_madd"+tval+"").hide();
  }

}     
</script>
</head>

<body>
  <a name="top"></a>
  <div>
    <div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
    <div id="logout">Hi <b><?=str_replace('@mic.com.tw', '', $_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
  </div>
  <div class="clear"></div>
  <?php
  include("./menu.php");
  ?>
  <div class="clear"></div>
  <div id="Search" >
    <div>
      <select id="SEL_PTYPE" onChange="MM_PT(this)">
        <option value="group_sku.php">Select...</option>
        <?php
        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
        mysqli_query($link_db,'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase, $link_db);
        $str_type="select ProductTypeID,ProductTypeName from producttypes";
        $type_result=mysqli_query($link_db,$str_type);
        while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result))
        {
          ?>
          <option value="group_sku.php?PType_id=<?=$ProductTypeID?>" <?php if(intval($PType_id)==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName?></option>
          <?php
        }
        mysqli_close($link_db);
        ?>
      </select> &nbsp;&nbsp;
    </div>
  </div>

  <div id="content">
    <h3 class="left">SKU Grouping List:</h3>
    <p class="clear"></p>

    <!--datatable-->
    <div>
      <div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
      </div>
      <div class="left">
        <form id="form1" name="form1" method="post" action="group_sku.php">
          <input name="sear_txt" type="text" size="20" value="" /> <input type="button" value="Search" onclick="search_value();">
        </form>  
      </div>
    </div>
    <p class="clear"></p>

    <table class="list_table2">
      <tr>
        <th onClick="#" width="150">*Product Type</th>
        <th>*Conditions </th>
        <th><!-- <a href="#groupSKU_add" onclick="show_add();">Add New</a> --></th>
      </tr>
      <?php
      if(isset($_REQUEST['page'])==""){
        $page="1";
      }else{
        $page=intval($_REQUEST['page']);
      }      
      if(empty($page))$page="1";

      $read_num="10";
      $start_num=$read_num*($page-1);

      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
      //$select=mysqli_select_db($dataBase, $link_db);      

      if(intval($PType_id)<>''){
        if(isset($_REQUEST['s_search'])<>''){
          $s_search=trim($_REQUEST['s_search']);
          $str="SELECT * FROM product_skus_categories a inner join ProductTypes b on a.ProductTypeID=b.ProductTypeID where `ProductTypeName` like '%".$s_search."%' and b.ProductTypeID=".$PType_id." ORDER BY a.Product_SKU_Cid limit $start_num,$read_num;";
        }else{
          $str="SELECT * FROM product_skus_categories where ProductTypeID=".$PType_id." ORDER BY Product_SKU_Cid limit $start_num,$read_num;";
        }
      }else{
        if(isset($_REQUEST['s_search'])<>''){
          $s_search=$_REQUEST['s_search'];
          $str="SELECT * FROM product_skus_categories a inner join ProductTypes b on a.ProductTypeID=b.ProductTypeID where `ProductTypeName` like '%".$s_search."%' ORDER BY a.Product_SKU_Cid limit $start_num,$read_num;";
        }else{
          $str="SELECT * FROM product_skus_categories ORDER BY Product_SKU_Cid limit $start_num,$read_num;";
        }
      }
      $result_u=mysqli_query($link_db,$str);
      $i=0;
      while(list($Product_SKU_Cid,$ProductTypeID,$SKUs_Conditions)=mysqli_fetch_row($result_u))
      {
        $i=$i+1;
        putenv("TZ=Asia/Taipei");
        ?>
        <tr>
          <td>
            <?php
            $str1="select * from producttypes where ProductTypeID=".$ProductTypeID;
            $cmd_t1=mysqli_query($link_db,$str1);
            $t_result=mysqli_fetch_row($cmd_t1);    
            if($t_result==true){
              echo $t_result[1];
            }    
            ?></td>
            <td>
              <?php
              if($SKUs_Conditions<>''){
                $data_m="";
                $CSKUs_id = explode(",", $SKUs_Conditions,-1);
                $CSKUs_count = count($CSKUs_id);

                echo "<table border='0'>";
                for($j=0;$j<$CSKUs_count;$j++){

                  $str_CSKUs="select SKUs_Mid,SKUs_MiName from skus_mainsub where SKUs_Mid=".$CSKUs_id[$j]; 
                  $CSKUsresult=mysqli_query($link_db,$str_CSKUs);
                  $data_CSKUs=mysqli_fetch_row($CSKUsresult);
                  echo "<tr>";
                  echo "<td>".$data_CSKUs[1]."</td>";
                  echo "<td>";

                  $p=0;
                  $str_CSKUs_list="select SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow from skus_sublist where SKUs_Mid=".$data_CSKUs[0]." and ProductTypeID=".$t_result[0];
                  $CSKUslistresult=mysqli_query($link_db,$str_CSKUs_list);
                  while($data_CSKUslist=mysqli_fetch_row($CSKUslistresult))
                  {
                    $p=$p+1;
                    $data_m=$data_CSKUslist[3].", ";
                    echo $data_m;
                    if($p%8==0)
                    {
                      echo "<br />";
                    }
                  }
                  echo "</td>";
                  echo "</tr>";

                }
                echo "</table>";
              }   
              ?>
            </td>           
            <td>
              <a href="?pr_id=<?=$Product_SKU_Cid;?>&SType_id=<?=$t_result[0];?>#groupSKU_edit">Edit</a><br>&nbsp;&nbsp;<br>
              <?php echo "<input type='button' name='D_This' value=Del onClick=Del_id(".$Product_SKU_Cid.");>"; ?>
            </td>                
          </tr>
          <?php
        }
        ?>
      </table>
      <!--end of datatable-->
      <?php
      if(isset($_REQUEST['pr_id'])<>""){

        $p_marx=intval($_REQUEST['pr_id']);
        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
        mysqli_query($link_db,'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase, $link_db);  
        $str_matr_m="select * from product_skus_categories where Product_SKU_Cid=".$p_marx;
        $cmd_matr_m=mysqli_query($link_db,$str_matr_m);
        $record_matr_m=mysqli_fetch_row($cmd_matr_m);

        if(empty($record_matr_m)):
          else:
          $MA0=$record_matr_m[1];
          $MA1=$record_matr_m[2];
          $MA5=$record_matr_m[6];
          endif;

          if(isset($_REQUEST['SType_id'])!=""){
            $SType_id=intval($_REQUEST['SType_id']);
          }else{
            $SType_id=$MA0;
          }

        }
        ?>

        <div id="groupSKU_edit" class="subsettings" style="display:none">
          <!-- <form id="form3" name="form3" method="post" action="?kinds=edit_groupSKU"> -->
          <form id="form3" name="form3" method="post" action="">
            <!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
            <table class="addspec">
              <tr><td colspan="2"><input name="" type="button" value="Delete" disabled /> </td></tr>
              <tr>
                <th>Product Type</th>
                <td>
                  <?php
                  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                  mysqli_query($link_db,'SET NAMES utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                  //$select=mysqli_select_db($dataBase, $link_db);
                  $str_type1="select ProductTypeID,ProductTypeName from producttypes where ProductTypeID=".$SType_id;
                  $type_result1=mysqli_query($link_db,$str_type1);
                  list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result1);
                  echo $ProductTypeName;
                  mysqli_close($link_db);
                  ?><input type="hidden" name="PT_id" value="<?=$SType_id;?>">
                </td>
              </tr>
              <tr>
                <th>Status</th><td><input type="radio" value="1" name="ESR1" <?php if($MA5=='1') { echo "checked";} ?> > Online <input type="radio" value="0" name="ESR1" <?php if($MA5=='0') { echo "checked";} ?>> Offline </td>
              </tr>
              <tr>
                <th>Select Conditions:</th>
                <td>
                  <div id="accordion">
                    <table border="0">
                      <tr >        
                        <td width="40%" style="word-wrap: break-word; word-break: normal;">
                          <?php
                          $i=0;
                          if(isset($SType_id)<>''){   

                            $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                            mysqli_query($link_db,'SET NAMES utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                            //$select=mysqli_select_db($dataBase, $link_db);
                            
                            $Smid_value = preg_split("/,/i",$MA1);
                            if($Smid_value[0]!=""){
                              $Smid0 = $Smid_value[0];
                            }else{
                              $Smid0 = "";
                            }
                            if($Smid_value[1]!=""){
                              $Smid1 = $Smid_value[1];
                            }else{
                              $Smid1 = "";
                            }
                            if($Smid_value[2]!=""){
                              $Smid2 = $Smid_value[2];
                            }else{
                              $Smid2 = "";
                            }
                            
                            
                            

                            $str_CSKUss="select SKUs_Mid,SKUs_MiName from skus_mainsub where `SKUs_Mid`='".$Smid0."' or `SKUs_Mid`='".$Smid1."' or `SKUs_Mid`='".$Smid2."'";     
                            $CSKUsresult_s=mysqli_query($link_db,$str_CSKUss);
                            $i=0;
                            while($Adata_CSKUs=mysqli_fetch_row($CSKUsresult_s)){
                              $skumid_data=$Adata_CSKUs[0];
                              $i=$i+1;          
                              ?>
                              <input name="skuCondi[]" class="skuCondi_s<?=$Adata_CSKUs[0];?>" type="checkbox" value="<?=$Adata_CSKUs[0];?>" onclick="check_type(<?=$Adata_CSKUs[0];?>);"                     
                              <?php
                              $div_style="";
                              $data_cm="";
                              $Set_Dis="";
                              $MA1_value = preg_split("/,/i",$MA1);
                              for($j=0;$j<count($MA1_value)-1;$j++){
                               if($Adata_CSKUs[0]==$MA1_value[$j]){
                                $Set_Dis="Y";
                                $str_s="select SKUs_Sid,SKUs_Mid,ProductTypeID,SKUs_Mname,IsShow from skus_sublist where SKUs_Mid=".$Adata_CSKUs[0]." and ProductTypeID=".$SType_id;
                                $str_result=mysqli_query($link_db,$str_s);
                                $pp=0;
                                while($data_CS=mysqli_fetch_row($str_result))
                                {
                                  $pp=$pp+1;
                                  $data_cm.=$data_CS[3]."，";
                                }

                                $data_cm=preg_replace('/"/',"'",$data_cm);
                                $data_cm=str_replace("'",'"',$data_cm);		

                                echo "checked";
                              }else{
                              } 
                            }                                                      
                            ?> /> <?=$Adata_CSKUs[1];?>
                            <a class="fancybox fancybox.iframe" href="elb_group_sku.php?ProductTypeID=<?=$SType_id?>&SKUs_Mid=<?=$Adata_CSKUs[0]?>">[Edit]</a>  
                            <?php
                            /*$str_style="";
                            $str_abled="";
                            if($Set_Dis!="Y"){
                              $str_style="style='display:none'";
                            }
                            $div_style="<div id=SKUs_madd".$Adata_CSKUs[0]." ".$str_style." > Values:<input name=sk_na".$Adata_CSKUs[0]." size='100' type='text' value='".trim($data_cm)."' ".$str_abled." /><input type='hidden' name=sk_ma".$Adata_CSKUs[0]." value=".$Adata_CSKUs[0]."> (Multiple values seprated by ，)</div>";*/
                            
                            //=$div_style;       
                            
                            echo "<br>";
                          }     
                          mysqli_close($link_db);
                        }
                        ?>
                        <!-- <a href="#groupSKU_add" onclick="add_conditi();">Add new</a><br /> -->
                        <!-- <DIV id="conditi_add01" style="display:none">Conditions Name: <INPUT type="text" id="CON_01" name="CON_01" size="20" value="">&nbsp;<INPUT id="CONBtn" type="button" value="Done" onclick="WCONB()" />&nbsp;<a href="#groupSKU_add" onclick="close_conditi();">X</a> <span id="error_da"></span></DIV> -->
                      </td>
                    </tr>        
                  </table>      
                </div>   

              </td>
            </tr>
            <!-- <tr><td colspan="2"><input type="hidden" name="m_id" value="<?//=$p_marx;?>"><input type="hidden" name="ES1" value="<?//=$SType_id;?>"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr> -->
          </table>
        </form>
      </div>
      <div id="groupSKU_add" class="subsettings" style="display:none">
        <div class="right"><a href="#" onclick="hide_add();"> [close] </a></div>
        <form id="form4" name="form4" method="post" action="?kinds=add_groupSKU" onsubmit="return Final_Check();">
          <table class="addspec">
            <tr><td colspan="2"><input name="" type="button" value="Delete" disabled /> </td></tr>
            <tr>
              <th>Product Type</th>
              <td>
                <input id="SEL_APTYPE" name="SEL_APTYPE" type="text" size="25" value=""  />
              </td>
            </tr>
            <tr>
              <th>Status</th><td><input type="radio" value="1" name="AESR1" checked> Online <input type="radio" value="0" name="AESR1"> Offline </td>
            </tr>
            <tr>
              <th>Select Conditions:</th>
              <td>
                <div id="accordion">
                  <table border="0">
                    <tr >        
                      <td width="40%" style="word-wrap: break-word; word-break: normal;">
                        <?php       
                        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                        mysqli_query($link_db,'SET NAMES utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                        //$select=mysqli_select_db($dataBase, $link_db);
                        $str_CSKUss="select SKUs_Mid,SKUs_MiName from skus_mainsub";     
                        $CSKUsresult_s=mysqli_query($link_db,$str_CSKUss);
                        $i=0;
                        while($Adata_CSKUs=mysqli_fetch_row($CSKUsresult_s)){
                          $i=$i+1;
                          ?>
                          <input name="skuCondi_a[]" class="skuCondi_s<?=$Adata_CSKUs[0];?>" type="checkbox" value="<?=$Adata_CSKUs[0];?>" onclick="check_type_A(<?=$Adata_CSKUs[0];?>);" /> <?=$Adata_CSKUs[1];?>
                          <?php
                          $str_style="";
                          $str_abled="";
                          $Set_Dis="";
                          if($Set_Dis!="Y"){
                            $str_style="style='display:none'";
                          }
                          $div_style="<div id=SKUs_madd".$Adata_CSKUs[0]." ".$str_style." > Values:<input name=sk_ana".$Adata_CSKUs[0]." size='100' type='text' value='' ".$str_abled." /><input type='hidden' name=sk_ama".$Adata_CSKUs[0]." value=".$Adata_CSKUs[0]."> (Multiple values seprated by ，)</div>";
                          ?>
                          <?=$div_style;?>
                          <?php
                          echo "<br>";
                        }     
                        mysqli_close($link_db);
                        ?>		
                      </td>
                    </tr>        
                  </table>
                </div>
              </td>
            </tr>
            <tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
          </table>
        </form>
        <script language="JavaScript">
        function Final_Check( ) {
          if ( document.form4.SEL_APTYPE.value == "" ) {
            alert ("請選擇 Product Type！");
            document.form4.SEL_APTYPE.focus();
            return false;
          }
          return true;
        }
        </script>
      </div>
      <p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
    </div>
    <p class="clear">&nbsp;</p>
    <div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
  </body>
  </html>
  <?php
  if(isset($_REQUEST['pr_id'])<>""){
    echo "<script language='Javascript'>show_edit();</script>\n";
    exit();
  }
  ?>