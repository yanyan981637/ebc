<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='add_supmery'){

$str_new="SELECT `ID` FROM `sp_memory` order by `ID` desc limit 1";
$new_cmd=mysqli_query($link_db,$str_new);
$MCount=mysqli_fetch_row($new_cmd);
$NCount=$MCount[0]+1;

if(isset($_POST['mv01A'])!=''){
$mv01A=trim($_POST['mv01A']);
}else{
$mv01A="";
}
if(isset($_POST['sz01A'])!==''){
$sz01A=trim($_POST['sz01A']);
}else{
$sz01A="";
}
if(isset($_POST['tp01A'])!==''){
$tp01A=trim($_POST['tp01A']);
}else{
$tp01A="";
}
if(isset($_POST['fq01A'])!==''){
$fq01A=trim($_POST['fq01A']);
}else{
$fq01A="";
}
if(isset($_POST['cv01A'])!==''){
$cv01A=trim($_POST['cv01A']);
}else{
$cv01A="";
}
if(isset($_POST['vn01A'])!==''){
$vn01A=htmlspecialchars($_POST['vn01A'], ENT_QUOTES);
}else{
$vn01A="";
}
if(isset($_POST['pn01A'])!==''){
$pn01A=htmlspecialchars($_POST['pn01A'], ENT_QUOTES);
}else{
$pn01A="";
}
if(isset($_POST['vt01A'])!==''){
$vt01A=htmlspecialchars($_POST['vt01A'], ENT_QUOTES);
}else{
$vt01A="";
}
if(isset($_POST['rh01A'])!==''){
$rh01A=trim($_POST['rh01A']);
}else{
$rh01A="";
}
if(isset($_POST['n01A'])!==''){
$n01A=trim($_POST['n01A']);
}else{
$n01A="";
}
if(isset($_POST['relProd_val'])!==''){
$relProd_val=trim($_POST['relProd_val']);
}else{
$relProd_val="";
}
if(isset($_FILES['MyFileA']['name'])!=''){
$MyFileA=trim($_FILES['MyFileA']['name']);

   if(($MyFileA != "none" && $MyFileA != ""))
   {
     $UploadPath = "../../images/";
     $flag = copy($_FILES['MyFileA']['tmp_name'], $UploadPath.$_FILES['MyFileA']['name']);
     if($flag) echo ""; 
     $urlA="./images/";   
   }else{   
     $urlA="";   
   }
}else{
$MyFileA="";
}
   
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");  

if(isset($_POST['url01A'])!=""){
$url01A=trim($_POST['url01A']);
}else{
$url01A="";
}
if(isset($_POST['status01A'])!=''){
$status01A=trim($_POST['status01A']);
}else{
$status01A="";
}

$str_inst="INSERT INTO `sp_memory`(`ID`, `VENDER_NAME`, `MEMORY_SIZE`, `NOTE`, `MEMORY_TYPE`, `CHIP`, `VENDER_NUMBER`, `CHIP_PART_NUMBER`, `MEMORY_FREQUENCE`, `VOLTAGE`, `ROHS`, `LANG`, `MODEL`, `QualifiedCPU`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`) VALUES (".$NCount.",'".$mv01A."','".$sz01A."','".$n01A."','".$tp01A."','".$cv01A."','".$vn01A."','".$pn01A."','".$fq01A."','".$vt01A."','".$rh01A."','en-US','".$relProd_val."',NULL,'webmaster','$now','".$status01A."')";
//echo $str_inst;exit();
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script language='Javascript'>alert('AddNew the Data!');location.href='support_memory.php'</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='update_supmery'){

if(isset($_POST['m_id'])!=''){
$m_id=intval($_POST['m_id']);
}else{
$m_id="";
}
if(isset($_POST['mv01'])!=''){
$mv01=trim($_POST['mv01']);
}else{
$mv01="";
}
if(isset($_POST['sz01'])!=''){
$sz01=trim($_POST['sz01']);
}else{
$sz01="";
}
if(isset($_POST['tp01'])!=''){
$tp01=trim($_POST['tp01']);
}else{
$tp01="";
}
if(isset($_POST['fq01'])!=''){
$fq01=trim($_POST['fq01']);
}else{
$fq01="";
}
if(isset($_POST['cv01'])!=''){
$cv01=trim($_POST['cv01']);
}else{
$cv01="";
}
if(isset($_POST['vn01'])!=''){
$vn01=htmlspecialchars($_POST['vn01'], ENT_QUOTES);
}else{
$vn01="";
}
if(isset($_POST['pn01'])!=''){
$pn01=htmlspecialchars($_POST['pn01'], ENT_QUOTES);
}else{
$pn01="";
}
if(isset($_POST['vt01'])!=''){
$vt01=htmlspecialchars($_POST['vt01'], ENT_QUOTES);
}else{
$vt01="";
}
if(isset($_POST['rh01'])!=''){
$rh01=trim($_POST['rh01']);
}else{
$rh01="";
}
if(isset($_POST['n01E'])!=''){
$n01E=trim($_POST['n01E']);
}else{
$n01E="";
}
if(isset($_POST['relProd_valM'])!=''){
$relProd_valM=trim($_POST['relProd_valM']);
}else{
$relProd_valM="";
}

if(isset($_FILES['MyFile']['name'])!=''){
$MyFile=trim($_FILES['MyFile']['name']);

   if(($MyFile != "none" && $MyFile != ""))
   {
     $UploadPath = "../../images/";
     $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);
     if($flag) echo ""; 
     $url="./images/";   
   }else{   
     $url="";   
   }
}else{
$MyFile="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");  

