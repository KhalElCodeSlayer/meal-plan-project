<?php
session_start();
require_once "dbconfig.php";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$rname=filter_input(INPUT_GET,"rname",FILTER_SANITIZE_STRING); 

$q = $conn->query("CALL RecipeSearch('%$rname%')");
$r = $q->fetchAll(PDO::FETCH_ASSOC);
if (empty($r)):
    ?>
    <table>
  
  <tbody>
      <tr>
          <td>No Recipe found matching this Search</td>
      </tr>
  </tbody>
</table>
<?php else:
?>
<table>
  <thead>
      <tr>
          <th>Recipe ID#</th>
          <th>Recipe Name</th>
          <th>Description</th>
          <th>Image</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach ($r as $row): ?>
      <tr>
          <td><a href="recipedetail.php?rpid=<?=$row['recipe_id']; ?>"> <?= $row['recipe_id']; ?> </a></td>
          <td><?= $row['recipe_nm']; ?></td>
          <td><?= $row['recipe_description']; ?></td>
          <td><img src="<?= $row['image']; ?>"></td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>