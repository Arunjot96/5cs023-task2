<?php
// --- COOKIES style code ---
$style = 0;
if (isset($_COOKIE["selectedStyle"])) {
  $style = $_COOKIE["selectedStyle"];
}

// --- SESSION visit counter ---
session_start();
if (!isset($_SESSION['visits'])) {
  $_SESSION['visits'] = 1;
} else {
  $_SESSION['visits']++;
}

// --- DATABASE connection ---
$mysqli = new mysqli("localhost", "2112247", "SRIAKAAL96k!", "db2112247");
if ($mysqli->connect_errno) {
  echo "Failed to connect: " . $mysqli->connect_error;
  exit();
}

// --- SEARCH ---
$searchTitle = $_POST['searchTitle'] ?? '';
$searchGenre = $_POST['searchGenre'] ?? '';
$searchPrice = $_POST['searchPrice'] ?? '';

$sql = "SELECT * FROM movies WHERE 1";

if (!empty($searchTitle)) {
  $sql .= " AND Movie_name LIKE '%" . $mysqli->real_escape_string($searchTitle) . "%'";
}
if (!empty($searchGenre)) {
  $sql .= " AND Genre LIKE '%" . $mysqli->real_escape_string($searchGenre) . "%'";
}
if (!empty($searchPrice)) {
  $sql .= " AND Price <= '" . $mysqli->real_escape_string($searchPrice) . "'";
}

$result = $mysqli->query($sql);
if (!$result) {
  echo "Query failed: " . $mysqli->error;
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Movies</title>
  <!-- USE COOKIE STYLE -->
  <link rel="stylesheet" href="style<?= $style; ?>.css">

  <!-- Bootstrap (keep it) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">Movies</a>
  </div>
</nav>

<div class="container">
  <p><strong>Visits this session:</strong> <?= $_SESSION['visits'] ?></p>

  <!-- ADD MOVIE BUTTON -->
  <a href="add.php" class="btn btn-success mb-3">Add New Movie</a>

  <h1>Movies List</h1>


  <form method="post" class="mb-4">
    <div class="mb-3">
      <label>Search by Title:</label>
      <input type="text" name="searchTitle" class="form-control">
    </div>
    <div class="mb-3">
      <label>Search by Genre:</label>
      <input type="text" name="searchGenre" class="form-control">
    </div>
    <div class="mb-3">
      <label>Search by Max Price:</label>
      <input type="text" name="searchPrice" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
  </form>

  <table class="table table-striped">
    <tr>
      <th>ID</th><th>Title</th><th>Genre</th><th>Price</th><th>Date of Release</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['Movie_id'] ?></td>
        <td><?= $row['Movie_name'] ?></td>
        <td><?= $row['Genre'] ?></td>
        <td><?= $row['Price'] ?></td>
        <td><?= $row['Date_of_release'] ?></td>
      </tr>
    <?php } ?>
  </table>

  <!-- Link to change style -->
  <p><a href="changestyle.php">Change Style</a></p>
</div>

</body>
</html>
