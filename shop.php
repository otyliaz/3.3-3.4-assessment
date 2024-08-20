<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shop - CAS Centenary</title>
    <?php include ('./includes/basehead.html'); ?>
  </head>

<body>

<?php
session_start();
require_once ('./includes/connect.inc');

// if (!isset($_SESSION['admin'])){
//   // isn't admin, redirect them to a different page
//   header("Location: index.php");
// }

include('./includes/nav.php')?>

<div class="container">

<h1>Shop CAS merchandise:</h1>

<div class="row">

<form action="shop.php" method="get" class="d-flex">
    <input type="search" class="form-control" name="search" placeholder="Search" aria-label="Search"/>
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>


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

while($row = $result->fetch_assoc()) {
  $data_result[] = $row;

  $rowcount = $result->num_rows;
}

if (empty($data_result)) {
  echo '<p>No results found for "'.$search_term.'"</p>';
}

else {
  echo '<p>Showing '.$rowcount.' result(s)';

  if (!empty($search_term)) {
    // if search_term is not null or whitespace,
    echo' for "'.$search_term.'"';}
  
  echo ':</p> 
  </div>'; //closing first <div class=row>

  echo "<div class='row'>";


  foreach ($data_result as $row) {
      echo "
      <div class='col-md-4'>
      <a href='product.php?id=$row[idproduct]' class='text-decoration-none'>
        <div class='card mb-2'>
          <img src='./images/$row[image_url].jpg' class='card-img-top' alt='$row[name]'>
          <div class='card-body'>
            <h5 class='card-title'>$row[name]</h5>
            <p class='card-text'>Description: $row[description]</p>
            <p class='card-text'>Price: $row[price]</p>
            <p class='card-text'>Stock: $row[stock]</p>";
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
</body>
</html>