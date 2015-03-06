<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="20">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>HiCHI</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
    <script type="text/javascript">
        function recordLike(likeID){
            document.cookie= "likeID = " + likeID;
        }
        
        function recordRetweet(retweetID){
            document.cookie = "retweetID = " + retweetID;
        }
        
        function recordComment(commentID){
            document.cookie = "commentID = " + commentID;
        }
        
    </script>
</head>
<!-- !TODO: make comments page-->
<!-- !TODO: Have retweet cumulate from original tweet -->
<!-- !TODO: GuestID instead of UHID-->
<!-- !FIXME: show a users current tweet without wait -->
<body>          
    
    <h3> Timeline: </h3>
    
    <?php
            
        session_start();
        
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
                
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
            if ($_COOKIE["likeID"] != 0) {
                
                $sql = "UPDATE tweets SET likes = likes + 1 WHERE ID = " . $_COOKIE['likeID'];
                 
                if ($conn->query($sql) === FALSE) {
                    echo "<p> Could not like </p>";
				} 
					
            }

            if ($_COOKIE["retweetID"] != 0) {
                
                $sql = "SELECT guestID, tweet FROM tweets WHERE ID = " . $_COOKIE['retweetID'];
                

                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                         
                    $row = $result->fetch_assoc();
                    
                    $sql = "INSERT INTO tweets (guestID, tweet, date) VALUES (" . $_SESSION['ID'] . ", ' " . $row['tweet'] . " <br> <i> Retweeted from <b>" . $row['guestID'] . "</b></i> ', NOW())";
                   
                    if ($conn->query($sql) === FALSE) {
                        echo "<p> Could not retweet </p>";
				    }
				    else{
    				    $sql = "UPDATE tweets SET retweets = retweets + 1 WHERE ID = " . $_COOKIE['retweetID'];
    				    
    				    if ($conn->query($sql) === FALSE) {
                            echo "<p> Could not retweet </p>";
				        }
				    }  
				}
				
				else{
    				echo "<p> Could not retweet </p>";
				}
					
            }
            
            if ($_COOKIE["commentID"] != 0) {
                
                $_SESSION['commentID'] = $_COOKIE['commentID'];
                
                $conn->close();
                
                /* Redirect to a different page in the current directory that was requested */
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'commentflow.php';
                header("Location: http://$host$uri/$extra");
                exit;
					
            }  
             
            $_SERVER["REQUEST_METHOD"] = "";
                
        }
            
        setcookie("likeID", 0);
        setcookie("retweetID", 0);
        setcookie("commentID", 0);
        
        $sql = "SELECT * 
				FROM tweets 
                ORDER BY date DESC;";
					
        $result = $conn->query($sql);
			
        if ($result->num_rows > 0) {
                        
            while($row = $result->fetch_assoc()): 
            
                $ID = $row['ID'];?>
                    
                <p style='width: 350px'> <b> Guest <?php echo $row["guestID"]; ?> </b> <?php echo $row["tweet"]; ?>  </p>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input onclick = "recordLike(<?php echo $row['ID'];?>)"  type="submit" name="like" value="&#128077;"> 
                        <?php echo $row["likes"];?>
                        
                    <input onclick = "recordRetweet(<?php echo $row['ID'];?>)" type='submit' name="retweet" value="&#128257;"> 
                        <?php echo $row["retweets"]; ?> 
                        
                    <input onclick = "recordComment(<?php echo $row['ID'];?>)" type='submit' name="comment" value="&#128173;"> 
                        <?php echo $row["comments"]; ?>    
                    
                </form>
                
                <br>
            
            <?php endwhile; 
         
        }

        else {
            echo "<p> No one has created a tweet! Give it a try :-) </p>";
        }
					
        $conn->close();
			
    ?>

</body>

</html>








