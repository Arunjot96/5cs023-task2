<?php
// Connect to database
$mysqli = mysqli_connect("localhost", "2112247", "SRIAKAAL96k!", "db2112247");

if ($mysqli->connect_errno) {
  echo "Failed to connect: " . $mysqli->connect_error;
  exit();
}

// Run INSERT if form submitted
if (isset($_POST["submit"])) {
  $name = $_POST["name"];
  $genre = $_POST["genre"];
  $price = $_POST["price"];
  $date = $_POST["date"];

  $sql = "INSERT INTO movies (Movie_name, Genre, Price, Date_of_release) 
          VALUES ('$name', '$genre', '$price', '$date')";

  if (mysqli_query($mysqli, $sql)) {
    echo "<p>Record added successfully</p>";
  } else {
    echo "<p>Error: " . mysqli_error($mysqli) . "</p>";
  }
}
?>

<html>
<head>
  <title>Add Movie</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h1>Add New Movie</h1>
  <form method="post">
    <div class="mb-3">
      <label>Movie Name:</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
      <label>Genre:</label>
      <input type="text" name="genre" class="form-control">
    </div>
    <div class="mb-3">
      <label>Price:</label>
      <input type="text" name="price" class="form-control">
    </div>
    <div class="mb-3">
      <label>Date of Release:</label>
      <input type="date" name="date" class="form-control">
    </div>
    <input type="submit" name="submit" value="Add Movie" class="btn btn-success">
  </form>

  <a href="5cs023-task2-2112247.php" class="btn btn-secondary mt-3">Back to Movies List</a>
</div>
</body>
</html>
