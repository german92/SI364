<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) 
     && isset($_POST['year']) && isset($_POST['miles']) && (isset($_POST['price'])) && isset($_POST['id']) ) {
       
    //Check if fields are empty
    if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['miles']) || empty($_POST['price']) ) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: index.php' ) ;
      return;
    }
    //Check if year miles and price fields are numeric
    elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['miles']) || !is_numeric($_POST['price'])) {
      $_SESSION['error'] = 'Error in input data';
      header( 'Location: index.php' ) ;
      return;
    }
    else {
    $sql = "UPDATE autos SET make = :make, 
            model = :model, year = :year, miles = :miles, price = :price
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
	':model' => $_POST['model'],
	':year' => $_POST['year'],
	':miles' => $_POST['miles'],
	':price' => $_POST['price'],
        ':id' => $_POST['id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
    }
}


$stmt = $pdo->prepare("SELECT * FROM autos where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['miles']);
$p = htmlentities($row['price']);
$id = htmlentities($row['id']);

echo <<< _END
<p>Edit Auto</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="$ma"></p>
<p>Model:
<input type="text" name="model" value="$mo"></p>
<p>Year:
<input type="text" name="year" value="$y"></p>
<p>Miles:
<input type="text" name="miles" value="$mi"></p>
<p>Price:
<input type="text" name="price" value="$p"></p>
<input type="hidden" name="id" value="$id">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
_END
?>

