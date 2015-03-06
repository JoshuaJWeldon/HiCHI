<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="20">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>HiCHI</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
</head>

<body>     
    
    <h3> Comment: </h3>    
    <p align="right"><a href="tweetflow.php"> &#128072; Timeline </a>     
    <br>
    
    <?php
            
        session_start();
        
        $comment = "";
        
        $servername = "173.194.254.168";
        $username   = "root";
        $password   = "NormanVjo@2";
        $dbname     = "hichi";
            
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
            
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
 
        $sql = "SELECT * FROM tweets WHERE ID = " . $_SESSION['commentID'];
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
                        
            $row = $result->fetch_assoc();
        
            echo "<p> <i>" . $row['tweet'] . "</i></p>";
        }

        else{
            echo "<p> Could not get comment, please refresh page.</p>";   
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
            //firstname
            if (!empty($_POST["comment"])) {
	                                        
                $comment = test_input($_POST["comment"]);
                    
                $sql = "INSERT INTO comments (guestID, tweetID, comment, date) VALUES (" . $_SESSION['ID'] . ", " . $_SESSION['commentID'] . ", '" . $comment . "', NOW())";
                 
                if ($conn->query($sql) === FALSE) {
                    echo "<p> Could not get comment, please refresh page.</p>";
				} 
				else{
    				
    				$sql = "UPDATE tweets SET comments = comments + 1 WHERE ID = " . $_SESSION['commentID'];
    				    
    				$conn->query($sql);
				}
					
					
                unset($_POST["comment"]);
            }
   
            $_SERVER["REQUEST_METHOD"] = "";
                
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $sql = "SELECT * 
				FROM comments 
				WHERE tweetID = " . $_SESSION['commentID'] . "
                ORDER BY date DESC;";
					
        $result = $conn->query($sql);
			
        if ($result->num_rows > 0) {
                        
            while($row = $result->fetch_assoc()): 
            
                $ID = $row['ID'];?>
                    
                <p style='width: 350px'> <b> <?php echo $row["guestID"]; ?> </b> <?php echo $row["comment"]; ?>  </p>
            
            <?php endwhile; 
         
        }

        else {
            echo "<p> No one has commented on this tweet! Give it a try :-) </p>";
        }
        $conn->close();
            
    ?>
    
	
    	
                
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
        <textarea name="comment" rows="5" cols="50" style="resize: none"></textarea>
        <br><br>
                
        <input type="submit" name="button" value="comment">
    </form>

</body>

</html>








