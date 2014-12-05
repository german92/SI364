<?php
include_once 'psl-config.php';   // As functions.php is not included
/*$pdo = new PDO('mysql:host=50.62.209.7:3306;port=8889;dbname=secure_login','sec_user', 'eKcGZr59zAa2BEWU');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
try
{
$pdo = new PDO('mysql:host=localhost;dbname=secure_login', 
   'sec_user', 'eKcGZr59zAa2BEWU');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $ex)
{die($ex->getMessage());}
?>