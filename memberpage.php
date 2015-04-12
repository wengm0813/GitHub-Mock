<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Members Page';

//include header template
require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h3> Welcome to your page, <?php echo $_SESSION['username']; ?>!</h3>

            <p>
                </br>
                <img src="images/msulogo.png" alt="msulogo" height = 75% width = 75% align = "middle"/>
                </br>
                </br>
            </p>

            <p><a href='projects.php'>Manage Your Projects</a></p>
            <p><a href='friends.php'>Manage Friends List</a></p>
            <p><a href='profile.php'>View/Edit Profile Info</a></p>
            <p><a href='resetpass.php'>Reset Your Password</a></p>
            <p><a href='logout.php'>Logout</a></p>
            <hr>

        </div>
    </div>


</div>

<?php
//include header template
require('layout/footer.php');
?>
