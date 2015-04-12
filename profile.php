<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Change Profile Page';

//$stmt = $_db->prepare('SELECT Password FROM User WHERE username = :username ');
//$stmt->execute(array('username' => $username));
//$row = $stmt->fetch();
//return $row['Password'];
try {
    $query = 'SELECT UserID, First_Name,Middle_Initial,Last_Name,Email,Hometown_City,Hometown_State,Year_Of_Birth,Privacy FROM User WHERE username = :user';
    $statement = $db->prepare($query);
    $params = array(':user' => $_SESSION['username']);
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
if(isset($_POST['submit'])){
    try {
        $query3 = 'DELETE From UserInterests Where UserID=:ID';
        $statement3 = $db->prepare($query3);
        $params3 = array(':ID' => $usrid);
        $statement3->execute($params3);

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }


    /*if (!filter_var(strlen($_POST['email'], FILTER_VALIDATE_EMAIL))){
        $email = $_SESSION['myEmail'];
        $error[] = 'Email is either empty or not correct.';
    }
    else {
        $email = $_POST['email'];

    }*/

    if (empty($_POST["email"])) {
        $email = $_SESSION['myEmail'];
        $error[] = 'Email is empty.';
    }
    else {

            $email = $_POST['email'];


    }

    if (strlen($_POST['firstName']) == 0) {
        $firstName = $_SESSION['myFirst_Name'];
        $error[] = 'First Name cannot be empty.';
    }
    else {
        $firstName = $_POST['firstName'];

    }


    if (strlen($_POST['lastName']) == 0) {
        $lastName =  $_SESSION['myLast_Name'];
        $error[] = 'Last Name cannot be empty.';
    }

    else {
        $lastName = $_POST['lastName'];

    }

    if (strlen($_POST['middleName']) > 1) {
        $error[] = 'Middle Initial just 1 character.';
        $firstName = $_SESSION['myMiddle_Initial'];

    }

    if (strlen($_POST['middleName']) == 0) {
        $middleName = "";

    }
    else {
        $middleName = $_POST['middleName'];

    }


    if (strlen($_POST['homeTownCity']) == 0) {
        $homeTownCity = $_SESSION['myCity'];
        $error[] = 'Home city Cannot be empty.';
    }

    else{
        $homeTownCity = $_POST['homeTownCity'];



    }

    if (strlen($_POST['homeTownState']) == 0) {
        $homeTownState =  $_SESSION['myState'];
        $error[] = 'Home state Cannot be empty.';
    }

    else{
        $homeTownState = $_POST['homeTownState'];

    }
    if (strlen($_POST['DOB']) != 4 || !is_numeric($_POST['DOB'])) {

        $DOB =  $_SESSION['myDOB'];
        $error[] = 'Birth Year must be year, format 1994.';
    }

    else{
        $DOB = $_POST['DOB'];

    }


    if(!isset($_POST['interest'])){
        $error[] = "Please choose at least one interest";
    }
    else
    {
        $checkbox1 = $_POST['interest'];
    }



    //if no errors have been created carry on
    if(!isset($error)){

        //hash the password
        $hashedpassword = ($_POST['password']);

        //create the activasion cod

        try {

            //insert into database with a prepared statement
            $stmt = $db->prepare ('UPDATE User SET Email = :email,First_Name = :firstName, Middle_Initial = :middleName,
                                    Last_Name = :lastName, Hometown_City = :homeTownCity, Hometown_State = :homeTownState, Year_Of_Birth =:DOB,
                                    Privacy = :privacy
                                    WHERE username = :user');
            $stmt->execute(array(

                ':email' => $email,
                ':firstName' => $firstName,
                ':middleName' => $middleName,
                ':lastName' => $lastName,
                ':homeTownCity' => $homeTownCity,
                ':homeTownState' => $homeTownState,
                ':DOB' => $DOB,
                ':user' => $_SESSION['username'],
                ':privacy' =>$_POST['privacy']


            ));


            /*foreach($checkbox1 as $value){
                //echo $checkbox1[i];
                IF ($value =="")
                {
                    CONTINUE;
                }
                $sql_input = "INSERT INTO UserInterests VALUES (:usrid,'$value')";
                $statement4 = $db->prepare($sql_input);
                $params4 = array(':usrid' => $_SESSION['myUserID']);
                $statement4->execute($params4);
            }*/

            foreach($checkbox1 as $value){
                //echo $checkbox1[i];
                IF ($value =="")
                {
                    CONTINUE;
                }
                $sql_input = "INSERT INTO UserInterests VALUES ($usrid,'$value')";
                $db->query($sql_input);
            }

            header("Refresh:0");

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

            <h2>Change Profile -<?php echo $_SESSION['username']; ?></h2>
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

                <div class="form-group">
                    <p> Email: </p>
                    <input type="email" name="email" id="email" class="form-control input-lg"  value="<?php echo $_SESSION['myEmail']; ?>" tabindex="2">
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> First Name: </p>

                            <input type="text" name="firstName" id="firstName" class="form-control input-lg" value="<?php echo $_SESSION['myFirst_Name']; ?>"  tabindex="4">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Middle Initial: </p>
                            <input type="text" name="middleName" id="middleName" class="form-control input-lg" value = "<?php echo  $_SESSION['myMiddle_Initial']; ?>" tabindex="4">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <p> Last Name: </p>
                            <input type="text" name="lastName" id="lastName" class="form-control input-lg" value="<?php echo  $_SESSION['myLast_Name']; ?>" tabindex="5">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Home Town City: </p>
                            <input type="text" name="homeTownCity" id="homeTownCity" class="form-control input-lg" value="<?php echo  $_SESSION['myCity']; ?>" tabindex="6">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Home Town State: </p>
                            <input type="text" name="homeTownState" id="homeTownState" class="form-control input-lg" value="<?php echo  $_SESSION['myState']; ?>"tabindex="6">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">

                            <p> Date of Birth: </p>
                            <input type="text" name="DOB" id="DOB" class="form-control input-lg" value="<?php echo  $_SESSION['myDOB']; ?>"tabindex="7">

                        </div>
                    </div>




                    <div class="col-xs-6 col-md-6">
                        <div class="form-group">
                            <p> Your Profile Privacy Setting: </p>
                            <select class="form-control input-lg" name = "privacy" id="privacy" tabindex="7">
                                <option value = "1" <?php if($_SESSION['myPrivacy']=="1") echo "selected";?>>Low</option>
                                <option value = "2"<?php if($_SESSION['myPrivacy']=="2") echo "selected";?>>Medium</option>
                                <option value = "3"<?php if($_SESSION['myPrivacy']=="3") echo "selected";?>>High</option>
                            </select>

                        </div>

                    </div>

                </div>



                    <div class="form-group"  class="form-control input-lg">
                        <p>Choose your interest <p>


                            <label class="checkbox-inline">
                            <?php if(in_array('Game Design',$_SESSION['myInterest'] )){
                                echo '<input name = "interest[0]" id= "interest[]" type="checkbox" value="Game Design" checked>Game Design';}
                                else {
                                    echo ' <input name = "interest[0]" id= "interest[]" type="checkbox" value="Game Design">Game Design';
                                }
                            ?>
                            </label>

                            <label class="checkbox-inline">
                                <?php if(in_array('Contemporary Arts',$_SESSION['myInterest'] )){
                                    echo '<input name = "interest[1]" id= "interest[]" type="checkbox" value="Contemporary Arts" checked>Contemporary Arts';}
                                else echo ' <input name = "interest[1]" id= "interest[]" type="checkbox" value="Contemporary Arts">Contemporary Arts';
                                ?>
                            </label>

                            <label class="checkbox-inline">
                                <?php if(in_array('Sports',$_SESSION['myInterest'] )){
                                    echo '<input name = "interest[2]" id= "interest[]" type="checkbox" value="Sports" checked>Sports';}
                                else echo ' <input name = "interest[2]" id= "interest[]" type="checkbox" value="Sports">Sports';
                                ?>
                            </label>

                            <label class="checkbox-inline">
                                <?php if(in_array('Other',$_SESSION['myInterest'] )){
                                    echo '<input name = "interest[3]" id= "interest[]" type="checkbox" value="Other" checked>Other';}
                                else echo ' <input name = "interest[3]" id= "interest[]" type="checkbox" value="Other">Other';
                                ?>
                            </label>


                </div>


                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Save Change " class="btn btn-primary btn-block btn-lg" tabindex="8"></div>
                 </div>
            </form>
        </div>
    </div>

</div>



<?php
//include header template
require('layout/footer.php');
?>
