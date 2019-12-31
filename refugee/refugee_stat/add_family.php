<?php
session_start();

if($_SESSION['programs'] != "refugee"){
    header("Location: ../index.php");
    exit;
}

include "php_module/html_content.php";
echo $html_content;

?>

