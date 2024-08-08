<?php

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
        <p class="note">Note: Not all attribute boxes need to be filled, but put the attribute name in
            the corresponding number text box (i.e. 'CREAMINV' is the 2nd attribute of 'Cream', so
            write it in the 'Attribute 2' textbox)</p>
        <p>Input attribute names in ALL CAPS</p>
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
        	echo "<br>Retrieved attribute names from selected table:<br>";
        		echo '<br /><table class="attributes-table">';
        		echo "<thead><tr><th>Attribute Num.</th><th>Attribute Name</th></tr><tbody>";

                $attributeNumber = 1;

        		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
        			echo "<tr>";
                        echo "<td>" . $attributeNumber . "</td>";
                        echo "<td>" . $row['COLUMN_NAME'] . "</td>";
                        echo "</tr>"; //or just use "echo $row[0]"
                        $attributeNumber++;
        		}

        		echo "</tbody></table>";
        	}

       function printSelectedTableResult($result, $attributes)
            	{ //prints results from a select statement
            	echo "<br>Retrieved data with selected attributes from chosen table:<br>";
            		echo '<br /><table class="selected-table">';
            		echo "<thead><tr>";

                       foreach ($attributes as $attr) {
                               if (!empty($attr)) {
                                   echo "<th>$attr</th>";
                               }
                           }
                     echo "</tr></thead><tbody>";

            		while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
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


function handleDisplayAttsRequest($currentTable)
	{
		global $db_conn;
		$result = executePlainSQL("SELECT COLUMN_NAME
		    FROM user_tab_columns
		    WHERE table_name='$currentTable'");
		printResult($result);

		oci_commit($db_conn);
	}

function handleDisplaySelectedTableRequest($currentTable, $attributes)
	{
		global $db_conn;

		$nonEmptyAttrs = array_filter($attributes); // Filter out empty attributes
            if (!empty($nonEmptyAttrs)) {
                $attrs = implode(", ", $nonEmptyAttrs);
                $query = "SELECT $attrs FROM $currentTable";
                $result = executePlainSQL($query);
                printSelectedTableResult($result, $nonEmptyAttrs);
                oci_commit($db_conn);
	}
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
                if (array_key_exists('displayToppingsAtts', $_GET)) {
                    $currentTable = 'TOPPINGS';
                    handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayCoffeeAtts', $_GET)) {
                    $currentTable = 'COFFEE';
                    handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayCreamAtts', $_GET)) {
                     $currentTable = 'CREAM';
                     handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displaySweetenerAtts', $_GET)) {
                    $currentTable = 'SWEETENER';
                    handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayDecafAtts', $_GET)) {
                    $currentTable = 'DECAF';
                    handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayCaffeinatedAtts', $_GET)) {
                    $currentTable = 'CAFFEINATED';
                    handleDisplayAttsRequest($currentTable);
                }else if (array_key_exists('displayIcedCoffeeAtts', $_GET)) {
                     $currentTable = 'ICEDCOFFEE';
                     handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayDeliveryAtts', $_GET)) {
                     $currentTable = 'DELIVERY';
                     handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displaySupplierAtts', $_GET)) {
                     $currentTable = 'SUPPLIER';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayShoppingListAtts', $_GET)) {
                      $currentTable = 'SHOPPINGLIST';
                      handleDisplayAttsRequest($currentTable);
                }else if (array_key_exists('displayPurchaseAtts', $_GET)) {
                      $currentTable = 'PURCHASE';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displaySalesAtts', $_GET)) {
                      $currentTable = 'SALES';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayFundAtts', $_GET)) {
                      $currentTable = 'FUND';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayListToppingsAtts', $_GET)) {
                      $currentTable = 'LISTTOPPINGS';
                      handleDisplayAttsRequest($currentTable);
                }else if (array_key_exists('displayListCreamAtts', $_GET)) {
                      $currentTable = 'LISTCREAM';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayListSweetenerAtts', $_GET)) {
                      $currentTable = 'LISTSWEETENER';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayListCoffee1Atts', $_GET)) {
                      $currentTable = 'LISTCOFFEE1';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayListCoffee2Atts', $_GET)) {
                       $currentTable = 'LISTCOFFEE2';
                      handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayAddToppingsAtts', $_GET)) {
                       $currentTable = 'ADDTOPPINGS';
                       handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayAddCreamAtts', $_GET)) {
                       $currentTable = 'ADDCREAM';
                       handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayAddSweetenerAtts', $_GET)) {
                       $currentTable = 'ADDSWEETENER';
                       handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('displayDeliverAtts', $_GET)) {
                       $currentTable = 'DELIVER';
                       handleDisplayAttsRequest($currentTable);
                } else if (array_key_exists('viewTableTuples', $_GET)) {
                        $currentTable = $_GET['selectedTable'];
                        $attributes = [
                            $_GET['att1'],
                            $_GET['att2'],
                            $_GET['att3'],
                            $_GET['att4'],
                            $_GET['att5']
                            ];
                        handleDisplaySelectedTableRequest($currentTable, $attributes);
                }

			disconnectFromDB();
		}
	}

	if (isset($_POST['updateSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['displayTableAttsRequest']) ||
	           isset($_GET['displayProjectionRequest']))  {
               handleGETRequest();
	} else {
	if (connectToDB())
	    //handleDisplayRequest();
	    disconnectFromDB();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

