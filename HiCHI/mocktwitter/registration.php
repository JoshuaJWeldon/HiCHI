<?php
        
    $firstnameErr = $lastnameErr = $IDErr = $genderErr =  $pollErr =  "";
    $firstname = $lastname = $ID = $gender = $poll = "" ;
    $isValid = TRUE;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
        //firstname
        if (empty($_POST["firstname"])) {
                    
            $firstnameErr = "First name is required";
            $isValid = FALSE;
        }
                    
    else {
                    
            $firstname = test_input($_POST["firstname"]);
 
            if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
                        
                $firstnameErr = "Only letters and spaces are allowed";
                $isValid = FALSE;
            }
        }

        //lastname
        if (empty($_POST["lastname"])) {
                        
            $lastnameErr = "Last name is required";
            $isValid = FALSE;
        }

        else {
                    
            $lastname = test_input($_POST["lastname"]);
   
            if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
                        
                $lastnameErr = "Only letters and spaces allowed";
                $isValid = FALSE;
            }
        }
                
        //ID
        if (empty($_POST["ID"])) {
                            
            $IDErr = "ID number is required";
            $isValid = FALSE;
        }
                    
        else {
                            
            $ID = test_input($_POST["ID"]);
                    
                
            if (!is_numeric($ID)) {    
                        
                $IDErr = "Only digits 0-9 are allowed";
                $isValid = FALSE;
            }
        }
            
        //gender
        if (empty($_POST["gender"])) {
                        
            $genderErr = "Gender is required";
            $isValid = FALSE;
        }
                    
        else {
                            
                $gender = test_input($_POST["gender"]);
        }
            
        //gender
        if (empty($_POST["poll"])) {
                        
            $pollErr = "Political Affiliation is required";
            $isValid = FALSE;
        }
                    
        else {
                            
                $poll = test_input($_POST["poll"]);
        }
            
        //erase _post
        $_POST = array();
        $_SERVER["REQUEST_METHOD"] = "";
                
        //Insert if valid
        if($isValid){
                    
            $servername = "173.194.254.168";
            $username   = "root";
            $pass       = "NormanVjo@2";
            $dbname     = "hichi";
            
            $conn = new mysqli($servername, $username, $pass, $dbname);
            
            if ($conn->connect_error) {    
                exit ('Connection failed');
            }
            
            $sql = "INSERT INTO users (firstname, lastname, ID, gender, pollbefore) VALUES ('" . 
                    $firstname . "', '" . $lastname . "', " . $ID . ", '" . 
                    $gender . "','" . $poll . "')";
            
            if ($conn->query($sql) === TRUE) {
                $conn->close();
                        
                /* Redirect to a different page in the current directory that was requested */
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'login.php';
                header("Location: http://$host$uri/$extra");
                exit;
                    
            }
                
            else {
                $IDErr = "That ID number is already registered.";
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

<!DOCTYPE html>
<html>
<head>
    <!-- !TODO: meta refresh -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mock-Twitter</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
</head>

<body>

	<header id="header"><p> Welcome to HiCHI's Mock-Twitter Site </p></header>

	<div id="container">

		<main id="center" class="column">
			<article>
			
                <h1>Registration</h1>
                    
                <h2>User Registration</h2>
                
                <p>Already a member? Go to 
                    <a href="login.php">user login &#128699;</a>. 
                </p>
        
                <p style="font-weight: bold">Register:<p/>
                
                <span class="error">
                    <?php if(!$isValid){ echo "* invalid entries";}?>
                </span>
        
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            
                    First Name: <input type="text" name="firstname"> <span class="error"> <?php echo "* " . $firstnameErr;?></span>
                        <br><br>
                        
                    Last Name: <input type="text" name="lastname"> <span class="error"> <?php echo "* " . $lastnameErr;?></span>
                        <br><br>
                        
                    ID Number: <input type="text" name="ID"><span class="error"><?php echo "* " . $IDErr;?></span>
                        <br><br>
                        
                    Gender: <br>
                        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
                        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?>  value="male">Male
                        <span class="error"> <?php echo "* " . $genderErr;?></span>
                        <br><br>
                        
                    Political Affiliation: <br>
                        <input type="radio" name="poll" <?php if (isset($poll) && $poll=="liberal") echo "checked";?> value="liberal">Liberal
                        <input type="radio" name="poll" <?php if (isset($poll) && $poll=="conservative") echo "checked";?>  value="conservative">Conservative
                        <input type="radio" name="poll" <?php if (isset($poll) && $poll=="apathetic") echo "checked";?> value="apathetic">Apathetic
                        <input type="radio" name="poll" <?php if (isset($poll) && $poll=="undecided") echo "checked";?> value="undecided">Undecided
                        <span class="error"> <?php echo "* " . $pollErr;?></span>
                        <br><br>
                    
                    <input type="submit" name="submit" value="Register">
                </form>
        			
			</article>								
		</main>

		<nav id="left" class="column">
			<h3>Members:</h3>
			<ul>
				<li><a href="login.php">&#128699; Log-In</a></li>
				<li><a href="../index.html">&#128048; HiCHI Home </a></li>
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
			<p>Please fill out the registration field. If you already registered with HiCHI, you may continue to the login.</p>
		</div>
	</div>

	<div id="footer-wrapper">
		<footer id="footer"><p>HiCHI Contact Information</p></footer>
	</div>

</body>

</html>








