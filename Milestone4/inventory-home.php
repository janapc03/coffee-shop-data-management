
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

<html>

<head>
    <title>Inventory</title>
</head>

<body>
<?php include("homebar.php"); ?>

<div style="width:99%; margin:auto">
    <div style="display:inline-block; width:24%;">
        <h2>Inventory of toppings</h2>
        <form method="GET" action="inventory-home.php">
            <input type="hidden" id="displayToppingsTuplesRequest" name="displayToppingsTuplesRequest">
            <input type="submit" name="displayToppingsTuples"> </p>
        </form>

        <h3>Update Inventory of Toppings</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="updateToppingsRequest" name="updateToppingsRequest">
            Toppings name: <input type="text" name="name"> <br /><br />
            Updated inventory: <input type="text" name="inv"> <br /><br />

            <input type="submit" value="Update" name="updateToppingsSubmit"></p>
        </form>

        <h3>Insert New Topping</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="insertToppingQueryRequest" name="insertToppingQueryRequest">
            Topping Name: <input type="text" name="inName"> <br /><br />
            Amount in inventory: <input type="text" name="inInv"> <br /><br />

            <input type="submit" value="Insert" name="insertToppingSubmit"></p>
        </form>

        <h3>Delete a Topping</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="deleteToppingQueryRequest" name="deleteToppingQueryRequest">
            Topping Name: <input type="text" name="delName"> <br /><br />
            <input type="submit" value="Delete" name="deleteToppingSubmit"></p>
        </form>
    </div>

    <div style="display:inline-block; width:24%;">
        <h2>Inventory of creams</h2>
        <form method="GET" action="inventory-home.php">
            <input type="hidden" id="displayCreamTuplesRequest" name="displayCreamTuplesRequest">
            <input type="submit" name="displayCreamTuples"> </p>
        </form>

        <h3>Update Inventory of Creams</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="updateCreamRequest" name="updateCreamRequest">
            Cream name: <input type="text" name="name"> <br /><br />
            Updated inventory: <input type="text" name="inv"> <br /><br />

            <input type="submit" value="Update" name="updateCreamSubmit"></p>
        </form>

        <h3>Insert New Cream</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="insertCreamQueryRequest" name="insertCreamQueryRequest">
            Cream Name: <input type="text" name="inName"> <br /><br />
            Amount in inventory: <input type="text" name="inInv"> <br /><br />

            <input type="submit" value="Insert" name="insertCreamSubmit"></p>
        </form>

        <h3>Delete a Cream</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="deleteCreamQueryRequest" name="deleteCreamQueryRequest">
            Cream Name: <input type="text" name="delName"> <br /><br />
            <input type="submit" value="Delete" name="deleteCreamSubmit"></p>
        </form>

    </div>

    <div style="display:inline-block; width:24%;">
        <h2>Inventory of sweeteners</h2>
        <form method="GET" action="inventory-home.php">
            <input type="hidden" id="displaySweetenerTuplesRequest" name="displaySweetenerTuplesRequest">
            <input type="submit" name="displaySweetenerTuples"> </p>
        </form>

        <h3>Update Inventory of Sweeteners</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="updateSweetenerRequest" name="updateSweetenerRequest">
            Sweetener name: <input type="text" name="name"> <br /><br />
            Updated inventory: <input type="text" name="inv"> <br /><br />

            <input type="submit" value="Update" name="updateSweetenerSubmit"></p>
        </form>

        <h3>Insert New Sweetener</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="insertSweetenerQueryRequest" name="insertSweetenerQueryRequest">
            Sweetener Name: <input type="text" name="inName"> <br /><br />
            Amount in inventory: <input type="text" name="inInv"> <br /><br />
            <input type="submit" value="Insert" name="insertSweetenerSubmit"></p>
        </form>

        <h3>Delete a Sweetener</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="deleteSweetenerQueryRequest" name="deleteSweetenerQueryRequest">
            Sweetener Name: <input type="text" name="delName"> <br /><br />
            <input type="submit" value="Delete" name="deleteSweetenerSubmit"></p>
        </form>

    </div>

    <div style="display:inline-block; width:24%;">
        <h2>Inventory of Coffee Beans</h2>
        <form method="GET" action="inventory-home.php">
            <input type="hidden" id="displayCoffeeTuplesRequest" name="displayCoffeeTuplesRequest">
            <input type="submit" name="displayCoffeeTuples"> </p>
        </form>

        <h3>Update Inventory of Coffee Beans</h3>
        <form method="POST" action="inventory-home.php">
            <input type="hidden" id="updateCoffeeRequest" name="updateCoffeeRequest">
            Updated Caffeinated inventory: <input type="text" name="cafInv"> <br /><br />
            Updated Decaffeinated inventory: <input type="text" name="decafInv"> <br /><br />

            <input type="submit" value="Update" name="updateCoffeeSubmit"></p>
        </form>
    </div>

