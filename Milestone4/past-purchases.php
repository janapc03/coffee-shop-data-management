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
             border: 2px solid black;
             line-height: 10px;
             }

        .items-table-container {
            width: 90%;
            }
        .displayArea {
        padding: 10px 10px 10px 10px
        }

        nav {
            float: left;
            width: 18%;
            height: 600px;
            border: 2px solid black;
            line-height: 20px;
            }

        .userOptions {
        padding: 10px 10px 10px 10px
        }

        .displaySales {
             box-sizing: border-box;
             -moz-box-sizing: border-box;
             -webkit-box-sizing: border-box;
             height: 360px;
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
  <nav>
      <div class="userOptions">
      <h3><u><b>Options</b></u></h3>
      <div class="userButtons">
          <p> Find the average amount spent at each supplier: </p>
          <form method="GET" action="past-purchases.php">
               <input type="hidden" id="displayAvgCostsRequest" name="displayAvgCostsRequest">
               <p><input type="submit" value="Average Costs" name="displayAvgCostsTuples"></p>

               <input type="hidden" id="displayAggregationRequest" name="displayAggregationRequest">

               <p>Find the number of items that were purchased at a below average price:</p>

               <input type="radio" id="topping" name="add" value="topping">
               <label for="topping">Toppings</label><br>
               <input type="radio" id="cream" name="add" value="cream">
               <label for="cream">Creams</label><br>
               <input type="radio" id="sweet" name="add" value="sweet">
               <label for="sweet">Sweeteners</label><br>
               <input type="radio" id="coffee" name="add" value="coffee">
               <label for="coffee">Coffee</label><br>
               <p><input type="submit" name="displayAggregationTuples"></p>

              </form>
          </div>
</div>
        </nav>

    <article>
        <div class="displayArea">
        <h2>Past Purchases</h2>
        <form method="GET" action="past-purchases.php">
            <input type="hidden" id="displayPastPurchases" name="displayPastPurchases">
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

    function printResult($result)
        	{ //prints results from a select statement
        	echo "<br>Data for all past purchases:<br>";
        		echo '<br /><table class="past-purchases-table">';
        		echo "<thead><tr><th>Tracking Num.</th><th>Expected By</th><th>Supplier</th><th>Order Date</th><th>Total Cost</th></tr><tbody>";

        		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

        			echo "<tr>";
                        echo "<td>" . $row['TRACKINGNUM'] . "</td>";
                        echo "<td>" . $row['EXPECTEDDATE'] . "</td>";
                        echo "<td>" . $row['SUPNAME'] . "</td>";
                        echo "<td>" . $row['LISTDATE'] . "</td>";
                        echo "<td>" . $row['PRICE'] . "</td>";
                        echo "</tr>"; //or just use "echo $row[0]"
        		}

        		echo "</tbody></table>";
        	}

    function printTabResult($result, $quant)
        	{ //prints results from a select statement
        	echo "<br>Data for all past purchases:<br>";
        		echo '<br /><table class="past-purchases-table">';
        		echo "<thead><tr><th>Order Date</th><th>Quantity</th><th>Total Cost</th></tr><tbody>";

        		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

        			echo "<tr>";
                        echo "<td>" . $row['LISTDATE'] . "</td>";
                        echo "<td>" . $row[$quant] . "</td>";
                        echo "<td>" . $row['PRICE'] . "</td>";
                        echo "</tr>"; //or just use "echo $row[0]"
        		}

        		echo "</tbody></table>";
        	}

    function printAvgResult($result)
            	{ //prints results from a select statement
            	echo "<br>Retrieved data regarding average order cost by supplier:<br>";
            		echo '<br /><table class="avg-cost-table">';
            		echo "<thead><tr><th>Supplier</th><th>Num. of Orders</th><th>Average Order Cost</th></tr><tbody>";

            		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

            			echo "<tr>";
                            echo "<td>" . $row['SUPNAME'] . "</td>";
                            echo "<td>" . $row['COUNT_SUPNAME'] . "</td>";
                            echo "<td>" . $row['AVG_PRICE'] . "</td>";
                            echo "</tr>"; //or just use "echo $row[0]"
            		}

            		echo "</tbody></table>";
            	}

    function printAggregationResult($result)
                	{ //prints results from a select statement
                	echo "<br>Retrieved data regarding number of purchased items below average price: <br>";
                		echo '<br /><table class="aggregation-table">';
                		echo "<thead><tr><th>Name</th><th>Amount</th><th>Price</th></tr><tbody>";

                		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {

                			echo "<tr>";
                            echo "<td>" . $row['ITEMNAME'] . "</td>";
                            echo "<td>" . $row['ITEMAMOUNT'] . "</td>";
                            echo "<td>" . $row['ITEMPRICE'] . "</td>";
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

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['inItemName'],
			":bind2" => $_POST['inItemQty']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into demoTable values (:bind1, :bind2)", $alltuples);
		oci_commit($db_conn);
	}

	function handleDisplayAvgCostRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT d.supName AS SUPNAME, COUNT(d.supName) AS COUNT_SUPNAME, AVG(p.price) AS AVG_PRICE
		 FROM Deliver d, Delivery dy, Purchase p, ShoppingList sl
		 WHERE d.trackingNum=dy.trackingNum
		 AND dy.trackingNum=p.trackingNum
		 AND p.listDate=sl.listDate
		 GROUP BY d.supName");
		printAvgResult($result);

		oci_commit($db_conn);
	}

function handleDisplayRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT d.trackingNum, dy.expectedDate, d.supName, p.listDate, p.price
		 FROM Deliver d, Delivery dy, Purchase p, ShoppingList sl
		 WHERE d.trackingNum=dy.trackingNum
		 AND dy.trackingNum=p.trackingNum
		 AND p.listDate=sl.listDate");
		printResult($result);

		oci_commit($db_conn);
	}

function handleDisplayAggregationRequest()
	{
		global $db_conn;

		$result = executePlainSQL("SELECT d.trackingNum, dy.expectedDate, d.supName, p.listDate, p.price
        		 FROM Deliver d, Delivery dy, Purchase p, ShoppingList sl
        		 WHERE d.trackingNum=dy.trackingNum
        		 AND dy.trackingNum=p.trackingNum
        		 AND p.listDate=sl.listDate");
        		printResult($result);

        if (!array_key_exists('add', $_GET)) {
            echo "Additions option not clicked";
            exit();
        }else if ($_GET['add'] == 'topping') {
            $table = 'listToppings';
            $quant = 'TOPPINGQUANT';
        } else if ($_GET['add'] == 'cream') {
            $table = 'listCream';
            $quant = 'CREAMQUANT';
        } else if ($_GET['add'] == 'sweet') {
            $table = 'listSweetener';
            $quant = 'SWEETENERQUANT';
        } else if ($_GET['add'] == 'coffee') {
            $table = 'listCoffee2';
            $quant = 'COFFEEQUANT';
        }else {
            exit();
        }

        $result = executePlainSQL("SELECT * FROM " . $table . "");
        printTabResult($result, $quant);
        $result = executePlainSQL("SELECT AVG(price) FROM " . $table . " ");
        if (($row = oci_fetch_row($result)) != false) {

            echo "<br> The average price of " . $_GET['add'] . " is: $" . $row[0] . "<br>";
        }

        $result = executePlainSQL("SELECT COUNT(*) FROM " . $table . " WHERE price < (SELECT AVG(price) FROM " . $table . ")");
        if (($row = oci_fetch_row($result)) != false) {
        echo "<br>Retrieved data regarding number of purchased items below average price: <br>";

            echo "<br> The number of " . $_GET['add'] . " purchases below its average price: " . $row[0] . "<br>";
        }

		/*$result = executePlainSQL("SELECT toppingName AS ITEMNAME, toppingQuant as ITEMAMOUNT, lt.price as ITEMPRICE
                                            FROM listToppings lt
                                            UNION
                                            SELECT sweetName AS ITEMNAME, sweetenerQuant as ITEMAMOUNT, ls.price as ITEMPRICE
                                            FROM listSweetener ls
                                            UNION
                                            SELECT creamName AS ITEMNAME, creamQuant as ITEMAMOUNT, lc.price as ITEMPRICE
                                            FROM listCream lc
                                            UNION
                                            SELECT coffeeName AS ITEMNAME, coffeeQuant as ITEMAMOUNT, lcf2.price as ITEMPRICE
                                            FROM listCoffee1 lcf1, listCoffee2 lcf2
                                            WHERE lcf1.listDate=lcf2.listDate");
                                        printAggregationResult($result);*/

		oci_commit($db_conn);
	}


	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('insertCartQueryRequest', $_POST)) {
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
                if (array_key_exists('displayAvgCostsTuples', $_GET)) {
                    handleDisplayAvgCostRequest();
                } else if(array_key_exists('displayAggregationTuples', $_GET)) {
                    handleDisplayAggregationRequest();
                }

			disconnectFromDB();
		}
	}

	if (isset($_POST['updateSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayAvgCostsRequest']) ||
               isset($_GET['displayAggregationRequest']))  {
               handleGetRequest();
	} else {
	if (connectToDB())
	    handleDisplayRequest();
	    disconnectFromDB();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

