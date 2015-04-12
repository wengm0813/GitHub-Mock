<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Reset Password Page';

//if form has been submitted process it
if(isset($_POST['submit'])){

    //basic validation
    if(strlen($_POST['password']) < 8){
        $error[] = 'Password is too short, at least 8 character';
    }

    if($_POST['password'] != $_POST['passwordConfirm']){
        $error[] = 'Passwords do not match.';
    }

    //if no errors have been created carry on
    if(!isset($error)){

        //hash the password
        $hashedpassword = ($_POST['password']);

        try {




            $stmt = $db->prepare('UPDATE User SET Password = :password WHERE username = :user');
            $stmt->execute(array(
                ':password' => $hashedpassword,
                ':user' => $_SESSION['username']
            ));

            //redirect to index page
            header('Location: login.php?action=resetAccount');
            exit;

            //else catch the exception and show the error.
        } catch(PDOException $e) {
            $error[] = $e->getMessage();
        }

    }

}

//include header template
require('layout/header.php');
?>

    <div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Reset Password - <?php echo $_SESSION['username']; ?></h2>

            <p><a href='memberpage.php'>Back to Member Page</a></p>

            <?php
            //check for any errors
            if(isset($error)){
                foreach($error as $error){
                    echo '<p class="bg-danger">'.$error.'</p>';
                }
            }
            ?>


            <hr>

        </div>
    </div>



    <div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


	    	<?php if(isset($stop)){

    echo "<p class='bg-danger'>$stop</p>";

} else { ?>

    <form role="form" method="post" action="" autocomplete="off">


        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="New Password" tabindex="1">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm New Password" tabindex="1">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Change Password" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
        </div>
    </form>

<?php } ?>
		</div>
	</div>


</div>

<?php
//include header template
require('layout/footer.php');
?>