<!DOCTYPE html>
<head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <link rel="stylesheet" type="text/css" href="style.css" /> 
    <title>Post Status Form</title> 
</head> 
<body id="background"> 
    <div class="content" id="content">
        <h1>Post Status Form</h1>
        <?php

        //import the database&account infromation.php
        require_once('./sqlinfo.inc.php');

        //connect and select the database 
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

        //Check is the table exist
        //Create table SQL statement
        $CREATE_STATUS_TABLE = "CREATE TABLE STATUS (
            STATUS_CODE VARCHAR(5) PRIMARY KEY,
            STATUS VARCHAR(50) NOT NULL,
            SHARE VARCHAR(10) NOT NULL,
            UPLOADDATE VARCHAR(12),
            PERMISSION_TYPE VARCHAR(50)
            )";

        //The DESCRIBESTATUS will return true if the table exist, otherwise it will return false.
        if ($dbConnect->query ("DESCRIBE STATUS")) {
            console.log("Table exist");
        } else {
            echo "doesn't exist Creating table";
            //Run Create table statement
            if ($dbConnect->query($CREATE_STATUS_TABLE) === TRUE) {
                echo "Table STATUS is exist now<br>";
            } else {
                echo "Fail to create table" . $dbConnet->error;
            }
        }
        
        //get input fron poststatusform.php
        $Allow=$_POST["allow"];
        $Like=$_POST["like"];
        $Allow_comment=$_POST["allow_comments"];
        $Allow_share=$_POST["allow_share"];
        $new_date=$_POST["date"];

        //Using the mysqli_real_escape_string to keep the input safe and avoid the hacking        
        $Permission =mysqli_real_escape_string($dbConnect,$Permission=$Allow." ".$Like." ".$Allow_comment." ".$Allow_share);
        $Status_code=mysqli_real_escape_string($dbConnect,$Status_code=$_POST["statuscode"]);
        $Status=mysqli_real_escape_string($dbConnect,$Status=$_POST["status"]);
        $Share=mysqli_real_escape_string($dbConnect,$Share=$_POST["share"]);
        $Data=mysqli_real_escape_string($dbConnect,$Date=$_POST["date"]);

        //Convert the date to three int,for checkdate method
        list($d, $m, $Y) = explode("-", $new_date);

        //Select statement for checking if the input is already exist
        $SELECT_STATUS_CODE="SELECT STATUS_CODE FROM STATUS WHERE STATUS_CODE = '$Status_code'";
        //Insert statement for inserting the data to mysql
        $INSERT_RECORD = "INSERT INTO STATUS (STATUS_CODE, STATUS, SHARE, UPLOADDATE, PERMISSION_TYPE) VALUES ('$Status_code', '$Status', '$Share', '$Data', '$Permission');";   

        $result=mysqli_query($dbConnect, $SELECT_STATUS_CODE);
        $status_code_pattern = "/^S\d{4}$/";
        $status_pattern = "/^[A-Za-z\d,.?!][A-Za-z\d\s,.?!]*[A-Za-z\d,.?!]$|(^[A-Za-z\d,.?!]{0,1}[A-Za-z\d,.?!]$)/";
        //All four option value in permission has l. One the permission match with l that means it is not empty.
        $permission_pattern ="/l/";

        //Because the other three are required in the form page and Share has default value. So only the permission need to be check if empty
        //check if the permission is empty by check if it is match to permission_pattern
        if(preg_match($permission_pattern,$Permission)){
            if(preg_match($status_code_pattern,$Status_code)){
                if(preg_match($status_pattern,$Status)){
                    //check if the date is valid
                    if(checkdate($m, $d, $Y)){
                        //Determine the status code is exist or not by checking num_rows
                        //if the status code is not exist the number of row should be less than one
                        if(mysqli_num_rows($result)<1){
                            if($dbConnect->query($INSERT_RECORD) === TRUE){
                                echo "<p>Post success</p>";
                            }else{
                                echo "<p>Fail to Post</p>";
                            }
                        }else{
                            echo "<p>This status code already exists. Please try another one.</p>";
                        }
                                    
                    }else{
                        echo "<p>This is not a vaild date</p>";
                    }
                }else{
                    echo "<p>Wrong format! Should only contain alphanumericals, comma, period (full stop), exclamation 
                    mark and question mark.Also it can not start or end the a space. For example: I Love Human</p>";
                }
            }else{
                echo "<p>Wrong format! Should start with S and 4 number. Example: S0001.</p>";
            }
        }else{
            echo "<p>The Permission can not be empty </p>";
        }

        //relase the result which contain the num_row info
        mysqli_free_result($result);

        //disconnect to the database
        $dbConnect->close();
        ?>
        
        <br>
        <br>
        <a href="http://xrf4650.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
    </div>
    </body> 
</html>