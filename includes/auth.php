<?php
session_start();
if(!isset($_SESSION['login_success'])){
  header("location: index.php");
}
?>