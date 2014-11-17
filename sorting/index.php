<?php
require_once "pdo.php";
session_start();
?>


<!DOCTYPE html>
<html>
  <head>
    <title>German Ostaszynski Lipiec Sorting Assigment</title>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="jquery-latest.js"></script> 
<script type="text/javascript" src="jquery.tablesorter.js"></script> 

  </head>

  <body>
    <h2>Welcome to German's Sorting Assigment (hw9)</h2>
    <table id="myTable" class="tablesorter" >
      <thead>
      <tr>
	<th>STUDENT NAME</th>
	<th>STUDENT ID</th>
	<th>COLLEGE NAME</th>
	<th>MAJOR</th>
      </tr>
      </thead>
      <tbody>
      <?php

      //Declares statement ($stmt) to retrieve information from database
      $stmt = $pdo->query("SELECT Student.sID, sName, Apply.cName, major 
			   FROM Student, College, Apply
		           WHERE Student.sID = apply.sID AND College.cName = Apply.cName 
			   ORDER BY sName");

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	//Outputs student names
	echo("<tr><td>");
	echo($row['sName']);
	echo("</td>");

	//Outputs student ID's
	echo("<td>");
	echo($row['sID']);
	echo("</td>");

	//Outputs college names
	echo("<td>");
	echo($row['cName']);
	echo("</td>");

	//Outputs majors
	echo("<td>");
	echo($row['major']);
	echo("</td></tr>\n");
      }
?>
    </tbody>
    </table>

  </body>
  <script>

    $(document).ready(function() 
      { 
	      $("#myTable").tablesorter( {
          headers: {1: {
            sorter: false
            } 
          } 
        } ); 
      } 
    );
  </script>  

</html>

