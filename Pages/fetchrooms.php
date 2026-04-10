<?php
include '../conn.php';
if (isset($_GET['offset'])) {
    $offset = $_GET['offset'];
    $sql = "SELECT * from rooms LIMIT 6 OFFSET $offset";
    $res = mysqli_query($conn, $sql);
    $data = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
}

?>