if(isset($_POST['url01'])!=''){
$url01=trim($_POST['url01']);
}else{
$url01="";
}

if(isset($_POST['status01'])!=''){
$status01=trim($_POST['status01']);
}else{
$status01="";
}

$str_upd="UPDATE `sp_memory` SET `VENDER_NAME`='".$mv01."',`MEMORY_SIZE`='".$sz01."',`NOTE`='".$n01E."',`MEMORY_TYPE`='".$tp01."',`CHIP`='".$cv01."',`VENDER_NUMBER`='".$vn01."',`CHIP_PART_NUMBER`='".$pn01."',`MEMORY_FREQUENCE`='".$fq01."',`VOLTAGE`='".$vt01."',`ROHS`='".$rh01."',`LANG`='en-US',`MODEL`='".$relProd_valM."',`QualifiedCPU`=NULL,`UPDATE_USER`='webmaster',`UPDATE_DATE`='$now',`STATUS`='".$status01."' WHERE `ID`=".$m_id;
//echo $str_upd;exit();
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script language='Javascript'>alert('Update the Data!');location.href='support_memory.php'</script>";
exit();
}
}

if(isset($_REQUEST['act'])!=''){
  if(trim($_REQUEST['act'])=='del'){
  $did=intval($_REQUEST['d_id']);
  if($did!=''){
  $str_del="delete from sp_memory where ID=".$did;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Del the Data !');self.location='support_memory.php';</script>";
  exit();
  }
  }
}

