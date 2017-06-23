<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['role']);
unset($_SESSION['email']);
session_destroy();
header('Location:login.php');
?>