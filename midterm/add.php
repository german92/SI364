<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) 
  && isset($_POST['year']) && isset($_POST['miles']) && isset($_POST['price'])) {
    
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
      $sql = "INSERT INTO autos (make, model, year, miles, price) 
	VALUES (:make, :model, :year, :miles, :price)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
	':make' => $_POST['make'],
	':model' => $_POST['model'],
	':year' => $_POST['year'],
	':miles' => $_POST['miles'],
	':price' => $_POST['price']));
      $_SESSION['success'] = 'Record added';
      header( 'Location: index.php' ) ;
      return;
    }
  }
?>
<p>Add A New Car</p>
<form method="post">
<p>Make:
<input type="text" name="make"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Miles:
<input type="text" name="miles"></p>
<p>Price:
<input type="text" name="price"></p>
<p><input type="submit" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>

