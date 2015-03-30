<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();
    
    	$this->_db = $db;
    }

	private function get_user_hash($username){	

		try {
			$stmt = $this->_db->prepare('SELECT Password FROM User WHERE username = :username ');
			$stmt->execute(array('username' => $username));
			
			$row = $stmt->fetch();
			return $row['Password'];

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function login($username,$password){

		$hashed = $this->get_user_hash($username);
		
		if($this->password_verify($password,$hashed) == 1){
		    
		    $_SESSION['loggedin'] = true;
		    return true;
		} 	
	}
		
	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}		
	}
    
    public function deletefriend($firstname,$lastname,$username){
        echo "222";
            $stmt=$this->_db->prepare('Delete From `Friendship` Where SenderID in (select UserID From `User` Where First_Name=:1f and Last_Name=:1l) and RecipientID in (select UserID from `User` where username=:2f)');
            $stmt->execute(array(
                ':1f'=>$firstname,
                ':1l'=>$lastname,
                ':2f'=>$username));
        echo "33333";

        $query="Delete From `Friendship` Where RecipientID in (select UserID From `User` Where First_Name=".$firstname.
        "and Last_Name=".$lastname." and SenderID in (select UserID from `User` where username=".$username;

         $this->_db->query("DEALLOCATE PREPARE stmt");
        $stmt=$this->_db->prepare('Delete From `Friendship` Where RecipientID in (select UserID From `User` Where First_Name=:1f and Last_Name=:1l) and SenderID in (select UserID from `User` where username=:2f))');

        echo "666";

        $stmt->execute(array(
                ':1f'=>$firstname,
                ':1l'=>$lastname,
                ':2f'=>$username));

        echo "4444";


    }

    public function deletefriend2($firstname,$lastname,$username){

    }

}


?>