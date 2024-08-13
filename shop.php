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
require_once ('./includes/connect.inc'); ?>

<body>
<?php include('./includes/nav.php')?>

<div class="container">

<div class="input-group rounded">
  <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"/>
  <span class="input-group-text border-0" id="search-addon">
    <i class="fas fa-search"></i>
  </span>
</div>

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
          <img src='./images/$row[image_url].jpg' class='card-img-top' alt='image of the product'>
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


