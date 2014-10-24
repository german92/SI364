<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
  <title>German Ostaszynski Lipiec</title>
</head>
<body>
<?php
if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
  echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
  unset($_SESSION['success']);
}
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT make, model, year, miles, price, id FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  echo "<tr><td>";
  echo(htmlentities($row['make']));
  echo("</td><td>");
  echo(htmlentities($row['model']));
  echo("</td><td>");
  echo(htmlentities($row['year']));
  echo("</td><td>");
  echo(htmlentities($row['miles']));
  echo("</td><td>");
  echo(htmlentities($row['price']));
  echo("</td><td>");
  echo('<a href="edit.php?id='.htmlentities($row['id']).'">Edit</a> / ');
  echo('<a href="delete.php?id='.htmlentities($row['id']).'">Delete</a>');
  echo("</td></tr>\n");
}
?>
<a href="add.php">Add New</a>
</body>
</html>
