<!DOCTYPE html>
<head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <link rel="stylesheet" type="text/css" href="style.css" /> 
    <title>Search Form</title> 
</head> 
<body id="background"> 
    <div class="content" id="content">
        <h1>Search Form</h1>
        <?php

        //import the database&account infromation.php
        require_once('./sqlinfo.inc.php');

        // mysqli_connect returns false if connection failed, otherwise a connection value
        $dbConnect = @mysqli_connect(
            $sql_host,
            $sql_user,
            $sql_pass
        );

        // Checks if connection is successful
        if (!$dbConnect) {
            // Displays an error message
            echo "<p>Database connection failure. Error code " . mysqli_connect_errno()		. ": " . mysqli_connect_error(). "</p>";
        } else {
            console.log("Database connection sucessful");
        }
        
        $dbSelect = @mysqli_select_db($dbConnect,$sql_db);
        if (!$dbSelect) {
            // Displays an error message
            echo "<p>Unable to select the database.</p>"
            . "<p>Error code " . mysqli_errno($dbConnect)
            . ": " . mysqli_error($dbConnect) . "</p>";
        } else {
            console.log("Database connection sucessful");
        }
        
        //Search infor from db
        $input=$_GET["Search"];

        //using mysqli_real_escape_string keep the input safe and avoid the hacking
        $escape_string_input=mysqli_real_escape_string($dbConnect,$input);
        //User can not input space at the end or begin and can only input alphanumericals, comma, period (full stop), exclamation mark and question mark
        $pattern = "/^[A-Za-z\d,.?!][A-Za-z\d\s,.?!]*[A-Za-z\d,.?!]$|(^[A-Za-z\d,.?!]{0,1}[A-Za-z\d,.?!]$)/";

        //Fuzzy Search
        $SEARCH_STATUS = "SELECT * FROM STATUS WHERE STATUS LIKE '%$escape_string_input%'";
        $result = mysqli_query($dbConnect, $SEARCH_STATUS);

        //check if input empty
        if(!empty($escape_string_input)){
            //check if input match pattern
            if(preg_match($pattern,$escape_string_input)){
                //check if the record is exist
                if(mysqli_num_rows($result)>=1){
                    //generate the table to show record
                    echo "<table border='1'>";
                    echo "<tr>";
                    echo "<td>STATUS CODE</td>";
                    echo "<td>STATUS</td>";
                    echo "<td>SHARE</td>";
                    echo "<td>DATE</td>";
                    echo "<td>PERMISSION TYPE</td>";
                    echo "</tr>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>",$row["STATUS_CODE"],"</td>";
                        echo "<td>",$row["STATUS"],"</td>";
                        echo "<td>",$row["SHARE"],"</td>";
                        echo "<td>",$row["UPLOADDATE"],"</td>";
                        echo "<td>",$row["PERMISSION_TYPE"],"</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }else if (mysqli_num_rows($result)<1){
                    echo "<p>Record not found. Please try a different keyword.</p>";
                }else{
                    "<p>Error. Can not search.</p>";
                }
            }else{
                echo "<p>Wrong format! Should only contain alphanumericals, comma, period (full stop), exclamation 
                mark and question mark.Also it can not start or end the a space. For example: I Love Human</p>";
            }
        }else{
            echo "<p>The search input is empty. Please try to enter something</p>";
        }    

        //disconnect to the database
        $dbConnect->close();
        ?>

        <br>
        <br>
        <!--Go to home page-->
        <a style="float:right" href="http://xrf4650.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
        <!--Go to searchstatusform-->
        <a href="http://xrf4650.cmslamp14.aut.ac.nz/assign1/searchstatusform.html">Return to Search Page</a>
    </div>
    </body> 
</html>