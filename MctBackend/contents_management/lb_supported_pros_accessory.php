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

	require "../config.php";

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

	if (isset($_REQUEST['kinds']) && $_REQUEST['kinds'] == 'add_sku') {
		// 執行添加 SKU 的操作
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// 處理表單提交
			if (isset($_POST["sku_checkbox"]) && is_array($_POST["sku_checkbox"])) {
				//將SKU數組變字串
				$selectedSKUs = implode(",", $_POST["sku_checkbox"]);
				echo "<script language='javascript'>parent.document.forms['myForm1'].val.value='" . $selectedSKUs . "';"; //將值傳到父頁
				echo "alert('SKU added successfully: $selectedSKUs');";
				echo "parent.jQuery.fancybox.close();";
				echo "</script>";
			} else {
				echo "<script language='javascript'>";
				echo "parent.document.forms['myForm1'].val.value='';"; // 空
				echo "alert('No SKU selected');";
				echo "parent.jQuery.fancybox.close();";
				echo "</script>";
			}
		}
	} else {
		// 如果 kinds 参数不是 add_sku，執行其他操作
	}
	?>

  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<title>Add Supported Products</title>
  	<link rel=stylesheet type="text/css" href="../backend.css">
  	<style type="text/css">
  		table {
  			border: 0px solid #c0c0c0;
  			width: 90%
  		}

  		td {
  			padding: 5px 15px;
  			cursor: pointer;
  		}

  		td:hover {
  			background: #dcf2fd;
  		}
  	</style>
  	<link type="text/css" href="../lib/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
  	<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
  	<script type="text/javascript" src="../lib/jquery-ui-1.8.22.custom.min.js"></script>
  	<script type="text/javascript">
  		$(function() {

  			// Accordion
  			$("#accordion").accordion({
  				header: "h3"
  			});

  			// Progressbar
  			$("#progressbar").progressbar({
  				value: 20
  			});

  			//hover states on the static widgets
  			$('#dialog_link, ul#icons li').hover(
  				function() {
  					$(this).addClass('ui-state-hover');
  				},
  				function() {
  					$(this).removeClass('ui-state-hover');
  				}
  			);

  		});
  	</script>
  </head>
  <body style="background:#f9f9f9">
  	<h2>Add Products:</h2>
  	<div>
  		<?php /*SELECT MODELCODE, COUNT(*) FROM product_skus WHERE ProductTypeID = 116 GROUP BY MODELCODE    
  		        $result = $conn->query($sql); 
  		        if ($result && $result->num_rows > 0) {
  			    $total =$result->num_rows
  		        }*/
  		$sql = "SELECT COUNT(DISTINCT MODELCODE) FROM product_skus WHERE ProductTypeID =116"; //可用別名
        $result = $conn->query($sql);
        $total = 0;
        $total = $result->fetch_assoc()['COUNT(DISTINCT MODELCODE)'];
        /*或是 if ($result && $row = $result->fetch_assoc()) {
        	   $total = $row['COUNT(DISTINCT MODELCODE)'];
         }*/        
  		?>
  		<div class="pagination left">Total: <span class="w14bblue"><?php echo $total ?></span> records &nbsp;&nbsp;
  		</div>
  		<div class="left">
  			<!--<input name="" type="text" size="20" value="Search"  /> -->
  		</div>
  	</div>
  	<p class="clear">&nbsp;</p>

  	<form id="myForm" method="post" action="?kinds=add_sku">
  		<div id="accordion">
  			<h3><a href="#">Intel DSG</a></h3>
  			<?php                           //全部sku字符串須拆    別名     
				$sql = "SELECT MODELCODE, GROUP_CONCAT(SKU) AS SKU_list FROM product_skus WHERE ProductTypeID = 116 GROUP BY MODELCODE";
				$result = $conn->query($sql);
				if ($result && mysqli_num_rows($result) > 0) {
				?>
  				<ul>
  					<?php while ($row = $result->fetch_assoc()) { ?>
  						<li>
  							<input name="model_checkbox[]" type="checkbox" id="<?php echo $row['MODELCODE']; ?>" class="model-checkbox" />
  							<label for="<?php echo $row['MODELCODE']; ?>"><?php echo $row['MODELCODE']; ?>:</label>
  							(
  							<?php
								// 將 SKU_list 字符串變數組 SKU
								$skus = explode(",", $row['SKU_list']);
								foreach ($skus as $sku) {
									//foreach 將input、label、值歷遍  可在這用值判斷勾選
								?>
  								<input name="sku_checkbox[]" type="checkbox" id="<?php echo $sku; ?>" value="<?php echo $sku; ?>" class="sku-checkbox-<?php echo $row['MODELCODE']; ?>" />
  								<label for="<?php echo $sku; ?>"><?php echo $sku; ?></label>
  							<?php } ?>
  							)
  							<br style="margin:10px 0;" />
  						</li>
  					<?php } ?>
  				</ul>
  			<?php } $conn->close();?>
  		</div>
  		<p class="clear">&nbsp;</p>
  		<p><input name="" type="submit" value="Done" />&nbsp;&nbsp;&nbsp;&nbsp;
  			<input name="" type="button" value="Cancel" onclick="clearCheck();" />
  		</p>
  	</form>
  	<P style="color:#0F0">
  		- By Product Type 列出，每個 Product Type 下的 Model 及其 SKUs。每個 model 列一列，下面再列其下的 SKU。<br>
  		- ** SKU 請依 中英文數字排序<br>
  		- 可勾選多筆SKUs ，勾選modle 則所有SKU 都自動被check<br>
  	</p>
  	<script>
  		// DOM 
  		document.addEventListener("DOMContentLoaded", function() {
  			// 獲取所有模型代碼的複選框
  			let AA = document.querySelectorAll('.model-checkbox'); 	//最前面勾選框 				
  			// 複選框事件監聽器
  			AA.forEach(function(checkbox) {
  				checkbox.addEventListener('change', function() {
  					// 獲取相應模型代碼下的所有SKU複選框
  					let modelCode = this.id;  			
  					let skuCheckboxes = document.querySelectorAll('.sku-checkbox-' + modelCode);//被全選
  					// 設置所有SKU複選框的勾選狀態
  					skuCheckboxes.forEach(function(skuCheckbox) {
  						skuCheckbox.checked = checkbox.checked;
  					});
  				});
  			});
  		});

  		function clearCheck() {    
        let checkboxes = document.querySelectorAll('input[type="checkbox"]');        
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
  	</script>
  </body>
  </html>