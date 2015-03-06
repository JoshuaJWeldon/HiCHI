<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mock-Twitter</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
</head>

<body>
    <?php
        session_start();
                
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
                    die ("<p>Connection failed: " . $conn->connect_error . " </p>");
                }

                $sql = "SELECT * FROM users WHERE ID = " . $ID;
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                        
                    $row = $result->fetch_assoc();
                        
                    $_SESSION["firstname"] = $row["firstname"];
                    $_SESSION["ID"]     = $row["guestID"];
                        
                    $conn->close();
                        
                    /* Redirect to a different page in the current directory that was requested */
                    $host  = $_SERVER['HTTP_HOST'];
                    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    $extra = 'twitterpage.php';
                    header("Location: http://$host$uri/$extra");
                    exit;
                        
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
    
	<header id="header"><p> HiCHI's Mock-Twitter Site </p></header>

	<div id="container">

		<main id="center" class="column">
			<article>
			
                <h1>Login</h1>
            
                <h2>Guest Login</h2>
        
                <span class="error">
                    <?php if(!$isValid){ echo "Invalid entries";}?>
                </span>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                
                ID: <input type="text" name="ID"><span class="error"><?php echo $IDErr;?></span>
                <br><br>
           
                <input type="submit" name="submit" value="Login">
                </form>
	
                <p> If you have not registered you UH ID, go back to 
                    <a href="registration.php">registration &#128100;</a>.
                </p>
			</article>								
		</main>

		<nav id="left" class="column">
			<h3>Directory</h3>
			<ul>
    			<li><a href="registration.php">&#128100; Registration</a></li>
				<li><a href="../index.html"> &#128048; HiCHI Home </a></li>
			</ul>
			<h3>Helpful Links</h3>
			<ul>
				<li><a href="http://www2.hawaii.edu/~scottpr/">Scott Robertson</a></li>
				<li><a href="#">Link 2</a></li>
				<li><a href="#">Link 3</a></li>
				<li><a href="#">Link 4</a></li>
				<li><a href="#">Link 5</a></li>
			</ul>

		</nav>

		<div id="right" class="column">
			<h3>Instructions</h3>
			<p>Please continue to login. If you are not yet registered, please return to registration.</p>
		</div>
	</div>

	<div id="footer-wrapper">
		<footer id="footer"><p>HiCHI Contact Information</p></footer>
	</div>

</body>

</html>

















