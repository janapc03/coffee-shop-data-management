<!DOCTYPE html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database access configuration
$config["dbuser"] = "ora_miaodan";			// change "cwl" to your own CWL
$config["dbpassword"] = "a92389279";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())
?>

<html lang="en">

<head>
  <title>Inventory</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div id="top">
    <a href="">Recipes</a>
    <a href="inventory-home.php">Inventory</a>
    <a href="">Order</a>
  </div>
  </div>

  <br>

  <div class="container">

    <div class="category">


      <a href="inventory-coffee.php"> Coffee </a>
      <br>
      <a href="inventory-cream.php"> Cream </a>
      <br>
      <a href="inventory-sweetener.php"> Sweetener </a>
      <br>
      <a href="inventory-toppings.php"> Toppings </a>
    </div>

    <div class="inventory">
      <table>
        <tr>
          <th>TODO TOPPINGS</th>
          <th>TODO TOPPINGS</th>
          <th>TODO TOPPINGS</th>
        </tr>
        <tr>
          <td>TODO TOPPINGS</td>
          <td>TODO TOPPINGS</td>
          <td>TODO TOPPINGS</td>
        </tr>
        <tr>
          <td>TODO TOPPINGS</td>
          <td>TODO TOPPINGS</td>
          <td>TODO TOPPINGS</td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>