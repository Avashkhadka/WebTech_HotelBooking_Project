<?php
session_start();
session_destroy();
header("location:http://localhost/webtech_hotelbooking_project/pages/login.php ",true);
exit();
?>