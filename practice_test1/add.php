<?php
require_once "pdo.php";
session_start();


if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}

if ( isset($_POST['url']) && isset($_POST['email']) 
  && isset($_POST['length']) && isset($_POST['rating'])) {
    if (empty($_POST['url']) || empty($_POST['email']) || empty($_POST['length']) || empty($_POST['rating']) ) {

      $_SESSION['error'] = 'All values are required';
      header( 'Location: add.php' );
    }
    elseif ((!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) || (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) || !is_numeric($_POST['length']) || !is_numeric($_POST['rating'])) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: add.php' );
    }
    else {
      $sql = "INSERT INTO videos (url, email, length, rating) 
	VALUES (:url, :email, :length, :rating)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':url' => $_POST['url'],
	':email' => $_POST['email'],
	':length' => $_POST['length'],
	':rating' => $_POST['rating']));
      $_SESSION['success'] = 'Record added';
      header( 'Location: index.php' ) ;
      return;
    }
  }
?>
<p>Add A New Video </p>
<form method="post">
<p>Url:
<input type="text" name="url"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Length:
<input type="text" name="length"></p>
<p>Rating:
<input type="text" name="rating"></p>
<p><input type="submit" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>

