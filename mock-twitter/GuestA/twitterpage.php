<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <style> .error {color: #FF0000;}</style>
    </head>
    
    <body>

        <?php
            
            session_start();
            
            echo "<h1> " . $_SESSION["firstname"] . "</h1>";
                
            $tweetErr = "";
            $tweet = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                //firstname
                if (!empty($_POST["tweet"])) {
	                
                    $servername = "173.194.254.168";
                    $username   = "root";
                    $password       = "NormanVjo@2";
                    $dbname     = "hichi";
            
					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
            
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
            		} 
                        
                    $tweet = test_input($_POST["tweet"]);
                    
                    $sql = "INSERT INTO tweets (guestID, tweet, date) VALUES (" . $_SESSION['ID'] . ", '" . $_POST['tweet'] . "', NOW())";
                 
                 
					if ($conn->query($sql) === FALSE) {
						$tweetErr = "Could not tweet, try again.";
					} 
					
					$conn->close();
					
					unset($_POST["tweet"]);
                }
   
                $_SERVER["REQUEST_METHOD"] = "";
                
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
        ?>

		
   


        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
            <textarea name="tweet" rows="5" cols="60"></textarea>
                <br><br>
            <input type="submit" name="button" value="tweet">
        
        </form>

        <?php

			session_start();
			
			
			   $servername = "173.194.254.168";
                $username   = "root";
                $password       = "NormanVjo@2";
                    $dbname     = "hichi";
            
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
            
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
            } 
                    
            $sql = "SELECT * 
					FROM tweets 
					ORDER BY date DESC;";
					
            $result = $conn->query($sql);
			
            if ($result->num_rows > 0) {
                        
                while($row = $result->fetch_assoc()) {
                    
                    echo "<b>" . $row["guestID"] . ":</b>
		            
		            	<br><br>
		            		            		<p style='text-indent:5em'> " . $row["tweet"] . " </p>
		            	<br><br>
		            ";
                }
             
            }

            else {
                echo "You have not created a tweet! Give it a try :-)";
            }
					
			$conn->close();
			
	    ?>
	    
	            
       

        
    </body>
</html>