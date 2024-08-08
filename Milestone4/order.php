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
	<title>Order</title>

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
             line-height: 10px;
             }

        .order {
            float: left;
            width: 70%;
            height: 590px;
            border: 2px solid black;
            padding: 0px 10px 10px 10px;
            }

        .shoppingCart {
            float: right;
            width: 25%;
            height: 590px;
            border: 2px solid black;
            padding: 0px 10px 10px 10px;
            line-height: 20px;
            }

        .items-table-container {
            width: 90%;
            }

        .shopping-list-table {
            float: right;
            width: 25%;
        }

    .dates-table {
        float: right;
    }

        nav {
            float: left;
            width: 18%;
            height: 600px;
            line-height: 10px;
            }

        .displaySales {
             box-sizing: border-box;
             -moz-box-sizing: border-box;
             -webkit-box-sizing: border-box;
             height: 360px;
             border: 2px solid black;
             padding: 0px 10px 10px 10px;
             }

        .categories {
            box-sizing: border-box;
             -moz-box-sizing: border-box;
             -webkit-box-sizing: border-box;
             height: 240px;
             border: 2px solid black;
             padding: 0px 10px 10px 10px;
             }


         .sales-table-container {
             position: absolute;
             top: 2px;
             left: 2px;
             width: auto;
             padding: 2px;
         }

      p {
          font-family: "Trebuchet MS", sans-serif;
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
  <nav class="salesAndCategories">
      <div class="categories">
           <h3><b> <u>Categories</u></b> </h3>
           <form method="GET" action="order.php">
                 <input type="hidden" id="displayToppingsTuplesRequest" name="displayToppingsTuplesRequest">
                 <input type="submit" value="Toppings" name="displayToppingsTuples"> </p>

                 <input type="hidden" id="displayCreamTuplesRequest" name="displayCreamTuplesRequest">
                 <input type="submit" value="Cream" name="displayCreamTuples"> </p>

                 <input type="hidden" id="displaySweetenerTuplesRequest" name="displaySweetenerTuplesRequest">
                 <input type="submit" value="Sweetener" name="displaySweetenerTuples"> </p>

                 <input type="hidden" id="displayCoffeeTuplesRequest" name="displayCoffeeTuplesRequest">
                 <input type="submit" value="Coffee Beans" name="displayCoffeeTuples"> </p>
                 </form>


           </div>

      <div class="displaySales">

        <h3><b><u>Sales</u></b> </h3>
        <div class="sales-table-container">
        <form method="GET" action="order.php">
            <input type="hidden" id="displaySalesTuplesRequest" name="displaySalesTuplesRequest">
            </form>
        </div>
        <p> Add New Sales Info:</p>
            <form method="POST" action="order.php">
                       <input type="hidden" id="insertFundsQueryRequest" name="insertFundsQueryRequest">
                       <p>Date (YYYY-MM-DD): </p><input type="text" name="currDate"> <br /><br />
                       <p>Cafe Funds: </p><input type="text" name="cafeFunds"> <br /><br />
                       <p>Employee Pay: </p><input type="text" name="employeePay"> <br /><br />

                       <input type="submit" value="Add" name="insertFunds"></p>
                       </form>
            </div>

        </nav>

    <article>
        <div class="order">
            <h2> Shop: </h2>

            <div class="items-table-container">
                    <form method="GET" action="order.php">
                        <input type="hidden" id="displayItemsTuplesRequest" name="displayItemsTuplesRequest">
                        </form>
                    </div>
            </div>

    <div class="shoppingCart">
        <h3><b><u>Shopping Cart</u></b> </h3>
        <p> View shopping list dates: </p>
        <form method="GET" action="order.php">
                      <input type="hidden" id="displaySlDatesRequest" name="displaySlDatesRequest">
                      <input type="submit" value="View Dates" name="viewSlDatesTuples"></p>
                      </form>
        <p> Input a date to view items ordered on that day. </p>
        <form method="GET" action="order.php">
              <input type="hidden" id="displayShoppingListRequest" name="displayShoppingListRequest">
              <p>Date:</p> <input type="date" name="shoppingListDate"> <br /><br />

              <input type="submit" value="View List" name="viewListTuples"></p>
              </form>
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
			    echo "<br>INVALID INPUT, PLEASE TRY AGAIN<br>";
				//echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				//echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}

    function printSalesResult($result)
        	{ //prints results from a select statement
        		echo '<br /><table class="sales-table">';
        		echo "<thead><tr><th>Sales Date</th><th>Employee Pay</th><th>Funds</th></tr><tbody>";

        		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

        			echo "<tr>";
                        echo "<td>" . $row['SALESDATE'] . "</td>";
                        echo "<td>" . $row['EMPLOYEEPAY'] . "</td>";
                        echo "<td>" . $row['CAFEFUNDS'] . "</td>";
                        echo "</tr>"; //or just use "echo $row[0]"
        		}

        		echo "</tbody></table>";
        	}

        function printItemsResult($result, $name, $inv)
                	{ //prints results from a select statement
                	echo "<br>Retrieved item data for chosen category: <br>";

                		echo '<br /><table class="items-table" align = "center" border = "1" cellpadding = "3" cellspacing = "0">';
                		echo "<tr><th>Name</th><th>Inventory (kg)</th></tr>";


                            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                                echo "<tr><td>" . $row[$name]  . "</td><td>" . $row[$inv]  . "</td></tr>";
                            }

                            echo "</table>";
                	}

        function printCoffeeResult($result)
        { //prints results from a select statement
        echo "<br>Retrieved item data for chosen category: <br>";

            echo '<br /><table class="items-table" align = "center" border = "1" cellpadding = "3" cellspacing = "0">';
            echo "<tr><th>Caffeinated Inventory (kg)</th><th>Decaffeinated Inventory (kg)</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<td>" . $row['CAF']  ."</td>";
                echo "<td>" . $row['DECAF']  . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }

    function printDatesResult($result)
            	{ //prints results from a select statement
            	echo "<br>Retrieved shopping list dates: <br>";
            		echo '<br /><table class="dates-table">';
            		echo "<thead><tr><th>Shopping List Date</th></tr><tbody>";

            		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

            			echo "<tr>";
                            echo "<td>" . $row['LISTDATE'] . "</td>";
                            echo "</tr>"; //or just use "echo $row[0]"
            		}

            		echo "</tbody></table>";
            	}

        function printShoppingListResult($result)
                	{ //prints results from a select statement

                		echo '<br /><table class="shopping-list-table">';
                		echo "<thead><tr><th>Name</th><th>Amount</th><th>Price</th></tr><tbody>";

                		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

                			echo "<tr>";
                                echo "<td>" . $row['ITEMNAME'] . "</td>";
                                echo "<td>" . $row['ITEMAMOUNT'] . "</td>";
                                echo "<td>" . $row['PRICE'] . "</td>";
                                echo "</tr>"; //or just use "echo $row[0]"
                		}

                		echo "</tbody></table>";
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

	function handleInsertFundsRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['currDate'],
			":bind2" => $_POST['employeePay'],
			":bind3" => $_POST['cafeFunds']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into sales
		values (to_date(:bind1, 'YYYY-MM-DD'), :bind2, :bind3)", $alltuples);
		oci_commit($db_conn);
	}

	function handleDisplaySalesRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM Sales ORDER BY salesDate DESC");
		printSalesResult($result);

		oci_commit($db_conn);
	}

