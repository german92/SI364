<?php
include_once 'psl-config.php';   // As functions.php is not included
//$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);


$pdo = new PDO('mysql:host=localhost;port=8888;dbname=secure_login', 
   'root', 'root');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



