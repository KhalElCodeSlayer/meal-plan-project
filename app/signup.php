<?php session_start();
require 'dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP3161 Project</title>
    <link href="css/signup.css" type="text/css" rel="stylesheet" />
  </head>
  <body>
  <header>
        <nav class="navbar">
            
              <ul class="active">
                <li>
                  <a class="" href="index.php">Home</a>
                </li>
                <li>
                    <a class="" href="search.php">Recipe Search </a>
                </li>
                <li>
                  <a class="" href="signupform.php">Sign Up User</a>
                </li>
                <li class="logout">
                  <a class="" href="logout.php">Logout</a>
                </li>
                  
              </ul>

          </nav>
    </header>
  <main>
<?php
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$user_fname=filter_input(INPUT_POST,"fname",FILTER_SANITIZE_STRING);
$user_lname=filter_input(INPUT_POST,"lname",FILTER_SANITIZE_STRING);
$user_email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL); 
$user_password=filter_input(INPUT_POST,"psw",FILTER_SANITIZE_STRING);
$user_email= filter_var($user_email,FILTER_VALIDATE_EMAIL);

try {
    $conn->query("CALL userAdd('$user_fname','$user_lname','$user_password','$user_email')");
    echo "User was successfully added";
}
catch( Exception $e){
    echo "Sign up failed.";
}
?>
  </main>
  </body>
</html>
