<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['title']) && isset($_POST['plays']) 
  && isset($_POST['rating'])) {

    if (empty($_POST['title']) || !is_numeric($_POST['plays']) || !is_numeric($_POST['rating'])) {
      $_SESSION['error'] = 'Bad value for title, plays, or rating';
      header( 'Location: index.php' ) ;
      return;
    }
    else {
      $sql = "INSERT INTO tracks (title, plays, rating) 
	VALUES (:title, :plays, :rating)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':title' => $_POST['title'],
	':plays' => $_POST['plays'],
	':rating' => $_POST['rating']));
      $_SESSION['success'] = 'Record Added';
      header( 'Location: index.php' ) ;
      return;
    }
  }
?>
<p>Add A New Track</p>
<form method="post">
<p>Title:
<input type="text" name="title"></p>
<p>Plays:
<input type="text" name="plays"></p>
<p>Rating:
<input type="text" name="rating"></p>
<p><input type="submit" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>

