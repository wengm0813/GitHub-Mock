<?php require('includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }


//define page title
$title = 'Add Project Page';

//if form has been submitted process it


//include header template
require('layout/header.php');
?>

    <div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h2>Create New Project</h2>

            <p><a href='projects.php'>Back to Project Page</a></p>
            <hr>

        </div>
    </div>



    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


                <?php if(isset($stop)){

                    echo "<p class='bg-danger'>$stop</p>";

                }  ?>

                <form role="form" method="post" action="" autocomplete="off">


                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="projtitle" name="projtitle" id="projtitle" class="form-control input-lg" placeholder="Project Title" tabindex="1">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Creat Project" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
                        </div>

                        <!--                            <div class="col-xs-6 col-md-6">-->
                        <!--                                <div class="form-group">-->
                        <!--                                    <select class="form-control input-lg" name = "privacy" id="privacy" tabindex="7">-->
                        <!--                                        <option value = "1">Interest </option>-->
                        <!--                                        <option value = "1">Game Design </option>-->
                        <!--                                        <option value = "2">Contemporary Arts </option>-->
                        <!--                                        <option value = "3">Sports </option>-->
                        <!--                                        <option value = "3">Other </option>-->
                        <!---->
                        <!--                                    </select>-->
                        <!---->
                        <!--                                </div>-->
                        <!---->
                        <!--                            </div>-->


                        <!--                            <div class="row">-->
                        <!--                                <div class="col-xs-6 col-md-6"><input type="interestsubmit" name="interestsubmit" value="Search by Interest" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>-->
                        <!--                            </div>-->
                </form>

                <?php
                if(isset($_POST['submit'])){



                    //if no errors have been created carry on
                    if(!isset($error)){


                        try {
                            $stmt = $db->prepare('INSERT INTO Project (ProjectID, CreatorID, Project_Title, Timestamp) VALUES (NULL, :userid, :projtitle, CURRENT_TIMESTAMP);');

                            $stmt->execute(array(
                                ':userid' => $_SESSION['UserID'],
                                ':projtitle' => $_POST['projtitle']

                            ));

                            echo '</h2>Create Project Success</h2>';





                            //else catch the exception and show the error.
                        } catch(PDOException $e) {
                            $error[] = $e->getMessage();
                        }

                    }

                }

                ?>
                <?
                ?>

            </div>
        </div>


    </div>

<?php
//include header template
require('layout/footer.php');
?>