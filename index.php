<!DOCTYPE HTML>
<html>
    <head>
        <title>KTCS</title>
    </head>
<body>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="ktcsJavaScript.js"></script>
	<link rel="stylesheet" href="ktcsStyle.css">

 <?php
  //Create a user session or resume an existing one
 session_start();
 ?>
 
 <?php
 //check if the user clicked the logout link and set the logout GET parameter
if(isset($_GET['logout'])){
	//Destroy the user's session.
	$_SESSION['id']=null;
	session_destroy();
}
 ?>
 
 
 <?php
 //check if the user is already logged in and has an active session
if(isset($_SESSION['id'])){
	if($_SESSION['id'] != 1){ // a member logged in
		//Redirect the browser to the member editing page and kill this page.
		header("Location: member.php");
		die();
	} else { // the admin logged in
		//Redirect the browser to the admin editing page and kill this page.
		header("Location: admin.php");
		die();
	}
}
 ?>
 
<div class="everythingContainer">

	<div class="headerContainer">

		<div class="upperHeaderContainer">
		
			<div class="ktcsLogoContainer">
			KTCS Logo Here
			</div> <!-- close ktcsLogoContainer -->
			
			<div class="socialMediaContainer">
			Facebook Twitter Instagram Here
			</div> <!-- close socialMediaContainer -->
			
		</div> <!-- close upperHeaderContainer -->
		
		<div class="lowerHeaderContainer">
		
			<div class="allButtonsContainer">
			Links to Home, News, About, Contact, Hours etc here
			</div> <!-- close allButtonsContainer -->
			
			<div class="loginButtonContainer">
				<a href="login.php">Login</a>
			</div> <!-- close loginButtonContainer -->
		
		</div> <!-- close lowerHeaderContainer -->

	</div> <!-- close headerContainerStyle -->



	<div class="mainBodyContainer">
		
		<div class="navigationContainer">
		Put navigation here. If user isn't logged in, this area could just be empty or with a pretty car picture instead.
		</div>

		<div class="contentsContainer" id="contentsContainer">
		Put contents here.
		</div> <!-- close contentsContainer -->	
		
	</div> <!-- close mainBodyContainer -->



	<div class="dividerContainer">
	divider ------------------------------------------------ divider
	</div> <!-- close dividerContainer -->



	<div class="footerContainer">

		<div class="leftFooterContentsContainer">
		Left footer stuff here
		</div> <!-- close leftFooterContentsContainer -->
		
		<div class="rightFooterContentsContainer">
		Right footer stuff here
		</div> <!-- close rightFooterContentsContainer -->

	</div> <!-- close footerContainer -->
	
</div> <!-- close everythingContainer -->


</body>
</html>