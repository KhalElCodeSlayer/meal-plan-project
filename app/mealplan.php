<?php
session_start();
require_once "dbconfig.php";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
$uid=$_SESSION['userID'];
$q = $conn->query("CALL MealPlanGet('$uid')");

$mlp = $q->fetch(PDO::FETCH_ASSOC);

$ms=json_decode($mlp["meals_that_are_planned"]);
$ct=1;

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
    <?php if (isset($ms)){ ?>
    <table>
  <thead>
      <tr>
          <th>Day of the Week</th>
          <th>Meal Time</th>
          <th>Recipe ID#</th>
          <th>Recipe Name</th>
          <th>Serving Size</th>
          <th>Calories</th>
          <th>Image</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach ($ms as $m): 
         $md=explode(",",$m);
        if (in_array($ct,array(1,2,3))){
         $dy ="Monday";
        }elseif (in_array($ct,array(4,5,6))){
            $dy ="Tuesday";
         } elseif (in_array($ct,array(7,8,9))){
            $dy ="Wednesday";
         }elseif (in_array($ct,array(10,11,12))){
            $dy ="Thursday";
        }elseif (in_array($ct,array(13,14,15))){
            $dy ="Friday";
        }elseif (in_array($ct,array(16,17,18))){
            $dy ="Saturday";
        }elseif (in_array($ct,array(19,20,21))){
            $dy ="Sunday";
        }
        $ct+=1;
        ?>
        <tr>
            <td><?= $dy;?></td>
          <td><?= $md[3]; ?></td>
          <td><a href="recipedetail.php?rpid=<?=$md[2]; ?>"> <?= $md[2]; ?> </a></td>
          <td><?= $md[1]; ?></td>
          <td><?= $md[4]; ?></td>
          <td><?= $md[5]; ?></td>
          <td><img src="<?= $md[0]; ?>"></td>
      </tr>
      
      <?php endforeach; ?>
  </tbody>
</table>
<?php } else {
?>
  <table>
  <tbody>
  <tr>
    <td>No Meal Plan for this User</td>
      </tr>
  </tbody>
</table>

<?php }