</div>
<hr />
<?php
// The following code will be parsed as PHP

function debugAlertMessage($message)
{
    global $show_debug_alert_messages;

    if ($show_debug_alert_messages) {
        echo "<script type='text/javascript'>alert('" . $message . "');</script>";
    }
}

function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
    //echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;

    $statement = oci_parse($db_conn, $cmdstr);
    //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = oci_execute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For oci_execute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    }

    return $statement;
}

function executeBoundSQL($cmdstr, $list)
{
    /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
    See the sample code below for how this function is used */

    global $db_conn, $success;
    $statement = oci_parse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            //echo $val;
            //echo "<br>".$bind."<br>";
            oci_bind_by_name($statement, $bind, $val);
            unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
        }

        $r = oci_execute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    }
}

function printResult($result, $name, $inv)
{ //prints results from a select statement
    echo "<table>";
    echo "<tr><th>Name</th><th>Inventory</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
        echo "<tr><td>" . $row[$name]  . "</td><td>" . $row[$inv]  . "</td></tr>";
    }

    echo "</table>";
}

function printCoffeeResult($result)
{ //prints results from a select statement
    echo "<table>";
    echo "<tr><th>Caffeinated Inventory</th><th>Decaffeinated Inventory</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
        echo "<tr><td>" . $row['CAF']  . "</td><td>" . $row['DECAF']  . "</td></tr>";
    }

    echo "</table>";
}

function connectToDB()
{
    global $db_conn;
    global $config;

    // Your username is ora_(CWL_ID) and the password is a(student number). For example,
    // ora_platypus is the username and a12345678 is the password.
    // $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
    $db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

    if ($db_conn) {
        debugAlertMessage("Database is Connected");
        return true;
    } else {
        debugAlertMessage("Cannot connect to Database");
        $e = OCI_Error(); // For oci_connect errors pass no handle
        echo htmlentities($e['message']);
        return false;
    }
}

function disconnectFromDB()
{
    global $db_conn;
    debugAlertMessage("Disconnect from Database");
    oci_close($db_conn);
}

function handleUpdateRequest($table, $inv, $name)
{
    global $db_conn;

    $itemName = $_POST['name'];
    $updatedItemInv = $_POST['inv'];

    // you need the wrap the old name and new name values with single quotations
    executePlainSQL("UPDATE " . $table . " SET " . $inv . " ='" . $updatedItemInv . "' WHERE " . $name . " ='" . $itemName . "'");
    //executePlainSQL("UPDATE toppings SET toppingInv = 'low' WHERE toppingName = 'whipped cream'");
    oci_commit($db_conn);
}


function handleInsertRequest($table)
{
    global $db_conn;

    //Getting the values from user and insert data into the table
    $tuple = array(
        ":bind1" => $_POST['inName'],
        ":bind2" => $_POST['inInv'],
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("insert into " . $table . " values (:bind1, :bind2)", $alltuples);

    oci_commit($db_conn);
}

function handleUpdateCoffeeRequest()
{
    global $db_conn;
    $caf = $_POST['cafInv'];
    $decaf = $_POST['decafInv'];

    if ($caf != null) {
        executePlainSQL("UPDATE caffeinated SET coffeeInv ='" . $caf . "'");
    }
    if ($decaf != null) {
        executePlainSQL("UPDATE decaf SET coffeeInv ='" . $decaf . "'");
    }
    oci_commit($db_conn);
}

function handleDeleteRequest($table, $name)
{
    global $db_conn;

    $deleteName = $_POST['delName'];

    executePlainSQL("DELETE FROM " . $table . " WHERE " . $name . "='" . $deleteName . "'");
    //executePlainSQL("DELETE FROM toppings WHERE toppingName='cinnamon'");
    oci_commit($db_conn);
}

function handleDisplayRequest($table, $name, $inv)
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM " . $table . "");
    printResult($result, $name, $inv);

    oci_commit($db_conn);
}

