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
 
 <?php
 
//check if the login form has been submitted
if(isset($_POST['loginBtn'])){
 
    // include database connection
    include_once 'connection.php'; 
	
	// SELECT query
        $query = "SELECT member_id,username, password, email FROM members WHERE username=? AND password=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("ss", $_POST['username'], $_POST['password']);
         
        // Execute the query
		$stmt->execute();
 
		/* resultset */
		$result = $stmt->get_result();
		// Get the number of rows returned
		$num = $result->num_rows;;
		
		if($num>0){
			//If the username/password matches a user in our database
			//Read the user details
			$myrow = $result->fetch_assoc();
			//Create a session variable that holds the user's id
			$_SESSION['id'] = $myrow['member_id'];
			if($_SESSION['id'] != 1){ // a member logged in
				//Redirect the browser to the member editing page and kill this page.
				header("Location: member.php");
				die();
			} else { // the admin logged in
				//Redirect the browser to the admin editing page and kill this page.
				header("Location: admin.php");
				die();
			}
		} else {
			//If the username/password doesn't matche a user in our database
			// Display an error message and the login form
			echo "Failed to login";
		}
		} else {
			echo "failed to prepare the SQL";
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
				<button class="loginButton" id="loginButton" onclick="showLoginWindow()">Login</button>
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
		
		<div class="loginContentsContainer" id="loginContentsContainer">
			<form class="loginForm" id='loginForm' action='index.php' method='post'>
				<table border='0'>
					<tr>
						<td>Username</td>
						<td><input type='text' name='username' id='username' /></td>
					</tr>
					<tr>
						<td>Password</td>
						 <td><input type='password' name='password' id='password' /></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type='submit' id='loginBtn' name='loginBtn' value='Log In' /> 
						</td>
					</tr>
				</table>
			</form>
		</div> <!-- close loginContentsContainer -->

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