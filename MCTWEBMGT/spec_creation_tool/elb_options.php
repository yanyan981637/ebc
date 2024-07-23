<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if (isset($_REQUEST['SPCT_ID']) != '') {
    $SPCT_ID = intval($_REQUEST['SPCT_ID']);
} else {
    $SPCT_ID = "";
}
if (isset($_REQUEST['p_id']) != '') {
    $p_SKU = intval($_REQUEST['p_id']);
} else {
    $p_SKU = "";
}

if (isset($_REQUEST['kinds']) != '') {

    if ($_REQUEST['kinds'] == 'add_options') {

        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
        mysqli_query($link_db, 'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase);

        $T1 = $_POST['T1'];
        $T1 = str_replace("'", "&#39;", $T1);

        $str_c = "select SPECOptionValue FROM specoptions where SPECOptionValue='" . $T1 . "' and SPECOptionID=" . $SPCT_ID . "";
        $check_c = mysqli_query($link_db, $str_c);
        $record_c = mysqli_fetch_row($check_c);

        if (empty($record_c)) :
            putenv("TZ=Asia/Taipei");
            $now = date("Y/m/d H:i:s");

            $str_m = "select SPECOptionID FROM specoptions order by SPECOptionID desc limit 1";
            $check_m = mysqli_query($link_db, $str_m);
            $Max_COptionID = mysqli_fetch_row($check_m);
            $MCount = $Max_COptionID[0] + 1;

            $str_t = "insert into specoptions (SPECOptionID,SPECTypeID,SPECOptionValue,SPECOptionURL,crea_d,crea_u) values ($MCount,$SPCT_ID,'$T1','','$now','1782')";

            //-------------2017/04/17 新增資料比對-------------
            /*$str_ss="select * from specoptions where SPECOptionValue='$T1'";
$result=mysqli_query($link_db,$str_ss);
$row_result=mysqli_fetch_assoc($result);
echo isset($T1);exit();
if(isset($T1))
{
    //將讀取出來的資料取出欄位名稱為username的資料，並且存在$admin
    $admin=$row_result["SPECOptionValue"];
    if($T1==$admin)
    {
        echo "<script>alert('Repeated Value! Please enter another!');self.location='elb_options.php?SPCT_ID=$SPCT_ID&p_id=$p_SKU'</script>";
    } else {
        $cmd_t=mysqli_query($link_db,$str_t);
        echo "<script>alert('Add Options it!');self.location='elb_options.php?SPCT_ID=$SPCT_ID&p_id=$p_SKU'</script>";
    }
}*/
            //-----------2017/04/17註解原本code----------------

            $cmd_t = mysqli_query($link_db, $str_t);
            if ($cmd_t == true) :
                echo "<script>alert('Add Options it!');self.location='elb_options.php?SPCT_ID=$SPCT_ID&p_id=$p_SKU'</script>";
            endif;
        else :

            echo "<script>alert('SPECOptionsName目前已經存在,請重新輸入!');self.location='elb_options.php?SPCT_ID=$SPCT_ID&p_id=$p_SKU'</script>";
            exit();

        endif;
        mysqli_close($link_db);
    }


    if ($_REQUEST['kinds'] == 'options_set') {
        $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
        mysqli_query($link_db, 'SET NAMES utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
        mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
        //$select=mysqli_select_db($dataBase);

        $str_re = "";

        $sp_id = intval($_POST['sp_id']);
        $p_id = intval($_POST['p_id']);

        if (isset($_POST['opt_all']) <> '') {
            foreach ($_POST['opt_all'] as $opt_ck) {
                $str_re = $str_re . $opt_ck . ",";
            }
        } else {
            $str_re = '';
        }
        $str_t = "update `specvalues` set SPECValue='" . $str_re . "' where Product_SKU_Auto_ID=" . $p_id . " and SPECTypeID=" . $sp_id;
        $cmd_t = mysqli_query($link_db, $str_t);
        if ($cmd_t == true) :
            echo "<script>alert('設定SPECOptions成功!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
        endif;
        mysqli_close($link_db);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Add Edit Product Types's Options</title>
    <link rel="stylesheet" type="text/css" href="../backend.css">
    <style type="text/css">
        table {
            border: 1px solid #c0c0c0;
            width: 95%
        }

        thead {
            background: #00a0e9;
            color: #fff;
            font-weight: bolder;
            padding: 5px 15px;
        }

        td {
            padding: 5px 15px;
        }

        td.two {
            padding-left: 50px
        }

        tr {
            cursor: pointer;
        }

        tr:hover {
            background: #dcf2fd;
        }

        tbody:nth-child(even) {
            background: #f8f8f8;
        }
    </style>
    <script language="JavaScript">
        <!--
        function Final_Check() {
            if (document.form2.T1.value == '') {
                alert("請輸入Options！");
                document.form2.T1.focus();
                return false;
            }
            return true;
        }
        //
        -->
    </script>
</head>

<body style="backbround:#f9f9f9">
    <p>
    <form id="form2" name="form2" method="post" action="?kinds=add_options&SPCT_ID=<?= $SPCT_ID ?>&p_id=<?= $p_SKU ?>" onsubmit="return Final_Check();">
        Options <input name="T1" type="text" size="25" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;Enter tooltips <input name="T2" type="text" size="25" value="" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Add" /> <a href="#" onclick="javascript:parent.location.reload();parent.jQuery.fancybox.close();">Close</a></p>
    </form>
    <form id="form1" name="form1" method="post" action="?kinds=options_set&SPCT_ID=<?= $SPCT_ID ?>">
        <table>
            <?php
            $data_option_ss = "";
            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
            mysqli_query($link_db, 'SET NAMES utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
            //$select=mysqli_select_db($dataBase, $link_db);
            $str_option_ss = "select SPECValue from `specvalues` where Product_SKU_Auto_ID=" . $p_SKU . " and SPECTypeID=" . $SPCT_ID;
            $option_result_ss = mysqli_query($link_db, $str_option_ss);
            while ($data_ps = mysqli_fetch_row($option_result_ss)) {
                $data_option_ss .= $data_ps[0] . ",";
            }
            mysqli_close($link_db);

            $data_option_ss = str_replace(',,', ',', $data_option_ss);

            $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
            mysqli_query($link_db, 'SET NAMES utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
            mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
            //$select=mysqli_select_db($dataBase, $link_db);

            $str_Types = "select SPECTypeID,SPECTypeName from spectypes where SPECTypeID=" . $SPCT_ID;
            $Typesresult = mysqli_query($link_db, $str_Types);
            $data = mysqli_fetch_row($Typesresult);
            ?>
            <thead>
                <tr>
                    <td><?= $data[1]; ?> :</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $str_s = "";
                $link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
                mysqli_query($link_db, 'SET NAMES utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
                mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
                //$select=mysqli_select_db($dataBase, $link_db);
                $str_Options = "select SPECOptionID,SPECTypeID,SPECOptionValue,IsShow FROM specoptions where SPECTypeID=" . $SPCT_ID . " order by SPECOptionValue";
                $Optionsresult = mysqli_query($link_db, $str_Options);

                while (list($SPECOptionID, $SPECTypeID, $SPECOptionValue, $IsShow) = mysqli_fetch_row($Optionsresult)) {
                    $str_s = $str_s . "spo_" . $SPECOptionID . ",";
                ?>
                    <tr>
                        <td><input name="optons_name" type="hidden" value="<?= $str_s; ?>">
                            <input name="opt_all[]" type="checkbox" value="<?= $SPECOptionID; ?>" <?php if (strpos($data_option_ss, $SPECOptionID . ",") != '' || strpos($data_option_ss, $SPECOptionID . ",") === 0) {
                                                                                                    echo "checked";
                                                                                                } ?> /> <?= $SPECOptionValue; ?>
                        </td>
                    </tr>
                <?php
                }
                mysqli_close($link_db);
                ?>
                <tr>
                    <td>
                        <p style="padding:5px 20px; "><input type="hidden" name="p_id" value="<?= $p_SKU ?>"><input type="hidden" name="sp_id" value="<?= $SPCT_ID ?>"><input type="submit" value="Done" /></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <P style="color:#0F0;display:none">
        - show 這個 category 下面所有設定的types, check to set.<br>
        - Add New box 可輸入新的type, add後出現在下面table
        - 參考
        http://dbushell.github.com/Nestable/ & http://mjsarfatti.com/sandbox/nestedSortable/<br>
        以table 方式呈現兩層，可用拖拉 rows 進行兩層grouping & 排序
    </p>
</body>

</html>