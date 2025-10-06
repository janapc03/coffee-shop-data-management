<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// -------------------
// Database configuration
// -------------------
$config["dbuser"] = "root";       // Your MySQL username
$config["dbpassword"] = "";       // Your MySQL password
$config["dbhost"] = "localhost";  // Your MySQL host
$config["dbname"] = "coffeeShop"; // Your MySQL database

$db_conn = NULL;
$success = true;
$show_debug_alert_messages = false;



// -------------------
// Helper functions
// -------------------
function debugAlertMessage($message)
{
    global $show_debug_alert_messages;
    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}

function connectToDB()
{
    global $db_conn, $config;
    $db_conn = mysqli_connect($config["dbhost"], $config["dbuser"], $config["dbpassword"], $config["dbname"]);

    if (!$db_conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    debugAlertMessage("Database is Connected");
    return true;
}

function disconnectFromDB()
{
    global $db_conn;
    if ($db_conn) {
        mysqli_close($db_conn);
    }
}

function executePlainSQL($cmdstr)
{
    global $db_conn, $success;
    $result = mysqli_query($db_conn, $cmdstr);

    if (!$result) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        echo mysqli_error($db_conn);
        $success = false;
    }

    return $result;
}

function executeBoundSQL($cmdstr, $list)
{
    global $db_conn, $success;
    $stmt = mysqli_prepare($db_conn, $cmdstr);

    if (!$stmt) {
        echo "<br>Cannot prepare the following command: " . $cmdstr . "<br>";
        echo mysqli_error($db_conn);
        $success = false;
        return;
    }

    foreach ($list as $tuple) {
        $types = str_repeat("s", count($tuple)); // all strings
        mysqli_stmt_bind_param($stmt, $types, ...array_values($tuple));
        $r = mysqli_stmt_execute($stmt);
        if (!$r) {
            echo "<br>Execution failed: " . mysqli_stmt_error($stmt) . "<br>";
            $success = false;
        }
    }

    mysqli_stmt_close($stmt);
}

// -------------------
// Display functions
// -------------------
function printResult($result)
{
    echo "<br>Retrieved attribute names from selected table:<br>";
    echo '<br /><table class="attributes-table">';
    echo "<thead><tr><th>Attribute Num.</th><th>Attribute Name</th></tr><tbody>";

    $attributeNumber = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $attributeNumber . "</td>";
        echo "<td>" . $row['COLUMN_NAME'] . "</td>";
        echo "</tr>";
        $attributeNumber++;
    }

    echo "</tbody></table>";
}

function printSelectedTableResult($result, $attributes)
{
    echo "<br>Retrieved data with selected attributes from chosen table:<br>";
    echo '<br /><table class="selected-table">';
    echo "<thead><tr>";

    foreach ($attributes as $attr) {
        if (!empty($attr)) {
            echo "<th>$attr</th>";
        }
    }
    echo "</tr></thead><tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($attributes as $attr) {
            if (!empty($attr)) {
                echo "<td>" . $row[$attr] . "</td>";
            }
        }
        echo "</tr>";
    }

    echo "</tbody></table>";
}