if(isset($_REQUEST['sear'])!=''){
if(trim($_REQUEST['sear'])=='ok'){

  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
    
	if(isset($_REQUEST['M1'])!=''){
    $M1=trim($_REQUEST['M1']);
    }else{
	$M1="";
	}
	if(isset($_REQUEST['SZ1'])!=''){
    $SZ1=trim($_REQUEST['SZ1']);
    }else{
	$SZ1="";
	}
	if(isset($_REQUEST['TY1'])!=''){
    $TY1=trim($_REQUEST['TY1']);
    }else{
	$TY1="";
	}
	if(isset($_REQUEST['FQ1'])!=''){
    $FQ1=trim($_REQUEST['FQ1']);
    }else{
	$FQ1="";
	}
	if(isset($_REQUEST['CV1'])!=''){
    $CV1=trim($_REQUEST['CV1']);
    }else{
	$CV1="";
	}
	
     if($M1<>''){
	 
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME=".$M1." and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."'";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."'";
				  }
			   }
			}
		}
	   
	 }else{
	    
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."'";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."'";
				  }
			   }
			}
		}
		
	 }
	 
  }else{
  
    if(isset($_REQUEST['M1'])!=''){
    $M1=trim($_REQUEST['M1']);
    }else{
	$M1="";
	}
	if(isset($_REQUEST['SZ1'])!=''){
    $SZ1=trim($_REQUEST['SZ1']);
    }else{
	$SZ1="";
	}
	if(isset($_REQUEST['TY1'])!=''){
    $TY1=trim($_REQUEST['TY1']);
    }else{
	$TY1="";
	}
	if(isset($_REQUEST['FQ1'])!=''){
    $FQ1=trim($_REQUEST['FQ1']);
    }else{
	$FQ1="";
	}
	if(isset($_REQUEST['CV1'])!=''){
    $CV1=trim($_REQUEST['CV1']);
    }else{
	$CV1="";
	}
    
     if($M1<>''){
	 
		if($SZ1<>''){
			if($TY1<>'')
			{
			
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			   
			}else{

			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."'";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."'";
				  }
			   }
			}
		}
	   
	 }else{
	    
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."'";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."'";
				  }
			   }
			}else{
			   if($FQ1<>''){			   
				  if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."'";
				  }
			   }else{
			      if($CV1<>''){
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.CHIP='".$CV1."'";
				  }else{
				   $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE";
				  }
			   }
			}
		}
		
	 }

  }
}
}else{
  $str1="SELECT count(*) FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE";  
}
  $list1 =mysqli_query($link_db,$str1);
  list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Memory Lists</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css/css.css" />
	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			//document.getElementById('CMTL01').style.display='none';

			/*
			 *  Simple image gallery. Uses default settings
			 */
			$('.fancybox').fancybox();
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
				closeEffect	: 'none',
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
					buttons	: {}
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
	</script>	
	<script language="JavaScript">
	function MM_o(selObj){
       window.open(document.getElementById('supmemory_page').options[document.getElementById('supmemory_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
    var m1,sz1,ty1,fq1,cv1,st1,m01,sz01,ty01,fq01,cv01,st01
	m1=document.getElementById('M1').value;
	sz1=document.getElementById('SZ1').value;
	ty1=document.getElementById('TY1').value;
	fq1=document.getElementById('FQ1').value;
	cv1=document.getElementById('CV1').value;
	st1=document.getElementById('sear_txt').value;
		
	if(m1!=""){
	m01="&M1=" + m1;
	}else{
	m01="";
	}
	if(sz1!=""){
	sz01="&SZ1=" + sz1;
	}else{
	sz01="";
	}
	if(ty1!=""){
	ty01="&TY1=" + ty1;
	}else{
	ty01="";
	}
	if(fq1!=""){
	fq01="&FQ1=" + fq1;
	}else{
	fq01="";
	}
	if(cv1!=""){
	cv01="&CV1=" + cv1;
	}else{
	cv01="";
	}
	if(st1!=""){
	st01="&s_search=" + st1;
	}else{
	st01="";
	}
	self.location = "?sear=ok" + m01 + sz01 + ty01 + fq01 + cv01 + st01;
		
    return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
		if(confirm('Are you sure you want to search this word?')) {
			search_value();
	    }
     }
    }
	
	function show_add(){
	  $('#spmemry_add').show();
	  $('#spmemry_edit').hide();
	}

	function hiden_add(){
	  self.location = "support_memory.php";
	}
	
	function show_edit(){
	  $('#spmemry_edit').show();
	  $('#spmemry_add').hide();
	}
	
	function hiden_edit(){
	  self.location = "support_memory.php";
	}	
    </script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;TYAN Website Backends - Website Contents Management - Contents: Memory Lists</h1></div>
<div id="logout"><a href="../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<?php
//  menu
include("../../menu.php");
//  menu end
?>
<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Memory Lists</h2> 
</div>
<div id="content">
<br />
<div class="right">| &nbsp;<a href="support_module.php" />Support Lists management</a>&nbsp; | &nbsp;<a href="support_hdd.php" />HDD/SSD Lists</a>&nbsp; | &nbsp;</div>
<br />
<p class="clear">&nbsp;</p>
<h3>Memory Lists:&nbsp;&nbsp;<a class="fancybox fancybox.iframe" href="lb_memory_description.html" /><img src="../../images/icon_edit.png" alt="Edit" /></a>
</h3>

<div class="pagination left">
<form id="form3" name="form3" method="post" action="support_memory.php?sear=ok" onsubmit="return false;">
<p>
<select id="M1" name="M1">
<option value="" selected>Module Vender</option>
<?php
$str_m1="SELECT `ID`, `MODULEVENDER` FROM `c_sp_memory_modulevender` order by `MODULEVENDER` asc";
$m1_result=mysqli_query($link_db,$str_m1);
while($m1_data=mysqli_fetch_row($m1_result)){
?>
<option value="<?=$m1_data[0];?>"><?=$m1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="SZ1" name="SZ1">
<option value="" selected>Size</option>
<?php
$str_s1="SELECT `ID`, `MEMORYSIZE`, `DESCRIPTION`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_memory_size` order by `MEMORYSIZE`";
$s1_result=mysqli_query($link_db,$str_s1);
while($s1_data=mysqli_fetch_row($s1_result)){
?>
<option value="<?=$s1_data[0];?>"><?=$s1_data[2];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="TY1" name="TY1">
<option value="" selected>Type</option>
<?php
$str_t1="SELECT `ID`, `MEMORYTYPE` FROM `c_sp_memory_type`";
$t1_result=mysqli_query($link_db,$str_t1);
while($t1_data=mysqli_fetch_row($t1_result)){
?>
<option value="<?=$t1_data[1];?>"><?=$t1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="FQ1" name="FQ1">
<option value="" selected>Frequence</option>
<?php
$str_f1="SELECT `ID`, `FREQUENCE` FROM `c_sp_memory_frequence`";
$f1_result=mysqli_query($link_db,$str_f1);
while($f1_data=mysqli_fetch_row($f1_result)){
?>
<option value="<?=$f1_data[1];?>"><?=$f1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<select id="CV1" name="CV1">
<option value="" selected>Chipset Vendor</option>
<?php
$str_v1="SELECT `ID`, `CHIPVENDER` FROM `c_sp_memory_chipvender`";
$v1_result=mysqli_query($link_db,$str_v1);
while($v1_data=mysqli_fetch_row($v1_result)){
?>
<option value="<?=$v1_data[1];?>"><?=$v1_data[1];?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
 <input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" />  <span style="color:#0F0">**Key word search: "Vender Number" & "Part Number" & "Compatible Products" 欄位 </span> </p>
</form>
 <p>Total: <span class="w14bblue"><?=$public_count;?></span> records </p>
</div>
<table class="list_table">
  <tr>
    <th >*Module Vendor <a class="fancybox fancybox.iframe" href="lb_module_vender.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>*Size <a class="fancybox fancybox.iframe" href="lb_memory_size.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>*Type <a class="fancybox fancybox.iframe" href="lb_memory_type.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>*Frequence <a class="fancybox fancybox.iframe" href="lb_memory_frequency.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>*Chipset Vendor <a class="fancybox fancybox.iframe" href="lb_chipset_vender.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>Vender Number</th><th>Part Number</th><th>*Status</th><th>Compatible Products</th><th><div class="button14"><a href="#spmemry_add" style="width:50px;" onClick="show_add();">Add</a></div></th>
  </tr>
  <?php
      if(isset($_REQUEST['page'])!=""){
      $page=intval($_REQUEST['page']);
      }else{
      $page="1";
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1); 
      
if(isset($_REQUEST['sear'])!=''){
if(trim($_REQUEST['sear'])=='ok'){
  
  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  if(isset($_REQUEST['M1'])!=''){
  $M1=trim($_REQUEST['M1']);
  }else{
  $M1="";
  }
  if(isset($_REQUEST['SZ1'])!=''){
  $SZ1=trim($_REQUEST['SZ1']);
  }else{
  $SZ1="";
  }
  if(isset($_REQUEST['TY1'])!=''){
  $TY1=trim($_REQUEST['TY1']);
  }else{
  $TY1="";
  }
  if(isset($_REQUEST['FQ1'])!=''){
  $FQ1=trim($_REQUEST['FQ1']);
  }else{
  $FQ1="";
  }
  if(isset($_REQUEST['CV1'])!=''){
  $CV1=trim($_REQUEST['CV1']);
  }else{
  $CV1="";
  }
  
     if($M1<>''){
	 
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME=".$M1." and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}
	   
	 }else{
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}else{
			
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.CHIP='".$CV1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}
		$str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where (A.VENDER_NUMBER='".$s_search."' or CHIP_PART_NUMBER='".$s_search."') ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
	 }
	 
  }else{
   if(isset($_REQUEST['M1'])!=''){
   $M1=trim($_REQUEST['M1']);
   }else{
   $M1="";
   }
   if(isset($_REQUEST['SZ1'])!=''){
   $SZ1=trim($_REQUEST['SZ1']);
   }else{
   $SZ1="";
   }
   if(isset($_REQUEST['TY1'])!=''){
   $TY1=trim($_REQUEST['TY1']);
   }else{
   $TY1="";
   }
   if(isset($_REQUEST['FQ1'])!=''){
   $FQ1=trim($_REQUEST['FQ1']);
   }else{
   $FQ1="";
   }
   if(isset($_REQUEST['CV1'])!=''){
   $CV1=$_REQUEST['CV1'];
   }else{
   $CV1="";
   }
    
     if($M1<>''){
	 
		if($SZ1<>''){
			if($TY1<>'')
			{
			
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			   
			}else{

			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and D.ID='".$SZ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_TYPE='".$TY1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.VENDER_NAME='".$M1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}
	   
	 }else{
	    
		if($SZ1<>''){
			if($TY1<>'')
			{
			   if($FQ1<>'')
			   {
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
				  
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_TYPE='".$TY1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			   
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where D.ID='".$SZ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}else{
		    if($TY1<>''){
			
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_TYPE='".$TY1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}else{
			   if($FQ1<>'')
			   {
				  if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' and A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.MEMORY_FREQUENCE='".$FQ1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }else{
			      if($CV1<>''){
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE where A.CHIP='".$CV1."' ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }else{
				   $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";
				  }
			   }
			}
		}
		
	 }

  }
}
}else{
  $str="SELECT A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, A.ICON, A.URL, A.MEMORYSIZE, A.MODULEVENDER, A.STATUS, A.UPDATE_DATE from (Select A.ID, A.VENDER_NAME, A.MEMORY_SIZE, A.VOLTAGE, A.NOTE, A.MEMORY_TYPE, A.CHIP, A.VENDER_NUMBER, A.CHIP_PART_NUMBER, A.MEMORY_FREQUENCE, A.AMB, A.ROHS, A.MODEL, A.QualifiedCPU, B.ICON, B.URL, D.MEMORYSIZE, B.MODULEVENDER, A.STATUS, A.UPDATE_DATE FROM sp_memory AS A INNER JOIN c_sp_memory_modulevender AS B ON A.VENDER_NAME = B.ID INNER JOIN c_sp_memory_frequence AS C ON A.MEMORY_FREQUENCE = C.FREQUENCE INNER JOIN c_sp_memory_size AS D ON A.MEMORY_SIZE = D.MEMORYSIZE) A ORDER BY A.UPDATE_DATE desc limit $start_num,$read_num;";  
}

      $result=mysqli_query($link_db,$str);
      $i=0;
	  while(list($ID,$VENDER_NAME, $MEMORY_SIZE, $VOLTAGE, $NOTE, $MEMORY_TYPE, $CHIP, $VENDER_NUMBER, $CHIP_PART_NUMBER, $MEMORY_FREQUENCE, $AMB, $ROHS, $MODEL, $QualifiedCPU, $ICON, $URL, $SIZE, $MODULEVENDER, $STATUS, $UPDATE_DATE)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><?=$MODULEVENDER;?></td><td><?=$SIZE;?></td><td ><?=$MEMORY_TYPE;?></td><td ><?=$MEMORY_FREQUENCE;?></td><td ><?=$CHIP;?></td><td ><?=$VENDER_NUMBER;?></td><td ><?=$CHIP_PART_NUMBER;?></td><td ><?php if(trim($STATUS)=='1'){ echo "Enabled"; }else if(trim($STATUS)=='0'){ echo "Disabled"; } ?></td>
	<td >
	<?php
	/*
	$mdl=explode(',',$MODEL,-1);
	echo count($mdl)."<br />";
	if(count($mdl)<4){
	$br="";
	}else if(count($mdl)>=4){
	  if(count($mdl)%4==0){
	  $br="<br />";
	  }else{
	  $br="";
	  }
	}
	*/
	$u=0;$br="";
	$mdl=explode(',',$MODEL,-1);
	for($m=0;$m<=count($mdl)-1;$m++){
	$u+=1;
	 if($u>3){
	  if($u%4==0){
	  $br="<br />";
	  }else{
	  $br="";
	  }
	 }else if($u<4){
	 $br="";
	 }
	echo $mdl[$m].",".$br;
	}
	
	?></td>
	<td ><a href="support_memory.php?mid=<?=$ID;?>#spmemry_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
	  }
  ?>
  <tr>
    <td colspan="10">
    <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
    ?>
    </td>
  </tr>
</table>
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="supmemory_page" name="supmemory_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>

  <P style="color:#0F0">
  - 資料由舊系統dump: http://www.tyan.com/TYANWEBMGT/support_memory.aspx<br>
  - "Status" 決定這個 memory 是否會出現在被套用的 SKU page 上的 "Support Memory Lists" 中 <br >
- "Compatible Products"只列最新的三筆 SKU <br>- click "Del" 要popup a confirmation window to proceed<br >
    - * 表可sorting<br >- List順序:新至舊
  </p>
<p class="clear">&nbsp;</p>
<!--Click Edit and add -->							
<div id="spmemry_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_supmery" enctype="multipart/form-data" onsubmit="return Final_Check();">
<h1>Add a Memory:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Module Vendor:  </th>
<td>
<select id="mv01A" name="mv01A">
<option value="" selected>Select</option>
<?php
$str_m="SELECT `ID`, `MODULEVENDER`, `URL`, `ICON` FROM `c_sp_memory_modulevender` where `STATUS`='1'";
$m_result=mysqli_query($link_db,$str_m);
while($mdata=mysqli_fetch_array($m_result)){
?>
<option value="<?=$mdata[0];?>"><?=$mdata[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Size: </th>
<td>
<select id="sz01A" name="sz01A">
<option value="" selected>Select</option>
<?php
$str_s="SELECT `ID`, `MEMORYSIZE`, `DESCRIPTION` FROM `c_sp_memory_size` where `STATUS`='1' order by `MEMORYSIZE`";
$s_result=mysqli_query($link_db,$str_s);
while($sdata=mysqli_fetch_row($s_result)){
?>
<option value="<?=$sdata[1];?>"><?=$sdata[2];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Type:</th>
<td>
<select id="tp01A" name="tp01A">
<option selected>Select</option>
<?php
$str_tp="SELECT `ID`, `MEMORYTYPE` FROM `c_sp_memory_type` where `STATUS`='1'";
$tp_result=mysqli_query($link_db,$str_tp);
while($tp_data=mysqli_fetch_row($tp_result)){
?>
<option value="<?=$tp_data[1];?>"><?=$tp_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Frequence: </th>
<td>
<select id="fq01A" name="fq01A">
<option value="" selected>Select</option>
<?php
$str_fq="SELECT `ID`, `FREQUENCE` FROM `c_sp_memory_frequence` where `STATUS`='1'";
$fq_result=mysqli_query($link_db,$str_fq);
while($fq_data=mysqli_fetch_row($fq_result)){
?>
<option value="<?=$fq_data[1];?>"><?=$fq_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Chipset Vendor:  </th>
<td>
<select id="cv01A" name="cv01A">
<option value="" selected>Select</option>
<?php
$str_cv="SELECT `ID`, `CHIPVENDER` FROM `c_sp_memory_chipvender` where `STATUS`='1'";
$cv_result=mysqli_query($link_db,$str_cv);
while($cv_data=mysqli_fetch_row($cv_result)){
?>
<option value="<?=$cv_data[1];?>"><?=$cv_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Vender Number: </th>
<td><input id="vn01A" name="vn01A" type="text" size="30" value="" /></td>
</tr>
<tr>
<th>Part Number: </th>
<td><input id="pn01A" name="pn01A" type="text" size="30" value="" /></td>
</tr>
<tr>
<th>VOLTAGE: </th>
<td><input id="vt01A" name="vt01A" type="text" size="30" value="" /></td>
</tr>
<tr>
<th>ROHS: </th>
<td>
<select id="rh01A" name="rh01A">
<option value="1" selected>Yes</option>
<option value="0">No</option>
</select>
</td>
</tr>
<tr>
<th>Note: </th>
<td><textarea cols="100" id="n01A" name="n01A" rows="10"></textarea></td>
</tr>
<tr>
<th>Compatible Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_supported_pros.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr id="CMTL01" style="display:none;">
<th><input type="checkbox" name="" value=""> CMTL:  </th>
<td>Image: <input type="file" id="MyFileA" name="MyFileA" size="30" /><br />
URL: <input id="url01A" name="url01A" type="text" size="40" value=""  />
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01A" name="status01A"><option value="1" selected>Enabled</option><option value="0">Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input name="b2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_memory.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check( ) {
if(document.form1.mv01A.value == ""){
alert("Required select Module Vendor！");
document.form1.mv01A.focus();
return false;
}

if(document.form1.sz01A.value == ""){
alert("Required select Size！");
document.form1.sz01A.focus();
return false;
}

if(document.form1.tp01A.value == ""){
alert("Required select Type！");
document.form1.tp01A.focus();
return false;
}

if(document.form1.fq01A.value == ""){
alert("Required select Frequence！");
document.form1.fq01A.focus();
return false;
}

if(document.form1.cv01A.value == ""){
alert("Required select Chipset Vendor！");
document.form1.cv01A.focus();
return false;
}

if(document.form1.vn01A.value == ""){
alert("Required input Vender Number！");
document.form1.vn01A.focus();
return false;
}
/*
if(document.form1.pn01A.value == ""){
alert("Required input Part Number！");
document.form1.pn01A.focus();
return false;
}
*/
if(document.form1.vt01A.value == ""){
alert("Required input VOLTAGE！");
document.form1.vt01A.focus();
return false;
}

/*
if(document.form1.n01A.value == ""){
alert("Required input Note！");
document.form1.n01A.focus();
return false;
}
*/

if(document.form1.relProd_val.value == ""){
alert("Required Input a Related Products！");
document.form1.relProd_val.focus();
return false;
}
/*
if(document.form1.MyFileA.value == ""){
alert("Please select To upload large image！");
document.form1.MyFileA.focus();
return false;
}

if(document.form1.url01A.value == ""){
alert("Required input a URL！");
document.form1.url01A.focus();
return false;
}
*/
return true;
}
</script>
</div>
<?php
if(isset($_REQUEST['mid'])!=''){

$mid01=intval($_REQUEST['mid']);
$str_mi="SELECT `ID`, `VENDER_NAME`, `MEMORY_SIZE`, `NOTE`, `MEMORY_TYPE`, `CHIP`, `VENDER_NUMBER`, `CHIP_PART_NUMBER`, `MEMORY_FREQUENCE`, `NAME`, `AMB`, `VOLTAGE`, `ROHS`, `LANG`, `MODEL`, `QualifiedCPU`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `sp_memory` where `ID`=".$mid01;
$mi_result=mysqli_query($link_db,$str_mi);
$midata=mysqli_fetch_row($mi_result);
?>
<div id="spmemry_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=update_supmery" enctype="multipart/form-data" onsubmit="return MFinal_Check();">
<h1>Edit a Memory:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Module Vendor:  </th>
<td>
<select id="mv01" name="mv01">
<option value="" selected>Select</option>
<?php
$str_m="SELECT `ID`, `MODULEVENDER`, `URL`, `ICON` FROM `c_sp_memory_modulevender` where `STATUS`='1'";
$m_result=mysqli_query($link_db,$str_m);
while($mdata=mysqli_fetch_array($m_result)){
?>
<option value="<?=$mdata[0];?>" <?php if($midata[1]==$mdata[0]){ echo "selected"; } ?>><?=$mdata[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Size: </th>
<td>
<select id="sz01" name="sz01">
<option value="" selected>Select</option>
<?php
$str_s="SELECT `ID`, `MEMORYSIZE`, `DESCRIPTION` FROM `c_sp_memory_size` where `STATUS`='1' order by `MEMORYSIZE`";
$s_result=mysqli_query($link_db,$str_s);
while($sdata=mysqli_fetch_row($s_result)){
?>
<option value="<?=$sdata[1];?>" <?php if($midata[2]==$sdata[1]){ echo "selected"; } ?>><?=$sdata[2];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Type:</th>
<td>
<select id="tp01" name="tp01">
<option selected>Select</option>
<?php
$str_tp="SELECT `ID`, `MEMORYTYPE` FROM `c_sp_memory_type` where `STATUS`='1'";
$tp_result=mysqli_query($link_db,$str_tp);
while($tp_data=mysqli_fetch_row($tp_result)){
?>
<option value="<?=$tp_data[1];?>" <?php if($midata[4]==$tp_data[1]){ echo "selected"; } ?>><?=$tp_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Frequence: </th>
<td>
<select id="fq01" name="fq01">
<option value="" selected>Select</option>
<?php
$str_fq="SELECT `ID`, `FREQUENCE` FROM `c_sp_memory_frequence` where `STATUS`='1'";
$fq_result=mysqli_query($link_db,$str_fq);
while($fq_data=mysqli_fetch_row($fq_result)){
?>
<option value="<?=$fq_data[1];?>" <?php if($midata[8]==$fq_data[1]){ echo "selected"; } ?>><?=$fq_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Chipset Vendor:  </th>
<td>
<select id="cv01" name="cv01">
<option value="" selected>Select</option>
<?php
$str_cv="SELECT `ID`, `CHIPVENDER` FROM `c_sp_memory_chipvender` where `STATUS`='1'";
$cv_result=mysqli_query($link_db,$str_cv);
while($cv_data=mysqli_fetch_row($cv_result)){
?>
<option value="<?=$cv_data[1];?>" <?php if($midata[5]==$cv_data[1]){ echo "selected"; } ?>><?=$cv_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Vender Number: </th>
<td><input id="vn01" name="vn01" type="text" size="30" value="<?=$midata[6];?>" /></td>
</tr>
<tr>
<th>Part Number: </th>
<td><input id="pn01" name="pn01" type="text" size="30" value="<?=$midata[7];?>" /></td>
</tr>
<tr>
<th>VOLTAGE: </th>
<td><input id="vt01" name="vt01" type="text" size="30" value="<?=$midata[11];?>" /></td>
</tr>
<tr>
<th>ROHS: </th>
<td>
<select id="rh01" name="rh01">
<option value="1" <?php if($midata[12]==1){ echo "selected"; } ?>>Yes</option>
<option value="0" <?php if($midata[12]=='0'){ echo "selected"; } ?>>No</option>
</select>
</td>
</tr>
<tr>
<th>Note: </th>
<td><textarea cols="100" id="n01E" name="n01E" rows="10"><?=$midata[3];?></textarea></td>
</tr>
<tr>
<th>Compatible Products:</th>
<td> <div class="button14 " style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_memolist_pros.php?cid=<?=$midata[0];?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$midata[14];?></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr id="CMTL01M" style="display:none;">
<th><input type="checkbox" name="" value=""> CMTL:  </th>
<td>Image: <input type="file" id="MyFile" name="MyFile" size="30" /><br />
URL: <input id="url01" name="url01" type="text" size="40" value=""  />
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01" name="status01"><option value="1" <?php if($midata[18]=="1"){ echo "selected"; } ?>>Enabled</option><option value="0" <?php if($midata[18]=="0"){ echo "selected"; } ?>>Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input id="m_id" name="m_id" type="hidden" value="<?=$midata[0];?>"><input name="b3" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c3" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_memory.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function MFinal_Check( ) {
if(document.form2.mv01.value == ""){
alert("Required select Module Vendor！");
document.form2.mv01.focus();
return false;
}

if(document.form2.sz01.value == ""){
alert("Required select Size！");
document.form2.sz01.focus();
return false;
}

if(document.form2.tp01.value == ""){
alert("Required select Type！");
document.form2.tp01.focus();
return false;
}

if(document.form2.fq01.value == ""){
alert("Required select Frequence！");
document.form2.fq01.focus();
return false;
}

if(document.form2.cv01.value == ""){
alert("Required select Chipset Vendor！");
document.form2.cv01.focus();
return false;
}

if(document.form2.vn01.value == ""){
alert("Required input Vender Number！");
document.form2.vn01.focus();
return false;
}

if(document.form2.pn01.value == ""){
alert("Required input Part Number！");
document.form2.pn01.focus();
return false;
}

if(document.form2.vt01.value == ""){
alert("Required input VOLTAGE！");
document.form2.vt01.focus();
return false;
}

/*
if(document.form2.n01.value == ""){
alert("Required input Note！");
document.form2.n01.focus();
return false;
}
*/

if(document.form2.relProd_valM.value == ""){
alert("Required Input a Related Products！");
document.form2.relProd_valM.focus();
return false;
}
/*
if(document.form2.MyFile.value == ""){
alert("Please select To upload large image！");
document.form2.MyFile.focus();
return false;
}

if(document.form2.url01A.value == ""){
alert("Required input a URL！");
document.form2.url01A.focus();
return false;
}
*/
return true;
}
</script>
</div>
<?php
}
?>
<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>

<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'n01A', {
    });
</script>
<script>
  CKEDITOR.replace( 'n01E', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
 echo "<script>show_edit();</script>\n";
 exit();
}
?>