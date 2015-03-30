<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Add Friend Page';

//if form has been submitted process it


//include header template
require('layout/header.php');
?>

    <div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Add Friend</h2>

            <p><a href='memberpage.php'>Back to Member Page</a></p>
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
                                    <input type="usrname" name="usrname" id="usrname" class="form-control input-lg" placeholder="Username" tabindex="1">
                                </div>
                            </div>


                        <div class="row">
                            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Search User" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
                        </div>
                    </form>

                    <?php
                    if(isset($_POST['submit'])){



                        //if no errors have been created carry on
                        if(!isset($error)){


                            try {
                                $stmt = $db->prepare('SELECT U1.UserID as UserID1, U2.UserID as UserID2, U2.First_Name, U2.Last_Name
                                                      FROM User as U1, User as U2
                                            WHERE U1.username = :user1 AND U2.username = :user2');

                                $stmt->execute(array(
                                    ':user1' => $_SESSION['username'],
                                    ':user2' => $_POST['usrname']

                                ));



                                foreach($stmt as $stmt ) {
                                    $user1id =  $stmt['UserID1'];
                                    $user2id = $stmt['UserID2'];
                                    $first = $stmt['First_Name'];
                                    $last = $stmt['Last_Name'];


                                    echo $first," ",$last," ";
                                    echo  "<a onclick href=adding.php?user1=";
                                    echo $user1id;
                                    echo "&user2=";
                                    echo $user2id;
                                    echo ">Add Friend Request</a>";

                                }


                                //else catch the exception and show the error.
                            } catch(PDOException $e) {
                                $error[] = $e->getMessage();
                            }

                        }

                    }
                    ?>
                    <?
                    ?>

                <?php } ?>
            </div>
        </div>


    </div>

<?php
//include header template
require('layout/footer.php');
?>