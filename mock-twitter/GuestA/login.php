<!DOCTYPE HTML> 
<html>
    <head>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <style> .error {color: #FF0000;}</style>
    </head>
    
    <body>
            
        <!-- Create err messages if necessary -->
        <?php
                
            $IDErr = "";
            $ID = "";
            $isValid = TRUE;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                //ID
                if (empty($_POST["ID"])) {
                        
                    $IDErr = "ID number is required";
                    $isValid = FALSE;
                }
                    
                else {
                        
                    $ID = test_input($_POST["ID"]);
                    
                    
                    if (!is_numeric($ID)) {
                        
                        $IDErr = "ID can only include digits 0-9";
                        $isValid = FALSE;
                    }
                }
                                    
                //erase _post
                $_POST = array();
                $_SERVER["REQUEST_METHOD"] = "";
                
                //Check if valid
                if($isValid){
                    
                    $servername = "173.194.254.168";
                    $username   = "root";
                    $pass       = "NormanVjo@2";
                    $dbname     = "hichi";
                
                    $conn = new mysqli($servername, $username, $pass, $dbname);
                
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT firstname FROM users WHERE ID = " . $ID;
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        
                        $row = $result->fetch_assoc();
                        
                        session_start();
                        $_SESSION["firstname"] = $row["firstname"];
                        $_SESSION["ID"]     = $ID;
                        
                        $conn->close();
                        
                        header("Location: http://146.148.87.66/GuestA/twitterpage.php");
                    }

                    else {
                        $IDErr = "Invaild ID number";
                    }
                    
                    $conn->close();
                }
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
        ?>

        <h1>Guest A</h1>
            
        <h2>Guest Login</h2>
        
        <p style="font-weight: bold" align="right"><a href="signin.php">register &#128100;</a></p>
        
        <span class="error">
            <?php if(!$isValid){ echo "Invalid entries";}?>
        </span>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                
            ID: <input type="text" name="ID"><span class="error"><?php echo $IDErr;?></span>
                <br><br>
           
            <input type="submit" name="submit" value="Login">
        </form>

    </body>
</html>