<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("location: sigin.php");
}

echo $_SESSION['mail'];












?>