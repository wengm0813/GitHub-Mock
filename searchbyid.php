<?php require('includes/config.php');

$conn = $db;
$OK = true; // We use this to verify the status of the update.
// If 'buscar' is in the array $_POST proceed to make the query.
if (isset($_GET['id'])) {
    // Create the query
    $data = trim($_GET['id']);
    $sql = 'SELECT username, First_Name,Last_Name,Email FROM User WHERE username = ?';
    // we have to tell the PDO that we are going to send values to the query
    $stmt = $conn->prepare($sql);
    // Now we execute the query passing an array toe execute();
    $results = $stmt->execute(array($data));
    // Extract the values from $result
    $row = $stmt->fetch();
    $error = $stmt->errorInfo();
    //echo $error[2];
}
// If there are no records.
// If there are no records.
if(empty($rows)) {
    echo "<tr>";
    echo "<td colspan='4'>There were not records</td>";
    echo "</tr>";
}
else {
    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['First_Name']."</td>";
        echo "<td>".$row['Last_Name']."</td>";
        echo "<td>".$row['Email']."</td>";
        echo "</tr>";
    }
}
?>