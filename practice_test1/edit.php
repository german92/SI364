<?php
require_once "pdo.php";
session_start();


if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}

if ( isset($_POST['url']) && isset($_POST['email']) 
     && isset($_POST['length']) && isset($_POST['rating']) && isset($_POST['id']) ) {
       
    if (empty($_POST['url']) || empty($_POST['email']) || empty($_POST['length']) || empty($_POST['rating']) ) {

      $_SESSION['error'] = 'All values are required';
      header( 'Location: edit.php' );
    }

    elseif ((!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) || (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) || !is_numeric($_POST['length']) || !is_numeric($_POST['rating'])) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: edit.php' );
    }
    else {
    $sql = "UPDATE videos SET url = :url, 
            email = :email, length = :length, rating = :rating
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':url' => $_POST['url'],
	':email' => $_POST['email'],
	':length' => $_POST['length'],
	':rating' => $_POST['rating'],
        ':id' => $_POST['id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
    }
}


$stmt = $pdo->prepare("SELECT * FROM videos where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

$u = htmlentities($row['url']);
$e = htmlentities($row['email']);
$l = htmlentities($row['length']);
$r = htmlentities($row['rating']);
$id = htmlentities($row['id']);

echo <<< _END
<p>Edit User</p>
<form method="post">
<p>Url:
<input type="text" name="url" value="$u"></p>
<p>Email:
<input type="text" name="email" value="$e"></p>
<p>Length:
<input type="text" name="length" value="$l"></p>
<p>Rating:
<input type="text" name="rating" value="$r"></p>
<input type="hidden" name="id" value="$id">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
_END
?>