function handleDisplayCoffeeRequest()
{
    global $db_conn;
    $result = executePlainSQL("SELECT DISTINCT c.coffeeInv as caf, d.coffeeInv as decaf FROM caffeinated c, decaf d");
    printCoffeeResult($result);

    oci_commit($db_conn);
}




// HANDLE ALL POST ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handlePostRequest()
{
    if (connectToDB()) {
        if (array_key_exists('updateToppingsRequest', $_POST)) {
            $table = 'toppings';
            $inv = 'toppingInv';
            $name = 'toppingName';
            handleUpdateRequest($table, $inv, $name);
        } else if (array_key_exists('updateCreamRequest', $_POST)) {
            $table = 'cream';
            $inv = 'creamInv';
            $name = 'creamName';
            handleUpdateRequest($table, $inv, $name);
        } else if (array_key_exists('updateSweetenerRequest', $_POST)) {
            $table = 'sweetener';
            $inv = 'sweetenerInv';
            $name = 'sweetName';
            handleUpdateRequest($table, $inv, $name);
        } else if (array_key_exists('updateCoffeeRequest', $_POST)) {
            handleUpdateCoffeeRequest();
        } else if (array_key_exists('insertToppingQueryRequest', $_POST)) {
            $table = 'toppings';
            handleInsertRequest($table);
        } else if (array_key_exists('insertCreamQueryRequest', $_POST)) {
            $table = 'cream';
            handleInsertRequest($table);
        } else if (array_key_exists('insertSweetenerQueryRequest', $_POST)) {
            $table = 'sweetener';
            handleInsertRequest($table);
        } else if (array_key_exists('deleteToppingQueryRequest', $_POST)) {
            $table = 'toppings';
            $name = 'toppingName';
            handleDeleteRequest($table, $name);
        } else if (array_key_exists('deleteCreamQueryRequest', $_POST)) {
            $table = 'cream';
            $name = 'creamName';
            handleDeleteRequest($table, $name);
        }  else if (array_key_exists('deleteSweetenerQueryRequest', $_POST)) {
            $table = 'sweetener';
            $name = 'sweetName';
            handleDeleteRequest($table, $name);
        }

        disconnectFromDB();
    }
}

// HANDLE ALL GET ROUTES
// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
function handleGetRequest()
{
    if (connectToDB()) {
        if (array_key_exists('displayToppingsTuples', $_GET)) {
            $table = 'toppings';
            $name = 'TOPPINGNAME';
            $inv = 'TOPPINGINV';
            handleDisplayRequest($table, $name, $inv);
        } else if (array_key_exists('displayCreamTuples', $_GET)) {
            $table = 'cream';
            $name = 'CREAMNAME';
            $inv= 'CREAMINV';
            handleDisplayRequest($table, $name, $inv);
        } else if (array_key_exists('displaySweetenerTuples', $_GET)) {
            $table = 'sweetener';
            $name = 'SWEETNAME';
            $inv= 'SWEETENERINV';
            handleDisplayRequest($table, $name, $inv);
        } else if (array_key_exists('displayCoffeeTuples', $_GET)) {
            handleDisplayCoffeeRequest();
        }

        disconnectFromDB();
    }
}
if (isset($_GET['displayToppingsTuplesRequest']) ||
    isset($_GET['displayCreamTuplesRequest']) ||
    isset($_GET['displaySweetenerTuplesRequest']) ||
    isset($_GET['displayCoffeeTuplesRequest'])) {
    handleGetRequest();
} else if (isset($_POST['updateToppingsSubmit']) ||
    isset($_POST['updateCreamSubmit']) ||
    isset($_POST['updateSweetenerSubmit']) ||
    isset($_POST['updateCoffeeSubmit']) ||
    isset($_POST['insertToppingSubmit']) ||
    isset($_POST['insertCreamSubmit']) ||
    isset($_POST['insertSweetenerSubmit']) ||
    isset($_POST['deleteToppingSubmit']) ||
    isset($_POST['deleteCreamSubmit']) ||
    isset($_POST['deleteSweetenerSubmit'])) {

    handlePostRequest();
}
?>

</body>
</html>