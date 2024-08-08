<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shop - CAS Centenary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>

<?php
require_once ('./includes/connect.inc');
require_once ('./includes/nav.inc');


echo '
<body>
<div class="container">';

echo 'anniversary products<br>';

echo "
<form method='get' action='products.php'>
  <label for='search'>Search for products:</label><br>
  <input type='text' id='search' name='search' required><br><br> 
  <input type='submit' name='submit' value='Search'>
</form>";

if (isset($_GET['submit'])){

  $search_term = $_GET['search'];

  $query = "SELECT * FROM Products WHERE Name LIKE '%$search_term%'";
}

else {$query = "SELECT * FROM Products";
}


$result = $conn->query($query);
echo $query;
echo "<p>successful sql</p>";

while($row = $result->fetch_assoc()) {
    $data_result[] = $row;
}

echo "
<h1>Results:</h1>";

if (empty($data_result)) {
  echo "<p>No results found.</p>";
}

else{
  echo "<div class='row'>";

  foreach ($data_result as $row) {
      echo "
      <div class='col-md-4'>
        <div class='card mb-2'>
          <img src='$row[ImageURL]' class='card-img-top' alt='image of the product'>
          <div class='card-body'>
            <h5 class='card-title'>$row[Name]</h5>
            <p class='card-text'>Description: $row[Description]</p>
            <p class='card-text'>Price: $row[Price]</p>
            <p class='card-text'>Stock: $row[Stock]</p>
            <p class='card-text'>Category: $row[Category]</p>
          </div>
        </div>
      </div>
      <br><br>";
  }
  echo "</div>";
}


$conn->close();
?>

</div>
</body>
</html>


