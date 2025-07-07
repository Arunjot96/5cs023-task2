<?php
$thisStyle = 0;

if (isset($_COOKIE["selectedStyle"])) { // has the cookie already been set
  $thisStyle = $_COOKIE["selectedStyle"];
}

if (isset($_POST["changeStyle"])) { // changing the style
  $thisStyle = $_POST["changeStyle"];
}

setcookie("selectedStyle", $thisStyle); // update or create the cookie
?>

<html>
<head>
  <title>Cookies - the style change page</title>
  <link rel="stylesheet" href="style<?= $thisStyle; ?>.css">
</head>
<body>
  <h1>This is the colour of a heading number 1</h1>
  <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
    <input type="submit" name="changeStyle" value="0"><br>
    <input type="submit" name="changeStyle" value="1"><br>
    <input type="submit" name="changeStyle" value="2"><br>
  </form>
  <p><a href="5cs023-task2-2112247.php">Link back to Movies Page</a></p>
</body>
</html>
