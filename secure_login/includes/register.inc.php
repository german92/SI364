<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
session_start();
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
        
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $sql = "SELECT id FROM members WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':email' => $_POST['email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
   // check existing email  
    
 
        if ($row != false) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
           
                        //$stmt->close();
        }
               
 
    // check existing username
    $sql = "SELECT id FROM members WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':username' => $_POST['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
   // check existing email  
    
 
        if ($row != false) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this username already exists.</p>';

            $_SESSION["error"] = "A user with this username already exists.";
            //unset($_SESSION["error"]);
                        //$stmt->close();
        }
               
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
    //console.log("Testing");
    if (empty($error_msg)) {
        //console.log("Testing");
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Inse""rt the new user into the database 
        $sql = "INSERT INTO members (username, email, password, salt) VALUES (:username, :email, :password, :salt)";
        $stmt = $pdo->prepare($sql);

            // Execute the prepared query.
            if (!$stmt->execute(array(':username' => $_POST['username'],
                                    ':email' => $_POST['email'],
                                    ':password' => $password,
                
                                    ':salt' => $random_salt))) { 
                if(window.console && window.console.log){
                console.log("Didn't insert");
                }
                
                header('Location: ../error.php?err=Registration failure: INSERT');
                
                //header('Location: ../error.php?err=Registration failure: INSERT');  
            }
        
        header('Location: ./register_success.php');
    }
}