<?php session_start();
require_once "dbconfig.php";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$user_email= filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL); 
$user_password= filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
$user_email= filter_var($user_email,FILTER_VALIDATE_EMAIL);
$findps=$conn->query("SELECT user_password FROM Users WHERE user_email='$user_email'");
$ps= $findps->fetch(PDO::FETCH_ASSOC);
if(isset($ps)){
$user_password=$ps['user_password'];
}
    $find=$conn->query("SELECT * FROM Users WHERE user_password='$user_password' AND user_email='$user_email'");
    $resultsf= $find->fetch(PDO::FETCH_ASSOC);
    if(isset($resultsf)){
        $_SESSION['logined_user']=$resultsf['user_email'];
        $_SESSION['fname']=$resultsf['user_fname'];
        $_SESSION['lname']=$resultsf['user_lname'];
        $_SESSION['userID']=$resultsf['userID'];
        if(isset($_SESSION['logined_user'])){
        header("Location:index.php" );
        }
    }
    else{
    echo "Login Failed. Invalid user_Email-address or Password";
}
?>
?>