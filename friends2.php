<?php require('includes/config.php');


//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Manage Friends List';


if(isset($_GET['call']) && $_GET['call']=='deletefriend') {


    $user->deletefriend($_GET['first'], $_GET['last'], $_SESSION['username']);



    header('Location: friends2.php');

}
//include header template
require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

                <h2>Manege <?php echo $_SESSION['username']; ?>'s Friends List </h2>
                <p><a href='add-friend.php'>Add a Friend</a></p>
                <h3>Current Friends:</h3>
                <?php

                $username = $_SESSION['username'];

                $query = "SELECT U2.First_Name, U2.Last_Name FROM Friendship f,User U1,User U2 WHERE U1.username = :user AND f.SenderID = U2.UserID And f.Pending = 1 And U1.UserID=f.RecipientID;";
                $statement = $db->prepare($query);
                $params = array(':user' => $_SESSION['username']);
                $statement->execute($params);


                foreach($statement as $statement ) {
                    $first = $statement['First_Name'];
                    $last = $statement['Last_Name'];

                    echo $first," ",$last,"  ";
                    echo  "<a href='friends2.php?call=deletefriend&first=";
                    echo $first;
                    echo "&last=";
                    echo $last;
                   // header('Location: http://cse480.wengmin.me/memberpage.php');

                    echo "'>Delete Friend</a>";
                    echo "</br>";
                }

                ?>
                </br>

                <h3>Pending Friendship Requirements:</h3>
                <?php

                $username = $_SESSION['username'];

                $query = "SELECT U2.First_Name, U2.Last_Name FROM Friendship f,User U1,User U2 WHERE U1.username = :user AND f.SenderID = U2.UserID And f.Pending = 0 And U1.UserID=f.RecipientID;";
                $statement = $db->prepare($query);
                $params = array(':user' => $_SESSION['username']);
                $statement->execute($params);


                foreach($statement as $statement ) {
                    $first = $statement['First_Name'];
                    $last = $statement['Last_Name'];

                    echo $first," ",$last,"  ";

                    echo  "<a onclick href=ignore.php?user1=";
                    echo $f.Senderid;
                    echo "&user2=";
                    echo $user2id;
                    echo ">Ignore Friend Request</a>";

                    echo  " ";
                    echo  "<a href='add-friend.php'> Accept Request</a>";
                    echo "</br>";
                }

                ?>
                </br>



            </br>
            <hr>

        </div>
    </div>


</div>

<?php
//include header template
require('layout/footer.php');
?>



