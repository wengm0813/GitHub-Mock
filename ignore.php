<?php require('includes/config.php');
/*
 * Hatter application catalog
 */

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Ignore Friend request';

header( "refresh:3;url=memberpage.php" );

require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Ignore friend request</h2>

            <p>Not <?php echo $_SESSION['username']; ?>? <a href='logout.php'>Logout</a></p>
            <hr>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <?php
            // Process in a function
            process($_GET['user1'], $_GET['user2']);



            /**
             * Process the query
             * @param $user the user to look for
             */
            function process($user_id1,$user_id2){
                global $db;
                $query = "DELETE FROM Friendship WHERE SenderID = $user_id1 AND RecipientID = $user_id2;";
                $query2 = "DELETE FROM Friendship WHERE SenderID = $user_id2 AND RecipientID = $user_id1;";
                if(!$db->query($query)) {
                    echo "Ignore request Failed! Automatic Return to Member Page after 3 Sec";
                }
                else{
                    echo "Friend request ignored. Return to Member Page after 3 Sec";
                }
                if(!$db->query($query2)) {
                    echo "Ignore request Failed! Automatic Return to Member Page after 3 Sec";
                }
                else{
                    echo "Friend request ignored. Return to Member Page after 3 Sec";
                }
            }
            ?>
        </div>

    </div>

</div>



