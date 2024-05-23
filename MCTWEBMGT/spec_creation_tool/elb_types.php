<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$PType_id="";$SPCC_ID="";$p_SKU="";
if(isset($_REQUEST['PType_id'])!=''){
    $PType_id=intval($_REQUEST['PType_id']);
}
if(isset($_REQUEST['SPCC_ID'])!=''){
    $SPCC_ID=intval($_REQUEST['SPCC_ID']);
}
if(isset($_REQUEST['p_id'])!=''){
    $p_SKU=intval($_REQUEST['p_id']);
}

if(isset($_REQUEST['kinds'])!=''){
    if(trim($_REQUEST['kinds'])=='add_types'){
        $T1="";$PType_id_s="";$SPCC_ID_s="";$p_id_s="";

        $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
        mysqli_query($link_db,'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase);

        if(isset($_POST['T1'])!=''){
            $T1=trim($_POST['T1']);
        }
        if(isset($_REQUEST['PType_id'])!=''){
            $PType_id_s=intval($_REQUEST['PType_id']);
        }
        if(isset($_REQUEST['SPCC_ID'])!=''){
            $SPCC_ID_s=intval($_REQUEST['SPCC_ID']);
        }
        if(isset($_REQUEST['p_id'])!=''){
            $p_id_s=intval($_REQUEST['p_id']);
        }

        $str_c="select SPECTypeName from spectypes where SPECCategoryID=".$SPCC_ID_s." and SPECTypeName='".$T1."'";
        $check_c=mysqli_query($link_db,$str_c);
        $record_c=mysqli_fetch_row($check_c);

        if(empty($record_c)):

            putenv("TZ=Asia/Taipei");
        $now=date("Y/m/d H:i:s");

        if(function_exists('com_create_guid')){
            $guid = com_create_guid();
        }else{
mt_srand((double)microtime()*10000); //optional for php 4.2.0 and up.
$charid = strtoupper(md5(uniqid(rand(), true)));
$hyphen = chr(45);// "-"
$uuid = chr(123)// "{"
.substr($charid, 0, 8).$hyphen
.substr($charid, 8, 4).$hyphen
.substr($charid,12, 4).$hyphen
.substr($charid,16, 4).$hyphen
.substr($charid,20,12)
 .chr(125);// "}"
 $guid = $uuid;
}


$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

$str_t="insert into spectypes (SPECCategoryID,SPECTypeName,WebOrder,InputTypeID,GUID,crea_d,crea_u,IsShow) values ($SPCC_ID_s,'$T1','',2,'$guid','$now','1782','1')";
$cmd_t=mysqli_query($link_db,$str_t);
if($cmd_t==true):
    echo "<script>alert('Add Types it!');self.location='elb_types.php?SPCC_ID=$SPCC_ID_s&PType_id=$PType_id_s&p_id=$p_id_s'</script>";
endif;
else:

    echo "<script>alert('SPECTypesName目前已經存在,請重新輸入!');self.location='elb_types.php?SPCC_ID=$SPCC_ID_s&PType_id=$PType_id_s&p_id=$p_id_s'</script>";
exit();

endif;
mysqli_close($link_db);
}

if(trim($_REQUEST['kinds'])=='types_set'){

    if(isset($_POST['ps_id'])!=''){
        $ps_id=intval($_POST['ps_id']);
    }else{
        $ps_id="";
    }
    if(isset($_POST['ps_SPCC'])!=''){
        $ps_SPCC=intval($_POST['ps_SPCC']);
    }else{
        $ps_SPCC="";
    }


    putenv("TZ=Asia/Taipei");
    $now=date("Y/m/d H:i:s");

    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    //$select=mysqli_select_db($dataBase);

    $str_m="select SPEC_Vaule_ID FROM `specvalues` order by SPEC_Vaule_ID desc limit 1";
    $check_m=mysqli_query($link_db,$str_m);
    $SMax_PMaxtrixID=mysqli_fetch_row($check_m);
    $SMMXCount=$SMax_PMaxtrixID[0]+1;

    if(isset($_POST['typs_all'])!=''){
        $typ_all_str="";
        foreach($_POST['typs_all'] as $tp_ck) {  

            $typ_all_str.=$tp_ck.",";	
            
            $str_specvalues="select Product_SKU_Auto_ID,SPECTypeID,SPECValue from `specvalues` where SPECTypeID=".$tp_ck." and Product_SKU_Auto_ID=".$ps_id;
            $specvalues_cmd=mysqli_query($link_db,$str_specvalues);
            $record_specvalues=mysqli_fetch_row($specvalues_cmd);


            if(empty($record_specvalues)):

            $str_sp="insert into specvalues (`SPEC_Vaule_ID`,`Product_SKU_Auto_ID`,`SPECTypeID`,`SPECValue`,`crea_d`,`crea_u`) values ($SMMXCount,$ps_id,$tp_ck,'','$now','1782');";
            $cmd_sp=mysqli_query($link_db,$str_sp);
            $SMMXCount++;  

            else:

                if($record_specvalues[2]==""){
                    $str_Options="select SPECOptionID,SPECTypeID,SPECOptionValue,IsShow FROM specoptions where SPECTypeID=".$tp_ck." order by SPECOptionValue";
                    $Optionsresult=mysqli_query($link_db,$str_Options);

                    list($SPECOptionID,$SPECTypeID,$SPECOptionValue,$IsShow)=mysqli_fetch_row($Optionsresult);

                    $str_sp1="update specvalues set `SPECValue`='".$SPECOptionID.",' where SPECTypeID=".$tp_ck." and Product_SKU_Auto_ID=".$ps_id.";";
                    $cmd_sp1=mysqli_query($link_db,$str_sp1);
                }

            endif; 


            }
        }else{
            echo "<script>alert('設定SPECTypes不能空白!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
            exit();
        }


        $str_tychk="select a.SPECTypeID from specvalues a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where b.SPECCategoryID=".$ps_SPCC." and INSTR('".$typ_all_str."',a.SPECTypeID)<1 and Product_SKU_Auto_ID=".$ps_id.";";
        $cmd_tychk=mysqli_query($link_db,$str_tychk);

        while($record_tychk=mysqli_fetch_row($cmd_tychk)){				
            $str_sp1="update specvalues set `SPECValue`='' where SPECTypeID=".$record_tychk[0]." and Product_SKU_Auto_ID=".$ps_id.";";

            $cmd_sp1=mysqli_query($link_db,$str_sp1);		   
        }      

setcookie("type_cookie".$ps_SPCC,$typ_all_str,time()+1800); //set cookie約1800秒

mysqli_close($link_db);
echo "<script>alert('設定SPECTypes成功!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
exit();
}
}
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
        <form id="form2" name="form2" method="post" action="?kinds=add_types&SPCC_ID=<?=$SPCC_ID?>&PType_id=<?=$PType_id;?>&p_id=<?=$p_SKU?>" onsubmit="return Final_Check();">
            Types <input name="T1" type="text" size="25" value=""  /> &nbsp;&nbsp;&nbsp;&nbsp;Enter tooltips <input name="T2" type="text" size="25" value=""  />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Add"  /> <a href="#" onclick="javascript:parent.location.reload();parent.jQuery.fancybox.close();">Close</a></p>
        </form>
        <form id="form1" name="form1" method="post" action="?kinds=types_set&SPCC_ID=<?=$SPCC_ID?>">
            <table>
                <?php
                $data_type_ss="";$str_optionc_s="";$data_optionc_s="";$SP_Pa="";

                $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                mysqli_query($link_db,'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_type_ss="select a.SPECTypeID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where b.SPECCategoryID=".$SPCC_ID." and Product_SKU_Auto_ID=".$p_SKU;
                $type_result_ss=mysqli_query($link_db,$str_type_ss);
                while($data_ps=mysqli_fetch_row($type_result_ss)){
                    $data_type_ss.=$data_ps[0].",";
                }
                mysqli_close($link_db);

                $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                mysqli_query($link_db,'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_optionc_s="select SPECTypeID from `specvalues` where SPECValue<>'' and (INSTR('".$data_type_ss."',SPECTypeID)>0) and Product_SKU_Auto_ID=".$p_SKU;
                $optionc_result_s=mysqli_query($link_db,$str_optionc_s);
                while($data_optc=mysqli_fetch_row($optionc_result_s)){

                    $data_optionc_s.=$data_optc[0].",";
                }
                mysqli_close($link_db);

                $data_optionc_s=str_replace(',,', ',', $data_optionc_s);

                $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                mysqli_query($link_db,'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);

                $str_type_s="SELECT `SKU_CategorySort`, `SKU_Type` FROM `product_skus` WHERE `Product_SKU_Auto_ID`=".$p_SKU;
                $type_result_s=mysqli_query($link_db,$str_type_s);
                $data_p=mysqli_fetch_row($type_result_s);
                mysqli_close($link_db);

                /* 20140312 Create */
                $data_p_value=$data_p[1];

                if(isset($_COOKIE["type_cookie".$SPCC_ID.""])!=''){
                    $data_p_value01=$_COOKIE["type_cookie".$SPCC_ID.""];
                }else{
                    $data_p_value01=$data_p_value;
                }

                $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                mysqli_query($link_db,'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_Types_Pa="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from spectypes where SPECCategoryID=".$SPCC_ID." and (ParentSpec is NULL)";
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
                    $str="";
                    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
                    mysqli_query($link_db,'SET NAMES utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                    //$select=mysqli_select_db($dataBase, $link_db);
                    $str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,ParentSpec,IsShow from spectypes where (SPECCategoryID=".$SPCC_ID." and SPECTypeID not in (SELECT distinct `ParentSpec` FROM  `spectypes` WHERE  `ParentSpec` IS NOT NULL )) or INSTR('".$SP_Pa."',ParentSpec)>0 order by SPECTypeName";
                    $Typesresult=mysqli_query($link_db,$str_Types);

                    while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$ParentSpec,$IsShow)=mysqli_fetch_row($Typesresult)){
                        $str=$str."spt_".$SPECTypeID.",";

                        if($ParentSpec!=NULL){

                            $str_Types_PStr="select SPECTypeName from spectypes where SPECTypeID='".$ParentSpec."'";
                            $Typesresult_PStr=mysqli_query($link_db,$str_Types_PStr);
                            $PStr_Val=mysqli_fetch_row($Typesresult_PStr);   

                            $SPE_SName=$PStr_Val[0]." -> ".$SPECTypeName;

                        }else if($ParentSpec==NULL){
                            $SPE_SName=$SPECTypeName;
                        }

                        ?>
                        <tr><td ><input name="typs_name" type="hidden" value="<?=$str;?>"><input name="ps_id" type="hidden" value="<?=$p_SKU;?>"><input name="ps_SPCC" type="hidden" value="<?=$SPCC_ID;?>">
                            <input name="typs_all[]" type="checkbox" value="<?=$SPECTypeID?>" <?php if(preg_match("/".$SPECTypeID."/i",$data_p_value01)!='') echo "checked"; ?> />
                            <?=$SPE_SName;?>
                        </td></tr>
                        <?php
                    }
                    mysqli_close($link_db);
                    ?>
                    <tr><td><p style="padding:5px 20px;"><input type="submit" value="Done"  /></p></td></tr>
                </tbody>
            </table>
        </form>
        <P style="color:#0F0">
            - show 這個 category 下面所有設定的types, check to set.<br>
            - Add New box 可輸入新的type, add後出現在下面table
            - 參考
            http://dbushell.github.com/Nestable/  &  http://mjsarfatti.com/sandbox/nestedSortable/<br>
            以table 方式呈現兩層，可用拖拉 rows 進行兩層grouping & 排序
        </p>
    </body>
    </html>