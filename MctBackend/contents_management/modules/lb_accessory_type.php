<?php
// 連線資料庫
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();
if (empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])) {
    echo "<script language='JavaScript'>location='../../login.php'</script>";
    exit();
}

require "../../config.php";

// 建立連線
$conn = new mysqli($db_host, $db_user, $db_pwd, $dataBase);
// 檢查連線是否成功
if ($conn->connect_error) {
    die('資料庫連線錯誤: ' . $conn->connect_error);
}
// 設置字符集編碼
$conn->query('SET NAMES utf8mb4');
// 設置時區
$conn->query('SET time_zone = "+8:00"');
$result1 = $conn->query("SELECT COUNT(ID) AS total FROM accessory_type");
$total_count_row = $result1->fetch_assoc();
$total_count = $total_count_row['total'];


$sql = "SELECT * FROM accessory_type ORDER BY C_DATE DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit Accessory Type</title>
    <link rel=stylesheet type="text/css" href="../../backend.css">
    <style type="text/css">



    </style>
</head>

<body style="background:#f9f9f9">
    <h2>Edit / Add Accessory Type:</h2>
    <p class="clear"></p>
    <p>Total: <span class="w14bblue"><?php echo $total_count ?></span> records </p>
    </div>
    <p class="clear"></p>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["TYPE"])) {
            date_default_timezone_set('Asia/Taipei');
            $TYPE = $_POST["TYPE"];           
            $c_date = date("Y-m-d H:i:s"); // 創建時間
            $u_date = date("Y-m-d H:i:s"); // 更新時間
            if (isset($_POST["submit_add"])) { //ADD按鈕NAME 
                // 新增模式
                $sql = "INSERT INTO accessory_type (Name,C_DATE) VALUES ('$TYPE','$c_date')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('新增成功！');</script>";
                    echo "<script>window.location.replace('lb_accessory_type.php');</script>";
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } elseif (isset($_POST["submit_edit"])) { //edit按鈕NAME 
                // 編輯模式
                if (isset($_POST['edit_id'])) {
                    // 編輯模式下，獲取要編輯的 Accessory Type ID
                    $edit_id = $_POST['edit_id'];

                    $sql = "UPDATE accessory_type SET Name='$TYPE',U_DATE='$u_date' WHERE ID='$edit_id'";
                    if ($conn->query($sql) === TRUE) {
                        // 如果查詢成功
                        echo "<script>alert('修正成功！');</script>";
                        echo "<script>window.location.replace('lb_accessory_type.php');</script>";
                        exit();
                    } else {
                        // 如果查询失敗
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        } else {
            echo "<script>alert('Accessory Type 名稱不能為空！');</script>";
        }
    }

    ?>
    <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="list_table">
            <tr>
                <th>Accessory Type</th>
                <th>
                    <div class="button14" style="width:50px;" onClick="add()">Add</div>
                </th>
            </tr>
            <!--add a Accessory Type-->
            <tr id="addRow" style="display:none;">
                <td><input id="newAccessoryType" name="TYPE" type="text" size="20" value="" /></td>
                <td style="width:150px"><input name="submit_add" type="submit" value="Done" />
                    <input type="button" value="Cancel" onclick="javascript:location.href='lb_accessory_type.php'" />
                </td>
            </tr>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <!--編輯 Accessory Type-->
                    <tr>
                        <td>
                            <?php if (isset($_GET['edit_id']) && $_GET['edit_id'] == $row['ID']) : ?><!--get值=當前行ID-->
                                <!-- 如果是編輯模式則顯示輸入框 -->
                                <input id="editAccessoryType" name="TYPE" type="text" size="20" value="<?php echo $row['Name']; ?>" />
                                <!-- 在編輯模式下設置隱藏的 input 元素來傳遞編輯資料的 ID -->
                                <input type="hidden" name="edit_id" value="<?php echo $row['ID']; ?>" />

                            <?php else : ?>
                                <!-- 如果不是編輯模式，則顯示 Accessory Type 名稱 -->
                                <?php echo $row['Name']; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (isset($_GET['edit_id']) && $_GET['edit_id'] == $row['ID']) : ?>
                                <!-- 如果是編輯模式，則顯示 "Done" 鈕 -->
                                <input name="submit_edit" type="submit" value="Done" />
                                <input name="" type="button" value="Cancel" onclick="javascript:location.href='lb_accessory_type.php'" />
                            <?php else : ?>
                                <!-- 如果不是編輯模式，則顯示 "Edit" 鏈結 -->
                                <a href="?edit_id=<?php echo $row['ID']; ?>">Edit</a> &nbsp;&nbsp;
                                <a href="?id=<?php echo $row['ID']; ?>" onclick="return confirm('確定要刪除嗎？')">Del</a>
                            <?php endif; ?>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='2'>No data</td></tr>";
            }
            ?>
        </table>
    </form>
    <?php
    // 刪除
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // 執行刪除操作
        $sql2 = "DELETE FROM accessory_type WHERE ID = '$id'";

        if ($conn->query($sql2) === TRUE) {
            echo "<script>window.location.href = 'lb_accessory_type.php';</script>";
            exit();
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
    $conn->close();
    ?>

    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>
    <p style="color:#0F0">- List 順序：由新至舊</p>
    <p class="clear">&nbsp;</p>
    <p class="clear">&nbsp;</p>

    <script>
        function add() {
            document.getElementById("addRow").style.display = "table-row";//table-row 呈現一行
        }
    </script>
</body>

</html>