<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>HiCHI</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
</head>
<body>
    <?php
                
        $tweetErr = "";
        $tweet = "";
        $tweetMessage = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            
            $tweetMessage = "Please wait at most 20sec for tweet to show.";
                    
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
                    $tweetMessage = "";
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
    
        <textarea name="tweet" rows="5" cols="50" style="resize: none"></textarea>
        <br><br>
                
        <input type="submit" name="button" value="tweet"> <?php echo $tweetMessage; ?>
    </form>
           

</body>

</html>
























