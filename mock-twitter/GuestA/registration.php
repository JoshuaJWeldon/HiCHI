<!DOCTYPE HTML> 
<html>
    
    <head>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <style>.error {color: #FF0000;}</style>
    </head>
    <body>
            
        <!-- Create err messages if necessary -->
        <?php
            
        
            $firstnameErr = $lastnameErr = $IDErr = $genderErr = "";
            $firstname = $lastname = $ID = $gender = "";
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
                        exit ('<p>Connection failed </p>');
                    }
                
                    $sql = "INSERT INTO users (firstname, lastname, ID, gender) VALUES ('" . 
                            $firstname . "', '" . $lastname . "', " . $ID . ", '" . 
                            $gender . "')";
                
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

        <h1>Guest A</h1>
            
        <h2>User Registration</h2>
        
        <p>Already a member? Go to <a href="login.php">user login &#128699;</a>. </p>

        <p style="font-weight: bold">Register:<p/>
        
        <span class="error">
            <?php if(!$isValid){ echo "* invalid enties";}?>
        </span>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
            First Name: <input type="text" name="firstname"> <span class="error"> <?php echo "* " . $firstnameErr;?></span>
                <br><br>
                
            Last Name: <input type="text" name="lastname"> <span class="error"> <?php echo "* " . $lastnameErr;?></span>
                <br><br>
                
            ID Number: <input type="text" name="ID"><span class="error"><?php echo "* " . $IDErr;?></span>
                <br><br>
                
            Gender:
                <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
                <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?>  value="male">Male
                <span class="error"> <?php echo "* " . $genderErr;?></span>
                <br><br>
            <input type="submit" name="submit" value="Register">
        </form>

    </body>
</html>

