<?php
/*------------------------------------
  [ Date ] : 8/382019
  [ Author ] : Muhammad Alaraby.
  [ Info ] : Home page.
--------------------------------------
*/
?>
<?php
ob_start();
session_start();

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "socail";

foreach($db as $key => $value){
    define(strtoupper($key), $value);

}
$connectToDatabase = mysqli_connect(DB_HOST, DB_USER,DB_PASS, DB_NAME);

 if (mysqli_connect_errno()){
     echo "failed to conncect". mysqli_connect_errno();
 } else {
     $query = "SET NAMES utf-8";
     mysqli_query($connectToDatabase, $query);
 }


 //$query = mysqli_query($connectToDatabase,"INSERT INTO `test` (`id`, `name`) VALUES (NULL, 'Martin');");
?>