// -------------------
// Request Handlers
// -------------------
function handleDisplayAttsRequest($currentTable)
{
    global $db_conn;
    $currentTable = mysqli_real_escape_string($db_conn, $currentTable);

    $result = executePlainSQL("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'coffeeShop' AND TABLE_NAME = '$currentTable'
    ");

    printResult($result);
}

function handleDisplaySelectedTableRequest($currentTable, $attributes)
{
    global $db_conn;
    if (!$currentTable) {
        echo "<br>No table name given.<br>";
        exit();
    }

    $currentTable = mysqli_real_escape_string($db_conn, $currentTable);

    // Validate that attributes exist
    $columnsResult = executePlainSQL("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'coffeeShop' AND TABLE_NAME = '$currentTable'
    ");

    $columns = [];
    while ($colRow = mysqli_fetch_assoc($columnsResult)) {
        $columns[] = strtoupper($colRow['COLUMN_NAME']);
    }

    $nonEmptyAttrs = array_filter(array_map('strtoupper', $attributes));
    $invalidAttrs = array_diff($nonEmptyAttrs, $columns);

    if (!empty($invalidAttrs)) {
        echo "<br>Invalid input, attributes do not exist: " . implode(", ", $invalidAttrs) . "<br>";
        exit();
    }

    if (!empty($nonEmptyAttrs)) {
        $attrs = implode(", ", $nonEmptyAttrs);
        $query = "SELECT $attrs FROM $currentTable";
        $result = executePlainSQL($query);
        printSelectedTableResult($result, $nonEmptyAttrs);
    } else {
        echo "<br>No attributes selected.<br>";
        exit();
    }
}

function handleInsertRequest()
{
    global $db_conn;

    $itemName = $_POST['inItemName'] ?? '';
    $itemQty  = $_POST['inItemQty'] ?? '';

    if (empty($itemName) || empty($itemQty)) {
        echo "<br>Please provide both item name and quantity.<br>";
        return;
    }

    $stmt = mysqli_prepare($db_conn, "INSERT INTO demoTable (ItemName, ItemQty) VALUES (?, ?)");

    if (!$stmt) {
        echo "<br>Failed to prepare statement: " . mysqli_error($db_conn) . "<br>";
        return;
    }

    mysqli_stmt_bind_param($stmt, "si", $itemName, $itemQty);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br>Record inserted successfully.<br>";
    } else {
        echo "<br>Error inserting record: " . mysqli_stmt_error($stmt) . "<br>";
    }

    mysqli_stmt_close($stmt);
}

function handlePOSTRequest()
{
    if (connectToDB()) {
        if (isset($_POST['insertCartQueryRequest'])) {
            handleInsertRequest();
        }
        disconnectFromDB();
    }
}

function handleGETRequest()
{
    if (connectToDB()) {
        $tablesMap = [
            'displayCoffeeAtts'=>'COFFEE','displayToppingsAtts'=>'TOPPINGS','displayCreamAtts'=>'CREAM',
            'displaySweetenerAtts'=>'SWEETENER','displayDecafAtts'=>'DECAF','displayCaffeinatedAtts'=>'CAFFEINATED',
            'displayIcedCoffeeAtts'=>'ICEDCOFFEE','displayDeliveryAtts'=>'DELIVERY','displaySupplierAtts'=>'SUPPLIER',
            'displayShoppingListAtts'=>'SHOPPINGLIST','displayPurchaseAtts'=>'PURCHASE','displaySalesAtts'=>'SALES',
            'displayFundAtts'=>'FUND','displayListToppingsAtts'=>'LISTTOPPINGS','displayListCreamAtts'=>'LISTCREAM',
            'displayListSweetenerAtts'=>'LISTSWEETENER','displayListCoffee1Atts'=>'LISTCOFFEE1','displayListCoffee2Atts'=>'LISTCOFFEE2',
            'displayAddToppingsAtts'=>'ADDTOPPINGS','displayAddCreamAtts'=>'ADDCREAM','displayAddSweetenerAtts'=>'ADDSWEETENER',
            'displayDeliverAtts'=>'DELIVER'
        ];

        foreach ($tablesMap as $key => $tableName) {
            if (isset($_GET[$key])) {
                handleDisplayAttsRequest($tableName);
            }
        }

        if (isset($_GET['viewTableTuples'])) {
            $currentTable = strtoupper($_GET['selectedTable']);
            $attributes = [
                strtoupper($_GET['att1']), strtoupper($_GET['att2']), strtoupper($_GET['att3']),
                strtoupper($_GET['att4']), strtoupper($_GET['att5'])
            ];
            handleDisplaySelectedTableRequest($currentTable, $attributes);
        }

        disconnectFromDB();
    }
}

// -------------------
// Route Requests
// -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePOSTRequest();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    handleGETRequest();
}
?>

<html>

