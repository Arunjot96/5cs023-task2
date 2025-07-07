<?php
session_start();

// Visit counter
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 1;
} else {
    $_SESSION['visits']++;
}

// Connect to database
$mysqli = new mysqli("localhost", "2112247", "SRIAKAAL96k!", "db2112247");
if ($mysqli->connect_errno) {
    echo "Failed to connect: " . $mysqli->connect_error;
    exit();
}

// Get search inputs
$searchTitle = "";
$searchGenre = "";
$searchPrice = "";

$sql = "SELECT * FROM movies WHERE 1=1";

if (isset($_POST['searchTitle']) && !empty($_POST['searchTitle'])) {
    $searchTitle = $mysqli->real_escape_string($_POST['searchTitle']);
    $sql .= " AND Movie_name LIKE '%$searchTitle%'";
}

if (isset($_POST['searchGenre']) && !empty($_POST['searchGenre'])) {
    $searchGenre = $mysqli->real_escape_string($_POST['searchGenre']);
    $sql .= " AND Genre LIKE '%$searchGenre%'";
}

if (isset($_POST['searchPrice']) && !empty($_POST['searchPrice'])) {
    $searchPrice = $mysqli->real_escape_string($_POST['searchPrice']);
    $sql .= " AND Price <= '$searchPrice'";
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
    <title>Movies - Task 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">Movies</a>
  </div>
</nav>

<div class="container">
    <p><strong>Visits this session:</strong> <?php echo $_SESSION['visits']; ?></p>

    <h1>Movies List</h1>

    <!-- SEARCH FORM -->
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label for="searchTitle" class="form-label">Search by Title:</label>
            <input type="text" name="searchTitle" id="searchTitle" value="<?php echo htmlspecialchars($searchTitle); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label for="searchGenre" class="form-label">Search by Genre:</label>
            <input type="text" name="searchGenre" id="searchGenre" value="<?php echo htmlspecialchars($searchGenre); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label for="searchPrice" class="form-label">Search by Max Price:</label>
            <input type="number" step="0.01" name="searchPrice" id="searchPrice" value="<?php echo htmlspecialchars($searchPrice); ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-striped">
        <tr>
            <th>ID</th><th>Title</th><th>Genre</th><th>Price</th><th>Date of Release</th>
        </tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['Movie_id']}</td>
        <td>{$row['Movie_name']}</td>
        <td>{$row['Genre']}</td>
        <td>{$row['Price']}</td>
        <td>{$row['Date_of_release']}</td>
    </tr>";
}
?>
    </table>
</div>
</body>
</html>
