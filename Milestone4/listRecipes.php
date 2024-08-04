<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_miaodan";			// change "cwl" to your own CWL
$config["dbpassword"] = "a92389279";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
?>

<html>

<head>
	<title>Coffee Shop</title>
</head>

<body>

    <?php include("homebar.php"); ?>

    <h1>Coffee Shop Recipes</h1>

    <hr />

    <div style="width:99%; margin:auto">
        <div style="display:inline-block; width:33%;">
        <h2>Insert New Caffeinated Coffee Recipes</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="insertCafQueryRequest" name="insertCafQueryRequest">
            Coffee Name: <input type="text" name="inCoffeeName"> <br /><br />
            Coffee Size: <input type="text" name="inCoffeeSize"> <br /><br />
            Coffee Inventory: <input type="text" name="inCoffeeInv"> <br /><br />
            Bean Type: <input type="text" name="inBeanType"> <br /><br />
            Roast Level: <input type="text" name="inRoastLevel"> <br /><br />

            <input type="submit" value="Insert" name="insertCafSubmit"></p>
        </form>
        </div>

        <div style="display:inline-block; width:33%;">
        <h2>Insert New Decaf Coffee Recipes</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="insertDecafQueryRequest" name="insertDecafQueryRequest">
            Coffee Name: <input type="text" name="inCoffeeName"> <br /><br />
            Coffee Size: <input type="text" name="inCoffeeSize"> <br /><br />
            Coffee Inventory: <input type="text" name="inCoffeeInv"> <br /><br />
            Bean Type: <input type="text" name="inBeanType"> <br /><br />
            Roast Level: <input type="text" name="inRoastLevel"> <br /><br />

            <input type="submit" value="Insert" name="insertDecafSubmit"></p>
        </form>
        </div>

        <div style="display:inline-block; width:33%;">
        <h2>Delete Coffee Recipe</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Coffee Name: <input type="text" name="inCoffeeName"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>
        <hr />

        <h2>Display Caffeinated Coffee Recipes</h2>
        <form method="GET" action="listRecipes.php">
            <input type="hidden" id="displayCafTuplesRequest" name="displayCafTuplesRequest">
            <input type="submit" value="Display Recipes" name="displayCafTuples"></p>
        </form>

        <hr />

        <h2>Display Decaf Coffee Recipes</h2>
        <form method="GET" action="listRecipes.php">
            <input type="hidden" id="displayDecafTuplesRequest" name="displayDecafTuplesRequest">
            <input type="submit" value="Display Recipes" name="displayDecafTuples"></p>
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

		// basically execute statement with multiple vars given

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
			    echo "<br>INVALID INPUT, PLEASE TRY AGAIN<br>";
				//echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				//echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

	function printResult($result)
	{ //prints results from a select statement
		echo "<table>";
		echo "<tr><th>Name</th><th>Size</th><th>Inventory</th><th>Bean Type</th><th>Roast Level</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row['COFFEENAME'] . "</td><td>" . $row['COFFEESIZE'] . "</td><td>" . $row['COFFEEINV'] . "</td><td>" . $row['BEANTYPE'] . "</td><td>" . $row['ROASTLEVEL'] . "</td></tr>"; //or just use "echo $row[0]"
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

	function handleInsertRequest($table)
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['inCoffeeName'],
			":bind2" => $_POST['inCoffeeSize'],
			":bind3" => $_POST['inCoffeeInv'],
			":bind4" => $_POST['inBeanType'],
			":bind5" => $_POST['inRoastLevel']
		);

		$alltuples = array(
			$tuple
		);

		$coffeetuple = array(
            ":bind11" => $_POST['inCoffeeName'],
            ":bind12" => $_POST['inCoffeeSize'],
        );

        $parenttuples = array(
            $coffeetuple
        );

		executeBoundSQL("insert into coffee values (:bind11, :bind12)", $parenttuples);

		oci_commit($db_conn);

		if ($success) {
	        executeBoundSQL("insert into $table values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);

    		oci_commit($db_conn);
		}
	}

	function handleDisplayCafRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM Caffeinated");
		echo "<h3>Caffeinated Coffee Recipes</h3>";
		printResult($result);

		oci_commit($db_conn);
	}

	function handleDisplayDecafRequest()
    {
        global $db_conn;
        $result = executePlainSQL("SELECT * FROM Decaf");
        echo "<h3>Decaf Coffee Recipes</h3>";
        printResult($result);

        oci_commit($db_conn);
    }

    function handleDeleteRequest()
    {
        global $db_conn;

        $delCoffee = $_POST['inCoffeeName'];

        executePlainSQL("DELETE FROM coffee WHERE coffeeName='" . $delCoffee . "'");
        oci_commit($db_conn);
    }

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('insertCafQueryRequest', $_POST)) {
			    $table = 'caffeinated';
				handleInsertRequest($table);
			} else if (array_key_exists('insertDecafQueryRequest', $_POST)) {
			    $table = 'decaf';
			    handleInsertRequest($table);
			} else if (array_key_exists('deleteQueryRequest', $_POST)) {
                handleDeleteRequest();
            }

			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
		    if (array_key_exists('displayCafTuples', $_GET)) {
				handleDisplayCafRequest();
			} else if (array_key_exists('displayDecafTuples', $_GET)) {
			    handleDisplayDecafRequest();
			}

			disconnectFromDB();
		}
	}

	if (isset($_POST['insertCafSubmit']) || isset($_POST['insertDecafSubmit']) || isset($_POST['deleteSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayCafTuplesRequest']) || isset($_GET['displayDecafTuplesRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

