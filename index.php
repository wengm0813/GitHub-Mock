<?php require('includes/config.php'); 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); } 

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM User WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
			
	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

    if (strlen($_POST['firstName']) < 0) {
        $firstName = "";
    }
    else {
        $firstName = $_POST['firstName'];

    }


    if (strlen($_POST['lastName']) < 0) {
        $lastName = "";
    }

    else {
        $lastName = $_POST['lastName'];

    }

    if (strlen($_POST['middleName']) < 0) {
        $middleName = "";}
    else {
        $middleName = $_POST['middleName'];

    }

    if (strlen($_POST['homeTownCity']) < 0) {
        $homeTownCity = "";}

    else{
        $homeTownCity = $_POST['homeTownCity'];

    }

    if (strlen($_POST['homeTownState']) < 0) {
        $homeTownState = "";}

    else{
        $homeTownState = $_POST['homeTownState'];

    }
    if (strlen($_POST['DOB']) < 0) {
        $DOB = 0;}

    else{
        $homeTownState = $_POST['DOB'];

    }



	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = ($_POST['password']);

		//create the activasion cod

		try {

			//insert into database with a prepared statement
            $stmt = $db->prepare ('INSERT INTO User (username,Password,Email,First_Name,Middle_Initial,Last_Name, Hometown_City, Hometown_State, Year_Of_Birth)
                                      VALUES (:username, :password, :email, :firstName, :middleName,:lastName,:homeTownCity,:homeTownState,:DOB)');

            $stmt->execute(array(
                ':username' => $_POST['username'],
                ':password' => $hashedpassword,
                ':email' => $_POST['email'],
                ':firstName' => $firstName,
                ':middleName' => $middleName,
                ':lastName' => $lastName,
                ':homeTownCity' => $homeTownCity,
                ':homeTownState' => $homeTownState,
                ':DOB' => $DOB


            ));
            $id = $db->lastInsertId('memberID');


			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'CSE480 Project';

//include header template
require('layout/header.php'); 
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
						</div>
					</div>
				</div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="firstName" id="firstName" class="form-control input-lg" placeholder="First Name" tabindex="4">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="middleName" id="middleName" class="form-control input-lg" placeholder="Middle Name" tabindex="4">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                        <input type="text" name="lastName" id="lastName" class="form-control input-lg" placeholder="Last Name" tabindex="5">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="homeTownCity" id="homeTownCity" class="form-control input-lg" placeholder="Home Town City" tabindex="6">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="homeTownState" id="homeTownState" class="form-control input-lg" placeholder="Home Town State" tabindex="6">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="DOB" id="DOB" class="form-control input-lg" placeholder="Date of Birth" tabindex="6">

                        </div>
                    </div>
                </div>

				
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>

</div>

<?php 
//include header template
require('layout/footer.php'); 
?>