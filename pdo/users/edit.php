<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['title']) && isset($_POST['plays']) 
     && isset($_POST['rating']) && isset($_GET['id']) ) {
           if (empty($_POST['title']) || !is_numeric($_POST['plays']) || !is_numeric($_POST['rating'])) {
      $_SESSION['error'] = 'Bad value for title, plays, or rating';
      header( 'Location: index.php' ) ;
      return;
    }
    else { 
    $sql = "UPDATE tracks SET title = :title, 
            plays = :plays, rating = :rating
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':title' => $_POST['title'],
        ':plays' => $_POST['plays'],
        ':rating' => $_POST['rating'],
        ':id' => $_GET['id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM tracks where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

$n = htmlentities($row['title']);
$e = htmlentities($row['plays']);
$p = htmlentities($row['rating']);
$id = htmlentities($row['id']);

echo <<< _END
<p>Edit Track</p>
<form method="post">
<p>Title:
<input type="text" name="title" value="$n"></p>
<p>Play:
<input type="text" name="plays" value="$e"></p>
<p>Rating:
<input type="text" name="rating" value="$p"></p>
<input type="hidden" title="id" value="$id">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
_END
?>

