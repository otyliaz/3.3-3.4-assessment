
<?php
session_start();

require_once './includes/connect.inc';

if (!isset($_SESSION['admin'])) {
    header("Location: register.php");
}

if(isset($_POST['add'])) {
        
    $name = $_POST['name'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $query = "INSERT INTO event (name, price, location, description) VALUES (?,?,?,?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sdss", $name, $price, $location, $description);
        $stmt->execute();
        $stmt->close();
        header("Location: register.php");
        exit();
    } else {
        echo "Error adding event: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add event - CAS Centenary</title>
<?php include './includes/basehead.html'; ?>
</head>

<?php include './includes/nav.php';?>

<div class="container">

    <h1 class="my-3">Add an event</h1>

    <form action="add_event.php" method="post"> 
    <div class="form-group">
        <label for="name">Event name:</label>
        <input class="form-control mb-2" type="text" name="name" id="name" placeholder="Type here" required> 
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input class="form-control mb-2" type="text" name="description" id="description" placeholder="Type here" required>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input class="form-control mb-2" type="number" name="price" id="price" step="any" placeholder="Type here" required>
    </div>
    <div class="form-group">
        <label for="stock">Location:</label>
        <input class="form-control mb-2" type="text" name="location" id="location" placeholder="Type here" required>
    </div>

    <input class="btn btn-green mt-2" type="submit" name="add" value="Add event">
    </form>

</div>
           
<?php include './includes/footer.html'?>

</body>
</html>