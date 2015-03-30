<?php require('includes/config.php');
   // require ('functions.php');
    //include 'functions.php';
    $username=$_SESSION['username'];
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Members Page';
    
    
function getUserFriends() {
    global $db;
    $query = "SELECT U2.First_Name FROM Friendship f,User U1,User U2 WHERE U1.username = :user AND f.SenderID = U1.UserID And f.Pending = 1 And U2.UserID=f.RecipientID;";
    $statement = $db->prepare($query);
    $params = array(':user' => $_SESSION['username']);
    $statement->execute($params);
    
    $result=$statement->fetch();
    
        return $result['First_Name'];}


//include header template
require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


            <h2>Member only page - Welcome <?php echo $username; ?></h2>
            <?php  echo getUserFriends();   ?>
            <p><a href='logout.php'>Logout</a></p>
            <hr>

        </div>
    </div>


</div>

<?php
//include header template
require('layout/footer.php');
?>