<head>
	<title>Home</title>

	<style>
        section::after {
            content: "";
            display: table;
            clear: both;
          }

        article {
                     float: right;
                     width: 80%;
                     background-color: #f1f1f1;
                     height: 600px;
                     border: 2px solid black;
                     line-height: 10px;
                     }
        .userInputs {
        padding: 10px 10px 10px 10px;
        }

        .items-table-container {
            width: 90%;
            }

        nav {
                    float: left;
                    width: 18%;
                    height: 600px;
                    border: 2px solid black;
                    line-height: 10px;
                    }

        .tableNameOptions{
             padding: 10px 10px 10px 10px;
             }

         p {
                   font-family: "Trebuchet MS", sans-serif;
                   }
               .attrNote {
               line-height: 20px;
               }

           .note {
           line-height: 20px;
              }

          .allButtons {
                     line-height: 8px;
                        }

               h2 {
                    font-family: "Trebuchet MS", sans-serif;
                    }
                h3 {
                           font-family: "Trebuchet MS", sans-serif;
                           }

    </style>

</head>

<body>
    <?php include("homebar.php"); ?>
<section class="container">
  <nav>
      <div class="tableNameOptions">
          <h3> <b> <u>View Attribute Names</u></b></h3>
      <p class=attrNote> Select a table name to view its attributes:</p>
      <p class="allButtons">
      <form method="GET" action="home-page.php" name="displayTableForm">
          <input type="submit" value="Coffee" name="displayCoffeeAtts">
          <input type="hidden" id="displayTableAttsRequest" name="displayTableAttsRequest">
          <input type="submit" value="Toppings" name="displayToppingsAtts">
          <input type="submit" value="Cream" name="displayCreamAtts">
          <input type="submit" value="Sweetener" name="displaySweetenerAtts">
          <input type="submit" value="Decaf" name="displayDecafAtts">
          <input type="submit" value="Caffeinated" name="displayCaffeinatedAtts">
          <input type="submit" value="IcedCoffee" name="displayIcedCoffeeAtts">
          <input type="submit" value="Delivery" name="displayDeliveryAtts">
          <input type="submit" value="Supplier" name="displaySupplierAtts">
          <input type="submit" value="ShoppingList" name="displayShoppingListAtts">
          <input type="submit" value="Purchase" name="displayPurchaseAtts">
          <input type="submit" value="Sales" name="displaySalesAtts">
          <input type="submit" value="Fund" name="displayFundAtts">
          <input type="submit" value="ListToppings" name="displayListToppingsAtts">
          <input type="submit" value="ListCream" name="displayListCreamAtts">
          <input type="submit" value="ListSweetener" name="displayListSweetenerAtts">
          <input type="submit" value="ListCoffee1" name="displayListCoffee1Atts">
          <input type="submit" value="ListCoffee2" name="displayListCoffee2Atts">
          <input type="submit" value="AddToppings" name="displayAddToppingsAtts">
          <input type="submit" value="AddCream" name="displayAddCreamAtts">
          <input type="submit" value="AddSweetener" name="displayAddSweetenerAtts">
          <input type="submit" value="Deliver" name="displayDeliverAtts">
      </form>
  </p>
                 </div>
        </nav>

    <article>
        <div class="userInputs">
            <h2>Welcome! Input the table name and attributes you'd like to view:</h2>
        <form method="GET" action="home-page.php">
                       <input type="hidden" id="displayProjectionRequest" name="displayProjectionRequest">
                       <p>Table Name:</p> <input type="text" name="selectedTable"> <br /><br />
                       <p>Attribute 1:</p> <input type="text" name="att1"> <br /><br />
                       <p>Attribute 2:</p> <input type="text" name="att2"> <br /><br />
                       <p>Attribute 3:</p> <input type="text" name="att3"> <br /><br />
                      <p> Attribute 4: </p><input type="text" name="att4"> <br /><br />
                       <p>Attribute 5: </p><input type="text" name="att5"> <br /><br />
                       <input type="submit" value="View Table" name="viewTableTuples"></p>
                      </form>
        </div>
        </article>
    </section>
    </body>

</html>
