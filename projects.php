<?php require('includes/config.php');


//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Manage Projects';


if(isset($_GET['call']) && $_GET['call']=='deleteproject') {


    $user->deleteproject($_GET['projid'], $_GET['creatorid']);

    header('Location: projects.php');

}
/////////////////////////////////////////////////////////header//////////////////////////////////////////////////////
require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Manage <?php echo $_SESSION['username']; ?>'s Projects</h2>

            <p><a href='memberpage.php'>Back to Member Page</a></p>
            <hr>


        </div>
    </div>
</div>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <p><a href='add-project.php'>Add New Project</a></p>

            <h3>Current Projects:</h3>
            <?php

            $username = $_SESSION['username'];

            //$query = "SELECT U2.First_Name, U2.Last_Name FROM Friendship f,User U1,User U2 WHERE U1.username = :user AND f.SenderID = U2.UserID And f.Pending = 1 And U1.UserID=f.RecipientID;";



            $query = "SELECT Project_Title, ProjectID, CreatorID, Timestamp FROM Project P, User U WHERE U.username = :user AND P.CreatorID = U.UserID;";
            $statement = $db->prepare($query);
            $params = array(':user' => $_SESSION['username']);
            $statement->execute($params);


            foreach($statement as $statement ) {
                $projtitle = $statement['Project_Title'];
                $time = $statement['Timestamp'];
                $projid = $statement['ProjectID'];
                $creatorid = $statement['CreatorID'];

                echo $projtitle, " created on: ", $time, " ";
                echo  "<a href='projects.php?call=deleteproject&projid=$projid&creatorid=$creatorid'>Delete Project</a></br>";
            }

            ?>
            </br>



        </div>
    </div>


</div>

<?php
//include header template
require('layout/footer.php');
?>



