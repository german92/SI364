<html>
    <head>
    <title>
      Guessing Game for German Ostaszynski Lipiec
    </title>
  </head>
  <body>
    <h1> Welcome to my guessing game!</h1>
    <p>
      <?php
	if ( ! isset($_GET['guess'])) {
	  echo("Missing guess parameters");
	}
	elseif ($_GET['guess'] == 0) {
	  echo("Your guess is not valid"); 
	}
	elseif ($_GET['guess'] > 42) {
	  echo("Your guess is too high");
	}
	elseif($_GET['guess'] < 42) {
	  echo("Your guess is too low");
	}
	else {
	  echo("Congratulations - You are right");
	}
      ?>
    </p>
  </body>
</html>
