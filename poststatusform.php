<!DOCTYPE html> 
<html> 
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" type="text/css" href="style.css" /> 
        <title>Post Status Form</title> 
    </head> 
    <body id="background">
        
    <div class="content" id="content"> 
        <h1>Status Posting System</h1>
        <!--form for submitting post info to db-->
        <form action="poststatusprocess.php" method="post">
            <p>
                <!--Status code text input-->
                Status Code (required): 
                <input type="text" name="statuscode" pattern = "^S\d{4}$" 
                title="Wrong format! Status code should start with a uppercase S and 4 number like S0001" required><br>

                <!--Status text input-->
                Status (required):   
                <input type="text" name="status" pattern="^[A-Za-z\d,.?!][A-Za-z\d\s,.?!]*[A-Za-z\d,.?!]$|(^[A-Za-z\d,.?!]{0,1}[A-Za-z\d,.?!]$)"
                title="Wrong format! Staus can only contain alphanumericals, comma, period (full stop), 
                exclamation mark and question mark. And it can not start or end with space" required><br><br>

                <!--Share option radio input-->
                Share:
                    <input type="radio" name="share" value="Public" checked>
                    <label for="Public">Public</label>
                    <input type="radio" name="share" value="Friends">
                    <label for="Friends">Friends</label>
                    <input type="radio" name="share" value="OnlyMe">
                    <label for="OnlyMe">OnlyMe</label>
                <br>

                <!--Date date input-->
                Date:<input type="text" name="date" value="<?php echo date("d-m-Y");?>" pattern="^\d{2}-\d{2}-\d{4}$" 
                title="Wrong format! Must put - between day, month year and must not contain any space. For example: 01-01-2022. " required>
                <br>

                <!--Premission checkbox input-->
                Permission:
                    <input type="checkbox" id="allow " name="allow" value ="allow">
                    <label for="allow ">Allow </label>
                    <input type="checkbox" id="like" name="like" value ="like">
                    <label for="Like">Like</label>
                    <input type="checkbox" id="allow Comments" name="allow_comments" value ="allowComment">
                    <label for="allow Comments">Allow Comments</label>
                    <input type="checkbox" id="allow Share" name="allow_share" value ="allowShare">
                    <label for="allow Share">Allow Share</label>
            </p>
            
            <!--Submit and reset button-->
            <input type="submit" value="Post" id="button">
            <input type="reset" value="Reset" id="button">
        </form>

        <br>
        <br>
        <!--back to index page-->
        <a href="http://xrf4650.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
    </div>
</body> 
</html>