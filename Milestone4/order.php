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
$config["dbuser"] = "ora_janapchi";			// change "cwl" to your own CWL
$config["dbpassword"] = "a87884193";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
// !!! Make UpdateFundsQueryRequest()
?>


<html>

<head>
	<title>Coffee Shop</title>

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
             }

        .order {
            float: left;
            width: 70%;
            height: 600px;
            border: 2px solid black;
            padding: 10px 10px 10px 10px;
            }
        .shoppingCart {
            float: right;
            width: 25%;
            height: 400px;
            border: 2px solid black;
            padding: 10px 10px 10px 10px;
            }

        nav {
            float: left;
            border: 2px solid black;
            width: 18%;
            height: 600px;
            background-color: #ffe6e6;
            }

        .displayFunds {
             height: 300px;
             border: 2px solid black;
             padding: 10px 10px 10px 10px;
             }

        .categories {
             height: 200px;
             border: 2px solid black;
             padding: 10px 10px 10px 10px;
             }

        table {
             width: 90%;
             }

    </style>

</head>

<body>
<section class="container">
  <nav class="fundsAndCategories">
      <div class="displayFunds">

        <p> <u>Sales</u> </p>
        <p> Cafe Funds: </p>
        <p> Employee Pay: </p>
            <form method="POST" action="order.php">
                       <input type="hidden" id="updateFundsQueryRequest" name="updateFundsQueryRequest">
                       Cafe Funds: <input type="text" name="cafeFunds"> <br /><br />
                       Employee Pay: <input type="text" name="employeePay"> <br /><br />

                       <input type="submit" value="Update" name="updateFunds"></p>
                       </form>
            </div>

        <div class="categories">
                    <p>Espresso</p>
                    <p>Toppings</p>
                    <p>Cream</p>
                    <p>Sweetener</p>
            </div>
        </nav>

    <article>
        <div class="order">
            <h2> Inventory: </h2>

            <table align = "center" border = "1" cellpadding = "3" cellspacing = "0">
                        <tr>
                        <td>Name</td>
                        <td>Inventory Quantity</td>
                        <td>Supplier</td>
                        </tr>
                        <?php
                        $x = 1;
                        while($x <= 5) {
                            echo "<tr>";
                          echo "<td> $x*$x </td>";
                          echo "<td>" .$x*$x. "</td>";
                           echo "<td>" .$x*$x*$x. "</td>";
                            echo "</tr>";
                          $x++;
                        }
                    ?>
                    </table>

            <div class="addToCart">
                <p>The values are case sensitive.</p>

                	<form method="POST" action="order.php">
                		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
                		Item Name: <input type="text" name="itemName"> <br /><br />
                		Quantity: <input type="text" name="itemQty"> <br /><br />

                		<input type="submit" value="Add to Cart" name="addToCart"></p>
                	</form>
                </div>
            </div>

    <div class="shoppingCart">
        <p> <u>Shopping Cart</u> </p>
        </div>

        </article>
    </section>



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

	function printResult($result)
	{ //prints results from a select statement
		echo "<br>Retrieved data from table Caffeinated:<br>";
		echo "<table>";
		echo "<tr><th>Name</th><th>Size</th><th>Inventory</th><th>Bean Type</th><th>Roast Level</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
			echo "<tr><td>" . $row['COFFEENAME'] . "</td><td>" .
			$row['COFFEESIZE'] . "</td><td>" . $row['COFFEEINV'] . "</td><td>" . $row['BEANTYPE'] . "</td><td>" . $row['ROASTLEVEL'] . "</td></tr>"; //or just use "echo $row[0]"
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

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['insNo'],
			":bind2" => $_POST['insName']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
	}

	function handleDisplayCafRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM Caffeinated");
		printResult($result);

		oci_commit($db_conn);
	}

	function handleDisplayDecafRequest()
    {
        global $db_conn;
        $result = executePlainSQL("SELECT * FROM Decaf");
        printResult($result);

        oci_commit($db_conn);
    }

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
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

	if (isset($_POST['updateSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayCafTuplesRequest']) || isset($_GET['displayDecafTuplesRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

