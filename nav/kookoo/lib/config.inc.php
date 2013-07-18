<?php
#set_time_limit(0);
error_reporting(E_ALL  & ~E_NOTICE & ~E_DEPRECATED);

$con=mysqli_connect("engineerinme.com","root","kgggdkp2692","peerhack");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: ";
  die();
  }
else
{
echo "connected";
}
?>
