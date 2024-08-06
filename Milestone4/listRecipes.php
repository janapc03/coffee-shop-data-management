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
	<title>Recipes</title>
	<style>
        p {
             font-family: "Trebuchet MS", sans-serif;
             }

         h1 {
            font-family: "Trebuchet MS", sans-serif;
             }

         h2 {
              font-family: "Trebuchet MS", sans-serif;
              }

         h3 {
              font-family: "Trebuchet MS", sans-serif;
              }

          .form-control {
            font-family: "Trebuchet MS", sans-serif;
          }
        </style>
</head>

<body>

    <?php include("homebar.php"); ?>

    <h1>Coffee Shop Recipes</h1>

    <hr />

    <div style="width:99%; margin:auto">
        <div style="display:inline-block; width:32%; vertical-align: top; border: 2px solid black">
        <h2>Insert New Caffeinated Coffee Recipe</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="insertCafQueryRequest" name="insertCafQueryRequest">
            <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
            <p>Coffee Size: </p><input type="text" name="inCoffeeSize"> <br /><br />
            <p>Roast Level:</p> <input type="text" name="inRoastLevel"> <br /><br />
            <p>Number of Espresso Shots:</p> <input type="number" name="inShots"> <br /><br />

            <input type="submit" value="Insert" name="insertCafSubmit"></p>
        </form>
        <h3>Insert Toppings, Creams, and Sweeteners to Coffee Recipes</h3>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="insertAddQueryRequest" name="insertAddQueryRequest">
            <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
            <p>Coffee Size: </p><input type="text" name="inCoffeeSize"> <br /><br />
           <p> Additions Name:</p> <input type="text" name="inAdd"> <br /><br />
            <p>Additions amount: </p><input type="text" name="inAddAm"> <br /><br />

            <input type="radio" id="topping" name="add" value="topping">
            <label for="topping">Toppings</label><br>
            <input type="radio" id="cream" name="add" value="cream">
            <label for="cream">Creams</label><br>
            <input type="radio" id="sweet" name="add" value="sweet">
            <label for="sweet">Sweeteners</label><br>

            <input type="submit" value="Insert" name="insertAddSubmit"></p>
        </form>
        </div>

        <div style="display:inline-block; width:33%; vertical-align: top; border: 2px solid black">
        <h2>Insert New Decaf Coffee Recipe</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="insertDecafQueryRequest" name="insertDecafQueryRequest">
            <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
           <p> Coffee Size:</p> <input type="text" name="inCoffeeSize"> <br /><br />
           <p> Roast Level:</p> <input type="text" name="inRoastLevel"> <br /><br />

            <input type="submit" value="Insert" name="insertDecafSubmit"></p>
        </form>
        <h3>Remove Toppings, Creams, and Sweeteners From Coffee Recipes</h3>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="deleteAddQueryRequest" name="deleteAddQueryRequest">
           <p> Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
           <p> Coffee Size: </p><input type="text" name="inCoffeeSize"> <br /><br />
           <p> Additions Name:</p> <input type="text" name="inAdd"> <br /><br />

            <input type="radio" id="topping" name="add" value="topping">
            <label for="topping">Toppings</label><br>
            <input type="radio" id="cream" name="add" value="cream">
            <label for="cream">Creams</label><br>
            <input type="radio" id="sweet" name="add" value="sweet">
            <label for="sweet">Sweeteners</label><br>

            <input type="submit" value="Delete" name="deleteAddSubmit"></p>
        </form>


        </div>

        <div style="display:inline-block; width:33%; vertical-align: top; border: 2px solid black">
        <h2>Delete Coffee Recipe</h2>
        <form method="POST" action="listRecipes.php">
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
           <p> Size:</p> <input type="text" name="inSize"> <br /><br />

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

        <hr />

        <h2>Display Iced Coffee Recipes</h2>
        <form method="GET" action="listRecipes.php">
            <input type="hidden" id="displayIceTuplesRequest" name="displayIceTuplesRequest">
            <input type="submit" value="Display Recipes" name="displayIceTuples"></p>
        </form>
        </div>
    </div>

    <hr />

    <div style="display:inline-block; width:99%; vertical-align: top">
    <div style="display:inline-block; width:32%; vertical-align: top; border: 2px solid black">
    <h2>Select Recipe to Ice</h2>
    <form method="POST" action="listRecipes.php">
        <input type="hidden" id="insertIceQueryRequest" name="insertIceQueryRequest">
        <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
        <p>Size:</p> <input type="text" name="inSize"> <br /><br />
        <p>Ice Amount:</p> <input type="text" name="inIce"> <br /><br />
        <p>Method of Iced Coffee:</p> <input type="text" name="inMethod"> <br /><br />

        <input type="submit" value="Ice" name="insertIceSubmit"></p>
    </form>
    </div>
    <div style="display:inline-block; width:33%; vertical-align: top; border: 2px solid black">
    <h2>Remove Iced Recipe</h2>
    <form method="POST" action="listRecipes.php">
        <input type="hidden" id="deleteIceQueryRequest" name="deleteIceQueryRequest">
        <p>Coffee Name:</p> <input type="text" name="inCoffeeName"> <br /><br />
       <p> Size: </p><input type="text" name="inSize"> <br /><br />

        <input type="submit" value="Delete" name="deleteIceSubmit"></p>
    </form>
    </div>
