<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Restock - CAS Centenary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>

<?php
session_start();
require_once ('./includes/connect.inc');

if (!isset($_SESSION['admin'])){
    // isn't admin, redirect them to a different page
    header("Location: index.php");
}
?>

<body>
<?php include('./includes/nav.php')?>

<div class="container">

<form action="shop.php" method="get" class="form-inline">
  <input type="search" class="form-control" name="search" placeholder="Search" aria-label="Search"/>
  <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
</form>



<?php
if (isset($_GET['submit'])){

  $search_term = $_GET['search'];

  $query = "SELECT * FROM Product WHERE Name LIKE '%$search_term%'";
}

else {
  $query = "SELECT * FROM Product";
}


$result = $conn->query($query);

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
          <img src='./images/$row[image_url].jpg' class='card-img-top' alt='$row[name]'>
          <div class='card-body'>
            <h5 class='card-title'>$row[name]</h5>
            <p class='card-text'>Description: $row[description]</p>
            <p class='card-text'>Price: $row[price]</p>
            <p class='card-text'>Stock: $row[stock]</p>
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


