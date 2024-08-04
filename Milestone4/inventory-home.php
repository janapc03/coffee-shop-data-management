
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database access configuration
$config["dbuser"] = "ora_jbarlesc";			// change "cwl" to your own CWL
$config["dbpassword"] = "a43974147";	// change to 'a' + your student number
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

<h1>Inventory of toppings</h1>
<form method="GET" action="inventory-toppings.php">
    <input type="hidden" id="displayToppingsTuplesRequest" name="displayToppingsTuplesRequest">
    <input type="submit" name="displayToppingsTuples"> </p>
</form>
<hr/>

<h1>Inventory of creams</h1>
<form method="GET" action="inventory-toppings.php">
    <input type="hidden" id="displayCreamTuplesRequest" name="displayCreamTuplesRequest">
    <input type="submit" name="displayCreamTuples"> </p>
</form>
<hr/>

<h1>Inventory of sweeteners</h1>
<form method="GET" action="inventory-toppings.php">
    <input type="hidden" id="displaySweetenerTuplesRequest" name="displaySweetenerTuplesRequest">
    <input type="submit" name="displaySweetenerTuples"> </p>
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

function handleDisplayRequest($table, $name, $inv)
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM " . $table . "");
    printResult($result, $name, $inv);

    oci_commit($db_conn);
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
        }

        disconnectFromDB();
    }
}
if (isset($_GET['displayToppingsTuplesRequest']) ||
    isset($_GET['displayCreamTuplesRequest']) ||
    isset($_GET['displaySweetenerTuplesRequest'])) {
    handleGetRequest();
}
?>

<hr/>

</body>
</html>