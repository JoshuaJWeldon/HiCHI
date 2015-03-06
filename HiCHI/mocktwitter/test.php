<?php session_start(); ?>
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
<!-- !TODO: comments and retweets-->
<!-- !TODO: GuestID instead of UHID-->
<!-- !FIXME: show a users current tweet without wait -->
<body>          
    
    <p> Wait for at most 20 seconds for your tweet to show. Thank you! </p>
    
    <?php

        
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
                    
                    $sql = "INSERT INTO tweets (guestID, tweet, date) VALUES (" . $_SESSION['ID'] . ", ' Retweeted from <i>" . $row['guestID'] . "</i>: " .  $row['tweet'] . "', NOW())";
                   
                    if ($conn->query($sql) === FALSE) {
                        echo "<p> Could not like </p>";
				    } 
                   
				}
				
				else{
    				echo "<p> Could not retweet </p>";
				}
				
				
					
            }
            
            if ($_COOKIE["commentID"] != 0) {
                
                $sql = "UPDATE tweets SET likes = likes + 1 WHERE ID = " . $_COOKIE['likeID'];
                 
                if ($conn->query($sql) === FALSE) {
                    echo "<p> Could not comment </p>";
				} 
					
            }  
             
            $_SERVER["REQUEST_METHOD"] = "";
                
        }
            
        $_COOKIE['likeID']    = 0;  
        $_COOKIE['retweetID'] = 0;
        $_COOKIE['commentID'] = 0;
        
        $sql = "SELECT * 
				FROM tweets 
                ORDER BY date DESC;";
					
        $result = $conn->query($sql);
			
        if ($result->num_rows > 0) {
                        
            while($row = $result->fetch_assoc()): 
            
                $ID = $row['ID'];?>
                    
                <p style='width: 350px'> <b> <?php echo $row["guestID"]; ?> </b> <?php echo $row["tweet"]; ?>  </p>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input onclick = "recordLike(<?php echo $row['ID'];?>)"  type="submit" name="like" value="&#128077;"> 
                        <?php echo $row["likes"];?>
                        
                    <input onclick = "recordRetweet(<?php echo $row['ID'];?>)" type='submit' name="retweet" value="&#128257;"> 
                        <?php echo $row["retweets"]; ?> 
                        
                    <input onclick = "recordComment(<?php echo $row['ID'];?>)" type='submit' name="comment" value="&#128173;"> 
                        <?php echo $row["comments"]; ?>    
                    
                </form>
            
            <?php endwhile; 
         
        }

        else {
            echo "You have not created a tweet! Give it a try :-)";
        }
					
        $conn->close();
			
    ?>

</body>

</html>








