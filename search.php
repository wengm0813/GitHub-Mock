<?php require('includes/config.php');


$conn = $db;
$OK = true; // We use this to verify the status of the update.
// If 'buscar' is in the array $_POST proceed to make the query.
if (isset($_GET['name'])) {
    // Create the query
    $data = "%".$_GET['name']."%";
    $sql = 'SELECT username, First_Name,Last_Name,Email FROM User WHERE  First_Name like ? or Last_Name like ? ';
    // we have to tell the PDO that we are going to send values to the query
    $stmt = $conn->prepare($sql);
    // Now we execute the query passing an array toe execute();
    $results = $stmt->execute(array($data));
    // Extract the values from $result
    $rows = $stmt->fetchAll();
    $error = $stmt->errorInfo();
    //echo $error[2];
}
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