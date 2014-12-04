<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}


function login($email, $password, $pdo) {
    // Using prepared statements means that SQL injection is not possible. 
    $stmt = $pdo->prepare("SELECT id, username, password, salt 
			   FROM members
			   WHERE email = :email
			   LIMIT 1"); 
      $stmt->execute(array(':email' => $email));    // Execute the prepared query.
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row !== false) {
        // hash the password with the unique salt.
        $db_password = hash('sha512', $password . $row['salt']);
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $row['password']) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $row['id']);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $row['username']);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
		    $id = $row['id'];
                    $sql->query("INSERT INTO login_attempts(user_id, time)
		      VALUES ($id, $now)");
		    $stmt = $pdo->prepare('$sql');
		    $stmt->execute();
                    return false;
                }
        } else {
            // No user exists.
            return false;
    }
}


function login_check($pdo) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
	$sql = "SELECT password
		FROM members
		WHERE id = :id LIMIT 1";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':id' => $user_id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($row != false) {
	  
                $login_check = hash('sha512', $row['password'] . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } 
        else {
	  // Not logged in
	  echo("Not logged in..."); 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}




