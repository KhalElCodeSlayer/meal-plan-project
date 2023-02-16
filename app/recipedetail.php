<?php
session_start();
require_once "dbconfig.php";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$rid=filter_input(INPUT_GET,"rpid",FILTER_SANITIZE_STRING); 

$q = $conn->query("CALL RecipeSpecificGet('$rid')");
$r = $q->fetch(PDO::FETCH_ASSOC);


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
<h1>
    <?php echo $r["recipe_nm"]?>
</h1>
<img  class ="rcp"src="<?php echo $r["image"]?>"> </br>
    Estimated time to prepare this recipe:<?php echo $r["estimatedtime"]?></br>
    Date Created: <?php echo $r["date_created"]?></br>
    Recipe Description: <?php echo $r["recipe_description"]?></br>
    Instructions:<?php foreach (json_decode($r["instructions"]) as $i): ?>
    <?php echo $i?> <br>
    <?php endforeach; ?>
    Ingredients: <?php foreach (json_decode($r["ingredients"]) as $in ): ?>
    <?php echo $in ?> <br>
    <?php endforeach; ?>
    </main>
    <footer>
        <div class="container">

        </div>
    </footer>
  </body>
</html>