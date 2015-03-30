<?php require('includes/config.php');
/*
 * Hatter application catalog
 */

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Add Friend Page';

header( "refresh:3;url=memberpage.php" );


require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Add Friend</h2>

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

            try {

                $sql = "INSERT INTO Friendship VALUES ($user_id1, $user_id2, '0');";
                // use exec() because no results are returned
                $db->exec($sql);

                echo "Add Successful! Automatic Return to Member Page after 3 Sec";
            }
            catch(PDOException $e)
            {
             
                echo "Add Friend Failed! Automatic Return to Member Page after 3 Sec";
            }



        }


        ?>
        </div>

    </div>

</div>



