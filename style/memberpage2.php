<?php require('includes/config.php');
   // require ('functions.php');
    //include 'functions.php';
    $username=$_SESSION['username'];
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Members Page';
    
    
function getUserFriends($username) {
    $query = "SELECT U2.First_Name FROM Friendship f,User U1,User U2 WHERE U1.username = \"".$username."\" AND f.SenderID = U1.UserID And f.Pending = 1 And U2.UserID=f.RecipientID;";
    $stmt=$db->prepare(&query);
//    $stmt->excute();
//    
//    $result=$stmt->fetch();
    $result="1234";
    
    //    $resultString = "<form method=\"post\" action=\"#\">";
    //    $resultString .= "<tr>";
    //    while ($row = $result->fetch_assoc()) {
    //        $resultString .= "<td>";
    //        $resultString .= $row['SenderID'];
    //        $resultString .= "</td>";
    //        $resultString .= "<td>";
    //        $resultString .= "<input type=\"submit\" name=\"accept\" value=\"Accept\">";
    //        $resultString .= "<input type=\"hidden\" name=\"acceptUser\" value=\"".$row['SenderID']."\">";
    //        $resultString .= "</td>";
    //    }
    //    $resultString .="</tr>";
    //    $resultString .="</form>";
    echo 3;
    return $result;
}

//include header template
require('layout/header.php');
?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


            <h2>Member only page - Welcome <?php echo $username; ?></h2>
            <?php getUserFriends($username);?>
            <p><a href='logout.php'>Logout</a></p>
            <hr>

        </div>
    </div>


</div>

<?php
//include header template
require('layout/footer.php');
?>
