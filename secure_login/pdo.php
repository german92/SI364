<?php
try
{
$pdo = new PDO('mysql:host=localhost;dbname=secure_login', 
   'sec_user', 'eKcGZr59zAa2BEWU');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $ex)
{die($ex->getMessage());}
?>