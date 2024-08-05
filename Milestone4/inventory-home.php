
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

<h1>Inventory of toppings</h1>
<form method="GET" action="inventory-home.php">
    <input type="hidden" id="displayToppingsTuplesRequest" name="displayToppingsTuplesRequest">
    <input type="submit" name="displayToppingsTuples"> </p>
</form>

<h2>Update Inventory of Toppings</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="updateToppingsRequest" name="updateToppingsRequest">
    Toppings name: <input type="text" name="name"> <br /><br />
    Updated inventory: <input type="text" name="inv"> <br /><br />

    <input type="submit" value="Update" name="updateToppingsSubmit"></p>
</form>

<h2>Insert New Topping</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="insertToppingQueryRequest" name="insertToppingQueryRequest">
    Topping Name: <input type="text" name="inName"> <br /><br />
    Amount in inventory: <input type="text" name="inInv"> <br /><br />

    <input type="submit" value="Insert" name="insertToppingSubmit"></p>
</form>

<hr/>

<h1>Inventory of creams</h1>
<form method="GET" action="inventory-home.php">
    <input type="hidden" id="displayCreamTuplesRequest" name="displayCreamTuplesRequest">
    <input type="submit" name="displayCreamTuples"> </p>
</form>

<h2>Update Inventory of Creams</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="updateCreamRequest" name="updateCreamRequest">
    Cream name: <input type="text" name="name"> <br /><br />
    Updated inventory: <input type="text" name="inv"> <br /><br />

    <input type="submit" value="Update" name="updateCreamSubmit"></p>
</form>

<h2>Insert New Cream</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="insertCreamQueryRequest" name="insertCreamQueryRequest">
    Topping Name: <input type="text" name="inName"> <br /><br />
    Amount in inventory: <input type="text" name="inInv"> <br /><br />

    <input type="submit" value="Insert" name="insertCreamSubmit"></p>
</form>

<hr/>

<h1>Inventory of sweeteners</h1>
<form method="GET" action="inventory-home.php">
    <input type="hidden" id="displaySweetenerTuplesRequest" name="displaySweetenerTuplesRequest">
    <input type="submit" name="displaySweetenerTuples"> </p>
</form>

<h2>Update Inventory of Sweeteners</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="updateSweetenerRequest" name="updateSweetenerRequest">
    Sweetener name: <input type="text" name="name"> <br /><br />
    Updated inventory: <input type="text" name="inv"> <br /><br />

    <input type="submit" value="Update" name="updateSweetenerSubmit"></p>
</form>

<hr/>

<h1>Inventory of Caffeinated Coffee Beans</h1>
<form method="GET" action="inventory-home.php">
    <input type="hidden" id="displayCafTuplesRequest" name="displayCafTuplesRequest">
    <input type="submit" name="displayCafTuples"> </p>
</form>

<h2>Update Inventory of Caffeinated Coffee Beans</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="updateCafRequest" name="updateCafRequest">
    Coffee bean name: <input type="text" name="name"> <br /><br />
    Updated inventory: <input type="text" name="inv"> <br /><br />

    <input type="submit" value="Update" name="updateCafSubmit"></p>
</form>

<hr/>

<h1>Inventory of Decaffeinated Coffee Beans</h1>
<form method="GET" action="inventory-home.php">
    <input type="hidden" id="displayDecafTuplesRequest" name="displayDecafTuplesRequest">
    <input type="submit" name="displayDecafTuples"> </p>
</form>

<h2>Update Inventory of Decaffeinated Coffee Beans</h2>
<form method="POST" action="inventory-home.php">
    <input type="hidden" id="updateDecafRequest" name="updateDecafRequest">
    Coffee bean name: <input type="text" name="name"> <br /><br />
    Updated inventory: <input type="text" name="inv"> <br /><br />

    <input type="submit" value="Update" name="updateDecafSubmit"></p>
</form>

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

    //$toppingtuple = array(
    //    ":bind11" => $_POST['inToppingName'],
     //   ":bind12" => $_POST['inToppingInv'],
    //);

    //$parenttuples = array(
    //    $toppingtuple
    //);

    //executeBoundSQL("insert into coffee values (:bind11, :bind12)", $parenttuples);

    //oci_commit($db_conn);

    executeBoundSQL("insert into " . $table . " values (:bind1, :bind2)", $alltuples);

    oci_commit($db_conn);
}

function handleDisplayRequest($table, $name, $inv)
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM " . $table . "");
    printResult($result, $name, $inv);

    oci_commit($db_conn);
}

function handleDisplayCoffeeRequest($table, $name, $inv)
{
    global $db_conn;
    $result = executePlainSQL("SELECT DISTINCT beanType, coffeeInv FROM " . $table . "");
    printResult($result, $name, $inv);

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
            } else if (array_key_exists('updateCafRequest', $_POST)) {
                $table = 'caffeinated';
                $inv = 'coffeeInv';
                $name = 'beanType';
                handleUpdateRequest($table, $inv, $name);
            } else if (array_key_exists('updateDecafRequest', $_POST)) {
                $table = 'decaf';
                $inv = 'coffeeInv';
                $name = 'beanType';
                handleUpdateRequest($table, $inv, $name);
            } else if (array_key_exists('insertToppingQueryRequest', $_POST)) {
                $table = 'toppings';
                handleInsertRequest($table);
            } else if (array_key_exists('insertCreamQueryRequest', $_POST)) {
                $table = 'cream';
                handleInsertRequest($table);
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
        } else if (array_key_exists('displayCafTuples', $_GET)) {
            $table = 'caffeinated';
            $name = 'BEANTYPE';
            $inv= 'COFFEEINV';
            handleDisplayCoffeeRequest($table, $name, $inv);
        } else if (array_key_exists('displayDecafTuples', $_GET)) {
            $table = 'decaf';
            $name = 'BEANTYPE';
            $inv= 'COFFEEINV';
            handleDisplayCoffeeRequest($table, $name, $inv);
        }

        disconnectFromDB();
    }
}
if (isset($_GET['displayToppingsTuplesRequest']) ||
    isset($_GET['displayCreamTuplesRequest']) ||
    isset($_GET['displaySweetenerTuplesRequest']) ||
    isset($_GET['displayCafTuplesRequest']) ||
    isset($_GET['displayDecafTuplesRequest'])) {
    handleGetRequest();
} else if (isset($_POST['updateToppingsSubmit']) ||
            isset($_POST['updateCreamSubmit']) ||
            isset($_POST['updateSweetenerSubmit']) ||
            isset($_POST['updateCafSubmit']) ||
            isset($_POST['updateDecafSubmit']) ||
            isset($_POST['insertToppingSubmit']) ||
            isset($_POST['insertCreamSubmit'])) {
    handlePostRequest();
}
?>

<hr/>

</body>
</html>