function handleDisplayItemsRequest($table, $name, $inv)
{
    global $db_conn;
    $result = executePlainSQL("SELECT * FROM Sales");
        printSalesResult($result);

    $result = executePlainSQL("SELECT * FROM " . $table . "");
    printItemsResult($result, $name, $inv);

    oci_commit($db_conn);
}

function handleDisplayCoffeeRequest()
{
    global $db_conn;

    $result = executePlainSQL("SELECT * FROM Sales");
    printSalesResult($result);

    $result = executePlainSQL("SELECT DISTINCT c.coffeeInv as caf, d.coffeeInv as decaf FROM caffeinated c, decaf d");
    printCoffeeResult($result);

    oci_commit($db_conn);
}

function handleDisplayDatesRequest()
	{
		global $db_conn;

		$result = executePlainSQL("SELECT * FROM Sales");
                printSalesResult($result);

		$result = executePlainSQL("SELECT listDate FROM ShoppingList");
		printDatesResult($result);

		oci_commit($db_conn);
	}

function handleDisplayShoppingListRequest()
{
    global $db_conn;

    $listDate = $_GET['shoppingListDate'];

    if ($listDate == null) {
        echo "<br>Invalid null input, please try again with an input date.<br>";
        exit();
    }

    $result = executePlainSQL("SELECT Count(*) FROM shoppingList WHERE listDate=to_date('$listDate','YYYY-MM-DD')");
    if (($row = oci_fetch_row($result)) != false ) {
        if ($row[0] == 0) {
            echo "Invalid input, date does not exist";
            exit();
        }
    }

    $result = executePlainSQL("SELECT * FROM Sales");
        printSalesResult($result);

    $result = executePlainSQL("SELECT toppingName AS ITEMNAME, toppingQuant as ITEMAMOUNT, price as PRICE
        FROM listToppings lt
        WHERE  lt.listDate=to_date('$listDate','YYYY-MM-DD')
        UNION
        SELECT sweetName AS ITEMNAME, sweetenerQuant as ITEMAMOUNT, price as PRICE
        FROM listSweetener ls
        WHERE  ls.listDate=to_date('$listDate','YYYY-MM-DD')
        UNION
        SELECT creamName AS ITEMNAME, creamQuant as ITEMAMOUNT, price as PRICE
        FROM listCream lc
        WHERE  lc.listDate=to_date('$listDate','YYYY-MM-DD')
        UNION
        SELECT coffeeName AS ITEMNAME, coffeeQuant as ITEMAMOUNT, price as PRICE
        FROM listCoffee1 lcf1, listCoffee2 lcf2
        WHERE  lcf1.listDate=to_date('$listDate','YYYY-MM-DD') AND lcf1.listDate=lcf2.listDate");

        /*if (oci_num_rows($result) == 0) {
                echo "<br>Invalid input, shopping list for that date does not exist.<br>";
            } else {
                echo "<br style='float:right;'>Retrieved shopping list data for chosen date: <br>";
            }*/
    printShoppingListResult($result);

    oci_commit($db_conn);
}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('insertFundsQueryRequest', $_POST)) {
				handleInsertFundsRequest();
				handleDisplaySalesRequest();
			}

			disconnectFromDB();
		}
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
                if (array_key_exists('displayToppingsTuples', $_GET)) {
                    $table = 'toppings';
                    $name = 'TOPPINGNAME';
                    $inv = 'TOPPINGINV';
                    handleDisplayItemsRequest($table, $name, $inv);
                } else if (array_key_exists('displayCreamTuples', $_GET)) {
                    $table = 'cream';
                    $name = 'CREAMNAME';
                    $inv= 'CREAMINV';
                    handleDisplayItemsRequest($table, $name, $inv);
                } else if (array_key_exists('displaySweetenerTuples', $_GET)) {
                    $table = 'sweetener';
                    $name = 'SWEETNAME';
                    $inv= 'SWEETENERINV';
                    handleDisplayItemsRequest($table, $name, $inv);
                } else if (array_key_exists('displayCoffeeTuples', $_GET)) {
                    handleDisplayCoffeeRequest();
                } else if (array_key_exists('viewListTuples', $_GET)) {
                    handleDisplayShoppingListRequest();
                } else if (array_key_exists('viewSlDatesTuples', $_GET)) {
                    handleDisplayDatesRequest();
                }

			disconnectFromDB();
		}
	}

	if (isset($_POST['insertFunds'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayToppingsTuplesRequest']) ||
               isset($_GET['displayCreamTuplesRequest']) ||
               isset($_GET['displaySweetenerTuplesRequest']) ||
               isset($_GET['displayCoffeeTuplesRequest']) ||
               isset($_GET['displayItemsTuplesRequest']) ||
               isset($_GET['displayShoppingListRequest']) ||
               isset($_GET['displaySlDatesRequest']))
               {
               handleGETRequest();
	} else {
	if (connectToDB())
	    handleDisplaySalesRequest();
	    disconnectFromDB();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

