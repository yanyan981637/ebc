<?php  
function country($str)
{      
  $str = str_replace("NA","North America",$str);
  $str = str_replace("SA","Central / South America",$str);
  $str = str_replace("EUR","Europe",$str);
  $str = str_replace("ME","Middle East / Africa",$str);
  $str = str_replace("ASIA","Asia",$str);
  $str = str_replace("Oceania","Oceania",$str);
  return $str;
}
?>