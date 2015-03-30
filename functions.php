<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 3/26/2015
 * Time: 10:10 PM
 */

function getUserFriends($username) {
    echo 1;
    $query = "SELECT U2.First_Name FROM Friendship f,User U1,User U2 WHERE U1.username = \"".$username."\" AND f.SenderID = U1.UserID And f.Pending = 1 And U2.UserID=f.RecipientID;";
//    $result = executeSQL($query);
    
    $resultString = "<form method=\"post\" action=\"#\">";
    $resultString .= "<tr>";
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
    echo 2;
    return $resultString;
}
