<?php
require_once "pdo.php";
session_start();


if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}

if ( isset($_POST['url']) && isset($_POST['email']) 
  && isset($_POST['length']) && isset($_POST['rating'])) {

    //Check if fields are empty
    if (empty($_POST['url']) || empty($_POST['email']) || empty($_POST['length']) || empty($_POST['rating']) ) {
      $_SESSION['error'] = 'All values are required';
      header( 'Location: add.php' );
      return;
    }
    //Check if URL starts with https:// or http://
    elseif ( (strpos($_POST['url'], 'http://') === FALSE) && (strpos($_POST['url'], 'https://') === FALSE ) )  {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: add.php' );
      return;
    }
    //Check if email have a @
    elseif (strpos($_POST['email'], '@') === FALSE) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: add.php' );
      return;
    }
    //Check if ratings and length are numeric
    elseif (!is_numeric($_POST['length']) || !is_numeric($_POST['rating'])) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: add.php' );
      return;
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

