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
			//echo "Failed to login";
			$login_error_message = 'Failed to login'; 
		}
		} else {
			//echo "failed to prepare the SQL";
			$login_error_message = 'failed to prepare the SQL'; 
			
		}
 }
 
?>

 <?php
 
//check if the register form has been submitted
if(isset($_POST['register_btn'])){
 
    // include database connection
    include_once 'connection.php'; 
	
	// SELECT query
        $query = "SELECT * FROM members WHERE username=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_POST['register_username']);
         
        // Execute the query
		$stmt->execute();
 
		// resultset 
		$result = $stmt->get_result();
		// Get the number of rows returned
		$num = $result->num_rows;
		
		foreach($_POST as $input=>$value) {
			if(empty($_POST[$input])) {
				$register_error_message = "All fields are required";
			}
		} 
		
		if($num>0){ // the inputted user name was already taken
			$register_error_message = 'Username unavailable'; 
		} else { // username was not taken
		
			if($_POST['register_password'] != $_POST['register_repeat_password']){  // passwords weren't the same
				$register_error_message = 'Passwords do not match'; 
			} else { // passwords match	
				
				if(!isset($register_error_message)){ // if there are still no errors, insert data
					$query2 = "INSERT INTO members (username, password, first_name, last_name, address, phone, email, license_num) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$stmt2 = $con->prepare($query2);
					$stmt2->bind_Param("sssssiss", $_POST['register_username'], $_POST['register_password'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['phone'], $_POST['email'], $_POST['license_num']);
					$stmt2->execute(); 
					if($stmt2){
						$register_success_message = "Successful registration! You may log in on the left.";
						unset($_POST);
					} else {
						$register_error_message = "Failed registration.";	
					} 
				}
			}
		}
		} else {
			$register_error_message = 'failed to prepare the SQL'; 
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

		<div class="loginContentsContainer" id="loginContentsContainer">
			<div class="oldMemberContainer" id="oldMemberContainer">
				Login:
				<form class="loginForm" id='loginForm' action='login.php' method='post'>
					<table border='0'>
						<?php if(!empty($login_error_message)) { ?>	
						<div class="error_message"><?php if(isset($login_error_message)) echo $login_error_message; ?></div>
						<?php } ?>
						<tr>
							<td>Username</td>
							<td><input type='text' name='username' id='username' /></td>
						</tr>
						<tr>
							<td>Password</td>
							 <td><input type='password' name='password' id='password' /></td>
						</tr>
						<tr>
							<td>
								<input type='submit' id='loginBtn' name='loginBtn' value='Submit' /> 
							</td>
						</tr>
					</table>
				</form>
			</div> <!-- close oldMemberContainer -->
				
			<div class="newMemberContainer" id="newMemberContainer">
				Register: 
				<form class="registerForm" id='registerForm' action='login.php' method='post'>
					<table border='0'>
						<?php if(!empty($register_success_message)) { ?>	
						<div class="success_message"><?php if(isset($register_success_message)) echo $register_success_message; ?></div>
						<?php } ?>
						<?php if(!empty($register_error_message)) { ?>	
						<div class="error_message"><?php if(isset($register_error_message)) echo $register_error_message; ?></div>
						<?php } ?>
						<tr>
							<td>Username</td>
							<td><input type='text' name='register_username' id='username' value='<?php if(isset($_POST['register_username'])) echo $_POST['register_username']; ?>' /></td>
						</tr> 
						<tr>
							<td>Password</td>
							 <td><input type='password' name='register_password' id='password' /></td>
						</tr>
						<tr>
							<td>Repeat password</td>
							 <td><input type='password' name='register_repeat_password' id='repeat_password' /></td>
						</tr>
						<tr> 
							<td>First name</td>
							 <td><input type='text' name='first_name' id='first_name' value='<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>'/></td>
						</tr>
						<tr>
							<td>Last name</td>
							 <td><input type='text' name='last_name' id='last_name' value='<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>'/></td>
						</tr>
						<tr>
							<td>Address</td>
							 <td><input type='text' name='address' id='address' value='<?php if(isset($_POST['address'])) echo $_POST['address']; ?>'/></td>
						</tr>
						<tr>
							<td>Phone</td>
							 <td><input type='text' name='phone' id='phone' value='<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>'/></td>
						</tr>
						<tr>
							<td>Email</td>
							 <td><input type='text' name='email' id='email' value='<?php if(isset($_POST['email'])) echo $_POST['email']; ?>'/></td>
						</tr>
						<tr>
							<td>Liscense Number</td>
							 <td><input type='text' name='license_num' id='license_num' value='<?php if(isset($_POST['license_num'])) echo $_POST['license_num']; ?>'/></td>
						</tr> 
						<tr>
							<td>
								<input type='submit' id='register_btn' name='register_btn' value='Submit' /> 
							</td>
						</tr>
					</table>
				</form>
			</div> <!-- close newMemberContainer -->
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