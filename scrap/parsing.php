<?php
echo "Still working";
/*$con=mysqli_connect("http://engineerinme.com","root","kgggdkp2692","peerhack");
if (mysqli_connect_errno($con)){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/

require ("simple_html_dom.php");
$market=array("Lajpat-Nagar","Chandni-Chowk");
$keyword=array("Cloth-shops","restaurant",);
$html = file_get_html('http://www.justdial.com/Delhi-NCR/'.$keyword[0].'%3Cnear%3E-'.$market[0]);
echo $html;
//mysqli_close($con);*/



 ?>


