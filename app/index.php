<?php 
    session_start();
    require_once "dbconfig.php";
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	if (!isset($_SESSION['logined_user']))
  {
    header('Location: logout.php');
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP3161 Project</title>
    <link href="css/main.css" type="text/css" rel="stylesheet" />
  </head>
  <body>
  <header>
        <nav class="navbar">
            
              <ul class="active">
                <li class="user">
                <?php echo $_SESSION["fname"]." ".$_SESSION["lname"]?>
              </li>
                <li>
                  <a class="" href="index.php">Home</a>
                </li>
                <li>
                    <a class="" href="search.php">Recipe Search </a>
                </li>
                <li>
                <a class="" href="mealplan.php">User Meal Plan</a>
                </li>
                <li>
                  <a class="" href="marketlist.php">Market List</a>
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
        <div class="container">
            <main>
                <div>
                    <h1>Welcome to the COMP3161 Meal Planner Website!</h1>
                    <div class="row">
                        <div class="column">
                            <img src="images/lily-banse--YHSwy6uqvk-unsplash.jpg">
                        </div>
                        <div class="column">
                            <img src="images/dan-gold-4_jhDO54BYg-unsplash.jpg">
                        </div>
                        <div class="column">
                            <img src="images/anna-pelzer-IGfIGP5ONV0-unsplash.jpg">
                        </div>  
                    </div>
                    <p>These are the various features implemented in this project:</p>
                    
                </div>
            </main>
        </div>
    </main>
    <footer>
        <div class="container">

        </div>
    </footer>
  </body>
</html>