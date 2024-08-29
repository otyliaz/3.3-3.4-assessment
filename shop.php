<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shop - CAS Centenary</title>
    <?php include './includes/basehead.html'; ?>
  </head>

<body>

<?php
session_start();
require_once './includes/connect.inc';
include './includes/nav.php'?>

<div class="container mb-2">

<h1 class="my-3 text-center">Shop CAS merchandise:</h1>

<div class="row my-2">

  <form action="shop.php" method="get" class="d-flex mx-auto" id="search-bar">
      <input type="search" class="form-control" name="search" placeholder="Search" aria-label="Search"/>
      <button class="btn btn-green" id="search-button" type="submit">
        <i class="fas fa-search"></i>
      </button>
  </form>

</div>

<?php
$query = "SELECT * FROM product";

if (isset($_GET['search'])){

  //trim off whitespace from search term
  $search_term = trim($_GET['search']);

  if (!empty($search_term)) {
    // if search_term is not null or whitespace,
    $query .= " WHERE name LIKE '%$search_term%'"; //add WHERE clause to original query
  }
}

//echo $query;

$result = $conn->query($query);
$rowcount = $result->num_rows;

while($row = $result->fetch_assoc()) {
  $data_result[] = $row;
}

echo '<p class="text-center"> Showing '.$rowcount.' result(s)';

if (!empty($search_term)) {
  // if search_term is not null or whitespace,
  echo' for "'.$search_term.'"';}
echo ':</p>';


if (isset($_SESSION['admin'])) {
  echo "
  <div class='text-center mt-2'>
    <a class='btn btn-red' href='addproduct.php'>Add product</a>
  </div>";
}

if (empty($data_result)) {
  echo '<p class="text-center">Sorry! No results found.<p>';
}

else {
  echo "<div class='row mt-3'>";

  foreach ($data_result as $row) {
    $imagepath = "./item_images/$row[image_url]";
      echo "
      <div class='col-md-6 col-lg-4'>
      <a href='product.php?id=$row[idproduct]' class='text-decoration-none'>
        <div class='card mb-3'>
          <img src='";

          if (!file_exists($imagepath) || empty($row['image_url'])) {
            echo "./item_images/no_img.png"; }
          else {echo $imagepath;}
          
          echo "' class='card-img-top' alt='$row[name]'>
          <div class='card-body'>
            <h5 class='card-title'>$row[name]</h5>
            <div class='d-flex justify-content-between'>
              <p class='fw-bold' id='item-price'>$" . number_format($row['price'], 2) . "</p>
              <p class='card-text text-end'>$row[stock] in stock</p>
            </div>";
            // //if the user is an admin, show an EDIT button.
            // if (isset($_SESSION['admin']))
            // {echo "<button class='btn btn-danger'>EDIT</button>";}
    echo "</div>"; //closing card-body
  echo "</div> </a>"; // closing card and anchor tag
echo "</div>"; // closing col
}

}
echo "</div>";

$conn->close();
?>

</div>

<?php include './includes/footer.html'?>

</body>
</html>