<div style="display:inline-block; width:33%; vertical-align: top; border: 2px solid black">
    <h2>Recipes With Additions</h2>
    <form method="GET" action="listRecipes.php">
        <input type="hidden" id="displayAddTuplesRequest" name="displayAddTuplesRequest">
        <p>Coffee Name: </p><input type="text" name="inCoffeeName"> <br /><br />

        <div>
        <input type="radio" id="caf" name="de_caf" value="caf">
        <label for="caf">Caffeinated</label><br>
        <input type="radio" id="decaf" name="de_caf" value="decaf">
        <label for="decaf">Decaffeinated</label><br>
        </div>

        <input type="submit" value="Display Addtional Toppings" name="displayAddToppingsTuples">
        <input type="submit" value="Display Addtional Creams" name="displayAddCreamTuples">
        <input type="submit" value="Display Addtional Sweeteners" name="displayAddSweetTuples">
    </form>

    <h2>List Recipes That Use All Additions</h2>
    <form method="GET" action="listRecipes.php">
        <input type="hidden" id="displayAllTuplesRequest" name="displayAllTuplesRequest">
        <input type="submit" value="Display Recipes With All Toppings" name="displayAllToppings">
        <input type="submit" value="Display Recipes With All Creams" name="displayAllCreams">
        <input type="submit" value="Display Recipes With All Sweeteners" name="displayAllSweeteners">
        </p>
    </form>

    <h2>List The Number of Additions for Recipes With Multiple Additions</h2>
    <form method="GET" action="listRecipes.php">
        <input type="hidden" id="displayNumTuplesRequest" name="displayNumTuplesRequest">
        <input type="submit" value="Display Recipes Number of Toppings" name="displayNumToppings">
        <input type="submit" value="Display Recipes Number of Creams" name="displayNumCreams">
        <input type="submit" value="Display Recipes Number of Sweeteners" name="displayNumSweeteners">
        </p>
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
			// ORA-01400: invalid NULL input
			// ORA-02291: no parent key
			// ORA-00001: already exists in table
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

			// ORA-01400: invalid NULL input
            // ORA-02291: no parent key
            // ORA-00001: already exists in table
			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
			    //echo "<br>INVALID INPUT, PLEASE TRY AGAIN<br>";
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

	function printCafResult($result)
	{ //prints results from a select statement
		echo "<table style=\"width:60%; text-align: center; margin-left:auto; margin-right:auto;  border-collapse: collapse;\">";
		echo "<tr style=\"border-bottom: 1px solid black\"><th>Name</th><th>Size</th><th>Inventory (kg)</th><th>Roast Level</th><th>Number of Espresso Shots</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEEINV'] . "</td><td style=\"padding: 15px;\">" . $row['ROASTLEVEL'] . "</td><td style=\"padding: 15px;\">" . $row['NUMSHOTS'] . "</td></tr>"; //or just use "echo $row[0]"
		}

		echo "</table>";
	}

	function printDecafResult($result)
    { //prints results from a select statement
        echo "<table style=\"width:50%; text-align: center; margin-left:auto; margin-right:auto;  border-collapse: collapse;\">";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Name</th><th>Size</th><th>Inventory (kg)</th><th>Roast Level</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEEINV'] . "</td><td style=\"padding: 15px;\">" . $row['ROASTLEVEL'] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

	function printIceResult($result)
    { //prints results from a select statement
        echo "<table style=\"width:75%; text-align: center; margin-left:auto; margin-right:auto;  border-collapse: collapse;\">";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Name</th><th>Size</th><th>Method</th><th>Ice Amount</th><th>Inventory (kg)</th><th>Roast Level</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['METHOD'] . "</td><td style=\"padding: 15px;\">" . $row['ICEAMOUNT'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEEINV'] . "</td><td style=\"padding: 15px;\">" . $row['ROASTLEVEL'] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printAddCafResult($result, $add, $addName, $addAmount)
    { //prints results from a select statement
        echo "<table style=\"width:60%; text-align: center; margin-left:auto; margin-right:auto; border-collapse: collapse;\">";
        echo "<h3 style=\"text-align: center\"> " . $add . " Used: </h3>";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Coffee Name</th><th>Size</th><th>Roast Level</th><th>Espresso Shots</th><th>" . $add . "</th><th>Amount</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['ROASTLEVEL'] . "</td><td style=\"padding: 15px;\">" . $row['NUMSHOTS'] . "</td><td style=\"padding: 15px;\">" . $row[$addName] . "</td><td style=\"padding: 15px;\">" . $row[$addAmount] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function printAddDecafResult($result, $add, $addName, $addAmount)
    { //prints results from a select statement
        echo "<table style=\"width:60%; text-align: center; margin-left:auto; margin-right:auto;  border-collapse: collapse;\">";
        echo "<h3 style=\"text-align: center\"> " . $add . " Used: </h3>";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Coffee Name</th><th>Size</th><th>Roast Level</th><th>" . $add . "</th><th>Amount</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['ROASTLEVEL'] . "</td><td style=\"padding: 15px;\">" . $row[$addName] . "</td><td style=\"padding: 15px;\">" . $row[$addAmount] . "</td></tr>"; //or just use "echo $row[0]"
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

		$resultC = executePlainSQL("SELECT coffeeInv FROM " . $table ."");
		$rowC = OCI_Fetch_Array($resultC, OCI_ASSOC);
		if (!$rowC) {
		    $inv = 'empty';
		} else {
		    $inv = $rowC['COFFEEINV'];
		}

		if ($table == 'caffeinated') {

		    $tuple = array(
                ":bind1" => $_POST['inCoffeeName'],
                ":bind2" => $_POST['inCoffeeSize'],
                ":bind3" => $inv,
                ":bind4" => $_POST['inRoastLevel'],
                ":bind5" => $_POST['inShots']
            );
		} else {
		    $tuple = array(
                ":bind1" => $_POST['inCoffeeName'],
                ":bind2" => $_POST['inCoffeeSize'],
                ":bind3" => $inv,
                ":bind4" => $_POST['inRoastLevel']
            );
		}

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

		if ($table == 'caffeinated') {
		    executeBoundSQL("insert into " . $table . " values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
        } else {
            executeBoundSQL("insert into " . $table . " values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
        }
        oci_commit($db_conn);
	}

	function handleInsertIceRequest()
	{
	    global $db_conn;

	    $tuple = array(
            ":bind1" => $_POST['inCoffeeName'],
            ":bind2" => $_POST['inSize'],
            ":bind3" => $_POST['inIce'],
            ":bind4" => $_POST['inMethod']
        );

        $alltuples = array(
            $tuple
        );

        executeBoundSQL("insert into icedCoffee values (:bind1, :bind2, :bind3, :bind4)", $alltuples);

	    oci_commit($db_conn);
	}

    function handleAddRequest()
    {
        global $db_conn;

        $tuple = array(
            ":bind1" => $_POST['inAdd'],
            ":bind2" => $_POST['inAddAm'],
            ":bind3" => $_POST['inCoffeeName'],
            ":bind4" => $_POST['inCoffeeSize']
        );

        $alltuples = array(
            $tuple
        );

        if (!array_key_exists('add', $_POST)) {
            echo "Additions option not clicked";
            exit();
        } if ($_POST['add'] == 'topping') {
            $table = 'addToppings';
        } else if ($_POST['add'] == 'cream') {
            $table = 'addCream';
        } else if ($_POST['add'] == 'sweet') {
            $table = 'addSweetener';
        } else {
            exit();
        }

        executeBoundSQL("insert into " . $table . " values (:bind1, :bind2, :bind3, :bind4)", $alltuples);

        oci_commit($db_conn);
    }

	function handleDisplayRequest($table)
	{
		global $db_conn;

		$result = executePlainSQL("SELECT * FROM " . $table ."");

		if ($table == 'caffeinated') {
            printCafResult($result);
		} else {
            printDecafResult($result);
		}

		oci_commit($db_conn);

	}

    function handleDisplayIceRequest()
    {
        global $db_conn;
        $result = executePlainSQL("SELECT DISTINCT * FROM icedcoffee i, caffeinated c WHERE i.coffeeName = c.coffeeName AND i.coffeeSize = c.coffeeSize");
        echo "<h3 style=\"text-align: center\">Iced Coffee Recipes</h3>";
        printIceResult($result);
        echo "<h3 style=\"text-align: center\">Iced Decaf Coffee Recipes</h3>";
        $result = executePlainSQL("SELECT DISTINCT * FROM icedcoffee i, decaf d WHERE i.coffeeName = d.coffeeName AND i.coffeeSize = d.coffeeSize");
        printIceResult($result);

        oci_commit($db_conn);
    }

    function handleDisplayAllRequest($add, $addName, $addOn, $addOnName, $titleName)
    {
        global $db_conn;
        $result = executePlainSQL("SELECT * FROM coffee c WHERE NOT EXISTS (SELECT " . $addName . " FROM " . $add . " WHERE NOT EXISTS (SELECT " . $addOnName . " FROM " . $addOn . " WHERE " . $addOnName . " = " . $addName . " AND a.coffeeName = c.coffeeName AND a.coffeeSize = c.coffeeSize))");

        echo "<h3 style=\"text-align: center\">Coffee Recipes that add all " . $titleName . "</h3>";
        echo "<table style=\"width:25%; text-align: center; margin-left:auto; margin-right:auto; border-collapse: collapse;\">";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Name</th><th>Size</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td></tr>"; //or just use "echo $row[0]"
        }
        echo "</table>";

        oci_commit($db_conn);
    }

    function handleDisplayAddRequest($table, $add, $addName, $addAmount)
    {
        global $db_conn;


        if (!array_key_exists('de_caf', $_GET)) {
            echo "Caffeine option not clicked";
            exit();
        } if ($_GET['de_caf'] == 'decaf') {
            $coffee = 'Decaf';
        } else if ($_GET['de_caf'] == 'caf') {
            $coffee = 'Caffeinated';
        } else {
            exit();
        }

        $name = $_GET['inCoffeeName'];

        if ($name == null) {
            echo "Invalid null input, please try again";
            exit();
        }

        $result = executePlainSQL("SELECT * FROM " . $table . " a, " . $coffee . " c WHERE c.coffeeName = '" . $name . "' AND a.coffeeName = c.coffeeName AND a.coffeeSize = c.coffeeSize");

        if ($coffee == 'Caffeinated') {
            printAddCafResult($result, $add, $addName, $addAmount);
        } else {
            printAddDecafResult($result, $add, $addName, $addAmount);
        }

        oci_commit($db_conn);
    }

    function handleDisplayNumRequest($table, $name, $titleName)
    {
        global $db_conn;
        $result = executePlainSQL("SELECT coffeeName, coffeeSize, COUNT(" .$name. ") as num FROM " . $table . " GROUP BY coffeeName, coffeeSize HAVING COUNT(*)>1");

        echo "<h3 style=\"text-align: center\">Coffee Recipes With Multiple " . $titleName . " and How Many</h3>";
        echo "<table style=\"width:25%; text-align: center; margin-left:auto; margin-right:auto;  border-collapse: collapse;\">";
        echo "<tr style=\"border-bottom: 1px solid black\"><th>Name</th><th>Size</th><th>Number of " . $titleName . "</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
            echo "<tr style=\"border-bottom: 1px solid black\"><td style=\"padding: 15px;\">" . $row['COFFEENAME'] . "</td><td style=\"padding: 15px;\">" . $row['COFFEESIZE'] . "</td><td style=\"padding: 15px;\">" . $row['NUM'] . "</td></tr>"; //or just use "echo $row[0]"
        }
        echo "</table>";

        oci_commit($db_conn);
    }

    function handleDeleteRequest($table)
    {
        global $db_conn;

        $delCoffee = $_POST['inCoffeeName'];
        $delSize = $_POST['inSize'];

        if ($delCoffee = null || $delSize == null) {
            echo "Invalid null input, please try again";
            exit();
        }

        executePlainSQL("DELETE FROM " . $table . " WHERE coffeeName='" . $delCoffee . "' AND coffeeSize='" . $delSize . "'");
        oci_commit($db_conn);
    }

    function handleDelAddRequest()
    {
        global $db_conn;

        if (!array_key_exists('add', $_POST)) {
            echo "Additions option not clicked";
            exit();
        } else if ($_POST['add'] == 'topping') {
            $table = 'addToppings';
            $addName = 'toppingName';
        } else if ($_POST['add'] == 'cream') {
            $table = 'addCream';
            $addName = 'creamName';
        } else if ($_POST['add'] == 'sweet') {
            $table = 'addSweetener';
            $addName = 'sweetName';
        } else {
            exit();
        }

        $name = $_POST['inCoffeeName'];
        $size = $_POST['inCoffeeSize'];
        $add = $_POST['inAdd'];

        if ($name = null || $size == null || $add == null) {
            echo "Invalid null input, please try again";
            exit();
        }

        $result = executePlainSQL("DELETE FROM " . $table . " WHERE coffeeName='" . $name . "' AND coffeeSize='" . $size . "' AND " . $addName . "='" . $add . "'");

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
			    $table = 'coffee';
                handleDeleteRequest($table);
            } else if (array_key_exists('insertIceQueryRequest', $_POST)) {
                handleInsertIceRequest();
            } else if (array_key_exists('deleteIceQueryRequest', $_POST)) {
                $table = 'icedCoffee';
                handleDeleteRequest($table);
            } else if (array_key_exists('insertAddQueryRequest', $_POST)) {
                handleAddRequest();
            } else if (array_key_exists('deleteAddQueryRequest', $_POST)) {
                handleDelAddRequest();
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
		        $table = 'caffeinated';
		        echo "<h3 style=\"text-align: center\">Caffeinated Coffee Recipes</h3>";
				handleDisplayRequest($table);
			} else if (array_key_exists('displayDecafTuples', $_GET)) {
			    $table = 'decaf';
			    echo "<h3 style=\"text-align: center\">Decaf Coffee Recipes</h3>";
			    handleDisplayRequest($table);
			} else if (array_key_exists('displayIceTuples', $_GET)) {
			    handleDisplayIceRequest();
            } else if (array_key_exists('displayAddToppingsTuples', $_GET)) {
                $table = 'addToppings';
                $add = 'Toppings';
                $addName = 'TOPPINGNAME';
                $addAmount = 'TOPPINGAMOUNT';
                handleDisplayAddRequest($table, $add, $addName, $addAmount);
            } else if (array_key_exists('displayAddCreamTuples', $_GET)) {
                $table = 'addCream';
                $add = 'Creams';
                $addName = 'CREAMNAME';
                $addAmount = 'CUPAMOUNT';
                handleDisplayAddRequest($table, $add, $addName, $addAmount);
            } else if (array_key_exists('displayAddSweetTuples', $_GET)) {
                $table = 'addSweetener';
                $add = 'Sweeteners';
                $addName = 'SWEETNAME';
                $addAmount = 'SWEETENERAMOUNT';
                handleDisplayAddRequest($table, $add, $addName, $addAmount);
            } else if (array_key_exists('displayAllToppings', $_GET)) {
                $add = 'toppings t';
                $addName = 't.toppingName';
                $addOn = 'addToppings a';
                $addOnName = 'a.toppingName';
                $titleName = 'Toppings';
                handleDisplayAllRequest($add, $addName, $addOn, $addOnName, $titleName);
            } else if (array_key_exists('displayAllCreams', $_GET)) {
                $add = 'cream cr';
                $addName = 'cr.creamName';
                $addOn = 'addCream a';
                $addOnName = 'a.creamName';
                $titleName = 'Creams';
                handleDisplayAllRequest($add, $addName, $addOn, $addOnName, $titleName);
            } else if (array_key_exists('displayAllSweeteners', $_GET)) {
                $add = 'sweetener s';
                $addName = 's.sweetName';
                $addOn = 'addSweetener a';
                $addOnName = 'a.sweetName';
                $titleName = 'Sweeteners';
                handleDisplayAllRequest($add, $addName, $addOn, $addOnName, $titleName);
            } else if (array_key_exists('displayNumToppings', $_GET)) {
                $table = 'addToppings';
                $name = 'toppingName';
                $titleName = 'Toppings';
                handleDisplayNumRequest($table, $name, $titleName);
            } else if (array_key_exists('displayNumCreams', $_GET)) {
                $table = 'addCream';
                $name = 'creamName';
                $titleName = 'Creams';
                handleDisplayNumRequest($table, $name, $titleName);
            } else if (array_key_exists('displayNumSweeteners', $_GET)) {
                $table = 'addSweetener';
                $name = 'sweetName';
                $titleName = 'Sweeteners';
                handleDisplayNumRequest($table, $name, $titleName);
            }

			disconnectFromDB();
		}
	}

	if (isset($_POST['insertCafSubmit']) || isset($_POST['insertDecafSubmit']) || isset($_POST['deleteSubmit']) ||
	    isset($_POST['insertIceSubmit']) || isset($_POST['deleteIceSubmit']) ||
	    isset($_POST['insertAddSubmit']) || isset($_POST['deleteAddSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayCafTuplesRequest']) || isset($_GET['displayDecafTuplesRequest']) ||
	            isset($_GET['displayIceTuplesRequest']) || isset($_GET['displayAddTuplesRequest']) ||
	            isset($_GET['displayAllTuplesRequest']) || isset($_GET['displayNumTuplesRequest'])) {
		handleGETRequest();
	}

	/*SELECT c.coffeeName FROM coffee c WHERE NOT EXISTS (SELECT cr.creamName FROM cream cr WHERE NOT EXISTS (SELECT a.creamName FROM addCream a WHERE a.creamName = cr.creamName AND a.coffeeName = c.coffeeName));*/

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

