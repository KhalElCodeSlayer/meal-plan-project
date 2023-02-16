<?php
session_start();
require_once "dbconfig.php";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
$uid=$_SESSION['userID'];
$q = $conn->query("CALL SuperMarketListGET('$uid')");
$mk = $q->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>COMP3161 Project</title>
    <link href="css/search.css" type="text/css" rel="stylesheet" />
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
    <br>
    <table>
  <thead>
      <tr>
          <th>Ingredient</th>
          <th>Amount Needed</th>
          <th>Unit</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach ($mk as $m):   
        ?>
        <tr>
          <td><?= $m["ingredient_name"]; ?></td>
          <td><?= $m["amount_needed"]; ?></td>
          <td><?= $m["unit"]; ?></td>
      </tr>
      
      <?php endforeach; ?>
  </tbody>
</table>
</main>
    <footer>
        <div class="container">

        </div>
    </footer>
  </body>
</html>
