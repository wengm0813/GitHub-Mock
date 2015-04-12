<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'User Profile Page';


$_SESSION['USRID1'] = $_GET['user1']; ///SELF
$_SESSION['USRID2'] = $_GET['user2']; ///OTHER

//$stmt = $_db->prepare('SELECT Password FROM User WHERE username = :username ');
//$stmt->execute(array('username' => $username));
//$row = $stmt->fetch();
//return $row['Password'];
try {
    $query = 'SELECT UserID, First_Name,Middle_Initial,Last_Name,Email,Hometown_City,Hometown_State,Year_Of_Birth,Privacy,username FROM User WHERE UserID = :user';
    $statement = $db->prepare($query);
    $params = array(':user' => $_SESSION['USRID2']);
    $statement->execute($params);
    $user_data = $statement->fetch();


    $_SESSION['myUserID'] = $user_data['UserID'];
    $_SESSION['myFirst_Name'] = $user_data['First_Name'];
    $_SESSION['myMiddle_Initial'] = $user_data['Middle_Initial'];
    $_SESSION['myLast_Name'] = $user_data['Last_Name'];
    $_SESSION['myEmail'] = $user_data['Email'];
    $_SESSION['myCity'] = $user_data['Hometown_City'];
    $_SESSION['myState'] = $user_data['Hometown_State'];
    $_SESSION['myDOB'] = $user_data['Year_Of_Birth'];
    $_SESSION['myPrivacy'] = $user_data['Privacy'];
    $_SESSION['myUsername'] = $user_data['username'];


} catch(PDOException $e) {
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
}

$usrid = $_SESSION['myUserID'];

try {
    $query2 = 'SELECT Interest From UserInterests Where UserID=:ID';
    $statement2 = $db->prepare($query2);
    $params2 = array(':ID' => $_SESSION['myUserID']);
    $statement2->execute($params2);


    $_SESSION['myInterest']=array();
    foreach($statement2 as $statement2){
        $_SESSION['myInterest'][]=$statement2['Interest'];
    }

} catch(PDOException $e) {
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
}




//if form has been submitted process it
if(isset($_POST['Add_Friend'])){

    header("Location: adding.php?user1={$_SESSION['USRID1']}&user2={$_SESSION['USRID2']}");
    exit;



}






//include header template
require('layout/header.php');
?>



<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2><?php echo $_SESSION['myUsername']; ?>'s Profile</h2>
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


</div>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3"><form role="form" method="post" action="" autocomplete="off">

                <div class="form-group" disabled>
                    <p> Email: </p>
                    <input type="email" name="email" id="email" class="form-control input-lg"  value="<?php echo $_SESSION['myEmail']; ?> " tabindex="2" disabled>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> First Name: </p>

                            <input type="text" name="firstName" id="firstName" class="form-control input-lg" value="<?php echo $_SESSION['myFirst_Name']; ?>"  tabindex="4" disabled>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Middle Initial: </p>
                            <input type="text" name="middleName" id="middleName" class="form-control input-lg" value = "<?php echo  $_SESSION['myMiddle_Initial']; ?>" tabindex="4" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <p> Last Name: </p>
                            <input type="text" name="lastName" id="lastName" class="form-control input-lg" value="<?php echo  $_SESSION['myLast_Name']; ?>" tabindex="5" disabled>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Home Town City: </p>
                            <input type="text" name="homeTownCity" id="homeTownCity" class="form-control input-lg" value="<?php echo  $_SESSION['myCity']; ?>" tabindex="6" disabled>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Home Town State: </p>
                            <input type="text" name="homeTownState" id="homeTownState" class="form-control input-lg" value="<?php echo  $_SESSION['myState']; ?>"tabindex="6" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">

                            <p> Date of Birth: </p>
                            <input type="text" name="DOB" id="DOB" class="form-control input-lg" value="<?php echo  $_SESSION['myDOB']; ?>"tabindex="7" disabled>

                        </div>
                    </div>
                </div>



                <div class="form-group"  class="form-control input-lg" >
                    <p>Choose your interest <p>


                        <label class="checkbox-inline" >
                            <?php if(in_array('Game Design',$_SESSION['myInterest'] )){
                                echo '<input name = "interest[0]" id= "interest[]" type="checkbox" value="Game Design" checked disabled>Game Design';}
                            else {
                                echo ' <input name = "interest[0]" id= "interest[]" type="checkbox" value="Game Design" disabled>Game Design';
                            }
                            ?>
                        </label>

                        <label class="checkbox-inline" >
                            <?php if(in_array('Contemporary Arts',$_SESSION['myInterest'] )){
                                echo '<input name = "interest[1]" id= "interest[]" type="checkbox" value="Contemporary Arts" checked disabled>Contemporary Arts';}
                            else echo ' <input name = "interest[1]" id= "interest[]" type="checkbox" value="Contemporary Arts" disabled>Contemporary Arts';
                            ?>
                        </label>

                        <label class="checkbox-inline" >
                            <?php if(in_array('Sports',$_SESSION['myInterest'] )){
                                echo '<input name = "interest[2]" id= "interest[]" type="checkbox" value="Sports" checked disabled>Sports';}
                            else echo ' <input name = "interest[2]" id= "interest[]" type="checkbox" value="Sports" disabled>Sports';
                            ?>
                        </label>

                        <label class="checkbox-inline" >
                            <?php if(in_array('Other',$_SESSION['myInterest'] )){
                                echo '<input name = "interest[3]" id= "interest[]" type="checkbox" value="Other" checked disabled>Other';}
                            else echo ' <input name = "interest[3]" id= "interest[]" type="checkbox" value="Other" disabled>Other';
                            ?>
                        </label>


                </div>


                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" name="Add_Friend" value="Add Friend " class="btn btn-primary btn-block btn-lg" tabindex="8"></div>
                </div>
            </form>
        </div>
    </div>

</div>



<?php
//include header template
require('layout/footer.php');
?>
