<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>HiCHI</title>
    <link rel="stylesheet" href="../style.css" type="text/css">	
</head>
<!-- !TODO: move each form in a frame and perform meta refresh -->
<!-- !TODO: comments and retweets-->
<!-- !TODO: GuestID instead of UHID-->
<body>
       
	<header id="header"><p> HiCHI's Mock-Twitter </p></header>

	<div id="container">

		<main id="center" class="column">
			<article>
    			
    			<h2> <?php echo $_SESSION["firstname"]; ?> </h2>
			
                <p> <?php echo "Your GuestID is: <i>" . $_SESSION['ID'] . "</i>";?></p>
                
                <p> 
                    <iframe style="position: fixed; right: 200px" width="560" height="315" src="https://www.youtube.com/embed/qtnMy2aSOWQ" frameborder="0" allowfullscreen></iframe>
                    <iframe scrolling="no" style="left: 200px" width="400" height="150" src="tweetbox.php" frameborder="0"> </iframe>
                </p>
                
                <p>
                    <iframe scrolling="no" style="left: 200px" width="400" height="10000" src = "tweetflow.php" frameborder="0"></iframe>
                </p>
                
            </article>								
		</main>

		<nav id="left" class="column">
			<h3>Options</h3>
			<ul>
                <!-- !TODO: Impliment Upload Photo-->
				<li><a href="#">&#128247; Upload Photo</a></li>
				<!-- !TODO: Create Settings Page -->
				<li><a href="#">&#128199; Settings</a></li>
				<li><a href="review.php"> &#128511; Finished </a></li>
			</ul>
			<h3>Directory</h3>
			<ul>
				<li><a href="../index.html"> &#128048; HiCHI Home </a></li>
				<li><a href="login.php"> &#128048; Log-in </a></li>
				<li><a href="registration.php"> &#128048; Registration </a></li>
			</ul>

		</nav>

		<div id="right" class="column">
			<h3>Instructions</h3>
			<p>Watch the video and tweet your thoughts.</p>
		</div>
	</div>

	<div id="footer-wrapper">
		<footer id="footer"><p>HiCHI Contact Information</p></footer>
	</div>

</body>

</html>














