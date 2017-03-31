<!DOCTYPE HTML>
<html>
    <head>
        <title>Welcome MEMBER</title>
  
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
 
 if(isset($_POST['updateBtn']) && isset($_SESSION['id'])){
  // include database connection
    include_once 'connection.php'; 
	
	$query = "UPDATE members SET password=?,email=? WHERE member_id=?";
 
	$stmt = $con->prepare($query);	$stmt->bind_param('sss', $_POST['password'], $_POST['email'], $_SESSION['id']);
	// Execute the query
        if($stmt->execute()){
            echo "Record was updated. <br/>";
        }else{
            echo 'Unable to update record. Please try again. <br/>';
        }
 }
 
 ?>
 
 <?php
if(isset($_SESSION['id'])){
	if($_SESSION['id'] == 1){ // if the admin happens to be logged in and is looking at the member page, he gets redirected to admin page
		header("Location: admin.php");
		die();
	} else {
   
   //include database connection
   include_once 'connection.php';
	
	// SELECT query
        $query = "SELECT member_id,username, password, email FROM members WHERE member_id=?";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_SESSION['id']);
        // Execute the query
		$stmt->execute();
 
		// results 
		$result = $stmt->get_result();
		
		// Row data
		$myrow = $result->fetch_assoc();
	}
		
} else {
	//User is not logged in. Redirect the browser to the login index.php page and kill this page.
	header("Location: index.php");
	die();
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
				<a href="index.php?logout=1">Log Out</a>
			</div> <!-- close loginButtonContainer -->
		
		</div> <!-- close lowerHeaderContainer -->

	</div> <!-- close headerContainerStyle -->



	<div class="mainBodyContainer">
		
		<div class="navigationContainer">
			Put navigation here. If user isn't logged in, this area could just be empty or with a pretty car picture instead.
		</div>

		<div class="contentsContainer" id="contentsContainer">
			Put contents here. Welcome  <?php echo $myrow['username']; ?> <br/>
			<form name='editProfile' id='editProfile' action='member.php' method='post'>
				<table border='0'>
					<tr>
						<td>Username</td>
						<td><input type='text' name='username' id='username' disabled  /></td>
					</tr>
					<tr>
						<td>Password</td>
						 <td><input type='text' name='password' id='password' /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type='text' name='email' id='email' /></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type='submit' name='updateBtn' id='updateBtn' value='Update' /> 
						</td>
					</tr>
				</table>
			</form>
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