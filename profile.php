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
    $query = 'SELECT First_Name,Middle_Initial,Last_Name,Email,Hometown_City,Hometown_State,Year_Of_Birth FROM User WHERE username = :user';
    $statement = $db->prepare($query);
    $params = array(':user' => $_SESSION['username']);
    $statement->execute($params);
    $user_data = $statement->fetch();

    $_SESSION['myFirst_Name'] = $user_data['First_Name'];
    $_SESSION['myMiddlme_Initial'] = $user_data['Middle_Initial'];
    $_SESSION['myLast_Name'] = $user_data['Last_Name'];
    $_SESSION['myEmail'] = $user_data['Email'];
    $_SESSION['myCity'] = $user_data['Hometown_City'];
    $_SESSION['myState'] = $user_data['Hometown_State'];
    $_SESSION['myDOB'] = $user_data['Year_Of_Birth'];

    } catch(PDOException $e) {
        echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    }

//if form has been submitted process it
if(isset($_POST['submit'])){



    if (strlen($_POST['email']) == 0) {
        $email = $_SESSION['myEmail'];
    }
    else {
        $email = $_POST['email'];

    }

    if (strlen($_POST['firstName']) == 0) {
        $firstName = $_SESSION['myFirst_Name'];
    }
    else {
        $firstName = $_POST['firstName'];

    }


    if (strlen($_POST['lastName']) == 0) {
        $lastName =  $_SESSION['myLast_Name'];
    }

    else {
        $lastName = $_POST['lastName'];

    }


    if (strlen($_POST['homeTownCity']) == 0) {
        $homeTownCity = $_SESSION['myCity'];}

    else{
        $homeTownCity = $_POST['homeTownCity'];

    }

    if (strlen($_POST['homeTownState']) == 0) {
        $homeTownState =  $_SESSION['myState'];}

    else{
        $homeTownState = $_POST['homeTownState'];

    }
    if (strlen($_POST['DOB']) != 4 || !is_numeric($_POST['DOB'])) {
        $DOB =  $_SESSION['myDOB'];
    }

    else{
        $DOB = $_POST['DOB'];

    }

    //if no errors have been created carry on
    if(!isset($error)){

        //hash the password
        $hashedpassword = ($_POST['password']);

        //create the activasion cod

        try {

            //insert into database with a prepared statement
            $stmt = $db->prepare ('UPDATE User SET Email = :email,First_Name = :firstName,Middle_Initial = :middleName,
                                    Last_Name = :lastName, Hometown_City = :homeTownCity, Hometown_State = :homeTownState, Year_Of_Birth =:DOB
                                    WHERE username = :user');
            $stmt->execute(array(

                ':email' => $email,
                ':firstName' => $firstName,
                ':middleName' => $middleName,
                ':lastName' => $lastName,
                ':homeTownCity' => $homeTownCity,
                ':homeTownState' => $homeTownState,
                ':DOB' => $DOB,
                ':user' => $_SESSION['username']


            ));
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
            <hr>

        </div>
    </div>


</div>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3"><form role="form" method="post" action="" autocomplete="off">

                <div class="form-group">
                    <p> Email: </p>
                    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="<?php echo $_SESSION['myEmail']; ?>" value="<?php echo $_SESSION['myEmail']; ?>" tabindex="2">
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> First Name: </p>

                            <input type="text" name="firstName" id="firstName" class="form-control input-lg" value="<?php echo $_SESSION['myFirst_Name']; ?>" placeholder="<?php echo $_SESSION['myFirst_Name']; ?>" tabindex="4">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <p> Middle Initial: </p>
                            <input type="text" name="middleName" id="middleName" class="form-control input-lg" placeholder="<?php echo  $_SESSION['myMiddlme_Initial']; ?>" value = "<?php echo  $_SESSION['myMiddlme_Initial']; ?>"tabindex="4">
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
                            <input type="text" name="DOB" id="DOB" class="form-control input-lg" value="<?php echo  $_SESSION['myDOB']; ?>"tabindex="6">

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Save Change " class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
                </div>
            </form>
        </div>
    </div>

</div>





<?php
//include header template
require('layout/footer.php');
?>
