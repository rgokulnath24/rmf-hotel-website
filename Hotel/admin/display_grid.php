<?php
include("db.php");
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

$categories = ['breakfast', 'lunch', 'dinner', 'snacks'];
$data = [];



foreach ($categories as $cat) {
    $statusColumn = $cat . "_status";
    $sql = "SELECT * FROM $cat where $statusColumn=1";  //breakfast
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
{
            $row['category'] = ucfirst($cat);
            $row['type'] = ucfirst($row[$cat . '_type']);
            $data[] = $row;
        }
    }
}
$conn->close();
?>